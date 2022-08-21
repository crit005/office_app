<?php

namespace App\Http\Livewire\Components;

use App\Jobs\ExportMemberJob;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ExportButton extends Component
{
    public $search = null;
    public $orderField = ['field' => 'last_active', 'order' => 'desc'];
    public $isDownloading = false;
    public $downloadLink = 'app/public/xlsx/';
    public $pageName;

    public $exporting = null;

    public $connection = null;
    public function mount($pageName)
    {
        if (!Session::get('selectedSystem')) {
            return redirect(route('dashboard'));
        }
        $this->connection = Session::get('selectedSystem');
        $this->pageName = $pageName;
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

    public function doExport($protectData)
    {

    }

    public function checkExportJob()
    {
        $notification = Notifications::where('user_id', '=', Auth()->user()->id)
            ->where('page', '=', $this->pageName)
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

    public function setExporting($status)
    {
        $this->exporting = $status;
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
        return view('livewire.components.export-button');
    }
}
