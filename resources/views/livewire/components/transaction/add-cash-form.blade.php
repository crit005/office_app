<div wire:ignore.self class="modal fade blur-bg-dialog " id="addCashFormModal" tabindex="-1" role="dialog"
    aria-labelledby="addCashFormModalTitle" aria-hidden="true">
    <div wire:ignore.self class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-blur-light-green">
            <div class="modal-header">
                <div class="w-100 d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="modal-title text-white" id="exampleModalLongTitle">
                            Add New Cash
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
            <form wire:submit.prevent='addCash'>
                <div class="modal-body m-0 border-radius-0 bg-white">
                    <div class="row">
                        {{-- <div class="col-md-12"> --}}
                        <div class="form-group col-md-6">
                            <label for="tr_date">Date:</label>
                            <x-datepicker wire:model="form.tr_date" id="tr_date" :error="'tr_date'"
                                :format="'DD-MMM-Y'" />
                            @error('tr_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6"></div>

                        <div class="form-group col-md-6">
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

                        <div class="form-group col-md-6">
                            <label for="amount">Amount:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        id="basic-addon1">{{ $selectedCurrency ?? '?' }}</span>
                                </div>
                                <input type="text"
                                    class="form-control   @error('amount') is-invalid @else {{ $this->getValidClass('amount') }} @enderror"
                                    wire:model.debounce='form.amount' name="amount" id="amount" placeholder="Amount"
                                    aria-label="Username" aria-describedby="basic-addon1">
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">Description:</label>
                            <textarea wire:model.debounce='form.description' name="description" id="description" class="form-control" rows="3"
                                placeholder="Enter ..."></textarea>
                        </div>

                        {{-- </div> --}}

                    </div>
                    <!-- /Ended row -->
                </div>

                <div class="modal-footer">

                    <div class="d-flex text-sm justify-content-between" style="width: 100%;">
                        <div class="text-white">Created_at:
                            {{ date(env('DATE_FORMAT'), strtotime(now())) }}
                        </div>
                        <div class="text-white">Type:
                            <span class="badge-incom-label">Incom</span>
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
        window.addEventListener('show-add-cash-form', e => {
            $('#addCashFormModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        window.addEventListener('hide-add-cash-form', e => {
            $('#addCashFormModal').modal('hide');
        });

        window.addEventListener('add-cash-alert-success', e => {
            Swal.fire({
                title: 'Success!',
                text: 'Cash added successfully.',
                icon: 'success',
                confirmButtonText: 'OK',

            }).then((e) => {
                $('#addCashFormModal').modal('hide');
                Livewire.emit('refreshCashList');
            });
        });

        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });

        function clickme() {
            window.hide - add - cash - form();
        }
    </script>
@endpush
