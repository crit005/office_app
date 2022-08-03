<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\BeforeExport;

class MemberExport implements FromCollection, WithHeadings, WithEvents
{
    public $tableName;
    public $search;
    public $orderField;

    use Exportable;
    public function __construct($condition)
    {
        $this->tableName = $condition["tableName"];
        $this->search = $condition["search"];
        $this->orderField = $condition["orderField"];
    }

    public function headings(): array
    {
        return [
            'CustomerID', 'LoginID', 'Name', 'Email', 'Phone', 'Club', 'First Join', 'Last DP', 'Last WD', 'Last Active', 'Total DP', 'Total WD', 'Total Turnover', 'Totall Winlose'
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->getDelegate()->getSecurity()->setLockWindows(true);
                $event->writer->getDelegate()->getSecurity()->setLockStructure(true);
                $event->writer->getDelegate()->getSecurity()->setWorkbookPassword("Your password");
            }
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 1800);
        ini_set('max_input_time', 1200);

        $customer = new Customer();
        $customer->setTable('tbl_' . $this->tableName);
        return $customer->select('id', 'login_id', 'name', 'email', 'mobile', 'club_name', 'first_join', 'last_dp', 'last_wd', 'last_active', 'total_dp', 'total_wd', 'total_turnover', 'totall_winlose')->where('login_id', 'like', '%' . $this->search . '%')
            ->orWhere('mobile', 'like', '%' . $this->search . '%')
            ->orWhere('id', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('club_name', 'like', '%' . $this->search . '%')
            ->orderBY($this->orderField['field'], $this->orderField['order'])->get();

        // return $customer->where('last_active','=','2018-10-18')->get();
    }
}
