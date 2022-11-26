<form wire:submit.prevent='updateAddCash' class="">
    <div style="position: relative;" class="mr-3">
        <button type="button" onclick="hideEditPaymentForm()" class="btn btn-inline-form-cancel btn-round btn-sm ml-2 w-32">
            <i class="fas fa-times"></i>
        </button>
        <div class="tr-edit-payment-form-controller height-0" wire:ignore.self>
            <div class="inline-form m-0 row">

                <div class="form-group col-md-2 col-sm-6">
                    <label for="tr_edit_add_cash_tr_date">Date:</label>
                    <x-datepicker wire:model="form.tr_date" id="tr_edit_add_cash_tr_date" :error="'tr_date'"
                        :format="'DD-MMM-Y'" />
                    @error('tr_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3 col-sm-6">
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

                <div class="form-group col-md-2 col-sm-6">
                    <label for="amount">Amount:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"
                                id="basic-addon1">{{ $selectedCurrency ?? '?' }}
                            </span>
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

                <div class="form-group row col-md-10 col-sm-6 pr-0">
                    <label for="tr_edit_description" class="col-sm-12 col-md-2 col-form-label pt-0">Description:</label>
                    <div class="col-sm-12 col-md-10 m-md-0 p-0">
                        <textarea wire:model='form.description' name="description" id="tr_edit_description" class="form-control"
                            placeholder="Enter ..." rows="1"></textarea>
                    </div>
                </div>

                <div class="form-group col-md-2 d-flex flex-col justify-content-center">
                    <button type="submit" class="btn btn-primary btn-sm ml-2 w-32" style="width:45%"><i
                            class="fas fa-save"></i></button>
                    <button type="button" class="btn btn-danger btn-sm ml-2 w-32" style="width:45%"
                    onclick="showConfirmDelete('trEditAddCashFormDelete')">
                        <i class="fas fa-trash"></i></i>
                    </button>
                </div>

                <div class="text-sm text-gray row w-100">
                    <div class="col-md-6 d-flex flex-col justify-content-md-start w-100">
                        <div class="mr-2">Created_at: {{ date(env('DATE_FORMAT'), strtotime($transaction->created_at)) }}</div>
                        <div>Created_by: {{$transaction->createdByUser->name}}</div>
                    </div>
                    <div class="col-md-6 d-flex flex-col justify-content-md-end w-100">
                        @if($transaction->updated_by)
                        <div class="mr-2">Last Update: {{$transaction->updatedByUser->name}}/{{date(env('DATE_FORMAT'), strtotime($transaction->updated_at))}}</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(function e(){
            $('.tr-edit-payment-form-controller').css({"height":$('.inline-form').height()+'px'});
            const myTimeout = setTimeout(()=>{
                $('.tr-edit-payment-form-controller').css({"height":$('.inline-form').height()+'px'});
            },10);
            $('.tr-edit-payment-form-controller').on('transitionend webkitTransitionEnd oTransitionEnd', function () {
                $('.tr-edit-payment-form-controller').css("overflow","unset");
            });
        })
    </script>

</form>
