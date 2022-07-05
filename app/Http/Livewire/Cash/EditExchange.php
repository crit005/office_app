<?php

namespace App\Http\Livewire\Cash;

use App\Models\Balance;
use App\Models\CashTransaction;
use App\Models\Currency;
use App\Models\Items;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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

        if ($transaction->type == 'EXPAND') {
            $this->fromTransaction = $transaction;
            $this->toTransaction = CashTransaction::findOrFail($transaction->tr_id);
        } else {
            $this->toTransaction = $transaction;
            $this->fromTransaction = CashTransaction::findOrFail($transaction->tr_id);
        }

        $this->form['tr_date'] = $this->fromTransaction->tr_date;
        $this->form['currency_id'] = $this->fromTransaction->currency_id;
        $this->form['amount'] = -$this->fromTransaction->amount;
        $this->form['to_currency_id'] = $this->toTransaction->currency_id;
        $this->form['to_amount'] = $this->toTransaction->amount;
        $this->form['description'] = $this->fromTransaction->description;

        $this->cashRules['currency_id'] .= "|in:" . $this->currencyIds;
        $this->cashRules['to_currency_id'] .= "|in:" . $this->currencyIds;

        $this->item = Items::where('status', '=', 'SYSTEM')->where('name', '=', 'Exchange')->first()->id;
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
        Validator::make($this->form, $rules, [], $this->cashValidationAttributes)->validate();
    }

    public function updateExchange()
    {
        Validator::make($this->form, $this->cashRules, [], $this->cashValidationAttributes)->validate();

        $this->deleteOldExchange();
    }

    public function deleteOldExchange()
    {
        // update related fromTransaction Balance
        // draw back amount from cash transaction
        DB::update(
            "UPDATE cash_transactions
            SET balance = balance - ?, user_balance = if(owner = ? , user_balance - ? , user_balance)
            WHERE currency_id = ? AND status != 'DELETED' AND ((id > ? and tr_date = ?) OR tr_date > ? )
            ",
            [
                $this->fromTransaction->amount,
                $this->fromTransaction->owner,
                $this->fromTransaction->amount,
                $this->fromTransaction->currency_id,
                $this->fromTransaction->id,
                $this->fromTransaction->tr_date,
                $this->fromTransaction->tr_date
            ]
        );

        // draw back amount from balance
        DB::update(
            "UPDATE balances
            SET current_balance = current_balance - ?
            WHERE currency_id = ? AND (user_id = 0 OR user_id  = ? )
            ",
            [
                $this->fromTransaction->amount,
                $this->fromTransaction->currency_id,
                $this->fromTransaction->owner
            ]
        );
        //=================================================================
        // update related toTransaction Balance
        // draw back amount from cash transaction
        DB::update(
            "UPDATE cash_transactions
            SET balance = balance - ?, user_balance = if(owner = ? , user_balance - ? , user_balance)
            WHERE currency_id = ? AND status != 'DELETED' AND ((id > ? and tr_date = ?) OR tr_date > ? )
            ",
            [
                $this->toTransaction->amount,
                $this->toTransaction->owner,
                $this->toTransaction->amount,
                $this->toTransaction->currency_id,
                $this->toTransaction->id,
                $this->toTransaction->tr_date,
                $this->toTransaction->tr_date
            ]
        );

        // draw back amount from balance
        DB::update(
            "UPDATE balances
            SET current_balance = current_balance - ?
            WHERE currency_id = ? AND (user_id = 0 OR user_id  = ? )
            ",
            [
                $this->toTransaction->amount,
                $this->toTransaction->currency_id,
                $this->toTransaction->owner
            ]
        );
        //=================================================================


        // delete fromTransaction
        $this->fromTransaction->delete();
        // delete toTransaction
        $this->toTransaction->delete();
    }

    public function saveExchage()
    {
        $lastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('id','!=',$this->transaction->id)
            ->where('tr_date', '<=', date('Y-m-d', strtotime($this->form['tr_date'])))
            ->where('currency_id', '=', $this->form['currency_id'])
            ->sum('amount'); //require function

        $userLastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('id','!=',$this->transaction->id)
            ->where('tr_date', '<=', date('Y-m-d', strtotime($this->form['tr_date'])))
            ->where('currency_id', '=', $this->form['currency_id'])
            ->where('owner', '=', auth()->user()->id)
            ->sum('amount'); //require function

        $dataRecord = [];
        $dataRecord['tr_date'] = date('Y-m-d', strtotime($this->form['tr_date']));
        $dataRecord['item_id'] = $this->item;
        $dataRecord['item_name'] = 'Exchange';
        $dataRecord['amount'] = -$this->form['amount'];
        $dataRecord['bk_amount'] = -$this->form['amount'];
        $dataRecord['balance'] = $lastBalance - $this->form['amount'];
        $dataRecord['user_balance'] = $userLastBalance - $this->form['amount'];
        $dataRecord['currency_id'] = $this->form['currency_id'];
        $dataRecord['to_from'] = $this->form['to_currency_id'];
        $dataRecord['use_on'] = Currency::findOrFail($this->form['to_currency_id'])->code;
        $dataRecord['month'] = date('M-Y', strtotime($this->form['tr_date']));
        $dataRecord['description'] = $this->form['description'] ?? null;
        $dataRecord['owner'] = auth()->user()->id;
        // $dataRecord['updated_by'] = auth()->user()->id;
        $dataRecord['owner_name'] = auth()->user()->name;
        $dataRecord['type'] = "EXPAND";
        $dataRecord['status'] = "WAIT";
        $dataRecord['input_type'] = "MENUL";
        // $dataRecord['uuid']= Str::uuid()->toString();
        // $dataRecord['tr_id'] = "";

        // dd($dataRecord);

        $fromTranaction = CashTransaction::create($dataRecord);

        DB::update(
            "UPDATE cash_transactions
            SET balance = balance + ?, user_balance = if(owner = ? , user_balance + ? , user_balance)
            WHERE currency_id = ? AND ((id > ? and tr_date = ?) OR tr_date > ? )
            ",
            [
                $fromTranaction->amount,
                auth()->user()->id,
                $fromTranaction->amount,
                $fromTranaction->currency_id,
                $fromTranaction->id,
                $fromTranaction->tr_date,
                $fromTranaction->tr_date
            ]
        );

        //==================================================

        $lastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('id','!=',$this->transaction->id)
            ->where('tr_date', '<=', date('Y-m-d', strtotime($this->form['tr_date'])))
            ->where('currency_id', '=', $this->form['currency_id'])
            ->sum('amount'); //require function

        $userLastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('id','!=',$this->transaction->id)
            ->where('tr_date', '<=', date('Y-m-d', strtotime($this->form['tr_date'])))
            ->where('currency_id', '=', $this->form['currency_id'])
            ->where('owner', '=', auth()->user()->id)
            ->sum('amount'); //require function

        $dataRecord = [];
        $dataRecord['tr_date'] = date('Y-m-d', strtotime($this->form['tr_date']));
        $dataRecord['item_id'] = $this->item;
        $dataRecord['item_name'] = 'Exchange';
        $dataRecord['amount'] = $this->form['to_amount'];
        $dataRecord['bk_amount'] = $this->form['to_amount'];
        $dataRecord['balance'] = $lastBalance + $this->form['to_amount'];
        $dataRecord['user_balance'] = $userLastBalance + $this->form['to_amount'];
        $dataRecord['currency_id'] = $this->form['to_currency_id'];
        $dataRecord['to_from'] = $this->form['currency_id'];
        $dataRecord['use_on'] = Currency::findOrFail($this->form['currency_id'])->code;
        $dataRecord['month'] = date('M-Y', strtotime($this->form['tr_date']));
        $dataRecord['description'] = $this->form['description'] ?? null;
        $dataRecord['owner'] = auth()->user()->id;
        // $dataRecord['updated_by'] = auth()->user()->id;
        $dataRecord['owner_name'] = auth()->user()->name;
        $dataRecord['type'] = "INCOME";
        $dataRecord['status'] = "DONE";
        $dataRecord['input_type'] = "MENUL";
        // $dataRecord['uuid']= Str::uuid()->toString();
        $dataRecord['tr_id'] = $fromTranaction->id;

        // dd($dataRecord);

        $toTranaction = CashTransaction::create($dataRecord);

        DB::update(
            "UPDATE cash_transactions
            SET balance = balance + ?, user_balance = if(owner = ? , user_balance + ? , user_balance)
            WHERE currency_id = ? AND ((id > ? and tr_date = ?) OR tr_date > ? )
            ",
            [
                $toTranaction->amount,
                auth()->user()->id,
                $toTranaction->amount,
                $toTranaction->currency_id,
                $toTranaction->id,
                $toTranaction->tr_date,
                $toTranaction->tr_date
            ]
        );

        //===============================================

        $fromTranaction->update(['tr_id' => $toTranaction->id, 'status' => 'DONE']);
        // CashTransaction::findOrFail('id','=',$fromTranaction->id)->update(['tr_id'=> $toTranaction->id, 'status'=> 'DONE']);

        $userLastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('currency_id', '=', $fromTranaction->currency_id)
            ->where('owner', '=', auth()->user()->id)
            ->sum('amount'); //require function

        Balance::upsert(
            [
                'user_id' => auth()->user()->id,
                'currency_id' => $fromTranaction->currency_id,
                'current_balance' => $userLastBalance
            ],
            ['user_id', 'currency_id'],
            ['current_balance']
        );

        $lastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('currency_id', '=', $fromTranaction->currency_id)
            ->sum('amount');

        Balance::upsert(
            [
                'user_id' => 0,
                'currency_id' => $fromTranaction->currency_id,
                'current_balance' => $lastBalance
            ],
            ['user_id', 'currency_id'],
            ['current_balance']
        );

        //==============================================

        $userLastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('currency_id', '=', $toTranaction->currency_id)
            ->where('owner', '=', auth()->user()->id)
            ->sum('amount'); //require function

        Balance::upsert(
            [
                'user_id' => auth()->user()->id,
                'currency_id' => $toTranaction->currency_id,
                'current_balance' => $userLastBalance
            ],
            ['user_id', 'currency_id'],
            ['current_balance']
        );

        $lastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('currency_id', '=', $toTranaction->currency_id)
            ->sum('amount');

        Balance::upsert(
            [
                'user_id' => 0,
                'currency_id' => $toTranaction->currency_id,
                'current_balance' => $lastBalance
            ],
            ['user_id', 'currency_id'],
            ['current_balance']
        );
    }

    public function render()
    {
        return view('livewire.cash.edit-exchange');
    }
}
