<div>
    <span class="d-block text-white">Your Current Balance</span>
    @foreach ($balances as $balance)
        @dump($balance)
    @endforeach
    <span class="text-black">861285 ฿ / 6538 $</span>
</div>
