<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 main-title-block">
                    <h1 class="m-0 text-white">Passport</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                    <div class="clearfix"></div>
                    {{-- Top button --}}
                    <div class="clearfix float-sm-right">
                        <button class="btn btn-success btn-sm transaction-operator-top" wire:click.prevent='OpenAddCashForm'>
                            <i class="fas fa-plus-circle"></i> New
                        </button>
                        <button class="btn btn-info btn-sm transaction-operator-top" wire:click.prevent='OpenNewPaymentForm'>
                            <i class="fas fa-birthday-cake"></i> Birthday
                        </button>
                        <button class="btn btn-info btn-sm transaction-operator-top" wire:click.prevent='OpenNewExchangeForm'>
                            <i class="fas fa-passport"></i> P Expire
                        </button>
                        <button class="btn btn-info btn-sm transaction-operator-top" wire:click.prevent='OpenImportPaymentForm'>
                            <i class="fab fa-cc-visa"></i> V Expire
                        </button>
                    </div>
                    {{-- End Top button --}}

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header" style="z-index: 10001">
                    <div class="row">
                        <div class="col">
                            <h5 class="text-white"><i class="fas fa-passport mr-2"></i>Passport List</h5>
                        </div>
                        <div class="col">

                            <div class="btn-group btn-group-toggle ml-auto  float-right" data-toggle="buttons">
                                <label class="btn btn-sm elevation-1 bg-gradient-blue active">
                                    <input type="radio" name="tr_mode" id="type_b1" value="" autocomplete="off" checked=""> All
                                </label>

                                <label class="btn btn-sm elevation-1 bg-gradient-blue">
                                    <input type="radio" name="tr_mode" id="type_b2" value="1" autocomplete="off">
                                    <i class="fas fa-search"></i>
                                </label>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body-v1 p-0">
                    <div class="row">
                        <div class="col">
                            <div class="d-flex flex-col">
                                <div class="float-left">
                                    <img class="m-2" src="{{asset("images/4x6.jpg")}}" style="width:95px;" alt="">
                                </div>
                                <div class="py-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="div-row-label">Chhoun Cheythearith</div>
                                            <div class="div-row-val">Thearith</div>
                                        </div>
                                        <div class="col-12">
                                            <div class="div-row-label">Gender</div>
                                            <div class="div-row-val">Male</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="div-row-label">Movile</div>
                                            <div class="div-row-val text-nowrap">012 365 411</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="div-row-label">Status</div>
                                            <div class="div-row-val text-success">Active</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="div-row-label">Start Date</div>
                                    <div class="div-row-val">05-01-2015</div>
                                </div>
                                <div class="col">
                                    <div class="div-row-label">Date of Birth</div>
                                    <div class="div-row-val">05-01-1990</div>
                                </div>
                                <div class="col">
                                    <div class="div-row-label">Passport No</div>
                                    <div class="div-row-val">012 365 411FVD</div>
                                </div>
                                <div class="col">
                                    <div class="div-row-label">Passport Expire</div>
                                    <div class="div-row-val">05-12-2023</div>
                                </div>
                                <div class="col">
                                    <div class="div-row-label">Visa Expire</div>
                                    <div class="div-row-val">05-12-2023</div>
                                </div>
                            </div>
                            <div class="row float-right">
                                <div class="col float-right">
                                    <div class="div-row-label">Movile</div>
                                    <div class="div-row-val">012 365 411</div>
                                </div>
                                <div class="col float-right">
                                    <div class="div-row-label">Movile</div>
                                    <div class="div-row-val">012 365 411</div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="d-flex flex-row justify-content-center">
                        {{-- <div>
                            {{ $transactions->links() }}
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->

</div>
@push('js')
<script>

</script>
@endpush
