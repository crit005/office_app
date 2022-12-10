<?php

namespace App\Http\Livewire\Components\Transaction;

use App\Models\Currency;
use App\Models\Depatment;
use App\Models\Items;
use Livewire\Component;

class TrImportExpend extends Component
{
    public $currencys;
    public $importData = [];
    public $dataRows = [];
    public $items=[];
    public $itemRules, $depatmentRules;


    public function setImportData($arrExcelData)
    {
        $this->importData = $arrExcelData;
        $this->items = $this->importData[3];
        $this->items = array_filter($this->items, function($value) { return !is_null($value) && $value !== ''; });
        array_pop($this->items);
        $this->initDataRows();
        $this->rules['dataRows.*.'.count($this->importData[0])-2]=[
            //'in:'.$this->depatmentRules,
            function($attribute, $value,$fail){
                $test = $this->dataRows[explode(".",$attribute)[1]][2]??false;
                if(!$test){ // not exist kay
                    if($value==null || $value == ''){
                        $fail('depatment required');
                    }else{
                        if(!in_array($value,explode(',',$this->depatmentRules))){
                            $fail('depatment invalid');
                        }
                    }
                }else{ // kay exist
                    if($value !=null || $value != ''){
                        $fail('depatment should be blank');
                    }
                }
            },
    ];
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
                            return ((!is_null($value) && $value !== '') && (!in_array($key, [1, count($row) - 1,count($row) - 4])) || $key == (count($row) - 2) || $key == (count($row) - 3));
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
        $this->initDepatmentRules();
    }

    function initItemRules()
    {
        $this->itemRules='';
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
    function initDepatmentRules()
    {
        $this->depatmentRules= '';
        $depatments = Depatment::where('status','=','ENABLED')->get();
        foreach ($depatments as $index => $depatment) {
            $this->depatmentRules .= $depatment->name;
            if ($index < count($depatments) - 1) {
                $this->depatmentRules .= ",";
            }
        }
    }
    public function render()
    {
        return view('livewire.components.transaction.tr-import-expend');
    }
}
