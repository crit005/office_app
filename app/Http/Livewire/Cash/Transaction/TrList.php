<?php

namespace App\Http\Livewire\Cash\Transaction;

use App\Models\Currency;
use App\Models\Depatment;
use App\Models\Items;
use App\Models\TrCash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Livewire;

class TrList extends Component
{
    public $mode = 1;
    public $globleBalance = false;
    public $currentMonth;
    public $takeAmount;
    // public $refresh;
    public $reachLastRecord = false;
    public $editTransaction;
    public $updateTime = '';
    public $viewTransaction;
    public $viewId;
    public $depatments;
    public $currencys;

    // Search varibals
    public $searchs = [];
    public $fromDate, $toDate, $depatmentId, $itemId, $otherName, $currencyId, $isOther, $createdBy;
    public $order=['month'=>'desc','tr_date'=>'desc'];
    // search options
    public $type;

    //Print option
    public $printRequest = false;
    public $reportTitle;

    //chart
    public $chartDatas =[];
    public $transactions;
    public $totalDepartments = [];

    protected $queryString = [
        'mode'=>['except' => '', 'as' => 'm'],

    ];

    protected $listeners = [
        'refreshCashList' => 'refreshCashList',
        'clearEditTransactionCashList' => 'clearEditTransactionCashList',
        'cashResetPrintRequest'=>'resetPrintRequest'
    ];

    public function switchMonthOrder()
    {
        $this->order['month'] = $this->order['month']=='desc'?'asc':'desc';
        $this->reset(['currentMonth']);
    }
    public function switchDateOrder()
    {
        $this->order['tr_date'] = $this->order['tr_date']=='desc'?'asc':'desc';
        $this->reset(['currentMonth']);
    }

    public function refreshCashList()
    {
        $this->reset(['currentMonth']);
        $this->updateTime = time();
    }

    public function clearEditTransactionCashList($action = null)
    {
        $this->reset(['editTransaction', 'currentMonth']);
        $this->updateTime = time();
        if ($action) {
            if ($action == 'delete') {
                $this->dispatchBrowserEvent('alert-success', ["message" => "Delete Successfuly."]);
            }
        }
    }

    public function isNewMonth($month)
    {
        if ($this->currentMonth != $month) {
            $this->currentMonth = $month;
            return true;
        }
        return false;
    }

    public function inceaseTakeAmount($amount = null)
    {
        if ($amount) {
            $this->takeAmount += $amount;
        } else {
            $this->takeAmount += env('TAKE_AMOUNT', 100);
        }
        $this->reset(['currentMonth']);
    }

    public function mount()
    {
        $this->depatments = Depatment::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();
        $this->currencys = Currency::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();
        $this->items = Items::where('status', '=', 'ENABLED')->orderBy('position', 'asc')->get();

        $this->globleBalance = Session::get('isGlobleCash') ?? false;
        $this->takeAmount = env('TAKE_AMOUNT', 100);

        $this->createdBy = auth()->user()->id;
        // $this->createdBy = null;

        $this->initSearchs();
    }

    public function updated($name, $value)
    {
        if (($name == 'itemId' && $value == 13) || ($name == 'otherName')) {
            $this->isOther = true;
        } else {
            $this->reset(['otherName']);
            $this->isOther = false;
        }
        $this->emptySearchToNull($name, $value);
        $this->resetSearch($name);

        $this->initSearchs();
        // $this->emit('summatyRefresh',$this->searchs,$type??0,['createdBy'=>$this->createdBy]);
    }

    function resetSearch($name)
    {
        if (in_array($name, ['fromDate', 'toDate', 'depatmentId', 'itemId', 'otherName', 'currencyId', 'isOther', 'type'])) {
            $this->reset(['currentMonth']);
            $this->takeAmount = env('TAKE_AMOUNT', 100);
        }
    }

    public function resetUser()
    {
        $this->createdBy = $this->createdBy ? null : auth()->user()->id;
        $this->initSearchs();
        // $this->emit('summatyRefresh',$this->searchs,$type??0,['createdBy'=>$this->createdBy]);
    }

    function initSearchs()
    {
        $this->searchs = [
            'fromDate' => $this->fromDate ? date('Y-m-d', strtotime($this->fromDate)) : null,
            'createdBy' => $this->createdBy,
            'toDate' => $this->toDate ? date('Y-m-d', strtotime($this->toDate)) : null,
            'itemId' => $this->itemId,
            'otherName' => $this->otherName,
            'depatmentId' => $this->depatmentId,
            'createdBy' => $this->createdBy,
            'currencyId' => $this->currencyId,
            'type' => $this->type
        ];
        $this->updateTime = time();
    }

