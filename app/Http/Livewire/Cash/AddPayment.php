<?php

namespace App\Http\Livewire\Cash;

use App\Models\Balance;
use App\Models\CashTransaction;
use App\Models\Currency;
use App\Models\Depatment;
use App\Models\Items;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AddPayment extends Component
{
    public $form = [];    

    public $currencies;
    public $arrCurrencies;
    public $currencyIds;
    public $items;
    public $depatments;
    public $newTranaction;

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

        $this->items = Items::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();

        $this->depatments = Depatment::where('status', '=', 'ENABLED')->get();
    }

    public $cashRules = [
        'tr_date' => 'required|date|',
        'currency_id' => 'required',
        'amount' => 'required|numeric|gt:0',
        'item_id' => 'required',
        'depatment_id' => 'required'

    ];

    public $cashValidationAttributes = [
        'tr_date' => 'date',
        'currency_id' => 'currency',
        'item_id' => 'expand name',
        'depatment_id' => 'expand on'
    ];

    public function updatedForm($value)
    {
        $rules = array_filter($this->cashRules, function ($key) {
            return in_array($key, array_keys($this->form));
        }, ARRAY_FILTER_USE_KEY);

        Validator::make($this->form, $rules, [], $this->cashValidationAttributes)->validate();        
    }

    public function getValidClass(String $fieldName)
    {
        return array_key_exists($fieldName, $this->form) ? 'is-valid' : '';
    }

    public function addExpand()
    {
        Validator::make($this->form, $this->cashRules, [], $this->cashValidationAttributes)->validate();

        $lastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('tr_date', '<=', date('Y-m-d', strtotime($this->form['tr_date'])))
            ->where('currency_id', '=', $this->form['currency_id'])
            ->sum('amount'); //require function

        $userLastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('tr_date', '<=', date('Y-m-d', strtotime($this->form['tr_date'])))
            ->where('currency_id', '=', $this->form['currency_id'])
            ->where('owner', '=', auth()->user()->id)
            ->sum('amount'); //require function

        $dataRecord = [];
        $dataRecord['tr_date'] = date('Y-m-d', strtotime($this->form['tr_date']));
        $dataRecord['item_id'] = $this->form['item_id'];
        $dataRecord['item_name'] = Items::where('id', '=', $this->form['item_id'])->first()->name;
        $dataRecord['amount'] = -$this->form['amount'];
        $dataRecord['bk_amount'] = -$this->form['amount'];
        $dataRecord['balance'] = $lastBalance - $this->form['amount'];
        $dataRecord['user_balance'] = $userLastBalance - $this->form['amount'];
        $dataRecord['currency_id'] = $this->form['currency_id'];
        $dataRecord['to_from'] = $this->form['depatment_id'];
        $dataRecord['use_on'] = Depatment::where('id', '=', $this->form['depatment_id'])->first()->name;
        $dataRecord['month'] = date('M-Y', strtotime($this->form['tr_date']));
        $dataRecord['description'] = $this->form['description']?? '';
        $dataRecord['owner'] = auth()->user()->id;
        // $dataRecord['updated_by'] = auth()->user()->id;
        $dataRecord['owner_name'] = auth()->user()->name;
        $dataRecord['type'] = "EXPAND";
        $dataRecord['status'] = "DONE";
        $dataRecord['input_type'] = "MENUL";
        // $dataRecord['uuid']= Str::uuid()->toString();
        // $dataRecord['tr_id'] = "";

        // dd($dataRecord);

        $this->newTranaction = CashTransaction::create($dataRecord);

        $this->reset(['form']);

        $this->form['tr_date'] = date('d-M-Y', strtotime(now()));

        DB::update(
            "UPDATE cash_transactions
            SET balance = balance + ?, user_balance = if(owner = ? , user_balance + ? , user_balance)            
            WHERE currency_id = ? AND ((id > ? and tr_date = ?) OR tr_date > ? )
            ",
            [
                $this->newTranaction->amount,
                auth()->user()->id,
                $this->newTranaction->amount,
                $this->newTranaction->currency_id,
                $this->newTranaction->id,
                $this->newTranaction->tr_date,
                $this->newTranaction->tr_date
            ]
        );

        $userLastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('currency_id', '=', $this->newTranaction->currency_id)
            ->where('owner', '=', auth()->user()->id)
            ->sum('amount'); //require function

        Balance::upsert(
            [
                'user_id' => auth()->user()->id,
                'currency_id' => $this->newTranaction->currency_id,
                'current_balance' => $userLastBalance
            ],
            ['user_id', 'currency_id'],
            ['current_balance']
        );

        $lastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('currency_id', '=', $this->newTranaction->currency_id)
            ->sum('amount');

        Balance::upsert(
            [
                'user_id' => 0,
                'currency_id' => $this->newTranaction->currency_id,
                'current_balance' => $lastBalance
            ],
            ['user_id', 'currency_id'],
            ['current_balance']
        );

        $this->dispatchBrowserEvent('alert-success', ['message' => 'Expand added succeffully!']);
    }
    // add new cash
    public function addCash()
    {
        Validator::make($this->form, $this->cashRules, [], $this->cashValidationAttributes)->validate();

        $lastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('tr_date', '<=', date('Y-m-d', strtotime($this->form['tr_date'])))
            ->where('currency_id', '=', $this->form['currency_id'])
            ->sum('amount'); //require function

        $userLastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('tr_date', '<=', date('Y-m-d', strtotime($this->form['tr_date'])))
            ->where('currency_id', '=', $this->form['currency_id'])
            ->where('owner', '=', auth()->user()->id)
            ->sum('amount'); //require function

        $dataRecord = $this->form;
        $dataRecord['tr_date'] = date('Y-m-d', strtotime($this->form['tr_date']));
        // $dataRecord['item_id'] = $this->item->id;
        // $dataRecord['item_name'] = $this->item->name;
        $dataRecord['amount'] = $this->form['amount'];
        $dataRecord['bk_amount'] = $this->form['amount'];
        $dataRecord['balance'] = $lastBalance + $this->form['amount'];
        $dataRecord['user_balance'] = $userLastBalance + $this->form['amount'];
        // $dataRecord['currency_id'] = $this->form['currency_id'];
        $dataRecord['to_from'] = auth()->user()->id;
        $dataRecord['use_on'] = auth()->user()->name;
        $dataRecord['month'] = date('M-Y', strtotime($this->form['tr_date']));
        // $dataRecord['description'] = $this->form['description'];
        $dataRecord['owner'] = auth()->user()->id;
        // $dataRecord['updated_by'] = auth()->user()->id;
        $dataRecord['owner_name'] = auth()->user()->name;
        $dataRecord['type'] = "INCOME";
        $dataRecord['status'] = "DONE";
        $dataRecord['input_type'] = "MENUL";
        // $dataRecord['uuid']= Str::uuid()->toString();
        // $dataRecord['tr_id'] = "";

        $this->newTranaction = CashTransaction::create($dataRecord);

        $this->reset(['form', 'selectedCurrency']);

        $this->form['tr_date'] = date('d-M-Y', strtotime(now()));

        DB::update(
            "UPDATE cash_transactions
            SET balance = balance + ?, user_balance = if(owner = ? , user_balance + ? , user_balance)            
            WHERE currency_id = ? AND ((id > ? and tr_date = ?) OR tr_date > ? )
            ",
            [
                $this->newTranaction->amount,
                auth()->user()->id,
                $this->newTranaction->amount,
                $this->newTranaction->currency_id,
                $this->newTranaction->id,
                $this->newTranaction->tr_date,
                $this->newTranaction->tr_date

            ]
        );

        $userLastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('currency_id', '=', $this->newTranaction->currency_id)
            ->where('owner', '=', auth()->user()->id)
            ->sum('amount'); //require function

        Balance::upsert(
            [
                'user_id' => auth()->user()->id,
                'currency_id' => $this->newTranaction->currency_id,
                'current_balance' => $userLastBalance
            ],
            ['user_id', 'currency_id'],
            ['current_balance']
        );

        $lastBalance = CashTransaction::where('status', '=', 'DONE')
            ->where('currency_id', '=', $this->newTranaction->currency_id)
            ->sum('amount');

        Balance::upsert(
            [
                'user_id' => 0,
                'currency_id' => $this->newTranaction->currency_id,
                'current_balance' => $lastBalance
            ],
            ['user_id', 'currency_id'],
            ['current_balance']
        );

        $this->dispatchBrowserEvent('alert-success', ['message' => 'Cash added succeffully!']);
    }

    public function render()
    {
        return view('livewire.cash.add-payment');
    }
}
