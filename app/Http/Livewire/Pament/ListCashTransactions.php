<?php

namespace App\Http\Livewire\Pament;

use App\Models\CashTransaction;
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
    

    public function updatedSearch($var)
    {
        $this->resetPage();
    }

    public function render()
    {
        if (auth()->user()->id <= 2) {
            $transactions = CashTransaction::query()            
            ->orderBy('month', 'desc')
            ->orderBy('tr_date', 'desc')
            ->orderBy('name', 'asc')
            ->paginate(env('PAGINATE'));

        }else{
            $transactions = CashTransaction::query() 
            ->where('owner','=',auth()->user()->id)           
            ->orderBy('month', 'desc')
            ->orderBy('tr_date', 'desc')
            ->orderBy('name', 'asc')
            ->paginate(env('PAGINATE'));
        }
        return view('livewire.pament.list-cash-transactions',['transactions'=>$transactions]);
    }
}
