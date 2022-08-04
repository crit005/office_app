<?php

namespace App\Http\Livewire\Customer;

use App\Exports\MemberExport;
use App\Jobs\ExportMemberJob;
use App\Models\Customer;
use App\Models\Notifications;
use ArrayObject;
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
    public $downloadLink = 'app/public/xlsx/';

    public $exporting = null;

    public $connection = null;
    public function mount()
    {
        if (!Session::get('selectedSystem')) {
            return redirect(route('dashboard'));
        }
        $this->connection = Session::get('selectedSystem');
        $this->checkExportJob();
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
        $this->isDownloading = true;
        // return Excel::download(new MemberExport($this->search, $this->orderField), 'ListMember.xlsx');

        $batch = Bus::batch([])->dispatch();
        // Create notification type PROCESSING
        $notificationData = null;
        $notificationData['user_id'] = Auth::user()->id;
        $notificationData['title'] = 'Customer Exporting';
        $notificationData['message'] = 'Exporting ' . $protectData['fileName'] . ' is in progress please wait';

        $protectData['fileName'] = $protectData['fileName'] . strtotime(now());

        $notificationData['page'] = 'customer.list';
        $notificationData['type'] = 'DOWNLOAD';
        $notificationData['download_link'] = $this->downloadLink . $protectData['fileName'] . '.zip';
        $notificationData['batch_id'] = $batch->id;
        $notificationData['status'] = 'PROCESSING';
        $notification = Notifications::create($notificationData);

        // Exporting data
        $data = [
            "tableName" => $this->connection->connection_name,
            "orderField" => $this->orderField,
            "fileName" => $protectData['fileName'],
            "password" => $protectData['password'],
            "userId" => Auth::user()->id,
            "search" => $this->search,
            "batch_id" => $batch->id,
            "notification_id" => $notification->id
        ];

        $batch->add(new ExportMemberJob($data));

        unset($notification);
    }

    public function checkExportJob()
    {
        $notification = Notifications::where('user_id', '=', Auth()->user()->id)
            ->where('page', '=', 'customer.list')
            ->whereIn('status', ['NEED_ARLERT', 'PROCESSING'])
            ->first();
        if ($notification) {
            $this->exporting = [
                "id" => $notification->id,
                "status" => $notification->status,
                "downloadLink" => $notification->download_link
            ];
        } else {
            $this->exporting = null;
        }
        unset($notification);
    }

    public function doDownload()
    {
        // return storage::disk('avatars')->download("oV9hMeNdtJL6ZpDaaH3CdHsRM2ofCKKR6ijh0aFx.png"); // cannot delete affter download
        $notification = Notifications::find($this->exporting['id']);
        $notification->status = "DONE";
        $notification->description .= "_(DOWNLOADED)_";
        $notification->save();
        $file = $this->exporting['downloadLink'];
        $this->exporting = null;
        unset($notification);
        return response()->download(storage_path($file))->deleteFileAfterSend(true);

    }

    public function doDeleteExport()
    {
        //! cancel batch and delete job later;

        $notification = Notifications::find($this->exporting['id']);
        $notification->status = "DONE";
        $notification->description .= "_(CANCELED)_";
        $notification->save();
        $file = $this->exporting['downloadLink'];
        unlink(storage_path($file));
        $this->exporting = null;
        unset($notification);

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
