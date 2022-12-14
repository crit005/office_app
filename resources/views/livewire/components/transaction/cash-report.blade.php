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

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body m-0 border-radius-0 bg-white print-page page">
                {{-- page header --}}
                <div class="page-header">
                    <div class="page-title">
                        {{$title}}
                    </div>
                    <div class="summary-container">
                        <div class="data-filter">
                            <div class="text-info">Date: {{$fromDate??'...'}} to {{$toDate??'...'}}</div>
                            <div>Type: All</div>
                            <div>Currency: All</div>
                            <div>Filter:</div>
                        </div>
                        <div class="data-summary">
                            <div class="text-info">Begin: 1397$/17523฿</div>
                            <div class="text-success">CashIn: 205$/100฿</div>
                            <div class="text-danger">Expended: -280$/-5130฿</div>
                            <div class="text-warning">Balance: 1322$/12493฿</div>
                        </div>
                    </div>
                </div>
                {{-- ende page header --}}
                {{-- page body --}}
                <div class="page-body">
                    <table style="width: 100%">
                        <thead>
                            <tr style="border: 1px solid rgb(124, 124, 124)">
                                <th class="text-center bg-info text-white">#</th>
                                <th class="text-center bg-info text-white">Date</th>
                                <th class="text-center bg-info text-white">Payment Name</th>
                                <th class="text-center bg-info text-white">Amount</th>
                                <th class="text-center bg-info text-white">Pay On</th>
                                <th class="text-center bg-info text-white">Description</th>
                            </tr>
                        </thead>

                        <tbody id="sortable">
                            @forelse ($trCashs as $indext => $transaction)
                            <tr style="border: 1px solid rgb(124, 124, 124)"
                                wire:key="tr-re-{{ $transaction->id }}">
                                {{-- Number --}}
                                <td class="text-right minimal-table-column-t" style="padding-left: 5px; padding-right: 5px">
                                    {{ $indext +1 }}
                                </td>
                                {{-- Date --}}
                                <td class="minimal-table-column-t" style="border: 1px solid rgb(124, 124, 124)">
                                    {{ date(env('DATE_FORMAT','d-m-Y'), strtotime($transaction->tr_date)) }}
                                </td>
                                {{-- Payment Name --}}
                                <td class="text-left" style="border: 1px solid rgb(124, 124, 124)">
                                    @if ($transaction->item_id != 13)
                                    {{ $transaction->item->name }}
                                    @else
                                    {{ $transaction->other_name }}
                                    @endif
                                </td>
                                {{-- Amount --}}
                                <td class="text-center minimal-table-column-t
                                        @if ($transaction->type == 1) text-success
                                        @elseif ($transaction->type == 2)
                                        text-danger
                                        @elseif ($transaction->type == 3)
                                        text-info @endif " style="border: 1px solid rgb(124, 124, 124)">
                                    {{ $transaction->amount . $transaction->currency->symbol }}
                                </td>
                                {{-- Pay on --}}
                                <td class="text-center minimal-table-column-t" style="border: 1px solid rgb(124, 124, 124)">
                                    @if ($transaction->type == 1)
                                        ...
                                    @elseif ($transaction->type == 2)
                                    {{ $transaction->depatment->name }}
                                    @elseif ($transaction->type == 3)
                                    <div class="text-success">{{ $transaction->other_name }}</div>
                                    @endif

                                </td>
                                {{-- detail --}}
                                <td scope="col" class="text-center text-nowrap" style="border: 1px solid rgb(124, 124, 124)">
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
</div>

@push('js')
<script>
    window.addEventListener('show-report-view-data-table-cash-modal', e => {
            $('#ReportViewCashDataTableModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        window.addEventListener('hide-report-view-data-table-cash-modal', e => {
            $('#ReportViewCashDataTableModal').modal('hide');
        });

        // window.addEventListener('add-exchange-alert-success', e => {
        //     Swal.fire({
        //         title: 'Success!',
        //         text: 'Exchange added successfully.',
        //         icon: 'success',
        //         confirmButtonText: 'OK',

        //     }).then((e) => {
        //         $('#ReportViewCashDataTableModal').modal('hide');
        //         Livewire.emit('refreshCashList');
        //     });
        // });

        $('.modal-dialog-report-view-data-table').draggable({
            handle: ".modal-header"
        });
</script>
@endpush
