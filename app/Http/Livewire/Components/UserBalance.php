<?php

namespace App\Http\Livewire\Components;

use App\Models\CashTransaction;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserBalance extends Component
{
    public function render()
    {
        $balances = DB::select(
            "
            SELECT SUM(cash_transactions.amount) as current_balance, currencies.symbol
            From cash_transactions INNER JOIN currencies ON cash_transactions.currency_id = currencies.id
            WHERE cash_transactions.owner = ?
            GROUP BY cash_transactions.currency_id ,currencies.symbol
        ",
            [
                auth()->user()->id
            ]
        );
        if (!$balances) {
            $currencies = Currency::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();
            foreach ($currencies as $index => $currency) {
                array_push($balances, ['current_balance'=>0, 'symbol' =>  $currency->symbol]);
            }
            $balances = json_decode(json_encode($balances)) ;
        }

        // $balances=CashTransaction::where('owner','=',auth()->user()->id)->latest()->get()->groupBY('currency_id');

        return view('livewire.components.user-balance', ['balances' => $balances]);
    }
}
