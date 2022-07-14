<div class="card system-panel">
    <div class="card-header @if ($isOutOfDate) bg-warning @else bg-primary @endif">
        <div class="d-flex justify-content-between">
            <div class="align-self-center">{{ $connection->system_name }}<br>
                <span class="text-xs">Update at: {{$lastUpdate}}</span></div>
            <button wire:click.prevent="reloadMemberFromserver" wire:loading.attr="disabled"
                class="btn  @if ($isOutOfDate) btn-warning @else btn-primary @endif ">
                <i class="fas fa-sync-alt @if ($isOutOfDate) bounce @endif"
                    wire:loading.class.remove='bounce' wire:loading.class="fa-spin"
                    wire:target="reloadMemberFromserver"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex flex-row justify-content-between">
            <div class="text-warning"><i class="fas fa-user mr-2"></i>NEW</div>
            <div class="text-warning">
                <i class="fas fa-spinner fa-spin" wire:loading wire:target="reloadMemberFromserver"></i>
                {{ $totalNewMember }}<sup>{{date('M',strtotime(now()))}}</sup>
            </div>
        </div>
        <hr class="mt-1">
        <div class="d-flex flex-row justify-content-between">
            <div class="text-success"><i class="fas fa-user mr-2"></i>ACTIVE</div>
            <div class="text-success">
                <i class="fas fa-spinner fa-spin" wire:loading wire:target="reloadMemberFromserver"></i>
                {{ $totalActiveMember }}<sup>30d</sup>
            </div>
        </div>
        <hr class="mt-1">
        <div class="d-flex flex-row justify-content-between">
            <div class="text-danger"><i class="fas fa-user mr-2"></i>INACTIVE</div>
            <div class="text-danger">
                <i class="fas fa-spinner fa-spin" wire:loading wire:target="reloadMemberFromserver"></i>
                {{ $totalInactiveMember }}<sup><i class="fas fa-user-injured"></i></sup>
            </div>
        </div>
        <hr class="mt-1">
        <div class="d-flex flex-row justify-content-between align-content-between">
            <div class="text-primary align-self-center">
                <i class="fas fa-users  text-lg mr-2"></i>
                All( <span>{{ $totalAllMember }}</span> )
            </div>
            <button wire:click.prvent='gotoCustomerList' wire:loading.attr="disabled" wire:target="reloadMemberFromserver"
            class="btn btn-sm btn-primary  align-self-center">
                <i class="fas fa-sign-in-alt"></i>
            </button>
        </div>

    </div>
</div>