    function emptySearchToNull($name, $value)
    {
        if (in_array($name, ['fromDate', 'toDate', 'depatmentId', 'itemId', 'otherName', 'currencyId', 'isOther', 'type'])) {
            if ($value == '') {
                $this->reset([$name]);
            }
        }
    }

    function clearFilter()
    {
        $this->reset(['currentMonth', 'fromDate', 'toDate', 'depatmentId', 'itemId', 'otherName', 'currencyId', 'isOther', 'type']);
        $this->takeAmount = env('TAKE_AMOUNT', 100);
        $this->dispatchBrowserEvent('trResetRankDateTimePicker');
        $this->createdBy = auth()->user()->id;
        $this->initSearchs();
    }

    public function showEdit($id)
    {
        $transaction = TrCash::find($id);
        $this->editTransaction = $transaction;
        $this->reset(['currentMonth']);
    }

    public function showView($id)
    {
        $this->viewId = $id;
        $this->reset(['editTransaction']);
        $this->reset(['currentMonth']);
        $this->dispatchBrowserEvent('show-view-form');
    }

    public function printDataTableMode($title=null)
    {
        if($title){
            $this->reportTitle = $title;
        }
        $this->printRequest = true;
        $this->dispatchBrowserEvent('show-report-view-data-table-cash-modal');
    }

    public function resetPrintRequest()
    {
        $this->reset(['printRequest']);
    }

    public function setChartDatas($trs)
    {
        $this->chartDatas =[];
        foreach($trs[0] as $key=>$value){
            if($key!='name' && $key!='bg_color' && $key!='text_color'){
                $this->chartDatas[$key] = '';
            }
        }
        foreach($trs as $tr){
            foreach($tr as $key=>$val){
                if($key!='name' && $key!='bg_color' && $key!='text_color'){
                    // array_push($this->chartDatas[$key],-$val);
                    $this->chartDatas[$key] .= -$val.',';
                }
            }
        }
    }

    public function changeMode($mode)
    {
        $this->mode = $mode;
    }

    public function getDepatmentTransaction()
    {
        $currencys = Currency::where('status','=','ENABLED')
            ->when($this->currencyId,function($q){
                $q->where('id','=',$this->currencyId);
            })
            ->orderBy('position','asc')->get();
            $sumfield ='';
            foreach($currencys as $currency){
                $sumfield .=", sum(if(tr.currency_id =". $currency->id .",tr.amount,0)) AS ".$currency->code."_".$currency->symbol;
            }

            $arrCondition = [
                $this->fromDate, date('Y-m-d',strtotime($this->fromDate)),
                $this->toDate, date('Y-m-d',strtotime($this->toDate)),
                $this->depatmentId, $this->depatmentId,
                $this->currencyId, $this->currencyId,
                $this->createdBy, $this->createdBy
            ];

            $sql = "
            SELECT dp.name as name, dp.text_color AS text_color, dp.bg_color AS bg_color ".$sumfield."
            FROM tr_cashes AS tr inner JOIN depatments AS dp
                ON tr.to_from_id = dp.id
            WHERE tr.type = 2 and tr.`status`= 1
                AND if(?, tr.tr_date >=?,TRUE)
                AND if(?, tr.tr_date <= ?,TRUE)
                AND if(?, tr.to_from_id = ?,TRUE)
                AND if(?, tr.currency_id = ?,TRUE)
                AND if(?, tr.created_by = ?,TRUE)
            GROUP BY tr.to_from_id;
            ";
            $transactions = DB::select($sql, $arrCondition);
            $this->transactions = $transactions;

            if($this->transactions){
                $this->setTotalDepartment();
            }

            return $transactions;
    }

