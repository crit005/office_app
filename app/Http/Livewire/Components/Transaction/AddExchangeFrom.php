<?php

namespace App\Http\Livewire\Components\Transaction;

use App\Models\Balance;
use App\Models\Currency;
use App\Models\Depatment;
use App\Models\Items;
use App\Models\TrCash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AddExchangeFrom extends Component
{
    public $form = [];
    public $selectedCurrency = null;
    public $toSelectedCurrency = null;
    public $showOtherOption = false;

    public $currencies;
    public $arrCurrencies;
    public $currencyIds;
    public $items;
    public $depatments;
    public $newTranaction;
    public $item = null;

    public $currencyBalance = 0;
    public $currencyNexBalance = 0;

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
        // $this->cashRules['to_currency_id'] .= "|in:" . $this->currencyIds;

        $this->item = Items::where('status', '=', 'SYSTEM')->where('name', '=', 'Exchange')->first()->id;

        $this->items = Items::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();

        $this->depatments = Depatment::where('status', '=', 'ENABLED')->get();
    }

    public $cashRules = [
        'tr_date' => 'required|date|',
        'currency_id' => 'required',
        'amount' => 'required|numeric|gt:0',
        // 'item_id' => 'required',
        // 'to_from' => 'required',
        'to_currency_id' => 'required',
        'to_amount' => 'required|numeric|gt:0'

    ];

    public $cashValidationAttributes = [
        'tr_date' => 'date',
        'currency_id' => 'currency',
        // 'item_id' => 'expand name',
        // 'to_from' => 'expand on',
        'item_name' => 'Other Expand Name',
        'to_currency_id' => 'to currency',
        'to_amount' => 'to amount'
    ];

    public function updatedForm($value)
    {
        $rules = array_filter($this->cashRules, function ($key) {
            return in_array($key, array_keys($this->form));
        }, ARRAY_FILTER_USE_KEY);

        if (array_key_exists('item_id', $this->form)) {
            if ($this->form['item_id'] == 13) {
                $this->showOtherOption = true;
                $this->cashRules['item_name'] = 'required';
            } else {
                $this->showOtherOption = false;
                $this->cashRules['item_name'] = 'sometimes';
            }
        }

        Validator::make($this->form, $rules, [], $this->cashValidationAttributes)->validate();
        if (array_key_exists('currency_id', $this->form)) {
            $this->selectedCurrency = $this->arrCurrencies[$this->form['currency_id']]['symbol'];
            if (array_key_exists('to_currency_id', $this->form)) {
                if ($this->form['currency_id'] == $this->form['to_currency_id']) {
                    $this->toSelectedCurrency = null;
                    unset($this->form['to_currency_id']);
                }
            }
        }
        if (array_key_exists('to_currency_id', $this->form)) {
            $this->toSelectedCurrency = $this->arrCurrencies[$this->form['to_currency_id']]['symbol'];
        }
    }

    public function getValidClass(String $fieldName)
    {
        return array_key_exists($fieldName, $this->form) ? 'is-valid' : '';
    }

    //! calculate get currency balance for user
    public function getCurrencyBalance()
    {
        if ($this->selectedCurrency && array_key_exists('currency_id', $this->form)) {
            $currencyBalance = Balance::where('currency_id', '=', $this->form['currency_id'])->where('user_id', '=', auth()->user()->id)->first();
            if($currencyBalance){
                $this->currencyBalance = $currencyBalance->current_balance;
                return $this->currencyBalance . ' ' . $this->selectedCurrency;
            }


        }
        return '...';
    }

    //! calculate currency next balance
    public function getCurrencyNexBalance()
    {
        if ($this->selectedCurrency) {
            $amount = 0 ;
            if(array_key_exists('amount', $this->form) && ($this->form['amount']!='')){
                $amount = $this->form['amount'];
            }
            $this->currencyNexBalance = $this->currencyBalance - $amount;
            return $this->currencyNexBalance . ' ' . $this->selectedCurrency;
        }
        return '...';
    }

    public function addExchange()
    {

        Validator::make($this->form, $this->cashRules, [], $this->cashValidationAttributes)->validate();
        // $v = Validator::make($this->form, $this->cashRules, [], $this->cashValidationAttributes);

        // if ($v->fails())
        // {
        //     $messages = $v->messages();
        //     dd($messages);
        // }

        //! generate dataRecord from
        // $dataRecord = $this->form;
        $dataRecord['tr_date'] = date('Y-m-d', strtotime($this->form['tr_date']));
        $dataRecord['item_id'] = $this->item;
        $dataRecord['other_name'] = $this->form['to_amount'].$this->toSelectedCurrency;
        $dataRecord['amount'] = -$this->form['amount'];
        $dataRecord['currency_id'] = $this->form['currency_id'];
        $dataRecord['to_from_id'] =  $this->form['to_currency_id'];
        $dataRecord['month'] = date("Y-m-01", strtotime($dataRecord['tr_date']));
        $dataRecord['description'] =  $this->form['description'] ?? null;
        $dataRecord['created_by'] = auth()->user()->id;
        $dataRecord['type'] = 3; //1 = income, 2 = expand, 3 = exchange out, 4 = exchange in
        $dataRecord['status'] = 2; //0 = deleted, 1 = done, 2 = wait
        $dataRecord['input_type'] = 1; //1= menuly input, 2 = import from excle
        // $dataRecord['tr_id'] = null;
        // $dataRecord['updated_by'] = null;
        // $dataRecord['logs'] = null;
        // $dataRecord['created_at'] = auto;
        // $dataRecord['updated_at'] = auto;

        $fromTranaction = TrCash::create($dataRecord);


        //==================================================

        //! generate dataRecord to
        // $dataRecord = $this->form;
        $dataRecordTo['tr_date'] = date('Y-m-d', strtotime($this->form['tr_date']));
        $dataRecordTo['item_id'] = $this->item;
        $dataRecordTo['other_name'] = -$this->form['amount'].$this->selectedCurrency;
        $dataRecordTo['amount'] = $this->form['to_amount'];
        $dataRecordTo['currency_id'] = $this->form['to_currency_id'];
        $dataRecordTo['to_from_id'] =  $this->form['currency_id'];
        $dataRecordTo['month'] = date("Y-m-01", strtotime($dataRecord['tr_date']));
        $dataRecordTo['description'] =  'The exchage amount from exchange id'.$fromTranaction->id;
        $dataRecordTo['created_by'] = auth()->user()->id;
        $dataRecordTo['type'] = 4; //1 = income, 2 = expand
        $dataRecordTo['status'] = 1; //0 = deleted, 1 = done, 2 = wait
        $dataRecordTo['input_type'] = 1; //1= menuly input, 2 = import from excle
        $dataRecordTo['tr_id'] = $fromTranaction->id;
        // $dataRecord['updated_by'] = null;
        // $dataRecord['logs'] = null;
        // $dataRecord['created_at'] = auto;
        // $dataRecord['updated_at'] = auto;

        $toTranaction = TrCash::create($dataRecordTo);

        $fromTranaction->update(['tr_id' => $toTranaction->id, 'status' => 1]);

        // Update balance
        updateBalance($fromTranaction->currency_id,auth()->user()->id);
        updateBalance($toTranaction->currency_id,auth()->user()->id);

        $this->reset(['form','currencyBalance','currencyNexBalance','selectedCurrency']);
        $this->form['tr_date'] = date('d-M-Y', strtotime(now()));

        $this->dispatchBrowserEvent('add-exchange-alert-success');
    }

    public function render()
    {
        return view('livewire.components.transaction.add-exchange-from');
    }
}
