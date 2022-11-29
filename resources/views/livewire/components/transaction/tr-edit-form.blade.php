<form wire:submit.prevent='updatePayment' class="">
    <div style="position: relative;" class="mr-3">
        <button type="button" onclick="hideEditPaymentForm()" class="btn btn-inline-form-cancel btn-round btn-sm ml-2 w-32">
            <i class="fas fa-times"></i>
        </button>
        <div class="tr-edit-payment-form-controller height-0" style="overflow: hidden;"  wire:ignore.self>
        {{-- <div class="tr-edit-payment-form-controller height-0"  wire:ignore.self> --}}
            <div class="inline-form m-0 row">

                <div class="form-group-sm text-sm col-lg-2 col-md-4 col-sm-6 mt-2">
                    <label for="tr_edit_date_payment">Date:</label>
                    <x-datepicker wire:key='{{ $transaction->id }}' wire:model="form.tr_date"
                        id="tr_edit_date_payment" :error="'tr_date'" :format="'DD-MMM-Y'" />
                    @error('tr_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group-sm text-sm mt-2 {{$showOtherOption ? 'col-lg-2 col-md-4 col-sm-6' : 'col-lg-4 col-md-8 col-sm-6'}} ">
                    <label for="tr_edit_payment_item_id">Expand Name:</label>
                    <select wire:model.debounce='form.item_id'
                        class="form-control mb-2 @error('item_id') is-invalid @else {{ $this->getValidClass('item_id') }} @enderror"
                        name="item_id" id="tr_edit_payment_item_id">
                        <option value="">Select Expand</option>
                        @foreach ($items as $item)
                            <option value={{ $item->id }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('item_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                @if ($showOtherOption)
                <div class="form-group-sm text-sm col-lg-2 col-md-4 col-sm-6 mt-2">
                    <label for="tr_edit_item_name">Other Name:</label>
                    <div class="input-group mb-2">
                        <input type="text"
                            class="form-control   @error('item_name') is-invalid @else {{ $this->getValidClass('item_name') }} @enderror"
                            wire:model.debounce='form.item_name' name="item_name" id="tr_edit_item_name"
                            placeholder="Other Name" aria-label="Username"
                            aria-describedby="tr_edit_basic-addon1">
                        @error('item_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endif

                <div class="form-group-sm text-sm col-lg-2 col-md-4 col-sm-6 mt-2">
                    <label for="tr_edit_currency_id">Currency:</label>
                    <select wire:model.debounce='form.currency_id'
                        class="form-control @error('currency_id') is-invalid @else {{ $this->getValidClass('currency_id') }} @enderror"
                        name="currency_id" id="tr_edit_currency_id">
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
                <div class="form-group-sm text-sm col-lg-2 col-md-4 col-sm-6 mt-2">
                    <label for="tr_edit_amount">Amount:</label>
                    <div class="input-group mb-2">
                        <input type="text"
                            class="form-control   @error('amount') is-invalid @else {{ $this->getValidClass('amount') }} @enderror"
                            wire:model.debounce='form.amount' name="amount" id="tr_edit_amount" placeholder="Amount"
                            aria-label="Username" aria-describedby="tr_edit_basic-addon1">
                        <div class="input-group-append">
                            <span class="input-group-text"
                                id="tr_edit_basic-addon1">{{ $selectedCurrency ?? '?' }}</span>
                        </div>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group-sm text-sm col-lg-2 col-md-4 col-sm-6 mt-2">
                    <label for="tr_edit_to_from">Expand On:</label>
                    <select wire:model.debounce='form.to_from'
                        class="form-control @error('to_from') is-invalid @else {{ $this->getValidClass('to_from') }} @enderror"
                        name="to_from" id="tr_edit_to_from">
                        <option value="">Select Depatment</option>
                        @foreach ($depatments as $depatment)
                            <option value={{ $depatment->id }}>{{ $depatment->name }}</option>
                        @endforeach
                    </select>
                    @error('to_from')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- <div class="form-group-sm text-sm row col-md-10 col-sm-6 pr-0">
                    <label for="tr_edit_description" class="col-sm-12 col-lg-2 col-md-4 col-form-label pt-0">Description:</label>
                    <div class="col-sm-12 col-md-12 col-lg-10 md-0 p-0">
                        <textarea wire:ignore.self wire:model.debounce='form.description' name="description" id="tr_edit_description" class="form-control"
                            placeholder="Enter ..."
                             ></textarea>
                    </div>
                </div> --}}

                <div class="form-group-sm text-sm col-md-10 col-sm-12 mt-2">
                    <label for="tr_edit_description">Description:</label>
                    <textarea wire:ignore.self wire:model.debounce='form.description' name="description" id="tr_edit_description" class="form-control"
                    placeholder="Enter ..."
                        {{-- rows="1" --}}
                        ></textarea>
                </div>

                <div class="form-group-sm text-sm col-sm-6 col-md-1 d-flex align-items-end mt-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100 mt-2"><i class="fas fa-save"></i></button>
                </div>

                <div class="form-group-sm text-sm col-sm-6 col-md-1 d-flex align-items-end mt-2">
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
            $('#tr_edit_description').on("resize",()=>{
                console.log($('#tr_edit_description').heightgg);
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
