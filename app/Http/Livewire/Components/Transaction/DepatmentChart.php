<?php

namespace App\Http\Livewire\Components\Transaction;

use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DepatmentChart extends Component
{
    public array $dataset = [];
    public array $labels = [];
    public $transactions;

    public $fromDate;
    public $toDate;
    public $depatmentId;
    public $currencyId;
    public $createdBy;

    protected $listeners = [
        'rerender-department-chart' => 'rerenderDepartmentChart',
    ];

    public function rerenderDepartmentChart($searchs)
    {
        foreach ($searchs as $key => $val) {
            $this->$key = $val;
        }
        $this->transactions = $this->getDepatmentTransaction();

        $labels = $this->getLabels();
        $dataset = $this->getDepartmentDataset();

        $this->emit('updateChart', [
            'datasets' => $dataset,
            'labels' => $labels,
        ]);
    }

    public function mount($transactions)
    {
        $this->transactions = $transactions;
        $this->labels[] = $this->getLabels();
        $this->dataset = $this->getDepartmentDataset();
    }

    private function getLabels()
    {
        $labels = [];
        foreach($this->transactions as $transaction){
            $labels[] = $transaction->name?? $transaction["name"];
        }

        // generate month label
        // for ($i = 0; $i < 12; $i++) {
        //     $labels[] = now()->subMonths($i)->format('M');
        // }
        return $labels;
    }

    private function getColors()
    {
        $colors = [];
        foreach($this->transactions as $transaction){
            $colors[] = $transaction->bg_color;
        }
        return $colors;
    }

    private function getDepartmentDataset()
    {
        $data = [];
        foreach($this->transactions as $transaction){
            foreach($transaction as $key=>$val){
                if($key != 'name' && $key != 'bg_color' && $key != 'text_color'){
                    $data[$key][] = -$val;
                }
            }
        }
        $dataset = [];
        foreach($data as $key=>$val){
            $dataset[]=[
                'label' => $key,
                'backgroundColor' => $this->getColors(),
                'data' => $val,
            ];
        }

        return $dataset;
    }

    public function getDepatmentTransaction()
    {
        $currencys = Currency::where('status','=','ENABLED')->orderBy('position','asc')->get();
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
            return $transactions;
    }

    public function render()
    {
        return view('livewire.components.transaction.depatment-chart');
    }
}
