<?php

namespace App\Http\Livewire\Components;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class NotificationDropdownMenu extends Component
{
    public $n = 0;
    public function toast()
    {
        // $this->n +=1;
        // $this->dispatchBrowserEvent('toastr',['message'=>'test'.$this->n]);
        $notification = Notifications::where('user_id', '=', Auth::user()->id)->whereIn('status', ['SUCCESS_ALERT', 'ERROR_ALERT', 'WARNING_ALERT', 'INFO_ALERT'])->orderBy('updated_at', 'asc')->first();
        if ($notification) {
            if ($notification->status == 'SUCCESS_ALERT') {
                $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'message' => $notification->message]);
            } elseif ($notification->status == 'ERROR_ALERT') {
                $this->dispatchBrowserEvent('toastr', ['type' => 'error', 'message' => $notification->message]);
            } elseif ($notification->status == 'WARNING_ALERT') {
                $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'message' => $notification->message]);
            } elseif ($notification->status == 'INFO_ALERT') {
                $this->dispatchBrowserEvent('toastr', ['type' => 'info', 'message' => $notification->message]);
            }
            $notification->status = 'READY_ALERT';
            $notification->save();
        }
    }

    public function operator(Notifications $notification)
    {
        if($notification->type == 'DOWNLOAD'){
            if($notification->status == 'PROCESSING'){
                $this->dispatchBrowserEvent('alert-info',['message'=>'Your file is not ready!']);
                return;
            }
            return $this->doDownload($notification);
        }
    }

    public function doDownload(Notifications $notification)
    {
        // return storage::disk('avatars')->download("oV9hMeNdtJL6ZpDaaH3CdHsRM2ofCKKR6ijh0aFx.png"); // cannot delete affter download
        // $notification = Notifications::find($this->exporting['id']);
        $notification->status = "DONE";
        $notification->description .= "_(DOWNLOADED)_";
        $notification->save();
        $file = $notification->download_link;
        return response()->download(storage_path($file))->deleteFileAfterSend(true);

    }

    public function render()
    {
        $totalNotification = 0;
        $notifications = null;
        $notifications = Notifications::where('user_id', '=', Auth::user()->id)->where('status', '!=', 'DONE')->orderBy('created_at', 'desc')->get();
        if ($notifications) {
            $totalNotification = count($notifications);
        }

        return view('livewire.components.notification-dropdown-menu', ['totalNotification' => $totalNotification, 'notifications' => $notifications]);
    }
}
