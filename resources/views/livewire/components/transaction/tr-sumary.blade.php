<div class="d-flex flex-row justify-content-between mb-2">
    <div class="total-info-top d-flex flex-row">
        <div class="mr-3">
            <span class="info-label">Date:</span>
            <span class="info-number">{{$fromDate??"..."}}</span>
            <i class="fas fa-angle-double-right"></i>
            <span class="info-number">{{$toDate??"..."}}</span>
        </div>
    </div>

    <div class="total-info-top d-flex flex-row">
        <div class="mr-3">
            <span class="info-label">CashIn:</span> <span class="info-number">
                @foreach ($totals as $total )
                <span wire:key='sumary_cashin_{{$total->id}}' class="{{$total->cash_in < 0 ? 'text-danger':''}}">{{$total->cash_in . $total->symbol}}</span>
                    {{($total != end($totals)) ? '/':''}}
                @endforeach
            </span>
        </div>
    </div>

    <div class="total-info-top d-flex flex-row">
        <div>
            <span class="info-label">Expand:</span>
            <span class="info-number">
                @foreach ($totals as $total )
                <span wire:key='sumary_expend_{{$total->id}}' class="{{$total->expend < 0 ? 'text-danger':''}}">{{$total->expend . $total->symbol}}</span>
                    {{($total != end($totals)) ? '/':''}}
                @endforeach
            </span>
        </div>
    </div>

    <div class="total-info-top d-flex flex-row">
        <div>
            <span class="info-label">Balance:</span>
            <span class="info-number">
                @foreach ($totals as $total )
                <span wire:key='sumary_balance_{{$total->id}}' class="{{$total->total_cash + $total->begin_amount < 0 ? 'text-danger':''}}">{{$total->total_cash + $total->begin_amount . $total->symbol}}</span>
                    {{($total != end($totals)) ? '/':''}}
                @endforeach
            </span>
        </div>
    </div>
</div>
