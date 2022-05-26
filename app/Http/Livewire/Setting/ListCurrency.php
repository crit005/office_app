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
        $this->dispatchBrowserEvent('alert-success', ['message' => "Currency status updated successfully!"]);
    }

    public function render()
    {
        $disabledCurrencies = Currency::query()
            ->where('status', '=', 'DISABLED')
            ->where(function ($query) {
                $query->where('country_and_currency', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%')
                    ->orWhere('symbol', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%');
            });

        $currencies = Currency::query()
            ->where('status', '=', 'ENABlED')
            ->where(function ($query) {
                $query->where('country_and_currency', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%')
                    ->orWhere('symbol', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%');
            })
            ->union($disabledCurrencies)
            ->paginate(10);


        return view('livewire.setting.list-currency', ['currencies' => $currencies]);
    }
}
