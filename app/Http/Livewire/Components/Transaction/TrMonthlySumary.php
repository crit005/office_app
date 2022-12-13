<?php

namespace App\Http\Livewire\Components\Transaction;

use Livewire\Component;

class TrMonthlySumary extends Component
{
    public $totals = [];
    public $mode;

    public function mount($totals=[],$mode=0)
    {
        $this->totals = $totals;
        $this->mode = $mode;
    }
    public function render()
    {
        return view('livewire.components.transaction.tr-monthly-sumary');
    }
}
