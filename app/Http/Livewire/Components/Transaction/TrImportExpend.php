<?php

namespace App\Http\Livewire\Components\Transaction;

use App\Models\Currency;
use App\Models\Items;
use Livewire\Component;

class TrImportExpend extends Component
{
    public $currencys;
    public $importData = [];
    public $dataRows = [];
    public $items=[];
    public $itemRules;

    public function setImportData($arrExcelData)
    {
        $this->importData = $arrExcelData;
        $this->items = $this->importData[3];
        $this->items = array_filter($this->items, function($value) { return !is_null($value) && $value !== ''; });
        array_pop($this->items);
        $this->initDataRows();
        $this->validate(null,['item.*'=>'Invalid Payment']);
    }

    function initDataRows()
    {
        $this->dataRows = [];
        foreach($this->importData as $index => $row){
            if ($index > 3) {
                array_push(
                    $this->dataRows,
                    array_filter(
                        $row,
                        function ($value, $key)use($row) {
                            return (!is_null($value) && $value !== '') && (!in_array($key, [1, 2, count($row) - 1,count($row) - 4]));
                        }, ARRAY_FILTER_USE_BOTH
                    )
                );
            }
        }
    }

    public $rules=[
        "items.*"=>'in:Travelling,Perlengkapan Ktr',
        "dataRows.*.0"=>'date',
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
