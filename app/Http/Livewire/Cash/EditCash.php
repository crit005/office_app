<?php

namespace App\Http\Livewire\Cash;

use App\Models\Balance;
use App\Models\CashTransaction;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class EditCash extends Component
{
    public $form = [];
    public $selectedCurrency = null;
    public $transaction = null;
    public $currencies;
    public $arrCurrencies;
    public $currencyIds;
    public $logs;

    public function mount(CashTransaction $transaction)
    {
        $this->transaction = $transaction;
        $this->form = $transaction->toArray();

        $this->logs = json_decode($transaction->logs)?? [];
        
        array_push($this->logs, array_filter($this->form, function($k) {
            return $k != 'logs';
        }, ARRAY_FILTER_USE_KEY));


        $this->form['tr_date'] = date('d-M-Y', strtotime($this->form['tr_date']));
        $this->currencies = Currency::where('status', '=', 'ENABLED')->orWhere('id', '=', $transaction->currency_id)->orderBy('position', 'asc')->get();
        foreach ($this->currencies as $index => $currency) {
            $this->currencyIds .= $currency->id;
            if ($index < count($this->currencies) - 1) {
                $this->currencyIds .= ",";
            }
            $this->arrCurrencies[$currency->id] = $currency->toArray();
        }
        // intit rule for currency id
        $this->cashRules['currency_id'] .= "|in:" . $this->currencyIds;
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
    public function updateCash()
    {
        Validator::make($this->form, $this->cashRules, [], $this->cashValidationAttributes)->validate();

        // $log = array_push()

        // draw back amount from cash transaction
        DB::update(
            "UPDATE cash_transactions
            SET balance = balance - ?, user_balance = if(owner = ? , user_balance - ? , user_balance)
            WHERE currency_id = ? AND ((id > ? and tr_date = ?) OR tr_date > ? )
            ",
            [
                $this->transaction->amount,
                $this->transaction->owner,
                $this->transaction->amount,
                $this->transaction->currency_id,
                $this->transaction->id,
                $this->transaction->tr_date,
                $this->transaction->tr_date
            ]
        );

        // draw back amount from balance
        DB::update(
            "UPDATE balances
            SET current_balance = current_balance - ?
            WHERE currency_id = ? AND (user_id = 0 OR user_id  = ? )
            ",
            [
                $this->transaction->amount,
                $this->transaction->currency_id,
                $this->transaction->owner
            ]
        );
        //=================================================================

        

        $lastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('id','!=',$this->transaction->id)
            ->where('currency_id', '=', $this->form['currency_id'])            
            ->where(function($q){
                $q->where('tr_date', '<', date('Y-m-d', strtotime($this->form['tr_date'])))
                ->orWhere(function($q){
                    $q->where('id', '<', $this->transaction->id)
                    ->where('tr_date','=',date('Y-m-d', strtotime($this->form['tr_date'])));
                });
            })            
            ->sum('amount'); //require function

        $userLastBalance = CashTransaction::where('status', '=', 'DONE')  
            ->where('id','!=',$this->transaction->id)          
            ->where('currency_id', '=', $this->form['currency_id'])            
            ->where('owner', '=', $this->transaction->owner)
            ->where(function($q){
                $q->where('tr_date', '<', date('Y-m-d', strtotime($this->form['tr_date'])))
                ->orWhere(function($q){
                    $q->where('id', '<', $this->transaction->id)
                    ->where('tr_date','=',date('Y-m-d', strtotime($this->form['tr_date'])));
                });
            })
            ->sum('amount'); //require function
        // dd($lastBalance);
        $dataRecord = [];
        $dataRecord['tr_date'] = date('Y-m-d', strtotime($this->form['tr_date']));
        $dataRecord['amount'] = $this->form['amount'];
        $dataRecord['bk_amount'] = $this->form['amount'];
        $dataRecord['balance'] = $lastBalance + $this->form['amount'];
        $dataRecord['user_balance'] = $userLastBalance + $this->form['amount'];
        $dataRecord['currency_id'] = $this->form['currency_id'];
        $dataRecord['month'] = date('M-Y', strtotime($this->form['tr_date']));
        $dataRecord['description'] = $this->form['description'];
        $dataRecord['updated_by'] = auth()->user()->id;
        $dataRecord['logs'] = json_encode($this->logs);
        $this->transaction->update($dataRecord);

        // $this->reset(['form', 'selectedCurrency']);

        // $this->form['tr_date'] = date('d-M-Y', strtotime(now()));

        DB::update(
            "UPDATE cash_transactions
            SET balance = balance + ?, user_balance = if(owner = ? , user_balance + ? , user_balance)
            WHERE currency_id = ? AND ((id > ? and tr_date = ?) OR tr_date > ? )
            ",
            [
                $this->transaction->amount,
                $this->transaction->owner,
                $this->transaction->amount,
                $this->transaction->currency_id,
                $this->transaction->id,
                $this->transaction->tr_date,
                $this->transaction->tr_date

            ]
        );



        $userLastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('currency_id', '=', $this->transaction->currency_id)
            ->where('owner', '=', $this->transaction->owner)
            ->sum('amount'); //require function

        Balance::upsert(
            [
                'user_id' => $this->transaction->owner,
                'currency_id' => $this->transaction->currency_id,
                'current_balance' => $userLastBalance
            ],
            ['user_id', 'currency_id'],
            ['current_balance']
        );

        $lastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('currency_id', '=', $this->transaction->currency_id)
            ->sum('amount');

        Balance::upsert(
            [
                'user_id' => 0,
                'currency_id' => $this->transaction->currency_id,
                'current_balance' => $lastBalance
            ],
            ['user_id', 'currency_id'],
            ['current_balance']
        );

        $this->dispatchBrowserEvent('alert-updated-success', ['message' => 'Cash updated succeffully!']);
    }
    // end add new cash
    

    public function render()
    {
        return view('livewire.cash.edit-cash', ['currencies' => $this->currencies]);
    }
}
