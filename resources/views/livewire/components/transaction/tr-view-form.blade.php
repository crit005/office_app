<div wire:ignore.self class="modal fade blur-bg-dialog " id="viewPaymentFormModal" tabindex="-1" role="dialog"
    aria-labelledby="viewPaymentFormModalTitle" aria-hidden="true">
    <div wire:ignore.self class="modal-dialog modal-dialog-view-pament modal-dialog-centered" role="document">
        <div class="modal-content modal-blur-light-red">
            <div class="modal-header">
                <div class="w-100 d-flex flex-row justify-content-between">
                    @if ($transaction)
                        <div>
                            <h5 class="modal-title text-white" id="exampleModalLongTitle">
                                Payment #{{$transaction->id}}
                            </h5>
                            <div class="text-white text-sm">Created_by:
                                {{ auth()->user()->name }}
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
                        <div>
                            <span class="mr-3">Date:</span> <span>{{ date(env('DATE_FORMAT'), strtotime($transaction->tr_date)) }}</span>
                        </div>
                        <div>
                            <span class="mr-3">Pament Name:</span> <span class="mr-3">{{$transaction->item->name}}</span>
                            <span class="mr-3">Pay on:</span> <span>{{$transaction->depatment->name}}</span>
                        </div>
                        <div>
                            <span class="mr-3">Amount:</span> <span class="text-danger" style="font-size: 2rem;">{{$transaction->amount.' '.$transaction->currency->symbol}}</span>
                        </div>
                        <div>
                            <span>Describe:</span>
                        </div>
                        <div>
                            {!! $transaction->description !!}
                            {{json_decode($transaction->logs)[0]->tr_date}}
                            {{-- {{json_decode($transaction->log)[0]->tr_date}} --}}
                        </div>
                    @endif



                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <img class="d-block w-100" src="..." alt="First slide">
                          </div>
                          <div class="carousel-item">
                            <img class="d-block w-100" src="..." alt="Second slide">
                          </div>
                          <div class="carousel-item">
                            <img class="d-block w-100" src="..." alt="Third slide">
                          </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                      </div>



                </div> <!-- end modal-body -->

                <div class="modal-footer">

                    <div class="d-flex text-sm justify-content-between" style="width: 100%;">
                        <div class="text-white">Created_at:
                            {{ date(env('DATE_FORMAT'), strtotime($transaction->created_at)) }}
                        </div>

                        <div>
                            <button type="button" class="btn btn-secondary"data-dismiss="modal">
                                <i class="fa fa-times mr-2"></i>Cancel</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"><i
                                    class="fa fa-save mr-2"></i>Save</button>
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

