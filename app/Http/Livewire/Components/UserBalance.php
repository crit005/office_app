<?php

namespace App\Http\Livewire\Components;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserBalance extends Component
{
    public $isGloble = false;
    protected $userQuery = "
        SELECT current_balance, currencies.symbol
        From balances INNER JOIN currencies ON balances.currency_id = currencies.id
        WHERE user_id = ?
        ORDER BY currencies.position            
        ";

    protected $globleQuery = "
        SELECT current_balance, currencies.symbol
        From balances INNER JOIN currencies ON balances.currency_id = currencies.id
        WHERE user_id = 0
        ORDER BY currencies.position            
        ";

    protected $noneBalanceQuery = "
    SELECT 0 as current_balance, currencies.symbol
    From currencies
    WHERE status = 'ENABLED'
    ORDER BY currencies.position            
    ";

    public function switchGloble()
    {
        $this->isGloble = !$this->isGloble;
    }

    public function render()
    {


        $balances = DB::select(
            $this->isGloble ? $this->globleQuery : $this->userQuery,
            $this->isGloble ? [] : [auth()->user()->id]
        );

        if (!$balances) {
            $balances = DB::select($this->noneBalanceQuery);
        }


        return view('livewire.components.user-balance', ['balances' => $balances]);
    }
}
