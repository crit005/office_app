<div wire:ignore.self class="modal fade blur-bg-dialog " id="ReportViewCashDataTableModal" tabindex="-1" role="dialog"
    aria-labelledby="ReportViewCashDataTableModalTitle" aria-hidden="true">
    <div wire:ignore.self class="modal-dialog modal-dialog-lg modal-dialog-report-view-data-table modal-dialog-report"
        role="document">
        <div class="modal-content modal-blur-light-blue">
            <div class="modal-header">

                <div class="w-100 d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="modal-title text-white" id="exampleModalLongTitle">
                            Data Table Mode
                        </h5>
                    </div>
                </div>
                {{-- <button onclick="PrintElem('data-table-print-mode')">Print</button> --}}
                <button class="btn btn-primary btn-sm elevation-1 ml-2" onclick="PrintElem('data-table-print-mode')" >
                    <i class="fas fa-print"></i>
                </button>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body m-0 border-radius-0 bg-white print-page page" id="data-table-print-mode">
                {{-- page header --}}
                <div class="page-header">
                    <div class="page-title">
                        {{$title}}
                    </div>
                    <div class="summary-container">
                        <div class="data-filter">
                            <div class="text-info">Date: {{$fromDate??'...'}} to {{$toDate??'...'}}</div>
                            <div>Type: {{$this->getType()}}</div>
                            <div>Currency: {{$this->getCurrency()}}</div>
                            <div>{{$this->getFilter()}}</div>
                        </div>

                        <div class="data-summary text-right">
                            {{-- <div class="text-info">Begin: 1397$/17523฿</div>
                            <div class="text-success">CashIn: 205$/100฿</div>
                            <div class="text-danger">Expended: -280$/-5130฿</div>
                            <div class="text-warning">Balance: 1322$/12493฿</div> --}}
                            @if ($type!=3)
                            <div class="d-flex flex-row text-info">
                                <div>
                                    <span class="info-label">Begin:</span> <span class="info-number">
                                        @foreach ($summary as $total )
                                        <span wire:key='sumary_begin_{{$total->id}}' class="{{$total->begin_amount < 0 ? 'text-danger':''}}">{{$total->begin_amount . $total->symbol}}</span>
                                            {{($total != end($summary)) ? '/':''}}
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                            @endif

                            @if($type==1)
                            <div class="d-flex flex-row text-success">
                                <div>
                                    <span class="info-label">CashIn:</span> <span class="info-number">
                                        @foreach ($summary as $total )
                                        <span wire:key='sumary_cashin_{{$total->id}}' class="{{$total->cash_in < 0 ? 'text-danger':''}}">{{$total->cash_in . $total->symbol}}</span>
                                            {{($total != end($summary)) ? '/':''}}
                                        @endforeach
                                    </span>
                                </div>
                            </div>

                            @elseif ($type==2)
                            <div class="d-flex flex-row text-danger">
                                <div>
                                    <span class="info-label">Expand:</span>
                                    <span class="info-number">
                                        @foreach ($summary as $total )
                                        <span wire:key='sumary_expend_{{$total->id}}' class="{{$total->expend < 0 ? 'text-danger':''}}">{{$total->expend . $total->symbol}}</span>
                                            {{($total != end($summary)) ? '/':''}}
                                        @endforeach
                                    </span>
                                </div>
                            </div>

                            @elseif ($type==3)
                            <div class="d-flex flex-row text-success">
                                <div>
                                    <span class="info-label">Change In:</span> <span class="info-number">
                                        @foreach ($summary as $total )
                                        <span wire:key='sumary_cashin_{{$total->id}}' class="{{$total->cash_in < 0 ? 'text-danger':''}}">{{$total->cash_in . $total->symbol}}</span>
                                            {{($total != end($summary)) ? '/':''}}
                                        @endforeach
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex flex-row text-danger">
                                <div>
                                    <span class="info-label">Change Out:</span>
                                    <span class="info-number">
                                        @foreach ($summary as $total )
                                        <span wire:key='sumary_expend_{{$total->id}}' class="{{$total->expend < 0 ? 'text-danger':''}}">{{$total->expend . $total->symbol}}</span>
                                            {{($total != end($summary)) ? '/':''}}
                                        @endforeach
                                    </span>
                                </div>
                            </div>

                            @else
                            <div class="d-flex flex-row text-success">
                                <div>
                                    <span class="info-label">CashIn:</span> <span class="info-number">
                                        @foreach ($summary as $total )
                                        <span wire:key='sumary_cashin_{{$total->id}}' class="{{$total->cash_in < 0 ? 'text-danger':''}}">{{$total->cash_in . $total->symbol}}</span>
                                            {{($total != end($summary)) ? '/':''}}
                                        @endforeach
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex flex-row text-danger">
                                <div>
                                    <span class="info-label">Expand:</span>
                                    <span class="info-number">
                                        @foreach ($summary as $total )
                                        <span wire:key='sumary_expend_{{$total->id}}' class="{{$total->expend < 0 ? 'text-danger':''}}">{{$total->expend . $total->symbol}}</span>
                                            {{($total != end($summary)) ? '/':''}}
                                        @endforeach
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex flex-row text-info">
                                <div>
                                    <span class="info-label">Balance:</span>
                                    <span class="info-number">
                                        @foreach ($summary as $total )
                                        <span wire:key='sumary_balance_{{$total->id}}' class="{{$total->total_cash + $total->begin_amount < 0 ? 'text-danger':''}}">{{$total->total_cash + $total->begin_amount . $total->symbol}}</span>
                                            {{($total != end($summary)) ? '/':''}}
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
                {{-- ende page header --}}
                {{-- page body --}}
                <div class="page-body">
                    <table style="width: 100%">
                        <thead>
                            <tr>
                                <th class="text-center bg-info text-white px-2 py-1">#</th>
                                <th class="text-center bg-info text-white px-2 py-1">Date</th>
                                <th class="text-center bg-info text-white px-2 py-1">Payment Name</th>
                                <th class="text-center bg-info text-white px-2 py-1">Amount</th>
                                <th class="text-center bg-info text-white px-2 py-1">Pay On</th>
                                <th class="text-center bg-info text-white px-2 py-1">Description</th>
                            </tr>
                        </thead>

                        <tbody id="sortable">
                            @forelse ($trCashs as $indext => $transaction)
                            <tr wire:key="tr-re-{{ $transaction->id }}" class="border-bottom border-1">
                                {{-- Number --}}
                                <td class="text-right px-2 py-1">
                                    {{ $indext +1 }}
                                </td>
                                {{-- Date --}}
                                <td class="text-nowrap px-2 py-1">
                                    {{ date(env('DATE_FORMAT','d-m-Y'), strtotime($transaction->tr_date)) }}
                                </td>
                                {{-- Payment Name --}}
                                <td class="text-nowrap text-left px-2 py-1">
                                    @if ($transaction->item_id != 13)
                                    {{ $transaction->item->name }}
                                    @else
                                    {{ $transaction->other_name }}
                                    @endif
                                </td>
                                {{-- Amount --}}
                                <td class="text-nowrap text-right px-2 py-1
                                        @if ($transaction->type == 1) text-success
                                        @elseif ($transaction->type == 2)
                                        text-danger
                                        @elseif ($transaction->type == 3)
                                        text-info @endif ">
                                    {{ $transaction->amount . $transaction->currency->symbol }}
                                </td>
                                {{-- Pay on --}}
                                <td class="text-nowrap text-center px-2 py-1">
                                    @if ($transaction->type == 1)
                                        ...
                                    @elseif ($transaction->type == 2)
                                    {{ $transaction->depatment->name }}
                                    @elseif ($transaction->type == 3)
                                    <div class="text-success">{{ $transaction->other_name }}</div>
                                    @endif

                                </td>
                                {{-- detail --}}
                                <td scope="col" class="text-center px-2 py-1">
                                    {{ $transaction->description }}
                                </td>
                            </tr>
                            @empty
                            <tr class="bg-wite">
                                <td colspan="6" class="text-center"> No record found...</td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>
                {{-- end page body --}}
                {{-- page footer --}}
                <div class="page-footer">

                </div>
                {{-- end page footer --}}
            </div>

            {{-- <div class="modal-footer">

            </div> --}}

        </div>
    </div>
    {{-- from cash report --}}
