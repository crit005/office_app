<?php

namespace App\Http\Livewire\Components\Transaction;

use App\Models\Balance;
use App\Models\Currency;
use App\Models\Depatment;
use App\Models\Items;
use App\Models\TrCash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class TrEditForm extends Component
{
    public TrCash $transaction;

    public $form = [];
    public $selectedCurrency = null;
    public $showOtherOption = false;

    public $currencies;
    public $arrCurrencies;
    public $currencyIds;
    public $items;
    public $depatments;
    public $newTranaction;

    public $currencyBalance = 0;
    public $currencyNexBalance = 0;

    public $logs;
    public $oldCurrency_id;

    protected $listeners = ['trEditPaymentFormDelete' => 'deletePayment'];

    public function mount($id)
    {
        $transaction = TrCash::find($id);
        $this->transaction = $transaction;
        $this->form = $transaction->toArray();
        $this->form['to_from'] = $transaction->to_from_id;
        $this->form['amount'] = - $transaction->amount;
        $this->form['tr_date'] = date('d-M-Y', strtotime($this->form['tr_date']));

        $this->oldCurrency_id = $transaction->currency_id;

        $this->logs = json_decode($transaction->logs) ?? [];
        array_push($this->logs, array_filter($transaction->toArray(), function ($k) {
            return $k != 'logs';
        }, ARRAY_FILTER_USE_KEY));

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

        $this->items = Items::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();

        $this->depatments = Depatment::where('status', '=', 'ENABLED')->get();

        $this->selectedCurrency = $this->arrCurrencies[$this->form['currency_id']]['symbol'];

        if($transaction->item_id == 13){
            $this->form['item_name'] = $transaction->other_name;
            $this->showOtherOption = true;
            $this->cashRules['item_name'] = 'required';
        }
    }

    public $cashRules = [
        'tr_date' => 'required|date|',
        'currency_id' => 'required',
        'amount' => 'required|numeric|gt:0',
        'item_id' => 'required',
        'to_from' => 'required'

    ];

    public $cashValidationAttributes = [
        'tr_date' => 'date',
        'currency_id' => 'currency',
        'item_id' => 'expand name',
        'to_from' => 'expand on',
        'item_name' => 'Other Expand Name'
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

    public function updatePayment()
    {
        Validator::make($this->form, $this->cashRules, [], $this->cashValidationAttributes)->validate();

        //! generate dataRecord
        $dataRecord = $this->form;
        $dataRecord['tr_date'] = date('Y-m-d', strtotime($this->form['tr_date']));
        $dataRecord['item_id'] = $this->form['item_id'];
        $dataRecord['other_name'] = $this->form['item_id'] == 13 ? $this->form['item_name'] : null;
        $dataRecord['amount'] = -$this->form['amount'];
        // $dataRecord['currency_id'] = in $form;
        $dataRecord['to_from_id'] =  $this->form['to_from'];
        $dataRecord['month'] = date("Y-m-01", strtotime($dataRecord['tr_date']));
        // $dataRecord['description'] =  in $form;
        // $dataRecord['created_by'] = auth()->user()->id;
        // $dataRecord['type'] = 2; //1 = income, 2 = expand
        // $dataRecord['status'] = 1; //0 = deleted, 1 = done, 2 = wait
        // $dataRecord['input_type'] = 1; //1= menuly input, 2 = import from excle
        // $dataRecord['tr_id'] = null;
        $dataRecord['updated_by'] = auth()->user()->id;
        $dataRecord['logs'] = json_encode($this->logs);
        // $dataRecord['created_at'] = auto;
        // $dataRecord['updated_at'] = auto;

        //!=====================================

        $this->transaction->update($dataRecord);

        $this->reset(['form','currencyBalance','currencyNexBalance','selectedCurrency']);

        $this->form['tr_date'] = date('d-M-Y', strtotime(now()));


        //! update balance after update
        updateBalance($this->transaction->currency_id,auth()->user()->id);

        //! update old currency Balance
        if($this->oldCurrency_id != $this->transaction->currency_id){
            updateBalance($this->oldCurrency_id,auth()->user()->id);
        }
        $this->dispatchBrowserEvent('update-payment-alert-success');
    }

    public function deletePayment()
    {
        $oldCurrency_id = $this->transaction->currency_id;
        $oldUser_id = $this->transaction->created_by;
        // $this->transaction->status = 0;
        $this->transaction->update(['status'=>0,'updated_by'=>auth()->user()->id,'logs'=>$this->logs]);
        updateBalance($oldCurrency_id,$oldUser_id);
        $this->emitUp('clearEditTransactionCashList','delete');
    }

    public function render()
    {
        return view('livewire.components.transaction.tr-edit-form');
    }
}
