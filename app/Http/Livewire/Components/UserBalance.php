<?php

namespace App\Http\Livewire\Components;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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

    public function mount()
    {        
        $this->isGloble = Session::get('isGlobleCash')?? false;
    }

    public function switchGloble()
    {
        if (auth()->user()->group_id > 2) {
            $this->isGloble = false;                       
        }else{
            $this->isGloble = !$this->isGloble;
        }
        session(['isGlobleCash' => $this->isGloble]);
        $this->dispatchBrowserEvent('changeCashTransactionMode', ['globleMode' => $this->isGloble]);
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
