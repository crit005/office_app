<form wire:submit.prevent='updatePayment' class="">
    <div style="position: relative;" class="mr-3">
        <button type="button" onclick="hideEditPaymentForm()" class="btn btn-inline-form-cancel btn-round btn-sm ml-2 w-32">
            <i class="fas fa-times"></i>
        </button>
        <div class="tr-edit-payment-form-controller height-0" style="overflow: hidden;"  wire:ignore.self>
        {{-- <div class="tr-edit-payment-form-controller height-0"  wire:ignore.self> --}}
            <div class="inline-form m-0 row">

                <div class="form-group-sm text-sm col-lg-2 col-md-4 col-sm-6  mb-2">
                    <label for="tr_date">Date:</label>
                    <x-datepicker wire:model="form.tr_date" id="tr_date_exchange" :error="'tr_date'"
                        :format="'DD-MMM-Y'" />
                    @error('tr_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group-sm text-sm col-lg-2 col-md-4 col-sm-6 ">
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

                <div class="form-group-sm text-sm col-lg-3 col-md-4 col-sm-6">
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

                <div class="form-group-sm text-sm col-lg-2 col-md-4 col-sm-6">
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
                <div class="form-group-sm text-sm col-lg-3 col-md-4 col-sm-6">
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

                <div class="form-group-sm text-sm col-md-10 col-sm-12">
                    <label for="tr_edit_description">Description:</label>
                    <textarea wire:ignore.self wire:model.debounce='form.description' name="description" id="tr_edit_description" class="form-control"
                    placeholder="Enter ..."
                        {{-- rows="1" --}}
                        ></textarea>
                </div>

                <div class="form-group-sm text-sm col-sm-6 col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm w-100 mt-2"><i class="fas fa-save"></i></button>
                </div>

                <div class="form-group-sm text-sm col-sm-6 col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm w-100 mt-2" onclick="showConfirmDelete('trEditPaymentFormDelete')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>

                <div class="col-md-6 text-sm text-gray mt-2">
                    <div>
                        Created_by: {{$transaction->createdByUser->name}}
                        /{{ date(env('DATE_FORMAT','d-m-Y'), strtotime($transaction->created_at)) }}
                    </div>

                </div>
                <div class="col-md-6 text-sm text-gray text-right mt-2">
                    @if($transaction->updated_by)
                    <div>Last Update: {{$transaction->updatedByUser->name}}/{{date(env('DATE_FORMAT','d-m-Y'), strtotime($transaction->updated_at))}}</div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script>
        $(function e(){
            $('.tr-edit-payment-form-controller').css({"height":$('.inline-form').height()+'px'});
            $('.tr-edit-payment-form-controller').on('transitionend webkitTransitionEnd oTransitionEnd', function () {
                $('.tr-edit-payment-form-controller').css("overflow","");
            });
            // $('#tr_edit_payment_item_id').on('change',(e)=>{
            //     // console.log($('#tr_edit_payment_item_id').find(":selected").val());
            //     // const myTimeout = setTimeout(()=>{
            //     $('.tr-edit-payment-form-controller').css({"height":$('.inline-form').height()+'px'});
            //     // },500);
            // });
        })
    </script>

</form>

