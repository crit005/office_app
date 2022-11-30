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
    public $fromDate, $toDate, $depatmentId, $itemId, $otherName, $currencyId, $isOther;

    protected $listeners = [
        'refreshCashList' => 'refreshCashList',
        'clearEditTransactionCashList' => 'clearEditTransactionCashList'
    ];

    public function refreshCashList()
    {
        $this->reset(['currentMonth']);
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
    }

    public function updated($name, $value)
    {
        if ($name == 'itemId' && $value == 13) {
            $this->isOther = true;
        } else {
            $this->reset(['otherName']);
            $this->isOther = false;
        }
        $this->emptySearchToNull($name,$value);
        $this->resetSearch($name);
    }

    function resetSearch($name)
    {
        if (in_array($name, ['fromDate', 'toDate', 'depatmentId', 'itemId', 'otherName', 'currencyId', 'isOther'])) {
            $this->reset(['currentMonth']);
            $this->takeAmount = env('TAKE_AMOUNT', 100);
        }
    }

    function emptySearchToNull($name,$value)
    {
        if (in_array($name, ['fromDate', 'toDate', 'depatmentId', 'itemId', 'otherName', 'currencyId', 'isOther'])) {
            if($value==''){
                $this->reset([$name]);
            }


        }
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

    public function render()
    {
        // $fromDate, $toDate, $depatmentId, $itemId, $otherName, $currencyId, $isOther;
        if ($this->globleBalance) {
            $transactions = TrCash::where('status', '!=', 0)
                ->where('type', '!=', 4)
                ->orderBy('month', 'desc')
                ->orderBy('tr_date', 'desc')
                ->orderBy('id', 'desc')
                ->take($this->takeAmount)
                ->get();
            // ->toSql();
            // ->orderBy('name', 'asc')
            // ->paginate(env('PAGINATE'));
        } else {
            $transactions = TrCash::where('status', '!=', 0)
                ->where('created_by', '=', auth()->user()->id)
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
                // ->where(function ($q) {
                //     $q
                //         ->when($this->itemId, function ($q) {
                //             $q->where('item_id', '=', $this->itemId);
                //         })
                //         ->when($this->currencyId, function ($q) {
                //             $q->where('currency_id', '=', $this->currencyId);
                //         })
                //         ->when($this->otherName, function ($q) {
                //             $q->orWhere('other_name', 'like', "%" . $this->otherName . "%");
                //         });
                // })

                ->orderBy('month', 'desc')
                ->orderBy('tr_date', 'desc')
                ->orderBy('id', 'desc')
                ->take($this->takeAmount)
                ->get();
            // ->orderBy('name', 'asc')
            // ->paginate(env('PAGINATE'));
        }
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
