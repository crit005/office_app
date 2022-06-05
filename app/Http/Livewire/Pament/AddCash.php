<?php

namespace App\Http\Livewire\Pament;

use App\Models\CashTransaction;
use App\Models\Currency;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AddCash extends Component
{
    public $form =[];
    public $selectedCurrency = null;
    public $currencies;
    public $arrCurrencies;
    public $currencyIds;

    public function mount()
    {
        $this->currencies = Currency::where('status','=','ENABLED')->orderBy('position','asc')->get();
        foreach($this->currencies as $index => $currency){
            $this->currencyIds .= $currency->id;
            if($index < count($this->currencies)-1){
                $this->currencyIds .= ",";
            }
            $this->arrCurrencies[$currency->id] = $currency->toArray();
        }
        // intit rule for currency id
        $this->cashRules['currency_id'] .= "|in:" .$this->currencyIds;        
    }

    public $cashRules=[
        'tr_date'=>'required|date|',
        'currency_id' => 'required',
        'amount' => 'required|numeric|gt:0'
    ];

    public $cashValidationAttributes=[
        'tr_date' => 'date',
        'currency_id' => 'currency'
    ];

    public function updatedForm($value)
    {
        $rules = array_filter($this->cashRules, function ($key) {
            return in_array($key, array_keys($this->form));
        }, ARRAY_FILTER_USE_KEY);

        Validator::make($this->form, $rules,[],$this->cashValidationAttributes)->validate();
        if(array_key_exists('currency_id',$this->form)){
            $this->selectedCurrency = $this->arrCurrencies[$this->form['currency_id']]['symbol'];
        }
    }

    public function getValidClass(String $fieldName)
    {
        return array_key_exists($fieldName, $this->form) ? 'is-valid' : '';
    }

    // add new cash
    public function addCash()
    {
        Validator::make($this->form, $this->cashRules, [], $this->cashValidationAttributes)->validate();

        dd($this->form);

        // $dataRecord = $this->form;

        // $dataRecord['created_by'] = auth()->user()->id;

        // CashTransaction::create($dataRecord);        
    }
    // end add new cash

    public function render()
    {
        return view('livewire.pament.add-cash',['currencies' => $this->currencies]);
    }
}
