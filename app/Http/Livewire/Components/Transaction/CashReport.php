<?php

namespace App\Http\Livewire\Components\Transaction;

use App\Models\TrCash;
use Livewire\Component;

class CashReport extends Component
{
    public $title='Cash Report';
    // Search varibals
    public $fromDate, $toDate, $depatmentId, $itemId, $otherName, $currencyId, $isOther, $createdBy;
    public $order=['month'=>'desc','tr_date'=>'desc'];
    public $type;

    public function mount($search,$order)
    {
       foreach($search as $key => $val){
        $this->$key = $val;
       }
       $this->order = $order;
    }

    public function render()
    {
        $printData = TrCash::where('status', '!=', 0)
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
        ->orderBy('tr_date', $this->order['tr_date'])
        ->orderBy('id', $this->order['tr_date'])
        ->get();

        return view('livewire.components.transaction.cash-report',['trCashs'=>$printData]);
    }
}
