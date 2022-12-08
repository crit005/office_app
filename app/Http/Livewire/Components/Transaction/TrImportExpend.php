<?php

namespace App\Http\Livewire\Components\Transaction;

use App\Models\Currency;
use App\Models\Items;
use Livewire\Component;

class TrImportExpend extends Component
{
    public $currencys;
    public $importData = [];
    public $items=[];
    public $itemRules;
    public function setImportData($arrExcelData)
    {
        $this->importData = $arrExcelData;
        $this->items = $this->importData[3];
        $this->items = array_filter($this->items, function($value) { return !is_null($value) && $value !== ''; });
        array_pop($this->items);
        $this->validate(null,['item.*'=>'Invalid Payment']);
    }

    public $rules=[
        "items.*"=>'in:Travelling,Perlengkapan Ktr',
    ];

    public function mount()
    {
        $this->currencys = Currency::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();
        $this->initItemRules();
    }
    function initItemRules()
    {
        $items = Items::where('status','=','ENABLED')->get();
        foreach ($items as $index => $item) {
            $this->itemRules .= $item->name;
            if ($index < count($items) - 1) {
                $this->itemRules .= ",";
            }
            // $this->arrCurrencies[$currency->id] = $currency->toArray();
        }
        $this->rules['items.*']='in:'.$this->itemRules;
    }
    public function render()
    {
        return view('livewire.components.transaction.tr-import-expend');
    }
}
