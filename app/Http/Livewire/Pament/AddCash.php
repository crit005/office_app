<?php

namespace App\Http\Livewire\Pament;

use App\Models\CashTransaction;
use App\Models\Currency;
use App\Models\Items;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Support\Str;

class AddCash extends Component
{
    public $form = [];
    public $selectedCurrency = null;

    public $currencies;
    public $arrCurrencies;
    public $currencyIds;
    public $item;

    public function mount()
    {
        $this->currencies = Currency::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();
        foreach ($this->currencies as $index => $currency) {
            $this->currencyIds .= $currency->id;
            if ($index < count($this->currencies) - 1) {
                $this->currencyIds .= ",";
            }
            $this->arrCurrencies[$currency->id] = $currency->toArray();
        }
        // intit rule for currency id
        $this->cashRules['currency_id'] .= "|in:" . $this->currencyIds;
        $this->item = Items::where('name', '=', 'Add Cash')->where('status', '=', 'SYSTEM')->first();
    }

    public $cashRules = [
        'tr_date' => 'required|date|',
        'currency_id' => 'required',
        'amount' => 'required|numeric|gt:0'
    ];

    public $cashValidationAttributes = [
        'tr_date' => 'date',
        'currency_id' => 'currency'
    ];

    public function updatedForm($value)
    {
        $rules = array_filter($this->cashRules, function ($key) {
            return in_array($key, array_keys($this->form));
        }, ARRAY_FILTER_USE_KEY);

        Validator::make($this->form, $rules, [], $this->cashValidationAttributes)->validate();
        if (array_key_exists('currency_id', $this->form)) {
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

        $lastBalance = 0; //require function
        $userLastBalance = 0; //require function

        $dataRecord = $this->form;
        $dataRecord['tr_date'] = date('Y-m-d', strtotime($this->form['tr_date']));
        $dataRecord['item_id'] = $this->item->id;
        $dataRecord['item_name'] = $this->item->name;
        $dataRecord['amount'] = $this->form['amount'];
        $dataRecord['bk_amount'] = $this->form['amount'];
        $dataRecord['balance'] = $lastBalance + $this->form['amount'];
        $dataRecord['user_balance'] = $userLastBalance + $this->form['amount'];
        // $dataRecord['currency_id'] = $this->form['currency_id'];
        $dataRecord['to_from'] = auth()->user()->id;
        $dataRecord['month'] = date('M-Y', strtotime($this->form['tr_date']));
        // $dataRecord['description'] = $this->form['description'];
        $dataRecord['owner'] = auth()->user()->id;
        $dataRecord['type'] = "EXPAND";
        $dataRecord['status'] = "DONE";
        $dataRecord['input_type'] = "MENUL";
        // $dataRecord['uuid']= Str::uuid()->toString();
        // $dataRecord['tr_id'] = "";

        CashTransaction::create($dataRecord);

        $this->reset(['form','selectedCurrency']);

        $this->dispatchBrowserEvent('alert-success',['message'=>'Cash added succeffully!']);
    }
    // end add new cash

    public function render()
    {
        return view('livewire.pament.add-cash', ['currencies' => $this->currencies]);
    }
}
