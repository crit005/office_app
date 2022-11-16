<?php

namespace App\Http\Livewire\Components\Transaction;

use Livewire\Component;

class TopTrButtonGroup extends Component
{
    public function render()
    {
        return view('livewire.components.transaction.top-tr-button-group');
    }

    public function OpenAddCashForm()
    {
        $this->dispatchBrowserEvent('show-add-cash-form');
    }
    public function OpenNewPaymentForm()
    {
        $this->dispatchBrowserEvent('show-add-payment-form');
    }
    public function OpenNewExchangeForm()
    {
        $this->dispatchBrowserEvent('show-add-exchange-form');
    }
}
