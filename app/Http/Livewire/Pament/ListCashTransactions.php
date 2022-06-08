<?php

namespace App\Http\Livewire\Pament;

use App\Models\CashTransaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListCashTransactions extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Component variable //
    protected $paginationTheme = 'bootstrap';

    public $search = null;


    protected $adminQuery = "
    SELECT ct.id, ct.tr_date, ct.item_name, ct.amount, ct.balance, ct.user_balance, cu.symbol, cu.code,
	ct.to_from,u.name AS `owner`, ct.type, if(ct.item_name IN ('Add Cash','Transfer'), toUser.name, if(ct.item_name = 'Exchange', toCur.code, dp.name)) AS to_from
    FROM 
    cash_transactions AS ct INNER JOIN items AS it ON ct.item_id = it.id 
    INNER JOIN users AS u ON ct.owner = u.id 
    INNER JOIN depatments AS dp ON ct.to_from = dp.id
    INNER JOIN currencies AS cu ON ct.currency_id = cu.id
    INNER JOIN users AS toUser ON ct.to_from = toUser.id
    INNER JOIN currencies AS toCur ON ct.to_from =  toCur.id
    ";


    public function updatedSearch($var)
    {
        $this->resetPage();
    }

    public function render()
    {
        if (auth()->user()->id <= 2) {
            $transactions = CashTransaction::query()
                ->orderBy('tr_date', 'desc')
                ->orderBy('id', 'desc')
                // ->orderBy('name', 'asc')
                ->paginate(env('PAGINATE'));
        } else {
            $transactions = CashTransaction::query()
                ->where('owner', '=', auth()->user()->id)
                ->orderBy('tr_date', 'desc')
                ->orderBy('id', 'desc')
                // ->orderBy('name', 'asc')
                ->paginate(env('PAGINATE'));
        }
        

        return view('livewire.pament.list-cash-transactions', ['transactions' => $transactions]);
    }
}
