<?php

namespace App\Http\Livewire\Components;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationDropdownMenu extends Component
{
    public function render()
    {
        $totalNotification = 0;
        $notifications = null;
        $notifications = Notifications::where('user_id', '=', Auth::user()->id)->where('status', '!=', 'DONE')->get();
        if ($notifications) {
            $totalNotification = count($notifications);
        }

        return view('livewire.components.notification-dropdown-menu',['totalNotification'=>$totalNotification,'notifications'=>$notifications]);
    }
}
