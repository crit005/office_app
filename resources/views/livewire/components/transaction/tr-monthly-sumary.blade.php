<div class="d-flex flex-row justify-content-between">

    <div class="text-warning  text-left">
        Begin:
        @foreach ($totals as $total )
           <span class="{{$total->begin_amount < 0 ? 'text-danger':''}}">{{$total->begin_amount . $total->symbol}}</span>
            {{($total != end($totals)) ? '/':''}}
        @endforeach
    </div>
    <div class="text-success  text-center">
        Incom:
        @foreach ($totals as $total )
        <span class="{{$total->income < 0 ? 'text-danger':''}}">{{$total->income . $total->symbol}}</span>
            {{($total != end($totals)) ? '/':''}}
        @endforeach
    </div>
    <div class="text-danger  text-center">
        Expended:
        @foreach ($totals as $total )
        <span class="{{$total->expend < 0 ? 'text-danger':''}}">{{$total->expend . $total->symbol}}</span>
            {{($total != end($totals)) ? '/':''}}
        @endforeach
    </div>
    <div class="text-primary  text-right">
        Balance:
        @foreach ($totals as $total )
        <span class="{{$total->balance < 0 ? 'text-danger':''}}">{{$total->balance . $total->symbol}}</span>
            {{($total != end($totals)) ? '/':''}}
        @endforeach
    </div>

</div>
