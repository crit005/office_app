<?php

namespace App\Http\Livewire\Components;

use App\Models\CashTransaction;
use Livewire\Component;

class UserBalance extends Component
{
    public function render()
    {
        $balances = CashTransaction::where('owner', '=', auth()->user()->id)
            ->groupBy('currency_id')
            ->selectRaw('SUM(amount) as current_balance')
            // ->selectRaw('SUM(amount) as current_balance, currency_id')
            // ->pluck('current_balance','currency_id');
            ->get();

        return view('livewire.components.user-balance', ['balances' => $balances]);
    }
}
