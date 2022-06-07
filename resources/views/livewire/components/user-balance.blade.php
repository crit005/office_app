<div>
    <span class="d-block text-white">Your Current Balance</span>
   
    @dump(gettype($balances))
    @dump($balances)
    @foreach ($balances as $balance)
    {{-- {{$balance['current_balance'] .$balance['symbol']}} --}}
    @endforeach
    

    <span class="text-black">861285 ฿ / 6538 $</span>
</div>