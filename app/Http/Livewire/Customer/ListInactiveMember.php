<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class ListInactiveMember extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = null;
    public $orderField = ['field' => 'last_active', 'order' => 'desc'];

    public $fromDate = null;
    public $toDate = null;

    public $firstData = [];

    public $connection = null;
    public function mount()
    {
        if (!Session::get('selectedSystem')) {
            return redirect(route('dashboard'));
        }
        $this->connection = Session::get('selectedSystem');

        // $this->fromDate = date('d-M-Y', strtotime('-30 days'));
        $this->toDate = date('d-M-Y', strtotime('-30 days'));

        // $this->emit('ExportButton_SetOrderField',$this->orderField);
        // $this->emit('ExportButton_SetSearch',$this->search);
        // $this->emit('ExportButton_SetExportType','NEW_MEMBER');
        // $this->emit('ExportButton_SetFromDate',$this->fromDate);
        // $this->emit('ExportButton_SetToDate',$this->toDate);

        $this->firstData = [
            'pageName' => 'customer.inactive',
            'search' => $this->search,
            'exportType' => 'INACTIVE_MEMBER',
            'orderField' => $this->orderField,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
        ];
    }

    public function updatedSearch($var)
    {
        $this->emit('ExportButton_SetSearch', $this->search);
        $this->resetPage();
    }
    public function updatedFromDate($var)
    {
        $this->emit('ExportButton_SetFromDate', $this->fromDate);
        $this->resetPage();
    }
    public function updatedToDate($var)
    {
        $this->emit('ExportButton_SetToDate', $this->toDate);
        $this->resetPage();
    }

    public function setToDate($strDate)
    {
        $this->toDate = date('d-M-Y', strtotime($strDate));
        $this->emit('ExportButton_SetToDate', $this->toDate);
    }

    public function setOrderField($fieldName)
    {
        if ($this->orderField['field'] == $fieldName) {
            $this->orderField['order'] = $this->orderField['order'] == 'desc' ? 'asc' : 'desc';
        } else {
            $this->orderField['field'] = $fieldName;
            $this->orderField['order'] = 'asc';
        }
        $this->emit('ExportButton_SetOrderField', $this->orderField);
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
        $customers = $customer->where('last_active', '<', date('Y-m-d', strtotime($this->toDate)))
            ->where(function ($q) {
                $q->where('login_id', 'like', '%' . $this->search . '%')
                    ->orWhere('mobile', 'like', '%' . $this->search . '%')
                    ->orWhere('customer_id', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('club_name', 'like', '%' . $this->search . '%');
            })
            ->orderBY($this->orderField['field'], $this->orderField['order'])
            ->paginate(env('PAGINATE'));
        $this->emit('ExportButton_SetTotalRecord', $customers->total());
        $this->firstData['totalRecord'] = $customers->total();
        return view('livewire.customer.list-inactive-member', ['customers' => $customers]);
    }
}
