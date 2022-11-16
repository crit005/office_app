<div wire:ignore.self class="modal fade blur-bg-dialog " id="addPaymentFormModal" tabindex="-1" role="dialog"
    aria-labelledby="addPaymentFormModalTitle" aria-hidden="true">
    <div wire:ignore.self class="modal-dialog modal-dialog-pament modal-dialog-centered" role="document">
        <div class="modal-content modal-blur-light-red">
            <div class="modal-header">
                <div class="w-100 d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="modal-title text-white" id="exampleModalLongTitle">
                            Add New Payment
                        </h5>
                        <div class="text-white text-sm">Created_by:
                            {{ auth()->user()->name }}
                        </div>
                    </div>
                    <div>
                        <div class="text-white text-sm">Current_balance:
                            {{ $this->getCurrencyBalance() }}
                        </div>
                        <div class="text-white text-sm">Next balance:
                            {{ $this->getCurrencyNexBalance() }}
                        </div>
                    </div>
                </div>


                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <form wire:submit.prevent='{{ $showEditModal ? ' updateDepatment' : 'createDepatment' }}'> --}}
            <form wire:submit.prevent='addPayment'>
                <div class="modal-body m-0 border-radius-0 bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tr_date">Date:</label>
                                <x-datepicker wire:model="form.tr_date" id="tr_date_pament" :error="'tr_date'"
                                    :format="'DD-MMM-Y'" />
                                @error('tr_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6"></div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="item_id">Expand Name:</label>
                                <select wire:model.debounce='form.item_id'
                                    class="form-control @error('item_id') is-invalid @else {{ $this->getValidClass('item_id') }} @enderror"
                                    name="item_id" id="item_id">
                                    <option value="">Select Expand</option>
                                    @foreach ($items as $item)
                                        <option value={{ $item->id }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('item_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            @if ($showOtherOption)
                                <div class="form-group">
                                    <label for="item_name">Other Name:</label>
                                    <div class="input-group mb-3">
                                        <input type="text"
                                            class="form-control   @error('item_name') is-invalid @else {{ $this->getValidClass('item_name') }} @enderror"
                                            wire:model.debounce='form.item_name' name="item_name" id="item_name"
                                            placeholder="Other Name" aria-label="Username"
                                            aria-describedby="basic-addon1">
                                        @error('item_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currency_id">Currency:</label>
                                <select wire:model.debounce='form.currency_id'
                                    class="form-control @error('currency_id') is-invalid @else {{ $this->getValidClass('currency_id') }} @enderror"
                                    name="currency_id" id="currency_id">
                                    <option value="">Select Currency</option>
                                    @foreach ($currencies as $currency)
                                        <option value={{ $currency->id }}>
                                            {{ $currency->code . ' ' . $currency->symbol }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount:</label>
                                <div class="input-group mb-3">
                                    <input type="text"
                                        class="form-control   @error('amount') is-invalid @else {{ $this->getValidClass('amount') }} @enderror"
                                        wire:model.debounce='form.amount' name="amount" id="amount"
                                        placeholder="Amount" aria-label="Username" aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                            id="basic-addon1">{{ $selectedCurrency ?? '?' }}</span>
                                    </div>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="depatment_id">Expand On:</label>
                                <select wire:model.debounce='form.to_from'
                                    class="form-control @error('to_from') is-invalid @else {{ $this->getValidClass('to_from') }} @enderror"
                                    name="to_from" id="to_from">
                                    <option value="">Select Depatment</option>
                                    @foreach ($depatments as $depatment)
                                        <option value={{ $depatment->id }}>{{ $depatment->name }}</option>
                                    @endforeach
                                </select>
                                @error('to_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea wire:model.debounce='form.description' name="description" id="description" class="form-control" rows="3"
                                    placeholder="Enter ..."></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /Ended row -->

                </div> <!-- end modal-body -->

                <div class="modal-footer">

                    <div class="d-flex text-sm justify-content-between" style="width: 100%;">
                        <div class="text-white">Created_at:
                            {{ date(env('DATE_FORMAT'), strtotime(now())) }}
                        </div>
                        <div class="text-white">Type:
                            <span class="badge-expend-label">Expend</span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary"data-dismiss="modal">
                                <i class="fa fa-times mr-2"></i>Cancel</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"><i
                                    class="fa fa-save mr-2"></i>Save</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script>
        window.addEventListener('show-add-payment-form', e => {
            $('#addPaymentFormModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        window.addEventListener('hide-add-payment-form', e => {
            $('#addPaymentFormModal').modal('hide');
        });

        window.addEventListener('add-payment-alert-success', e => {
            console.log('called');
            Swal.fire({
                title: 'Success!',
                text: 'Payment added successfully.',
                icon: 'success',
                confirmButtonText: 'OK',

            }).then((e) => {
                $('#addPaymentFormModal').modal('hide');
                Livewire.emit('refreshCashList');
            });
        });

        $('.modal-dialog-pament').draggable({
            handle: ".modal-header"
        });

        function clickme() {
            window.hide - add - cash - form();
        }
    </script>
@endpush
