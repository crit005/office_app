<?php

namespace App\Http\Livewire\Cash\Transaction;

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
    public $updateTime='';

    protected $listeners = ['refreshCashList' => 'refreshCashList',
    'clearEditTransactionCashList'=>'clearEditTransactionCashList'];

    public function refreshCashList()
    {
        $this->reset(['currentMonth']);
    }

    public function clearEditTransactionCashList()
    {
        $this->reset(['editTransaction','currentMonth']);
        $this->updateTime = time();
    }

    public function isNewMonth($month)
    {
        if($this->currentMonth != $month){
            $this->currentMonth = $month;
            return true;
        }
        return false;
    }

    public function inceaseTakeAmount($amount=null)
    {
        if($amount){
            $this->takeAmount += $amount;
        }else{
            $this->takeAmount += env('TAKE_AMOUNT');
        }
        $this->reset(['currentMonth']);
    }

    public function mount()
    {
        $this->globleBalance = Session::get('isGlobleCash')?? false;
        $this->takeAmount = env('TAKE_AMOUNT');
    }

    public function showEdit(TrCash $transaction)
    {
        $this->editTransaction = $transaction;
        $this->reset(['currentMonth']);
        $this->dispatchBrowserEvent('show-edit-payment-form');
    }

    public function render()
    {
        if ($this->globleBalance) {
            $transactions = TrCash::where('status', '!=', 0)
                ->where('type', '!=', 4)
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
                ->orderBy('tr_date', 'desc')
                ->orderBy('id', 'desc')
                ->take($this->takeAmount)
                ->get();
                // ->orderBy('name', 'asc')
                // ->paginate(env('PAGINATE'));
        }
        if($this->takeAmount > count($transactions)){
            // if(!$this->reachLastRecord){
            //     $this->dispatchBrowserEvent('reach_the_last_record');
            //     $this->reachLastRecord = true;
            // }
            $this->reachLastRecord = true;
        }

        return view('livewire.cash.transaction.tr-list', ['trCashs' => $transactions]);
    }
}
