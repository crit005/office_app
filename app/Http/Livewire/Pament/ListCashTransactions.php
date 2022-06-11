<?php

namespace App\Http\Livewire\Pament;

use App\Models\CashTransaction;
use App\Models\Currency;
use App\Models\Items;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use phpDocumentor\Reflection\Types\This;

class ListCashTransactions extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Component variable //
    protected $paginationTheme = 'bootstrap';

    public $search = null;
    public $searchUserIds=[];
    public $searchCurrencyIds=[];


    public function updatedSearch($var)
    {
        $this->getUserIdsFromeSearch($var);
        $this->getCurrencyIdsFromeSearch($var);
        $this->resetPage();
    }

    public function getUserIdsFromeSearch($search)
    {
        $this->searchUserIds =[];
        $testUsers = User::select('id')->where('name','like','%'.$search.'%')->get();
        foreach($testUsers as $index => $tUser){
            $this->searchUserIds[$index] = $tUser->id;
        }
    }

    public function getCurrencyIdsFromeSearch($search)
    {
        $this->searchCurrencyIds =[];
        $testCurrencies = Currency::select('id')
        ->where('status','=','ENABLED')
        ->where(function($query) use($search){
            $query->where('symbol','=',$search)
            ->orWhere('code','like','%'.$search.'%');
        })        
        ->get();
        foreach($testCurrencies as $index => $currency){
            $this->searchCurrencyIds[$index] = $currency->id;
        }
    }

    public function render()
    {
        if (auth()->user()->id <= 2) {
            $transactions = CashTransaction::
                where('status','!=','DELETED')
                ->where(function($query){
                    $query->where('item_name','like','%'.$this->search.'%')
                    ->orWhere('tr_date','=',date('Y-m-d',strtotime($this->search)))
                    ->orWhere('month','like','%'.$this->search.'%')
                    ->orWhere('type','like','%'.$this->search.'%')
                    ->orWhere('amount','=',$this->search)
                    ->orWhere('balance','=',$this->search)
                    ->orWhereIn('owner',$this->searchUserIds)
                    ->orWhereIn('currency_id',$this->searchCurrencyIds)
                    ;
                })                
                ->orderBy('tr_date', 'desc')
                ->orderBy('id', 'desc')
                // ->toSql();
                // ->orderBy('name', 'asc')
                ->paginate(env('PAGINATE'));
                // dd($transactions);
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
