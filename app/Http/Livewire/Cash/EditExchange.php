<?php

namespace App\Http\Livewire\Cash;

use App\Models\CashTransaction;
use App\Models\Currency;
use Livewire\Component;

class EditExchange extends Component
{
    public $fromTransaction = null;
    public $toTransaction = null;
    public $form = null;

    public $selectedCurrency = null;
    public $toSelectedCurrency = null;
    public $showOtherOption = false;

    public $currencies;
    public $arrCurrencies;
    public $currencyIds;
    public $items;
    public $depatments;
    public $item = null;


    public function mount(CashTransaction $transaction)
    {
        $this->currencies = Currency::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();
        foreach ($this->currencies as $index => $currency) {
            $this->currencyIds .= $currency->id;
            if ($index < count($this->currencies) - 1) {
                $this->currencyIds .= ",";
            }
            $this->arrCurrencies[$currency->id] = $currency->toArray();
        }

        if($transaction->type == 'EXPAND'){
            $this->fromTransaction = $transaction;
            $this->toTransaction = CashTransaction::findOrFail($transaction->tr_id);
        } else{
            $this->toTransaction = $transaction;
            $this->fromTransaction = CashTransaction::findOrFail($transaction->tr_id);
        }

        $this->form['tr_date'] = $this->fromTransaction->tr_date;
        $this->form['currency_id'] = $this->fromTransaction->currency_id;
        $this->form['amount'] = $this->fromTransaction->amount;
        $this->form['to_currency_id'] = $this->toTransaction->currency_id;
        $this->form['to_amount'] = $this->toTransaction->amount;
        $this->form['description'] = $this->fromTransaction->description;
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

    public function getValidClass(String $fieldName)
    {
        return array_key_exists($fieldName, $this->form) ? 'is-valid' : '';
    }

    public function render()
    {
        return view('livewire.cash.edit-exchange');
    }
}
