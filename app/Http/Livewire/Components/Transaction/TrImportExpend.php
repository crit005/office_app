<?php

namespace App\Http\Livewire\Components\Transaction;

use App\Models\Currency;
use App\Models\Depatment;
use App\Models\Items;
use App\Models\TrCash;
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
    public $currency;
    public $selectedCurrency;
    public $month;

    public function updatedCurrency($value){
        $this->selectedCurrency = Currency::find($value);
        $this->validate();
    }

    public function rules()
    {
        return  [
            'month'=>'required|date',
            'importData'=>'required',
            'currency' => 'required',
            'inputItems.*'=>'required|in:'.$this->itemRules,
            // "dataRows.*.0"=>'required|date,
            "dataRows.*.0" => [
                'required','date',
                function($attribute, $value, $fail){
                    if($this->month && date('d-m-Y',strtotime($this->month))!='01-01-1970'){
                        $firstDate = date('01-m-Y',strtotime($this->month));
                        $lastDate = date('t-m-Y',strtotime($this->month));
                        $recordDate = date('d-m-Y',strtotime($value));
                        if(!(strtotime($firstDate) <= strtotime($recordDate) && strtotime($recordDate) <= strtotime($lastDate))){
                            $fail('Date should be between '.$firstDate.' and '.$lastDate);
                        }
                    }else{
                        $fail('Invalid date rank');
                    }
                }
            ],
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
        $items = Items::select(['id', 'name'])->where('status', '!=', 'DISABLED')->get();
        foreach ($items as $item) {
            $this->items[$item->name] = $item->id;
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
        $this->reset(['importData','dataRows']);
        $this->importData = $arrExcelData;
        if(count($arrExcelData)>=5){
            $this->month = $this->importData[1][0];
            $this->inputItems = $this->importData[3];
            $this->inputItems = array_filter($this->inputItems, function($value) { return !is_null($value) && $value !== ''; });
            array_pop($this->inputItems); // delete total col
            $this->initDataRows();
            $this->validate();
        }
    }

    public function resetImportData(){
        $this->reset(['importData','dataRows','currency','selectedCurrency','month']);
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

    function saveDatas(){
        $this->validate();
        $rows=[];
        foreach($this->dataRows as $dataRow){
            $dataRecord=[];
            $n=1;
            $cashin = false;
            $isOthers = false;
            foreach ($dataRow as $key => $value) {
                if ($n == 1) {
                    $dataRecord['tr_date'] = date('Y-m-d', strtotime($value));
                    $dataRecord['month'] = date("Y-m-01", strtotime($value));
                } elseif ($n == 2 && ($value != null || $value != '')) {
                    $dataRecord['item_id'] = $this->items['Add Cash'];
                    $dataRecord['amount'] = $value;
                    $dataRecord['to_from_id'] =  auth()->user()->id;
                    $dataRecord['type'] = 1; //1 = income, 2 = expand
                    $cashin = true;
                }elseif($n == 3){
                    if($cashin){
                        $dataRecord['description'] =  $value;
                        $dataRecord['other_name'] = null;
                    }else{
                        $dataRecord['item_id'] = $this->items[$this->inputItems[$key]];
                        $isOthers = $this->inputItems[$key] == 'Others' ?? false;
                        $dataRecord['amount'] = $value;
                        $dataRecord['type'] = 2; //1 = income, 2 = expand
                    }
                }elseif($n == 4){
                    if(!$cashin){
                        if(!$isOthers){
                            $dataRecord['other_name'] = null;
                            $dataRecord['description'] =  $value;
                        }else{
                            $dataRecord['other_name'] = 'Others';
                            $dataRecord['description'] =  $value;
                        }
                    }
                }elseif($n == 5){
                    if(!$cashin){
                        $dataRecord['to_from_id'] =  $this->depatments[$value];
                    }
                }
                $n += 1;
            }
            $dataRecord['currency_id'] = $this->currency;
            $dataRecord['created_by'] = auth()->user()->id;
            $dataRecord['status'] = 1; //0 = deleted, 1 = done, 2 = wait
            $dataRecord['input_type'] = 2; //1= menuly input, 2 = import from excle

            array_push($rows,$dataRecord);

        }
        $test = TrCash::insert($rows);
        if($test){
            updateBalance($this->currency, auth()->user()->id);
        }
        $this->dispatchBrowserEvent('import-alert-success');
    }


    public function render()
    {
        return view('livewire.components.transaction.tr-import-expend');
    }
}
