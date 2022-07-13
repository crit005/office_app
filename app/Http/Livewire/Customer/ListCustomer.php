<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ListCustomer extends Component
{
    public $connection = null;
    public function mount()
    {
        $this->connection = Session::get('selectedSystem');
    }
    public function render()
    {
        $customer = new Customer();
        $customer->setTable('tbl_' . $this->connection->connection_name);
        $customers = $customer->where('id','>',1)->get();
        return view('livewire.customer.list-customer',['customers'=>$customers]);
    }
}
