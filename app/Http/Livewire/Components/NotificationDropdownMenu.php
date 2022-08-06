<?php

namespace App\Http\Livewire\Components;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationDropdownMenu extends Component
{
    public $totalNotification = 0;
    public $notifications;
    public $SQLNotification = "
    SELECT * FROM notifications WHERE user_id = 1 AND `status` != 'DONE'
    ";

    public function mount()
    {
        $this->notifications = Notifications::where('user_id', '=', Auth::user()->id)->where('status', '!=', 'DONE')->get();
        if ($this->notifications) {
            $this->totalNotification = count($this->notifications);
        }
    }
    public function render()
    {
        return view('livewire.components.notification-dropdown-menu');
    }
}