<script>
    function printDiv(elem) {
       var divContents = document.getElementById(elem).innerHTML;
       var a = window.open('', '', 'height=500, width=500');
       a.document.write('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"><html>');
       a.document.write('<body >');
       a.document.write(divContents);
       a.document.write('</body></html>');
       a.document.close();
       a.print();
   }

   function PrintElem(elem)
   {
       let l = (window.screen.width - 1250)/2;
       // window.screen.width;
       var mywindow = window.open('', 'PRINT', 'height=1122,width=1250,left='+l);

       mywindow.document.write('<html><head><title>' + document.title  + '</title>');
       mywindow.document.write(`<link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">`);
       mywindow.document.write(`<link rel="stylesheet" href="{{ asset('css/style.css') }}">`);

       mywindow.document.write('</head><body >');
       mywindow.document.write(document.getElementById(elem).outerHTML);
       // mywindow.document.write(document.getElementById(elem).innerHTML);
       mywindow.document.write('</body></html>');
       mywindow.document.close(); // necessary for IE >= 10
       mywindow.focus(); // necessary for IE >= 10*/

       mywindow.onload=function(){ // necessary if the div contain images
           mywindow.focus(); // necessary for IE >= 10
           mywindow.print();
           mywindow.close();
       };

       //mywindow.print();
       //mywindow.close();

       return true;
   }

   window.addEventListener('show-report-view-data-table-cash-modal', e => {
       $('#ReportViewCashDataTableModal').modal({
           backdrop: 'static',
           keyboard: false
       });
   });

   window.addEventListener('hide-report-view-data-table-cash-modal', e => {
       $('#ReportViewCashDataTableModal').modal('hide');
   });

   $('.modal-dialog-report-view-data-table').draggable({
       handle: ".modal-header"
   });

   $('#ReportViewCashDataTableModal').on('hidden.bs.modal', function (e) {
        // Livewire.emit('cashResetPrintRequest');
        cashResetPrintRequest();
   })
</script>

</div>

@push('js')

@endpush
