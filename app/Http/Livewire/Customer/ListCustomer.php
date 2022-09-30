<?php

namespace App\Http\Livewire\Customer;

use App\Jobs\ExportMemberJob;
use App\Models\Customer;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class ListCustomer extends Component
{
    use WithPagination;

    protected $listeners = [
        'ListCustomer_Doexport'=>'doExport',
        'ListCustomer_DoDeleteExport'=>'doDeleteExport',
        'ListCustomer_DoDownload'=>'doDownload',
    ];

    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'page' => ['except' => 1, 'as' => 'p'],
        'orderField' => ['except' => '', 'as' => 'o'],
    ];

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
        // $this->checkExportJob();
        $this->emit('ExportButton_SetOrderField',$this->orderField);
        $this->emit('ExportButton_SetSearch',$this->search);
    }

    public function updatedSearch($var)
    {
        $this->emit('ExportButton_SetSearch',$this->search);
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

        $this->emit('ExportButton_SetOrderField',$this->orderField);
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

    // Not use in hear
    public function protectDownload()
    {
        $this->dispatchBrowserEvent('protectDownload');
    }

    // call from export button
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
        $notificationData['file_name'] = $protectData['fileName'];
        $notificationData['page'] = 'customer.list';
        $notificationData['type'] = 'DOWNLOAD';

        $download_name = $protectData['fileName'] . strtotime(now());

        $notificationData['download_link'] = $this->downloadLink . $download_name . '.zip';
        $notificationData['batch_id'] = $batch->id;
        $notificationData['status'] = 'PROCESSING';
        $notification = Notifications::create($notificationData);

        // Exporting data
        $data = [
            "tableName" => $this->connection->connection_name,
            "orderField" => $this->orderField,
            "fileName" => $protectData['fileName'],
            "download_name" => $download_name,
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
            ->whereIn('status', ['READY_ALERT','SUCCESS_ALERT', 'PROCESSING'])
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

    public function doDownload($exporting)
    {
        // return storage::disk('avatars')->download("oV9hMeNdtJL6ZpDaaH3CdHsRM2ofCKKR6ijh0aFx.png"); // cannot delete affter download
        $notification = Notifications::find($exporting['id']);
        $notification->status = "DONE";
        $notification->description .= "_(DOWNLOADED)_";
        $notification->save();
        $file = $exporting['downloadLink'];
        // $this->exporting = null;
        unset($notification);
        return response()->download(storage_path($file))->deleteFileAfterSend(true);

    }

    public function doDeleteExport($exporting)
    {
        //! cancel batch and delete job later;
        // $notification = Notifications::find($this->exporting['id']);
        $notification = Notifications::find($exporting['id']);
        $notification->status = "DONE";
        $notification->description .= "_(CANCELED)_";
        $notification->save();
        $file = $exporting['downloadLink'];
        unlink(storage_path($file));
        // $this->exporting = null;
        unset($notification);

    }

    public function render()
    {
        // dd(env('PAGINATE'));
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
