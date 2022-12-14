<?php

namespace App\Http\Livewire\Cash\Transaction;

use App\Models\Currency;
use App\Models\Depatment;
use App\Models\Items;
use App\Models\TrCash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class TrList extends Component
{
    public $globleBalance = false;
    public $currentMonth;
    public $takeAmount;
    // public $refresh;
    public $reachLastRecord = false;
    public $editTransaction;
    public $updateTime = '';
    public $viewTransaction;
    public $viewId;
    public $depatments;
    public $currencys;

    // Search varibals
    public $searchs = [];
    public $fromDate, $toDate, $depatmentId, $itemId, $otherName, $currencyId, $isOther, $createdBy;
    public $order=['month'=>'desc','tr_date'=>'desc'];
    // search options
    public $type;

    protected $listeners = [
        'refreshCashList' => 'refreshCashList',
        'clearEditTransactionCashList' => 'clearEditTransactionCashList'
    ];

    public function switchMonthOrder()
    {
        $this->order['month'] = $this->order['month']=='desc'?'asc':'desc';
        $this->reset(['currentMonth']);
    }
    public function switchDateOrder()
    {
        $this->order['tr_date'] = $this->order['tr_date']=='desc'?'asc':'desc';
        $this->reset(['currentMonth']);
    }

    public function refreshCashList()
    {
        $this->reset(['currentMonth']);
        $this->updateTime = time();
    }

    public function clearEditTransactionCashList($action = null)
    {
        $this->reset(['editTransaction', 'currentMonth']);
        $this->updateTime = time();
        if ($action) {
            if ($action == 'delete') {
                $this->dispatchBrowserEvent('alert-success', ["message" => "Delete Successfuly."]);
            }
        }
    }

    public function isNewMonth($month)
    {
        if ($this->currentMonth != $month) {
            $this->currentMonth = $month;
            return true;
        }
        return false;
    }

    public function inceaseTakeAmount($amount = null)
    {
        if ($amount) {
            $this->takeAmount += $amount;
        } else {
            $this->takeAmount += env('TAKE_AMOUNT', 100);
        }
        $this->reset(['currentMonth']);
    }

    public function mount()
    {
        $this->depatments = Depatment::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();
        $this->currencys = Currency::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();
        $this->items = Items::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();

        $this->globleBalance = Session::get('isGlobleCash') ?? false;
        $this->takeAmount = env('TAKE_AMOUNT', 100);

        $this->createdBy = auth()->user()->id;
        // $this->createdBy = null;

        $this->initSearchs();
    }

    public function updated($name, $value)
    {
        if (($name == 'itemId' && $value == 13) || ($name == 'otherName')) {
            $this->isOther = true;
        } else {
            $this->reset(['otherName']);
            $this->isOther = false;
        }
        $this->emptySearchToNull($name, $value);
        $this->resetSearch($name);

        $this->initSearchs();
    }

    function resetSearch($name)
    {
        if (in_array($name, ['fromDate', 'toDate', 'depatmentId', 'itemId', 'otherName', 'currencyId', 'isOther', 'type'])) {
            $this->reset(['currentMonth']);
            $this->takeAmount = env('TAKE_AMOUNT', 100);
        }
    }

    public function resetUser()
    {
        $this->createdBy = $this->createdBy ? null : auth()->user()->id;
        $this->initSearchs();
    }

    function initSearchs()
    {
        $this->searchs = [
            'fromDate' => $this->fromDate ? date('Y-m-d', strtotime($this->fromDate)) : null,
            'createdBy' => $this->createdBy,
            'toDate' => $this->toDate ? date('Y-m-d', strtotime($this->toDate)) : null,
            'itemId' => $this->itemId,
            'otherName' => $this->otherName,
            'depatmentId' => $this->depatmentId,
            'createdBy' => $this->createdBy,
            'currencyId' => $this->currencyId,
            'type' => $this->type
        ];
        $this->updateTime = time();
    }

    function emptySearchToNull($name, $value)
    {
        if (in_array($name, ['fromDate', 'toDate', 'depatmentId', 'itemId', 'otherName', 'currencyId', 'isOther', 'type'])) {
            if ($value == '') {
                $this->reset([$name]);
            }
        }
    }

    function clearFilter()
    {
        $this->reset(['currentMonth', 'fromDate', 'toDate', 'depatmentId', 'itemId', 'otherName', 'currencyId', 'isOther', 'type']);
        $this->takeAmount = env('TAKE_AMOUNT', 100);
        $this->dispatchBrowserEvent('trResetRankDateTimePicker');
        $this->createdBy = auth()->user()->id;
        $this->initSearchs();
    }

    public function showEdit($id)
    {
        $transaction = TrCash::find($id);
        $this->editTransaction = $transaction;
        $this->reset(['currentMonth']);
    }

    public function showView($id)
    {
        $this->viewId = $id;
        $this->reset(['editTransaction']);
        $this->reset(['currentMonth']);
        $this->dispatchBrowserEvent('show-view-form');
    }

    public function print(){
        $this->dispatchBrowserEvent('show-report-view-data-table-cash-modal');
    }


    public function render()
    {

        $transactions = TrCash::where('status', '!=', 0)
            ->when($this->createdBy, function ($q) {
                $q->where('created_by', '=', $this->createdBy);
            })
            // ->where('created_by', '=', auth()->user()->id)
            ->where('type', '!=', 4)

            ->when($this->fromDate, function ($q) {
                $q->where('tr_date', '>=', date('Y-m-d', strtotime($this->fromDate)));
            })
            ->when($this->toDate, function ($q) {
                $q->where('tr_date', '<=', date('Y-m-d', strtotime($this->toDate)));
            })
            ->when($this->depatmentId, function ($q) {
                $q->where('type', '=', 2)
                    ->where('to_from_Id', '=', $this->depatmentId);
            })
            ->when($this->itemId, function ($q) {
                $q->where('item_id', '=', $this->itemId);
            })
            ->when($this->type, function ($q) {
                $q->where('type', '=', $this->type);
            })
            ->when($this->otherName, function ($q) {
                $q->where('other_name', 'like', "%" . $this->otherName . "%");
            })
            # AND (`currency_id` = 99 OR (`type` = 3 and `to_from_id` = 99))
            ->when($this->currencyId, function ($q) {
                $q->where(function ($q) {
                    $q->where('currency_id', '=', $this->currencyId)
                        ->orWhere(function ($q) {
                            $q->where('type', '=', 3)
                                ->where('to_from_id', '=', $this->currencyId);
                        });
                });
            })


            ->orderBy('month', $this->order['month'])
            // ->orderBy('tr_date', 'desc')
            // ->orderBy('id', 'desc')
            ->orderBy('tr_date', $this->order['tr_date'])
            ->orderBy('id', $this->order['tr_date'])
            ->take($this->takeAmount)
            ->get();
        // ->orderBy('name', 'asc')
        // ->paginate(env('PAGINATE'));

        if ($this->takeAmount > count($transactions)) {
            // if(!$this->reachLastRecord){
            //     $this->dispatchBrowserEvent('reach_the_last_record');
            //     $this->reachLastRecord = true;
            // }
            $this->reachLastRecord = true;
        }

        return view('livewire.cash.transaction.tr-list', ['trCashs' => $transactions]);
    }
}
