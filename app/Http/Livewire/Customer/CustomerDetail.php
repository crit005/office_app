<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerDetail extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selectedId = null;
    public $selectedTab = 'info';
    public $search = null;
    public $orderField = ['field' => 'groupfor', 'order' => 'desc'];

    public $connection = null;

    public function mount($id)
    {
        if (!Session::get('selectedSystem')) {
            return redirect(route('dashboard'));
        }
        $this->connection = Session::get('selectedSystem');
        $this->selectedId = $id;

        $this->fromDate = date('d-M-Y', strtotime('-30 days'));
        $this->toDate = date('d-M-Y', strtotime(now()));
    }

    public function selecteTab($tabName)
    {
        $this->selectedTab = $tabName;
        $this->orderField = ['field' => 'groupfor', 'order' => 'desc'];
        $this->resetPage();
    }

    public function updatedSearch($var)
    {
        $this->resetPage();
    }

    public function updatedFromDate($var)
    {
        $this->resetPage();
    }
    public function updatedToDate($var)
    {
        $this->resetPage();
    }

    public function setToDate($strDate)
    {
        $this->fromDate =  date('d-M-Y', strtotime($strDate));
        $this->toDate = date('d-M-Y', strtotime(now()));
    }

    public function setOrderField($fieldName)
    {
        if ($this->orderField['field'] == $fieldName) {
            $this->orderField['order'] = $this->orderField['order'] == 'desc' ? 'asc' : 'desc';
        } else {
            $this->orderField['field'] = $fieldName;
            $this->orderField['order'] = 'asc';
        }
    }

    public function getSortIcon($field)
    {
        $icon = '';
        if ($this->orderField['field'] == $field) {
            if ($this->orderField['order'] == 'desc') {
                $icon = '<i class="fas fa-sort-alpha-down-alt align-self-center"></i>';
            } else {
                $icon = '<i class="fas fa-sort-alpha-down align-self-center"></i>';
            }
        }
        return $icon;
    }


    public function render()
    {
        $customer = new Customer();
        $customer->setTable('tbl_' . $this->connection->connection_name);
        $selectedCustomer = $customer->where('id', '=', $this->selectedId)->first();

        $listDeposit = null;
        $listWithdraws = null;
        $listWinloses = null;

        if ($this->selectedTab == 'dp') {

            $listDeposit = DB::connection($this->connection->connection_name)
                ->table('transaction')->select('id', 'webAccountLoginId', 'clubId', 'groupfor', 'inputAmount')
                ->where('customerid', '=', $selectedCustomer->id)
                ->whereIn('type', [1, 3])
                ->whereBetween('groupfor', [date('Y-m-d',strtotime($this->fromDate)), date('Y-m-d',strtotime($this->toDate))])
                ->orderBY($this->orderField['field'], $this->orderField['order'])
                ->paginate(env('PAGINATE'));
        } elseif ($this->selectedTab == 'wd') {

            $listWithdraws = DB::connection($this->connection->connection_name)
                ->table('transaction')->select('id', 'webAccountLoginId', 'clubId', 'groupfor', 'inputAmount')
                ->where('customerid', '=', $selectedCustomer->id)
                ->where('type', '=', 2)
                ->whereBetween('groupfor', [date('Y-m-d',strtotime($this->fromDate)), date('Y-m-d',strtotime($this->toDate))])
                ->orderBY($this->orderField['field'], $this->orderField['order'])
                ->paginate(env('PAGINATE'));
        } elseif ($this->selectedTab == 'wl') {

            $listWinloses = DB::connection($this->connection->connection_name)
                ->table('winlose')->select('id', 'loginId', 'clubId', 'groupfor', 'wlamt')
                ->where('loginId', '=', $selectedCustomer->login_id)
                ->whereBetween('groupfor', [date('Y-m-d',strtotime($this->fromDate)), date('Y-m-d',strtotime($this->toDate))])
                ->orderBY($this->orderField['field'], $this->orderField['order'])
                ->paginate(env('PAGINATE'));
        }

        return view(
            'livewire.customer.customer-detail',
            [
                'customer' => $selectedCustomer,
                'listDeposit' => $listDeposit,
                'listWithdraws' => $listWithdraws,
                'listWinloses' => $listWinloses,
            ]
        );
    }
}
