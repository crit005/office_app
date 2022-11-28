<div wire:ignore.self class="modal fade blur-bg-dialog " id="viewPaymentFormModal" tabindex="-1" role="dialog"
    aria-labelledby="viewPaymentFormModalTitle" aria-hidden="true">

    <div wire:ignore.self class="modal-dialog modal-lg modal-dialog-view-pament modal-dialog-centered" role="document">
        <div class="modal-content
            @if ($transaction)
                @if ($transaction->type == 2)
                    modal-blur-light-red
                @elseif ($transaction->type == 1)
                    modal-blur-light-green
                    @elseif ($transaction->type == 3)
                    modal-blur-light-blue
                @endif
            @endif">
            <div class="modal-header">
                <div class="w-100 d-flex flex-row justify-content-between">
                    @if ($transaction)
                        <div>
                            <h5 class="modal-title text-white" id="exampleModalLongTitle">
                                @if ($transaction->type == 2)
                                    Payment
                                @elseif ($transaction->type == 1)
                                    Add Cash
                                @elseif ($transaction->type == 3)
                                    Exchange
                                @endif
                                 #{{ $transaction->id }}
                            </h5>
                            <div class="text-white text-sm">
                                Created_by: {{ auth()->user()->name }} on: {{ date(env('DATE_FORMAT', 'd-m-Y'), strtotime($transaction->created_at)) }}
                            </div>
                        </div>
                    @endif
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body m-0 border-radius-0 bg-white">
                @if ($transaction)
                    @if ($transaction->type == 2)
                        <div>
                            <span class="mr-3 text-bold">Date:</span>
                            <span>{{ date(env('DATE_FORMAT', 'd-m-Y'), strtotime($transaction->tr_date)) }}</span>
                        </div>
                        <div>
                            <span class="mr-3 text-bold">Pament Name:</span> <span
                                class="mr-3">{{ $transaction->item_id != 13 ? $transaction->item->name : $transaction->other_name }}</span>
                            <span class="mr-3 text-bold">Pay on:</span>
                            <span style="
                                display: inline-block;
                                border-radius: 2px;
                                color:{{$transaction->depatment->text_color}};
                                background:{{$transaction->depatment->bg_color}};" class="pl-2 pr-2">
                                {{ $transaction->depatment->name }}
                            </span>
                        </div>
                        <div>
                            <span class="mr-3 text-bold">Amount:</span> <span class="text-danger"
                                style="font-size: 2rem;">{{ $transaction->amount . ' ' . $transaction->currency->symbol }}</span>
                        </div>
                        <div>
                            <span class="text-bold">Describe:</span>
                        </div>
                        <div>
                            {!! nl2br($transaction->description) !!}
                        </div>
                    @elseif ($transaction->type == 1)
                        <!-- Add Cash View -->
                        <div>
                            <span class="mr-3 text-bold">Date:</span>
                            <span>{{ date(env('DATE_FORMAT', 'd-m-Y'), strtotime($transaction->tr_date)) }}</span>
                        </div>
                        <div>
                            <span class="mr-3 text-bold">Amount:</span> <span class="text-success"
                                style="font-size: 2rem;">{{ $transaction->amount . ' ' . $transaction->currency->symbol }}
                            </span>
                        </div>
                        <div>
                            <span class="text-bold">Describe:</span>
                        </div>
                        <div>
                            {!! nl2br($transaction->description) !!}
                        </div>
                    @elseif ($transaction->type == 3)
                        <!-- Exchange View -->
                        <div>
                            <span class="mr-3 text-bold">Date:</span>
                            <span>{{ date(env('DATE_FORMAT', 'd-m-Y'), strtotime($transaction->tr_date)) }}</span>
                        </div>
                        <div>
                            <span class="mr-3 text-bold">From Amount:</span> <span class="text-danger"
                                style="font-size: 2rem;">{{ $transaction->amount . ' ' . $transaction->currency->symbol }}
                            </span>
                            <span class="mr-3 text-bold">To Amount:</span> <span class="text-success"
                                style="font-size: 2rem;">{{ $transaction->other_name }}
                            </span>
                        </div>
                        <div>
                            <span class="text-bold">Describe:</span>
                        </div>
                        <div>
                            {!! nl2br($transaction->description) !!}
                        </div>

                    @endif
                @endif

            </div> <!-- end modal-body -->

            <div class="modal-footer">

                <div class="d-flex text-sm justify-content-between" style="width: 100%;">
                    <div class="text-white">Updated
                        @if ($transaction->updated_by)
                            by: {{ $transaction->updatedByUser->name }}
                        @endif
                        @if ($transaction->updated_at)
                            on: {{ date(env('DATE_FORMAT', 'd-m-Y'), strtotime($transaction->updated_at)) }}
                        @endif
                    </div>

                    <div>
                        <button id="viewFormEditTransaction" type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled"
                            onclick="function callTrListUpdate(){
                                $('#tr_btn_edit_{{$transaction->id}}').click();
                                $('#viewPaymentFormModal').modal('hide');
                                }callTrListUpdate();"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script>
        window.addEventListener('show-view-form', e => {
            $('#viewPaymentFormModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        window.addEventListener('hide-view-form', e => {
            $('#viewPaymentFormModal').modal('hide');
        });

        $('.modal-dialog-view-pament').draggable({
            handle: ".modal-header"
        });
    </script>
</div>
