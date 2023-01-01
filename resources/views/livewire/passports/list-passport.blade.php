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
                    {{-- ro panel flex --}}
                    <div class="elevation-1 row-panel m-2 d-flex flex-nowrap align-items-start" id='pRow1'>
                        <div class="row flex-grow-1">
                            <div class="flex-grow-1">
                                <div class="row p-2">
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <div class="px-2">
                                                <div class="passport-img-circle elevation-1">
                                                    <img class="lazy" data-original="{{asset("images/4x6.jpg")}}" style="width:100%;" alt=""
                                                        onclick= "viewPassportImage('{{asset('images/4x6.jpg')}}','Photo ID')" >
                                                </div>
                                            </div>
                                            <div class="pl-2 flex-grow-1">
                                                <div class="">
                                                    <div class="div-row-label">Chhoun Cheythearith</div>
                                                    <div class="div-row-val"><b>Thearith</b> Male 05-12-2000</div>
                                                </div>
                                                {{-- <div class="d-flex"> --}}
                                                <div class="d-none row" data-detail='detail'>
                                                    <div class="col-6">
                                                        <div class="div-row-label">Mobile</div>
                                                        <div class="div-row-val">012 365 411</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="div-row-label">Status</div>
                                                        <div class="div-row-val text-success">Active</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-2 pt-2 d-none" data-detailbtn='detail'>
                                            <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i><span class="ml-2">Update</span></button>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i><span class="ml-2">Delete</span></button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row px-2">
                                            <div class="col-sm-3 col-4 d-none d-sm-block"  data-detail='detail'>
                                                <div class="div-row-label">Start Date</div>
                                                <div class="div-row-val">05-01-2015</div>
                                            </div>
                                            <div class="col-sm-3 col-4">
                                                <div class="div-row-label">Passport No</div>
                                                <div class="div-row-val">012 365 411FVD</div>
                                            </div>
                                            <div class="col-sm-3 col-4">
                                                <div class="div-row-label">Passport Expire</div>
                                                <div class="div-row-val">05-12-2023</div>
                                            </div>
                                            <div class="col-sm-3 col-4">
                                                <div class="div-row-label">Visa Expire</div>
                                                <div class="div-row-val">05-12-2023</div>
                                            </div>
                                            <div class="col-sm-3 col-6 d-none d-sm-none" data-detail='detail'></div>

                                            <div class="col-sm-3 col-6 d-none" data-detail='detail'>
                                                <div class="div-row-label">Passport Photo</div>
                                                <div class="">
                                                    <img class="lazy" data-original="{{asset("images/passport_sample.jpg")}}" style="max-height: 90px;" alt=""
                                                        onclick= "viewPassportImage('{{asset('images/passport_sample.jpg')}}','Photo Passport')" >
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-6 d-none" data-detail='detail'>
                                                <div class="div-row-label">Visa Photo</div>
                                                <div class="">
                                                    <img class="lazy" data-original="{{asset("images/Cambodia_Visa_2017.jpg")}}" style="max-height: 90px;" alt=""
                                                    onclick= "viewPassportImage('{{asset('images/Cambodia_Visa_2017.jpg')}}','Photo Visa')" >
                                                </div>
                                            </div>
                                            <div class="col-sm-6 d-none" data-detail='detail'>
                                                <div class="div-row-label">Description</div>
                                                <div class="div-row-val">Accountant at MBO Department. Live in room number 7.</div>
                                            </div>
                                            <div class="col-12 d-sm-none mt-2 d-none" data-detail='detail'>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-sm btn-primary w-100"><i class="fas fa-edit"></i><span class="ml-2">Update</span></button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-sm btn-danger w-100"><i class="fas fa-trash-alt"></i><span class="ml-2">Delete</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div>
                            <button onclick="toggleDetail('pRow1')" class="btn btn-sm btn-passport-row-togle elevation-1 m-2 mt-3"><i class="fas fa-angle-down"></i></button>
                        </div>
                    </div>

                    {{-- ro panel flex --}}
                    <div class="elevation-1 row-panel m-2 d-flex flex-nowrap align-items-start" id='pRow2'>
                        <div class="row flex-grow-1">
                            <div class="flex-grow-1">
                                <div class="row p-2">
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <div class="px-2">
                                                <div class="passport-img-circle elevation-1">
                                                    <img src="{{asset("images/4x6.jpg")}}" style="width:100%;" alt="">
                                                </div>
                                            </div>
                                            <div class="pl-2 flex-grow-1">
                                                <div class="">
                                                    <div class="div-row-label">Chhoun Cheythearith</div>
                                                    <div class="div-row-val"><b>Thearith</b> Male 05-12-2000</div>
                                                </div>
                                                {{-- <div class="d-flex"> --}}
                                                <div class="d-none row" data-detail='detail'>
                                                    <div class="col-6">
                                                        <div class="div-row-label">Mobile</div>
                                                        <div class="div-row-val">012 365 411</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="div-row-label">Status</div>
                                                        <div class="div-row-val text-success">Active</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-2 pt-2 d-none" data-detailbtn='detail'>
                                            <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i><span class="ml-2">Update</span></button>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i><span class="ml-2">Delete</span></button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row px-2">
                                            <div class="col-sm-3 col-4 d-none d-sm-block"  data-detail='detail'>
                                                <div class="div-row-label">Start Date</div>
                                                <div class="div-row-val">05-01-2015</div>
                                            </div>
                                            <div class="col-sm-3 col-4">
                                                <div class="div-row-label">Passport No</div>
                                                <div class="div-row-val">012 365 411FVD</div>
                                            </div>
                                            <div class="col-sm-3 col-4">
                                                <div class="div-row-label">Passport Expire</div>
                                                <div class="div-row-val">05-12-2023</div>
                                            </div>
                                            <div class="col-sm-3 col-4">
                                                <div class="div-row-label">Visa Expire</div>
                                                <div class="div-row-val">05-12-2023</div>
                                            </div>
                                            <div class="col-sm-3 col-6 d-none d-sm-none" data-detail='detail'></div>

                                            <div class="col-sm-3 col-6 d-none" data-detail='detail'>
                                                <div class="div-row-label">Passport Photo</div>
                                                <div class="">
                                                    <img src="{{asset("images/passport_sample.jpg")}}" style="max-height: 90px;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-6 d-none" data-detail='detail'>
                                                <div class="div-row-label">Visa Photo</div>
                                                <div class="">
                                                    <img src="{{asset("images/Cambodia_Visa_2017.jpg")}}" style="max-height: 90px;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 d-none" data-detail='detail'>
                                                <div class="div-row-label">Description</div>
                                                <div class="div-row-val">Accountant at MBO Department. Live in room number 7.</div>
                                            </div>
                                            <div class="col-12 d-sm-none mt-2 d-none" data-detail='detail'>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-sm btn-primary w-100"><i class="fas fa-edit"></i><span class="ml-2">Update</span></button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-sm btn-danger w-100"><i class="fas fa-trash-alt"></i><span class="ml-2">Delete</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div>
                            <button onclick="toggleDetail('pRow2')" data-toggle="show" class="btn btn-sm btn-passport-row-togle elevation-1 m-2 mt-3"><i class="fas fa-angle-down"></i></button>
                        </div>
                    </div>

                    {{-- ro panel flex --}}
                    <div class="elevation-1 row-panel m-2 d-flex flex-nowrap align-items-start" id='pRow3'>
                        <div class="row flex-grow-1">
                            <div class="flex-grow-1">
                                <div class="row p-2">
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <div class="px-2">
                                                <div class="passport-img-circle elevation-1">
                                                    <img src="{{asset("images/4x6.jpg")}}" style="width:100%;" alt="">
                                                </div>
                                            </div>
                                            <div class="pl-2 flex-grow-1">
                                                <div class="">
                                                    <div class="div-row-label">Chhoun Cheythearith</div>
                                                    <div class="div-row-val"><b>Thearith</b> Male 05-12-2000</div>
                                                </div>
                                                {{-- <div class="d-flex"> --}}
                                                <div class="d-none row" data-detail='detail'>
                                                    <div class="col-6">
                                                        <div class="div-row-label">Mobile</div>
                                                        <div class="div-row-val">012 365 411</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="div-row-label">Status</div>
                                                        <div class="div-row-val text-success">Active</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-2 pt-2 d-none" data-detailbtn='detail'>
                                            <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i><span class="ml-2">Update</span></button>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i><span class="ml-2">Delete</span></button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row px-2">
                                            <div class="col-sm-3 col-4 d-none d-sm-block"  data-detail='detail'>
                                                <div class="div-row-label">Start Date</div>
                                                <div class="div-row-val">05-01-2015</div>
                                            </div>
                                            <div class="col-sm-3 col-4">
                                                <div class="div-row-label">Passport No</div>
                                                <div class="div-row-val">012 365 411FVD</div>
                                            </div>
                                            <div class="col-sm-3 col-4">
                                                <div class="div-row-label">Passport Expire</div>
                                                <div class="div-row-val">05-12-2023</div>
                                            </div>
                                            <div class="col-sm-3 col-4">
                                                <div class="div-row-label">Visa Expire</div>
                                                <div class="div-row-val">05-12-2023</div>
                                            </div>
                                            <div class="col-sm-3 col-6 d-none d-sm-none" data-detail='detail'></div>

                                            <div class="col-sm-3 col-6 d-none" data-detail='detail'>
                                                <div class="div-row-label">Passport Photo</div>
                                                <div class="">
                                                    <img src="{{asset("images/passport_sample.jpg")}}" style="max-height: 90px;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-6 d-none" data-detail='detail'>
                                                <div class="div-row-label">Visa Photo</div>
                                                <div class="">
                                                    <img src="{{asset("images/Cambodia_Visa_2017.jpg")}}" style="max-height: 90px;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 d-none" data-detail='detail'>
                                                <div class="div-row-label">Description</div>
                                                <div class="div-row-val">Accountant at MBO Department. Live in room number 7.</div>
                                            </div>
                                            <div class="col-12 d-sm-none mt-2 d-none" data-detail='detail'>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-sm btn-primary w-100"><i class="fas fa-edit"></i><span class="ml-2">Update</span></button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-sm btn-danger w-100"><i class="fas fa-trash-alt"></i><span class="ml-2">Delete</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div>
                            <button onclick="toggleDetail('pRow3')" data-toggle="show" class="btn btn-sm btn-passport-row-togle elevation-1 m-2 mt-3"><i class="fas fa-angle-down"></i></button>
                        </div>
                    </div>

                    {{-- ro panel flex --}}
                    <div class="elevation-1 row-panel m-2 d-flex flex-nowrap align-items-start" id='pRow4'>
                        <div class="row flex-grow-1">
                            <div class="flex-grow-1">
                                <div class="row p-2">
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <div class="px-2">
                                                <div class="passport-img-circle elevation-1">
                                                    <img src="{{asset("images/4x6.jpg")}}" style="width:100%;" alt="">
                                                </div>
                                            </div>
                                            <div class="pl-2 flex-grow-1">
                                                <div class="">
                                                    <div class="div-row-label">Chhoun Cheythearith</div>
                                                    <div class="div-row-val"><b>Thearith</b> Male 05-12-2000</div>
                                                </div>
                                                {{-- <div class="d-flex"> --}}
                                                <div class="d-none row" data-detail='detail'>
                                                    <div class="col-6">
                                                        <div class="div-row-label">Mobile</div>
                                                        <div class="div-row-val">012 365 411</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="div-row-label">Status</div>
                                                        <div class="div-row-val text-success">Active</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-2 pt-2 d-none" data-detailbtn='detail'>
                                            <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i><span class="ml-2">Update</span></button>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i><span class="ml-2">Delete</span></button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row px-2">
                                            <div class="col-sm-3 col-4 d-none d-sm-block"  data-detail='detail'>
                                                <div class="div-row-label">Start Date</div>
                                                <div class="div-row-val">05-01-2015</div>
                                            </div>
                                            <div class="col-sm-3 col-4">
                                                <div class="div-row-label">Passport No</div>
                                                <div class="div-row-val">012 365 411FVD</div>
                                            </div>
                                            <div class="col-sm-3 col-4">
                                                <div class="div-row-label">Passport Expire</div>
                                                <div class="div-row-val">05-12-2023</div>
                                            </div>
                                            <div class="col-sm-3 col-4">
                                                <div class="div-row-label">Visa Expire</div>
                                                <div class="div-row-val">05-12-2023</div>
                                            </div>
                                            <div class="col-sm-3 col-6 d-none d-sm-none" data-detail='detail'></div>

                                            <div class="col-sm-3 col-6 d-none" data-detail='detail'>
                                                <div class="div-row-label">Passport Photo</div>
                                                <div class="">
                                                    <img src="{{asset("images/passport_sample.jpg")}}" style="max-height: 90px;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-6 d-none" data-detail='detail'>
                                                <div class="div-row-label">Visa Photo</div>
                                                <div class="">
                                                    <img src="{{asset("images/Cambodia_Visa_2017.jpg")}}" style="max-height: 90px;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 d-none" data-detail='detail'>
                                                <div class="div-row-label">Description</div>
                                                <div class="div-row-val">Accountant at MBO Department. Live in room number 7.</div>
                                            </div>
                                            <div class="col-12 d-sm-none mt-2 d-none" data-detail='detail'>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-sm btn-primary w-100"><i class="fas fa-edit"></i><span class="ml-2">Update</span></button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-sm btn-danger w-100"><i class="fas fa-trash-alt"></i><span class="ml-2">Delete</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div>
                            <button onclick="toggleDetail('pRow4')" data-toggle="show" class="btn btn-sm btn-passport-row-togle elevation-1 m-2 mt-3"><i class="fas fa-angle-down"></i></button>
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

    {{-- modal photo viw --}}

    <div id="modal-image-view" class="modal fade blur-bg-dialog image-viewer" tabindex="-1" role="dialog" aria-labelledby="imageView" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered2">
            <div class="modal-content modal-blur-light" >
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="image-view-title">Image view</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center bg-white">
                    <img class="elevation-1" id="img-view" src="{{asset("images/Cambodia_Visa_2017.jpg")}}" style="max-height:80vh; max-width: 100%; border-radius: 13px;" alt="">
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    {{-- End modal photo viw --}}

    {{-- add passport form --}}

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPassportFormModal">
        Launch demo modal
      </button>

    <div wire:ignore.self class="modal fade blur-bg-dialog " id="addPassportFormModal" tabindex="-1" role="dialog"
        aria-labelledby="addPassportFormModalTitle" aria-hidden="true">
        <div wire:ignore.self class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-blur-light-green">
                <div class="modal-header">
                    <div class="w-100 d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="modal-title text-white" id="exampleModalLongTitle">
                                Add Passport Info
                            </h5>
                            <div class="text-white text-sm">Created_by:
                                {{ auth()->user()->name }}
                            </div>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <form wire:submit.prevent='{{ $showEditModal ? ' updateDepatment' : 'createDepatment' }}'> --}}
                <form wire:submit.prevent='addPassport'>
                    <div class="modal-body m-0 border-radius-0 bg-white">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group form-group-sm row text-sm mb-1">
                                    <label for="passport-name" class="col-sm-5 col-form-label">Name:</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm" id="passport-name" placeholder="Name">
                                    </div>
                                </div>

                                <div class="form-group form-group-sm row text-sm mb-1">
                                    <label for="passport-nick-name" class="col-sm-5 col-form-label">Nick Name:</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm" id="passport-nick-name" placeholder="Nick Name">
                                    </div>
                                </div>

                                <div class="form-group form-group-sm row text-sm mb-1">
                                    <label for="passport-gender" class="col-sm-5 col-form-label">Gender:</label>
                                    <div class="col-sm-7">
                                        <div class="icheck-success d-inline male-radio">
                                            <input type="radio" id="radioPrimary1" name="r1" checked="">
                                            <label for="radioPrimary1" class=" text-sm"><i class="fas fa-male mr-2"></i> M
                                            </label>
                                        </div>
                                        <div class="icheck-warning d-inline">
                                            <input type="radio" id="radioPrimary2" name="r1">
                                            <label for="radioPrimary2" class=" text-sm">
                                                <i class="fas fa-female mr-2"></i> F
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm row text-sm mb-1">
                                    <label for="passport-dob" class="col-sm-5 col-form-label">Date Of Birth:</label>
                                    <div class="col-sm-7">
                                        <x-datepicker wire:model="form.dob" id="passport-dob" :moreclass="'form-control-sm'" :error="'dob'"
                                            :format="'DD-MMM-Y'" />
                                        @error('dob')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group form-group-sm row text-sm mb-1">
                                    <label for="passport-mobile" class="col-sm-5 col-form-label">Mobile:</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm" id="passport-mobile" placeholder="Mobile">
                                    </div>
                                </div>

                                <div class="form-group form-group-sm row text-sm mb-1">
                                    <label for="passport-start-date" class="col-sm-5 col-form-label">Start Date:</label>
                                    <div class="col-sm-7">
                                    <x-datepicker wire:model="form.start_date" id="passport-start-date" :moreclass="'form-control-sm'" :error="'start_date'"
                                        :format="'DD-MMM-Y'" />
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>

                                <div class="form-group form-group-sm row text-sm mb-1">
                                    <label for="passport-no" class="col-sm-5 col-form-label">Passport No:</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm" id="passport-no" placeholder="Passport No">
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                            </div>

                        </div>
                        <!-- /Ended row -->
                    </div>

                    {{-- modale footer --}}
                    <div class="modal-footer">

                    </div>
                    {{-- End modale footer --}}
                </form>
            </div>
        </div>
    </div>

    {{-- add passport form --}}


