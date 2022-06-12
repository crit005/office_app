<?php

namespace App\Http\Livewire\Pament;

use App\Models\CashTransaction;
use App\Models\Currency;
use App\Models\Items;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use phpDocumentor\Reflection\Types\This;

class ListCashTransactions extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Component variable //
    protected $paginationTheme = 'bootstrap';

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
        'use on' => 'to_from',
        'month' => 'month',
        'created by' => 'owner',
        'type' => 'type'
    ];


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


        $this->resetPage();
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
                    ->orWhere('country_and_currency', 'like', '%'.$search.'%');
            })
            ->get();
        foreach ($testCurrencies as $index => $currency) {
            $this->searchCurrencyIds[$index] = $currency->id;
        }
    }

    public function render()
    {
        if (auth()->user()->id <= 2) {
            $transactions = CashTransaction::where('status', '!=', 'DELETED')
                ->when($this->specificColumn, function ($query) {
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
                        ->orWhere('balance', '=', $this->search)
                        ->orWhereIn('owner', $this->searchUserIds)
                        ->orWhereIn('currency_id', $this->searchCurrencyIds);
                })
                ->orderBy('tr_date', 'desc')
                ->orderBy('id', 'desc')
                // ->toSql();
                // ->orderBy('name', 'asc')
                ->paginate(env('PAGINATE'));

            $transactionssql = CashTransaction::where('status', '!=', 'DELETED')
                ->when($this->specificColumn, function ($query) {
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
                        ->orWhere('balance', '=', $this->search)
                        ->orWhereIn('owner', $this->searchUserIds)
                        ->orWhereIn('currency_id', $this->searchCurrencyIds);
                })
                ->orderBy('tr_date', 'desc')
                ->orderBy('id', 'desc')
                ->toSql();
            // ->orderBy('name', 'asc')
            // ->paginate(env('PAGINATE'));
            // dd($transactionssql);
            $this->dum = $transactionssql;
        } else {
            $transactions = CashTransaction::query()
                ->where('owner', '=', auth()->user()->id)
                ->orderBy('tr_date', 'desc')
                ->orderBy('id', 'desc')
                // ->orderBy('name', 'asc')
                ->paginate(env('PAGINATE'));
        }


        return view('livewire.pament.list-cash-transactions', ['transactions' => $transactions]);
    }
}
