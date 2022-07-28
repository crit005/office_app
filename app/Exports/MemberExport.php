<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;

class MemberExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $customer = new Customer();
        $customer->setTable('tbl_' . $this->connection->connection_name);
        return $customer->where('last_active','>',date('Y-m-d', strtotime('-30 days')));
    }
}
