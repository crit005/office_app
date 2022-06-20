<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-white">Edit Expand</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form wire:submit.prevent='addExpand'>
                            <div class="card-header text-white text-center">
                                <h1 class="m-0">EDIT EXPAND</h1>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tr_date">Date:</label>
                                            <x-datepicker wire:model="form.tr_date" id="tr_date" :error="'tr_date'"
                                                :format="'DD-MMM-Y'" />
                                            @error('tr_date')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label for="currency_id">Currency:</label>
                                                    <select wire:model.debounce='form.currency_id'
                                                        class="form-control @error('currency_id') is-invalid @else {{$this->getValidClass('currency_id')}} @enderror"
                                                        name="currency_id" id="currency_id">
                                                        <option value="">Select Currency</option>
                                                        @foreach ($currencies as $currency)
                                                        <option value={{$currency->id}}>{{$currency->code .'
                                                            '.$currency->symbol}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('currency_id')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label for="amount">Amount:</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text"
                                                            class="form-control   @error('amount') is-invalid @else {{$this->getValidClass('amount')}} @enderror"
                                                            wire:model.debounce='form.amount' name="amount" id="amount"
                                                            placeholder="Amount" aria-label="Username"
                                                            aria-describedby="basic-addon1">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"
                                                                id="basic-addon1">{{$selectedCurrency
                                                                ?? "?"}}</span>
                                                        </div>
                                                        @error('amount')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="item_id">Expand Name:</label>
                                            <select wire:model.debounce='form.item_id'
                                                class="form-control @error('item_id') is-invalid @else {{$this->getValidClass('item_id')}} @enderror"
                                                name="item_id" id="item_id">
                                                <option value="">Select Expand</option>
                                                @foreach ($items as $item)
                                                <option value={{$item->id}}>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('item_id')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="depatment_id">Expand On:</label>
                                            <select wire:model.debounce='form.to_from'
                                                class="form-control @error('to_from') is-invalid @else {{$this->getValidClass('to_from')}} @enderror"
                                                name="to_from" id="to_from">
                                                <option value="">Select Depatment</option>
                                                @foreach ($depatments as $depatment)
                                                <option value={{$depatment->id}}>{{$depatment->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('to_from')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                    </div>

                                </div>
                                {{-- end row --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description:</label>
                                            <textarea wire:model.lazy='form.description' name="description"
                                                id="description" class="form-control" rows="3"
                                                placeholder="Enter ..."></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="d-flex justify-content-between" style="width: 100%;">
                                    <div class="text-white">Created_at:
                                        {{date(env("DATE_FORMAT"),strtotime(now()))}}
                                    </div>
                                    <div>
                                        {{-- <a href="{{url()->previous()}}"> --}}
                                            <button onclick="history.back()" type="button" class="btn btn-secondary"
                                                data-dismiss="modal"><i class="fa fa-times mr-2"></i>Cancel</button>
                                            {{-- </a> --}}

                                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"><i
                                                class="fa fa-save mr-2"></i>Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.Row for table -->


        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

@push('js')
<script>
    function goBack(){
            history.back();
        }

    window.addEventListener('alert-updated-success', e =>{
        Swal.fire({
            title: 'Success!',
            text: e.detail.message,
            icon: 'success',
            confirmButtonText: 'OK',                
        }).then(()=>{
            goBack();
        });            
    });
</script>
@endpush