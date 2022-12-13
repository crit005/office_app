<div class="d-flex flex-row justify-content-between">
    {{-- @dump($totals) --}}
    @if ($mode == 1)
    <div class="text-warning  text-left">
        Begin:
        @foreach ($totals as $total )
           <span class="{{$total->begin_amount < 0 ? 'text-danger':''}}">{{$total->begin_amount . $total->symbol}}</span>
            {{($total != end($totals)) ? '/':''}}
        @endforeach
    </div>
    <div class="text-success  text-center">
        CashIn:
        @foreach ($totals as $total )
        <span class="{{$total->cash_in < 0 ? 'text-danger':''}}">{{$total->cash_in . $total->symbol}}</span>
            {{($total != end($totals)) ? '/':''}}
        @endforeach
    </div>
    @elseif ($mode == 2)
    <div class="text-warning  text-left">
        Begin:
        @foreach ($totals as $total )
           <span class="{{$total->begin_amount < 0 ? 'text-danger':''}}">{{$total->begin_amount . $total->symbol}}</span>
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
    @elseif ($mode == 3)
    <div class="text-warning  text-left">
        Begin:
        @foreach ($totals as $total )
           <span class="{{$total->begin_amount < 0 ? 'text-danger':''}}">{{$total->begin_amount . $total->symbol}}</span>
            {{($total != end($totals)) ? '/':''}}
        @endforeach
    </div>
    <div class="text-success  text-center">
        Change In:
        @foreach ($totals as $total )
        <span class="{{$total->cash_in < 0 ? 'text-danger':''}}">{{$total->cash_in . $total->symbol}}</span>
            {{($total != end($totals)) ? '/':''}}
        @endforeach
    </div>
    <div class="text-danger  text-center">
        Change out:
        @foreach ($totals as $total )
        <span class="{{$total->expend < 0 ? 'text-danger':''}}">{{$total->expend . $total->symbol}}</span>
            {{($total != end($totals)) ? '/':''}}
        @endforeach
    </div>
    @else
    <div class="text-warning  text-left">
        Begin:
        @foreach ($totals as $total )
           <span class="{{$total->begin_amount < 0 ? 'text-danger':''}}">{{$total->begin_amount . $total->symbol}}</span>
            {{($total != end($totals)) ? '/':''}}
        @endforeach
    </div>
    <div class="text-success  text-center">
        CashIn:
        @foreach ($totals as $total )
        <span class="{{$total->cash_in < 0 ? 'text-danger':''}}">{{$total->cash_in . $total->symbol}}</span>
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
        <span class="{{$total->total_cash + $total->begin_amount < 0 ? 'text-danger':''}}">{{$total->total_cash + $total->begin_amount . $total->symbol}}</span>
            {{($total != end($totals)) ? '/':''}}
        @endforeach
    </div>
    @endif

</div>
