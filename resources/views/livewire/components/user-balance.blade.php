<div wire:poll>  
    <div class="m-0 nave-balance shadow-sm" wire:click.prevent='switchGloble' alt="Click to switch your balance">
        <div class="text-sm text-white m-0 p-0">
            @if ($isGloble)
            All Balance
            @else
            Your Balanc
            @endif
        </div>
        <div style="margin-top: -5px">
            @foreach ($balances as $index => $balance)
            <span class="badge @if ($balance->current_balance <= 0) badge-danger @else badge-success @endif">
                {{$balance->current_balance .$balance->symbol}}
            </span>
            @if($index < count($balances)-1) <span class="text-white"> / </span> @endif
                @endforeach
        </div>

    </div>

</div>