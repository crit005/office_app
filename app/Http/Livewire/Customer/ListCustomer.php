<?php

namespace App\Http\Livewire\Customer;

use App\Exports\MemberExport;
use App\Jobs\ExportMemberJob;
use App\Models\Customer;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
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
    public $downloadLink = '';

    public $connection = null;
    public function mount()
    {
        $this->downloadLink = storage::disk('avatars')->url("001.jpg");
        // $this->downloadLink = "http://localhost:8000/storage/public/xlsx/publicLinkcustomer.zip";

        if (!Session::get('selectedSystem')) {
            return redirect(route('dashboard'));
        }
        $this->connection = Session::get('selectedSystem');
    }

    public function download()
    {
        // return storage::disk('avatars')->download("oV9hMeNdtJL6ZpDaaH3CdHsRM2ofCKKR6ijh0aFx.png")->deleteFileAfterSend(true);
        return response()->download(storage_path("app/public/001.jpg"))->deleteFileAfterSend(true);
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
            } else {
                $icon = '<i class="fas fa-sort-alpha-down align-self-center"></i>';
            }
        }
        return $icon;
    }

    public function protectDownload()
    {
        $this->dispatchBrowserEvent('protectDownload');
    }

    public function doExport($protectData)
    {
        $this->test = $protectData['fileName'];
        $this->isDownloading = true;
        // return Excel::download(new MemberExport($this->search, $this->orderField), 'ListMember.xlsx');

        $batch = Bus::batch([])->dispatch();

        // Create notification type PROCESSING
        $notificationData = [];
        $notificationData['user_id'] = Auth::user()->id;
        $notificationData['title'] = 'Customer Exporting';
        $notificationData['message'] = $protectData['fileName'].' exporting is in progress please wait';
        $notificationData['page'] = route('customer.list');
        $notificationData['type'] = 'DOWNLOAD';
        $notificationData['batch_id'] = $batch->id;
        $notificationData['status'] = 'PROCESSING';

        $notification = Notifications::create($notificationData);

        // Exporting data
        $data = [
            "tableName" => $this->connection->connection_name,
            "orderField" =>$this->orderField,
            "fileName" => $protectData['fileName'],
            "password" => $protectData['password'],
            "userId" => Auth::user()->id,
            "search" => $this->search,
            "batch_id" => $batch->id,
            "notification_id" => $notification->id
        ];

        $batch->add(new ExportMemberJob($data));


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