</div>
@push('js')
<script>

    function viewPassportImage(src, title){
        $('#img-view').attr('src',src);
        $('#image-view-title').html(title);
        $('#modal-image-view').modal('show')
    }

    function toggleDetail(id){
        if($('.row-panel-show') && $('.row-panel-show').attr('id')!=id){
            $('.row-panel-show').find("[data-detail]").toggleClass('d-none');
            $('.row-panel-show').find("[data-detailbtn]").toggleClass('d-sm-block');
            $('.row-panel-show').find(".passport-img-circle").toggleClass('image-id');
            $('.row-panel-show').find(".btn-passport-row-togle").toggleClass('btn-passport-row-togle-up');
            $('.row-panel-show').toggleClass('row-panel-show');

        }

        $('#'+id).find("[data-detail]").toggleClass('d-none');
        $('#'+id).find("[data-detailbtn]").toggleClass('d-sm-block');
        $('#'+id).find(".passport-img-circle").toggleClass('image-id');
        $('#'+id).find(".btn-passport-row-togle").toggleClass('btn-passport-row-togle-up');
        $('#'+id).toggleClass('row-panel-show');
        $('#'+id).find(".lazy").lazyload({effect : "fadeIn"});
        $('#'+id).find(".lazy").removeClass('lazy');
    }

    function getShowPanelRow(){
        $('.row-panel-show').find("btn-passport-row-togle").click();
    }
</script>
@endpush
