<?php

namespace App\Http\Livewire\Components\Transaction;

use App\Models\Currency;
use App\Models\Depatment;
use App\Models\Items;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class TrImportExpend extends Component
{
    public $currencys;
    public $importData = [];
    public $dataRows = [];
    public $items=[], $inputItems;
    public $depatments=[];
    public $itemRules;
    public $test=[];
    public $currencyId;

    public function rules()
    {
        return  [
            'inputItems.*'=>'required|in:'.$this->itemRules,
            "dataRows.*.0"=>'required|date',
            "dataRows.*.*"=>function($attribute, $value, $fail){
                $j =  explode(".", $attribute)[1];
                $cashin = $this->dataRows[$j][2];
                if (!$cashin) { // not kas
                    $i = explode('.', $attribute)[2];
                    if ($i > 2 && $i < (count($this->importData[0] ?? []) - 4)) {
                        if ($value != null || $value != '') {
                            if (!is_numeric($value)) {
                                $fail('Expend must be a number');
                            } elseif ($value >= 0) {
                                $fail('Expend must less than 0');
                            }
                            if(count($this->dataRows[$j])>5){
                                $fail('There were multiple amounts found');
                            }
                        }
                    }
                } else { // has kas
                    $i = explode('.',$attribute)[2];
                    if($i>2 && $i<(count($this->importData[0] ?? []) - 4)){
                        if($value!=null || $value != ''){
                            $fail('There were multiple amounts found');
                        }
                    }
                }
            },
            "dataRows.*.2"=> function ($attribute, $value, $fail) {
                $j =  explode(".", $attribute)[1];
                if ($value != null || $value != '') {
                    if (count($this->dataRows[$j]) >= 5) {
                        $fail('There were multiple amounts found');
                    } elseif (!is_numeric($value)) {
                        $fail('Cashin must be a number');
                    } elseif ($value <= 0) {
                        $fail('Cash in must greater than 0');
                    }
                } else {
                    if (count($this->dataRows[$j]) < 5) {
                        $fail('Required amount');
                    }
                }
            },
            "dataRows.*." . (count($this->importData[0] ?? []) - 2) =>
            function ($attribute, $value, $fail) {
                // if ($value == null || $value == '') {
                //     $fail('Invalid');
                // }
                $cashin = $this->dataRows[explode(".", $attribute)[1]][2];
                if (!$cashin) { // not kas
                    if ($value == null || $value == '') {
                        $fail('Required department');
                    } else {
                        if (!array_key_exists($value, $this->depatments)) {
                            $fail('Invalid department');
                        }
                    }
                } else { // has kas
                    if ($value != null || $value != '') {
                        $fail('For cash in, department should be blank');
                    }
                }
            },

        ];
    }

    public function mount()
    {
        $this->currencys = Currency::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();
        $this->initItems();
        $this->initDepatments();
        $this->initItemRules();
    }

    function initItems()
    {
        $this->items = [];
        $items = Items::select(['id', 'name'])->where('status', '=', 'ENABLED')->get();
        foreach ($items as $item) {
            $this->itemRules[$item->name] = $item->id;
        }
    }

    function initDepatments()
    {
        $this->depatments = [];
        $depatments = Depatment::select(['id', 'name'])->where('status', '=', 'ENABLED')->get();
        foreach ($depatments as $depatment) {
            $this->depatments[$depatment->name] = $depatment->id;
        }
    }

    function initItemRules()
    {
        $this->itemRules='';

        $items = Items::select(['id','name'])->where('status','=','ENABLED')->get();
        foreach ($items as $index => $item) {
            $this->itemRules .= $item->name;
            if ($index < count($items) - 1) {
                $this->itemRules .= ",";
            }
        }
        // $this->rules['inputItems.*']='required|in:'.$this->itemRules;
    }

    public function setImportData($arrExcelData)
    {
        $this->resetImportData();
        $this->importData = $arrExcelData;
        if(count($arrExcelData)>=5){
            $this->inputItems = $this->importData[3];
            $this->inputItems = array_filter($this->inputItems, function($value) { return !is_null($value) && $value !== ''; });
            array_pop($this->inputItems); // delete total col
            $this->initDataRows();
            $this->validate();
        }

    }

    public function resetImportData(){
        $this->reset(['importData','dataRows','currencyId']);
    }

    public function initDataRows()
    {
        $this->dataRows = [];
        foreach ($this->importData as $index => $row) {
            if ($index > 3) {
                array_push(
                    $this->dataRows,
                    array_filter(
                        $row,
                        function ($value, $key) use ($row) {
                            return (($key == 2) || (!is_null($value) && $value !== '') && (!in_array($key, [1, count($row) - 1, count($row) - 4])) || $key == (count($row) - 2) || $key == (count($row) - 3));
                        },
                        ARRAY_FILTER_USE_BOTH
                    )
                );
            }
        }
    }

    function initDepatmentRulls()
    {
        $this->rules['dataRows.*.' . count($this->importData[0]) - 2] = [
            function ($attribute, $value, $fail) {
                if($value == null || $value == ''){
                    $fail('invalid');
                }
                $cashin = $this->dataRows[explode(".", $attribute)[1]][2];
                if (!$cashin) { // not kas
                    if ($value == null || $value == '') {
                        $fail('depatment required');
                    }
                    else {
                        if (!array_key_exists($value, $this->depatments)) {
                            $fail('depatment invalid');
                        }
                    }
                } else { // has kas
                    if ($value != null || $value != '') {
                        $fail('For cash in department should be blank');
                    }
                }
            },
        ];
    }

    public function render()
    {
        return view('livewire.components.transaction.tr-import-expend');
    }
}
