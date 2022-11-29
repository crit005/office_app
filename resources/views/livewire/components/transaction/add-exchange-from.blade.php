<div wire:ignore.self class="modal fade blur-bg-dialog " id="addExchangeFormModal" tabindex="-1" role="dialog"
    aria-labelledby="addExchangeFormModalTitle" aria-hidden="true">
    <div wire:ignore.self class="modal-dialog modal-dialog-exchange modal-dialog-centered" role="document">
        <div class="modal-content modal-blur-light-blue">
            <div class="modal-header">
                <div class="w-100 d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="modal-title text-white" id="exampleModalLongTitle">
                            Add New Exchange
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
            <form wire:submit.prevent='addExchange'>
                <div class="modal-body m-0 border-radius-0 bg-white">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tr_date">Date:</label>
                                <x-datepicker wire:model="form.tr_date" id="tr_date_exchange" :error="'tr_date'"
                                    :format="'DD-MMM-Y'" />
                                @error('tr_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6"></div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currency_id">From Currency:</label>
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
                                <label for="amount">From Amount:</label>
                                <div class="input-group mb-3">
                                    <input type="text"
                                        class="form-control   @error('amount') is-invalid @else {{ $this->getValidClass('amount') }} @enderror"
                                        wire:model.debounce='form.amount' name="amount" id="amount"
                                        placeholder="Amount">
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
                                <label for="to_currency_id">To Currency:</label>
                                <select wire:model.debounce='form.to_currency_id'
                                    class="form-control @error('to_currency_id') is-invalid @else {{ $this->getValidClass('to_currency_id') }} @enderror"
                                    name="to_currency_id" id="to_currency_id">
                                    <option value="">Select Currency</option>
                                    @foreach ($currencies as $currency)
                                        @if ($currency->id != ($form['currency_id'] ?? null))
                                            <option value={{ $currency->id }}>
                                                {{ $currency->code . ' ' . $currency->symbol }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('to_currency_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="to_amount">To Amount:</label>
                                <div class="input-group mb-3">
                                    <input type="text"
                                        class="form-control   @error('to_amount') is-invalid @else {{ $this->getValidClass('to_amount') }} @enderror"
                                        wire:model.debounce='form.to_amount' name="amount" id="to_amount"
                                        placeholder="Amount">
                                    <div class="input-group-append">
                                        <span class="input-group-text"
                                            id="basic-addon1">{{ $toSelectedCurrency ?? '?' }}</span>
                                    </div>
                                    @error('to_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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

                </div>

                <div class="modal-footer">

                    <div class="d-flex text-sm justify-content-between" style="width: 100%;">
                        <div class="text-white">Created_at:
                            {{ date(env('DATE_FORMAT'), strtotime(now())) }}
                        </div>
                        <div class="text-white">Type:
                            <span class="badge-exchange-label">Exchange</span>
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
        window.addEventListener('show-add-exchange-form', e => {
            $('#addExchangeFormModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        window.addEventListener('hide-add-exchange-form', e => {
            $('#addExchangeFormModal').modal('hide');
        });

        window.addEventListener('add-exchange-alert-success', e => {
            Swal.fire({
                title: 'Success!',
                text: 'Exchange added successfully.',
                icon: 'success',
                confirmButtonText: 'OK',

            }).then((e) => {
                $('#addExchangeFormModal').modal('hide');
                Livewire.emit('refreshCashList');
            });
        });

        $('.modal-dialog-exchange').draggable({
            handle: ".modal-header"
        });
    </script>
@endpush
