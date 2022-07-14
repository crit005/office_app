<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class ListCustomer extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $connection = null;
    public function mount()
    {
        $this->connection = Session::get('selectedSystem');
    }
    public function render()
    {
        $customer = new Customer();
        $customer->setTable('tbl_' . $this->connection->connection_name);
        $customers = $customer->paginate(env('PAGINATE'));
        return view('livewire.customer.list-customer',['customers'=>$customers]);
    }
}
