<li class="nav-item dropdown" wire:poll.alive wire:ignore.self>
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if ($totalNotification > 0)
            <span class="badge badge-warning navbar-badge">{{ $totalNotification }}</span>
        @endif

    </a>
    <div  wire:poll='toast()' wire:ignore.self
    class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">{{ $totalNotification }} Notifications</span>
        @if($notifications)
        @foreach ($notifications as $notification)
            <div class="dropdown-divider"></div>
            @if ($notification->status == 'PROCESSING')
            <div class="dropdown-item">
            @else
            <a href=""  wire:click.prevent='operator({{$notification}})'class="dropdown-item">
            @endif
            {{-- <a href=""  wire:click.prevent='operator({{$notification}})'class="dropdown-item"> --}}
                @if ($notification->type == 'DOWNLOAD')
                    @if ($notification->status == 'PROCESSING')
                    <i class="fas fa-spinner fa-spin mr-2 text-warning"></i>
                    @else
                    <i class="fas fa-download mr-2 text-success"></i>
                    @endif

                {{$notification->file_name}}
                @endif()

                <span class="float-right text-muted text-sm">
                    {{-- {{$carbon->createFromDate($notification->updated_at)->diffForHumans()}} --}}
                    {{ \Carbon\Carbon::parse($notification->updated_at)->diffForHumans() }}
                </span>
            <div class="dropdown-divider"></div>

            @if ($notification->status == 'PROCESSING')
            </div>
            @else
            </a>
            @endif
            {{-- </> --}}
        @endforeach

        @endif
        {{-- <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
        </a> --}}
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li>
