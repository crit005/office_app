<?php

namespace App\Http\Livewire\Customer;

use App\Exports\MemberExport;
use App\Jobs\ExportMemberJob;
use App\Models\Customer;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ListCustomer extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = null;
    public $orderField = ['field' => 'last_active', 'order' => 'desc'];
    public $isDownloading = false;
    public $test = '';

    public $connection = null;
    public function mount()
    {
        if(!Session::get('selectedSystem')){
            return redirect(route('dashboard'));
        }
        $this->connection = Session::get('selectedSystem');
        // $this->test = Storage::disk('public')->file();
        $this->test = storage_path('app/public/xlsx/test.zip');
    }

    public function updatedSearch($var)
    {
        $this->resetPage();
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
            }else{
                $icon = '<i class="fas fa-sort-alpha-down align-self-center"></i>';
            }
        }
        return $icon;
    }

    public function doExport()
    {
        $this->isDownloading = true;
        // return Excel::download(new MemberExport($this->search, $this->orderField), 'ListMember.xlsx');
        $batch = Bus::batch([])->dispatch();
        $batch->add(new ExportMemberJob($this->connection->connection_name, $this->search, $this->orderField));

    }
    public function render()
    {
        $customer = new Customer();
        $customer->setTable('tbl_' . $this->connection->connection_name);
        $customers = $customer->where('login_id', 'like', '%' . $this->search . '%')
            ->orWhere('mobile', 'like', '%' . $this->search . '%')
            ->orWhere('id', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('club_name', 'like', '%' . $this->search . '%')
            ->orderBY($this->orderField['field'], $this->orderField['order'])
            ->paginate(env('PAGINATE'));
        return view('livewire.customer.list-customer', ['customers' => $customers]);
    }
}
