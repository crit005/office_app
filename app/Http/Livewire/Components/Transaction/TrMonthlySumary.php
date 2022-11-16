<?php

namespace App\Http\Livewire\Components\Transaction;

use Livewire\Component;

class TrMonthlySumary extends Component
{
    public $totals = [];

    public function mount($totals=[])
    {
        $this->totals = $totals;
    }
    public function render()
    {
        return view('livewire.components.transaction.tr-monthly-sumary');
    }
}
