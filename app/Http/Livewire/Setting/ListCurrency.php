<?php

namespace App\Http\Livewire\Setting;

use App\Models\Currency;
use Livewire\Component;
use Livewire\WithPagination;

class ListCurrency extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = null;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function togleStatus($id)
    {
        $currency = Currency::findOrFail($id);
        $currency->status = $currency->status == 'ENABLED'? 'DISABLED':'ENABLED';
        $currency->update();
        $this->dispatchBrowserEvent('toast', ['message' => "Currency status updated successfully!"]);
    }

    public function updateCurrencyOrder($items)
    {          
        foreach($items as $item){
            Currency::find($item['value'])->update(['position' => (($this->page - 1)* 10) + $item['order']]);
        }

        $this->dispatchBrowserEvent('toast',["title"=>"Currency reposition are successfully!"]);
    }

    public function render()
    {
        if (auth()->user()->isAdmin()) {
            $currencies = Currency::query()
                ->where('country_and_currency', 'like', '%' . $this->search . '%')
                ->orWhere('code', 'like', '%' . $this->search . '%')
                ->orWhere('symbol', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->orderBy('status', 'desc')
                ->orderBy('position', 'asc')
                ->orderBy('country_and_currency', 'asc')
                ->paginate(500);
        } else {
            $currencies = Currency::query()
                ->where('status', '!=', 'DELETED')
                ->where(function ($query) {
                    $query->where('country_and_currency', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%')
                        ->orWhere('symbol', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%');
                })
                ->orderBy('status', 'desc')
                ->orderBy('position', 'asc')
                ->orderBy('country_and_currency', 'asc')
                ->paginate(500);
        }        


        return view('livewire.setting.list-currency', ['currencies' => $currencies]);
    }
}
