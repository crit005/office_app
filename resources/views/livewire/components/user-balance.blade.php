<div wire:poll>
    <span class="d-block text-white">Your Current Balance</span>

    @foreach ($balances as $index => $balance)
    <span class="badge @if ($balance->current_balance <= 0) badge-danger @else badge-success @endif">
        {{$balance->current_balance .$balance->symbol}}
    </span>
    @if($index < count($balances)-1) <span class="text-white"> / </span> @endif
    @endforeach

</div>