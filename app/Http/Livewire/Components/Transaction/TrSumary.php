<?php

namespace App\Http\Livewire\Components\Transaction;

use App\Models\Currency;
use Livewire\Component;

class TrSumary extends Component
{
    public $searchs = [];
    public $fromDate, $toDate, $depatmentId, $itemId, $otherName, $currencyId, $isOther, $createdBy;
    public $currencys;
    public $totals;

    public function mount($arrSearchs, $arrOptional = null)
    {
        $this->searchs = $arrSearchs;
        if ($arrOptional) {
            foreach ($arrOptional as $key => $val)
                $this->searchs[$key] = $val;
        }
        foreach ($this->searchs as $key => $val) {
            $this->$key = $val;
        }
        $this->fromDate = $this->fromDate ? date('d-M-Y', strtotime($this->fromDate)) : null;
        $this->toDate = $this->toDate ? date('d-M-Y', strtotime($this->toDate)) : null;
        $this->currencys = new Currency();
        $this->totals = $this->currencys->getTotal($this->searchs);
    }

    public function render()
    {
        return view('livewire.components.transaction.tr-sumary');
    }
}
