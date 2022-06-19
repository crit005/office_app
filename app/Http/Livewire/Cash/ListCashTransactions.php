<?php

namespace App\Http\Livewire\Cash;

use App\Models\Balance;
use App\Models\CashTransaction;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListCashTransactions extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Component variable //
    protected $paginationTheme = 'bootstrap';
    public $globleBalance = false;

    public $transaction = null;
    public $logs = null;
    public $search = null;
    public $searchUserIds = [];
    public $searchCurrencyIds = [];
    public $specificColumn = null;
    public $specificSearch = null;
    public $dum = '';
    public $specificOperator = null;
    public $specificOperators = ['=', '!=', '>=', "<=", '<', '>'];
    public $searchFields = [
        'date' => 'tr_date',
        'item' => 'item_name',
        'amount' => 'amount',
        'current balance' => 'balance',
        'use on' => 'use_on',
        'month' => 'month',
        'created by' => 'owner_name',
        'type' => 'type'
    ];

    public function mount()
    {
        if (auth()->user()->group_id > 2) {
            $this->searchFields['current balance'] = 'user_balance';
        }
        $this->globleBalance = Session::get('isGlobleCash')?? false;
    }

    protected $listeners = [
        'searchListener' => 'searchListener'
    ];

    public function updatedGlobleBalance($var)
    {
        if (auth()->user()->group_id > 2) {
            $this->globleBalance = false;
        }
    }

    public function updatedSearch($var)
    {
        $this->specificColumn = null;
        $this->specificSearch = null;
        $this->specificOperator = null;
        $this->searchUserIds = [];
        $this->searchCurrencyIds = [];

        $testColumn = explode("::", $var);
        if (count($testColumn) > 1) {
            if (array_key_exists(strtolower($testColumn[0]), $this->searchFields)) {
                $this->specificColumn = strtolower($testColumn[0]);
                $this->specificSearch = trim($testColumn[1], ' ');

                $operator = preg_replace('/[^=><!]/', '', $this->specificSearch);
                $this->specificOperator = in_array($operator, $this->specificOperators) ? $operator : null;

                $this->specificSearch = $this->specificOperator ? preg_replace('/[=><!]/', '', $this->specificSearch) : $this->specificSearch;

                if ($this->specificColumn == 'amount' || $this->specificColumn == 'current balance') {
                    $this->getCurrencyIdsFromeSearch(preg_replace('/[-+\s\d+.,]/', '', $this->specificSearch));
                    $this->specificSearch = preg_replace('/[^0-9-.]/', '', $this->specificSearch);
                } elseif ($this->specificColumn == 'date') {
                    $this->specificSearch = date('Y-m-d', strtotime($this->specificSearch));
                    // $this->specificOperator = $this->specificOperator?? '=';
                }
            }
        } else {
            $this->getUserIdsFromeSearch($var);
            $this->getCurrencyIdsFromeSearch($var);
        }


        //$this->resetPage();
    }

    public function getUserIdsFromeSearch($search)
    {
        $this->searchUserIds = [];
        $testUsers = User::select('id')->where('name', 'like', '%' . $search . '%')->get();
        foreach ($testUsers as $index => $tUser) {
            $this->searchUserIds[$index] = $tUser->id;
        }
    }

    public function getCurrencyIdsFromeSearch($search)
    {
        $this->searchCurrencyIds = [];
        $testCurrencies = Currency::select('id')
            ->where('status', '=', 'ENABLED')
            ->where(function ($query) use ($search) {
                $query->where('symbol', '=', $search)
                    ->orWhere('code', '=', $search)
                    ->orWhere('country_and_currency', 'like', '%' . $search . '%');
            })
            ->get();
        foreach ($testCurrencies as $index => $currency) {
            $this->searchCurrencyIds[$index] = $currency->id;
        }
    }

    // Trash user //
    public function confirmTrash(CashTransaction $transaction)
    {
        $this->transaction = $transaction;
        $oldRecord = $transaction->toArray();

        $this->logs = json_decode($transaction->logs) ?? [];

        array_push($this->logs, array_filter($oldRecord, function ($k) {
            return $k != 'logs';
        }, ARRAY_FILTER_USE_KEY));

        $this->dispatchBrowserEvent('show-confirm-trash');
    }

    public function putItemToTrash()
    {
        // draw back amount from cash transaction
        DB::update(
            "UPDATE cash_transactions
            SET balance = balance - ?, user_balance = if(owner = ? , user_balance - ? , user_balance)
            WHERE currency_id = ? AND ((id > ? and tr_date = ?) OR tr_date > ? )
            ",
            [
                $this->transaction->amount,
                $this->transaction->owner,
                $this->transaction->amount,
                $this->transaction->currency_id,
                $this->transaction->id,
                $this->transaction->tr_date,
                $this->transaction->tr_date
            ]
        );

        // draw back amount from balance
        DB::update(
            "UPDATE balances
            SET current_balance = current_balance - ?
            WHERE currency_id = ? AND (user_id = 0 OR user_id  = ? )
            ",
            [
                $this->transaction->amount,
                $this->transaction->currency_id,
                $this->transaction->owner
            ]
        );
        //=================================================================

        // dd($lastBalance);
        $dataRecord = [];
        $dataRecord['updated_by'] = auth()->user()->id;
        $dataRecord['logs'] = json_encode($this->logs);
        $dataRecord['amount'] = 0;
        $dataRecord['status'] = 'DELETED';
        $this->transaction->update($dataRecord);

        $this->reset(['transaction', 'logs']);

        $this->dispatchBrowserEvent('alert-success', ['message' => 'Delete successfully!']);
        // $this->resetComponentVariables();
    }
    // End Trash user

    public function render()
    {
        if ($this->globleBalance) {
            $transactions = CashTransaction::where('status', '!=', 'DELETED')
                ->where(
                    function ($q) {
                        $q->when($this->specificColumn, function ($query) {
                            $query->where($this->searchFields[$this->specificColumn], $this->specificOperator ?? 'like', $this->specificOperator ? $this->specificSearch : '%' . $this->specificSearch . '%')
                                ->when($this->searchCurrencyIds, function ($q) {
                                    $q->whereIn('currency_id', $this->searchCurrencyIds);
                                });
                        })
                            ->when($this->specificColumn == null, function ($query) {
                                $query->where('item_name', 'like', '%' . $this->search . '%')
                                    ->orWhere('tr_date', '=', date('Y-m-d', strtotime($this->search)))
                                    ->orWhere('month', 'like', '%' . $this->search . '%')
                                    ->orWhere('type', 'like', '%' . $this->search . '%')
                                    ->orWhere('amount', '=', $this->search)
                                    ->orWhere('use_on', '=', $this->search)
                                    ->orWhere('balance', '=', $this->search)
                                    ->orWhere('owner_name', $this->search)
                                    ->orWhereIn('currency_id', $this->searchCurrencyIds);
                            });
                    }
                )
                ->orderBy('tr_date', 'desc')
                ->orderBy('id', 'desc')
                // ->toSql();
                // ->orderBy('name', 'asc')
                ->paginate(env('PAGINATE'));
        } else {
            $transactions = CashTransaction::where('status', '!=', 'DELETED')
                ->where('owner', '=', auth()->user()->id)
                ->where(function ($q) {
                    $q->when($this->specificColumn, function ($query) {
                        $query->where($this->searchFields[$this->specificColumn], $this->specificOperator ?? 'like', $this->specificOperator ? $this->specificSearch : '%' . $this->specificSearch . '%')
                            ->when($this->searchCurrencyIds, function ($q) {
                                $q->whereIn('currency_id', $this->searchCurrencyIds);
                            });
                    })
                        ->when($this->specificColumn == null, function ($query) {
                            $query->where('item_name', 'like', '%' . $this->search . '%')
                                ->orWhere('tr_date', '=', date('Y-m-d', strtotime($this->search)))
                                ->orWhere('month', 'like', '%' . $this->search . '%')
                                ->orWhere('type', 'like', '%' . $this->search . '%')
                                ->orWhere('amount', '=', $this->search)
                                ->orWhere('use_on', '=', $this->search)
                                ->orWhere('balance', '=', $this->search)
                                ->orWhere('owner_name', $this->search)
                                ->orWhereIn('currency_id', $this->searchCurrencyIds);
                        });
                })
                ->orderBy('tr_date', 'desc')
                ->orderBy('id', 'desc')
                // ->orderBy('name', 'asc')
                ->paginate(env('PAGINATE'));
        }


        return view('livewire.cash.list-cash-transactions', ['transactions' => $transactions]);
    }
}
