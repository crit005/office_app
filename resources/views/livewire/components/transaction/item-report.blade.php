<div wire:ignore.self class="modal fade blur-bg-dialog " id="ReportViewCashDataTableModal" tabindex="-1" role="dialog"
    aria-labelledby="ReportViewCashDataTableModalTitle" aria-hidden="true">
    <div wire:ignore.self class="modal-dialog modal-dialog-lg modal-dialog-report-view-data-table modal-dialog-report"
        role="document">
        <div class="modal-content modal-blur-light-blue">
            <div class="modal-header">

                <div class="w-100 d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="modal-title text-white" id="exampleModalLongTitle">
                            Payment Mode
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

                        <div class="data-summary">
                            {{-- <div class="text-info">Begin: 1397$/17523฿</div>
                            <div class="text-success">CashIn: 205$/100฿</div>
                            <div class="text-danger">Expended: -280$/-5130฿</div>
                            <div class="text-warning">Balance: 1322$/12493฿</div> --}}

                            <div class="d-flex flex-row text-info">
                                <div>
                                    <span class="info-label">Expend:</span>
                                    <div class="info-number">
                                        @if ($totalDepartments)
                                            @foreach ($totalDepartments as $key=>$value )
                                                <div>
                                                    <span class="text-info">{{explode('_',$key)[0]}} : </span><span class="text-danger">{{$value}}{{explode('_',$key)[1]}}</span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- ende page header --}}
                {{-- page body --}}
                <div class="page-body">
                    <div class="row pt-3">
                        <div class="col">
                            <table class="table table-v1 table-hover">
                                <thead>
                                    <tr class="tr-th-border-0">
                                        <th scope="col" class="text-center text-white minimal-table-column px-0 bg-info">
                                            <div>#</div>
                                        </th>
                                        <th scope="col" class="text-left text-white text-nowrap px-0 minimal-table-column bg-info">
                                            <div>Payment Name</div>
                                        </th>
                                        @if ($trCashs)
                                            @foreach ( $trCashs[0] as $key => $value )
                                                @if ($key != 'name' && $key != 'text_color' && $key != 'bg_color')
                                                <th scope="col" class="text-center text-whithe px-0  bg-info">
                                                    <div>
                                                        {{$key}}
                                                    </div>
                                                </th>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tr>
                                </thead>

                                <tbody id="sortable2">
                                    @if ($trCashs)
                                        @forelse ($trCashs as $indext => $transaction)

                                            <tr class="tr-td-border-0 bg-wite  text-sm-small-screen border-bottom-1" wire:key="dp-{{$indext}}"
                                                id="dp-{{ $indext }}">
                                                <td scope="col" class="text-sm text-left py-0">
                                                    <div class="p-1">
                                                        {{$indext +1}}
                                                    </div>
                                                </td>

                                                <td scope="col" class="text-center text-sm py-0">
                                                    <div class="text-left p-1 pl-2 text-nowrap">
                                                        {{ $transaction->name }}
                                                    </div>
                                                </td>

                                                @foreach ( $transaction as $key => $value )
                                                    @if ($key != 'name')
                                                    <td scope="col" class="text-right py-0 text-danger">
                                                        <div class="p-1">
                                                            {{$value?-$value:0}}{{explode('_',$key)[1]}}
                                                            <div class="progress progress-xxs">
                                                                <div class="progress-bar  bg-warning progress-bar-danger progress-bar-striped"
                                                                role="progressbar" aria-valuenow="{{$value?$value/($totalDepartments[$key]/100):0}}"
                                                                aria-valuemin="0" aria-valuemax="100"
                                                                style="width: {{$value?$value/($totalDepartments[$key]/100):0}}%;">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @endif
                                                @endforeach

                                            </tr>
                                        @endforeach
                                        <tr class="border-bottom-1">
                                            <th colspan="2" class="text-center text-sm py-0 bg-gray-light-h" style="background-color:rgb(235 235 235) !important;">
                                                <div class="text-right text-info p-1 pl-2">
                                                    Total:
                                                </div>
                                            </th>
                                            @foreach ( $trCashs[0] as $key => $value )
                                                @if ($key != 'name' && $key != 'text_color' && $key != 'bg_color')
                                                <th class="text-right py-0  bg-gray-light-h" style="background-color:rgb(235 235 235) !important;">
                                                    <div class="p-1 text-bold text-danger">
                                                        {{-$totalDepartments[$key]}}{{explode('_',$key)[1]}}
                                                    </div>
                                                </th>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>
                        {{-- chart --}}
                    </div>
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
