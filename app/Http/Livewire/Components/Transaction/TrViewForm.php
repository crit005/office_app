<?php

namespace App\Http\Livewire\Components\Transaction;

use App\Models\TrCash;
use Livewire\Component;

class TrViewForm extends Component
{
    public TrCash $transaction;
    public function mount($id=null)
    {
        if($id){
            $this->transaction = TrCash::find($id);
        }
    }
    public function render()
    {
        return view('livewire.components.transaction.tr-view-form');
    }
}