    public function getItemTransaction()
    {
        $currencys = Currency::where('status','=','ENABLED')
            ->when($this->currencyId,function($q){
                $q->where('id','=',$this->currencyId);
            })
            ->orderBy('position','asc')->get();
            $sumfield ='';
            foreach($currencys as $currency){
                $sumfield .=", sum(if(tr.currency_id =". $currency->id .",tr.amount,0)) AS ".$currency->code."_".$currency->symbol;
            }

            $arrCondition = [
                $this->fromDate, date('Y-m-d',strtotime($this->fromDate)),
                $this->toDate, date('Y-m-d',strtotime($this->toDate)),
                $this->itemId, $this->itemId,
                $this->currencyId, $this->currencyId,
                $this->createdBy, $this->createdBy
            ];

            $sql = "
            SELECT it.name as name".$sumfield."
            FROM tr_cashes AS tr inner JOIN items AS it
                ON tr.item_id = it.id
            WHERE tr.type = 2 and tr.`status`= 1
                AND if(?, tr.tr_date >=?,TRUE)
                AND if(?, tr.tr_date <= ?,TRUE)
                AND if(?, tr.item_id = ?,TRUE)
                AND if(?, tr.currency_id = ?,TRUE)
                AND if(?, tr.created_by = ?,TRUE)
            GROUP BY tr.item_id;
            ";
            $transactions = DB::select($sql, $arrCondition);
            $this->transactions = $transactions;

            if($this->transactions){
                $this->setTotalDepartment();
            }

            return $transactions;
    }

    public function setTotalDepartment()
    {
        $this->totalDepartments = [];
        if(count($this->transactions)>0){
            foreach($this->transactions[0] as $key=>$val){
            if($key != 'name' && $key != 'bg_color' && $key != 'text_color'){
                $this->totalDepartments[$key] = 0;
            }
            }
            foreach($this->transactions as $transaction){
                foreach($transaction as $key=>$val){
                    if($key != 'name' && $key != 'bg_color' && $key != 'text_color'){
                        $this->totalDepartments[$key] += $val;
                    }
                }
            }
        }
    }

    // chart block
    private function getLabels()
    {
        $labels = [];
        foreach($this->transactions as $transaction){
            $labels[] = $transaction->name?? $transaction["name"];
        }
        return $labels;
    }

    private function getDepartmentDataset()
    {

        if(count($this->transactions)>0){
            $data = [];
            foreach($this->transactions as $transaction){
                foreach($transaction as $key=>$val){
                    if($key != 'name' && $key != 'bg_color' && $key != 'text_color'){
                        $data[$key][] = $val?round($val/($this->totalDepartments[$key]/100),1):0;
                    }
                }
            }
            $dataset = [];
            foreach($data as $key=>$val){
                $dataset[]=[
                    'name' => $key,
                    'data' => $val,
                ];
            }

            return $dataset;
        }

    }
    // end chart block


    public function render()
    {
        if($this->mode == 1){
           $transactions = TrCash::where('status', '!=', 0)
            ->when($this->createdBy, function ($q) {
                $q->where('created_by', '=', $this->createdBy);
            })
            // ->where('created_by', '=', auth()->user()->id)
            ->where('type', '!=', 4)

            ->when($this->fromDate, function ($q) {
                $q->where('tr_date', '>=', date('Y-m-d', strtotime($this->fromDate)));
            })
            ->when($this->toDate, function ($q) {
                $q->where('tr_date', '<=', date('Y-m-d', strtotime($this->toDate)));
            })
            ->when($this->depatmentId, function ($q) {
                $q->where('type', '=', 2)
                    ->where('to_from_Id', '=', $this->depatmentId);
            })
            ->when($this->itemId, function ($q) {
                $q->where('item_id', '=', $this->itemId);
            })
            ->when($this->type, function ($q) {
                $q->where('type', '=', $this->type);
            })
            ->when($this->otherName, function ($q) {
                $q->where('other_name', 'like', "%" . $this->otherName . "%");
            })
            # AND (`currency_id` = 99 OR (`type` = 3 and `to_from_id` = 99))
            ->when($this->currencyId, function ($q) {
                $q->where(function ($q) {
                    $q->where('currency_id', '=', $this->currencyId)
                        ->orWhere(function ($q) {
                            $q->where('type', '=', 3)
                                ->where('to_from_id', '=', $this->currencyId);
                        });
                });
            })

            ->orderBy('month', $this->order['month'])
            // ->orderBy('tr_date', 'desc')
            // ->orderBy('id', 'desc')
            ->orderBy('tr_date', $this->order['tr_date'])
            ->orderBy('id', $this->order['tr_date'])
            ->take($this->takeAmount)
            ->get();
            // ->orderBy('name', 'asc')
            // ->paginate(env('PAGINATE'));

            if ($this->takeAmount > count($transactions)) {
                $this->reachLastRecord = true;
            }
        }elseif($this->mode == 2){
            $transactions = $this->getDepatmentTransaction();
        }else{
            $transactions = $this->getItemTransaction();
        }

        // Init top summary top total
        $this->emit('summatyRefresh',$this->searchs,$type??0,['createdBy'=>$this->createdBy]);

        return view('livewire.cash.transaction.tr-list', ['trCashs' => $transactions]);
    }
}
