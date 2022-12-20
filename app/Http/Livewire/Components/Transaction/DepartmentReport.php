<?php

namespace App\Http\Livewire\Components\Transaction;

use App\Models\Currency;
use App\Models\Depatment;
use App\Models\Items;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DepartmentReport extends Component
{
    public $title='Department Report';
    // Search varibals
    public $search=[];
    public $fromDate, $toDate, $depatmentId, $itemId, $otherName, $currencyId, $isOther, $createdBy;
    public $type;
    public $currencys;
    public $transactions;
    public $totalDepartments;

    public function mount($title='Department Report',$search)
    {
        $this->search = $search;
        $this->title = $title;
        foreach($search as $key => $val){
            $this->$key = $val;
        }
        $this->currencys = new Currency();
        $this->type = 2;
    }

    public function getType()
    {
        if($this->type == 1){
            return 'Cash In';
        }elseif($this->type == 2){
            return 'Expend';
        }elseif($this->type == 3){
            return 'Exchange';
        }else{
            return 'All';
        }
    }

    public function getCurrency()
    {
        if($this->currencyId){
            $currency = $this->currencys->find($this->currencyId);
            return $currency->code .'-'.$currency->symbol;
        }else{
            return "All";
        }
    }

    public function getFilter()
    {
        $strFilter ='Filter:';
        if($this->depatmentId){
            $strFilter .= ' '. Depatment::find($this->depatmentId)->name;
        }
        if($this->itemId){
            $strFilter .= ' '. Items::find($this->itemId)->name;
        }

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
                        $data[$key][] = round($val/($this->totalDepartments[$key]/100),1);
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
        return view('livewire.components.transaction.department-report',['trCashs'=>$this->getDepatmentTransaction()]);
    }
}
