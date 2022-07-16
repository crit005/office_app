<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class ListNewMember extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = null;
    public $orderField = ['field' => 'first_join', 'order' => 'desc'];

    public $fromDate = null;
    public $toDate = null;

    public $connection = null;
    public function mount()
    {
        if(!Session::get('selectedSystem')){
            return redirect(route('dashboard'));
        }
        $this->connection = Session::get('selectedSystem');

        $this->fromDate = date('01-M-Y');
        $this->toDate = date('d-M-Y', strtotime(now()));
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
        $this->fromDate =  date('d-M-Y',strtotime($strDate));
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
        $customers = $customer->whereBetween('first_join', [date('Y-m-d',strtotime($this->fromDate)), date('Y-m-d',strtotime($this->toDate))])
            ->where(function ($q) {
                $q->where('login_id', 'like', '%' . $this->search . '%')
                    ->orWhere('mobile', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('club_name', 'like', '%' . $this->search . '%');
            })
            ->orderBY($this->orderField['field'], $this->orderField['order'])
            ->paginate(env('PAGINATE'));

        return view('livewire.customer.list-new-member', ['customers' => $customers]);
    }
}
