<div>
    <span class="d-block text-white">Your Current Balance</span>
    <span class="text-black">
        {{-- @dump(gettype($balances))
        @dump($balances) --}}
        @foreach ($balances as $balance)
        {{$balance->current_balance .$balance->symbol}}
        @endforeach
    </span>
</div>
