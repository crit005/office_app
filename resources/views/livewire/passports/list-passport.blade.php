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
                            <button onclick="toggleDetail('pRow1')" data-toggle="show" class="btn btn-sm btn-passport-row-togle elevation-1 m-2 mt-3"><i class="fas fa-angle-down"></i></button>
                        </div>
                    </div>
                    {{-- ro panel flex --}}
                    <div class="elevation-1 row-panel m-2 d-flex flex-nowrap align-items-start">
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
                                                <div class="d-none">
                                                    <div>
                                                        <div class="div-row-label">Mobile</div>
                                                        <div class="div-row-val">012 365 411</div>
                                                    </div>
                                                    <div class="ml-2">
                                                        <div class="div-row-label">Status</div>
                                                        <div class="div-row-val text-success">Active</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-2 pt-2 d-none">
                                            <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i><span class="ml-2">Update</span></button>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i><span class="ml-2">Delete</span></button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row px-2">
                                            <div class="col-sm-3 col-4 d-none d-sm-block">
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
                                            <div class="col-sm-3 col-3">
                                                <div class="div-row-label">Visa Expire</div>
                                                <div class="div-row-val">05-12-2023</div>
                                            </div>
                                            <div class="col-sm-3 col-6 d-none">
                                                <div class="div-row-label">Passport Photo</div>
                                                <div class="">
                                                    <img src="{{asset("images/passport_sample.jpg")}}" style="max-height: 90px;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-6 d-none">
                                                <div class="div-row-label">Visa Photo</div>
                                                <div class="">
                                                    <img src="{{asset("images/Cambodia_Visa_2017.jpg")}}" style="max-height: 90px;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 d-none">
                                                <div class="div-row-label">Description</div>
                                                <div class="div-row-val">Accountant at MBO Department. Live in room number 7.</div>
                                            </div>
                                            <div class="col-12 d-sm-none mt-2 d-none">
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
                            <button class="btn btn-sm btn-passport-row-togle elevation-1 m-2 mt-3"><i class="fas fa-angle-down"></i></button>
                        </div>
                    </div>
                    {{-- ro panel flex --}}
                    <div class="elevation-1 row-panel m-2 d-flex flex-nowrap align-items-start">
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
                                                <div class="d-none">
                                                    <div>
                                                        <div class="div-row-label">Mobile</div>
                                                        <div class="div-row-val">012 365 411</div>
                                                    </div>
                                                    <div class="ml-2">
                                                        <div class="div-row-label">Status</div>
                                                        <div class="div-row-val text-success">Active</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-2 pt-2 d-none">
                                            <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i><span class="ml-2">Update</span></button>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i><span class="ml-2">Delete</span></button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row px-2">
                                            <div class="col-sm-3 col-4 d-none d-sm-block">
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
                                            <div class="col-sm-3 col-3">
                                                <div class="div-row-label">Visa Expire</div>
                                                <div class="div-row-val">05-12-2023</div>
                                            </div>
                                            <div class="col-sm-3 col-6 d-none">
                                                <div class="div-row-label">Passport Photo</div>
                                                <div class="">
                                                    <img src="{{asset("images/passport_sample.jpg")}}" style="max-height: 90px;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-6 d-none">
                                                <div class="div-row-label">Visa Photo</div>
                                                <div class="">
                                                    <img src="{{asset("images/Cambodia_Visa_2017.jpg")}}" style="max-height: 90px;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 d-none">
                                                <div class="div-row-label">Description</div>
                                                <div class="div-row-val">Accountant at MBO Department. Live in room number 7.</div>
                                            </div>
                                            <div class="col-12 d-sm-none mt-2 d-none">
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
                            <button class="btn btn-sm btn-passport-row-togle elevation-1 m-2 mt-3"><i class="fas fa-angle-down"></i></button>
                        </div>
                    </div>
                    {{-- detail row --}}
                    <div class="elevation-1 row-panel m-2 d-flex flex-nowrap align-items-start">
                        <div class="row flex-grow-1">
                            <div class="flex-grow-1">
                                <div class="row p-2">
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <div class="px-2">
                                                <div class="elevation-1">
                                                    <img src="{{asset("images/4x6.jpg")}}" style="width:80px;" alt="">
                                                </div>
                                            </div>
                                            <div class="pl-2 flex-grow-1">
                                                <div class="">
                                                    <div class="div-row-label">Chhoun Cheythearith</div>
                                                    <div class="div-row-val"><b>Thearith</b> Male 05-12-2000</div>
                                                </div>
                                                {{-- <div class="d-flex"> --}}
                                                <div class="d-flex">
                                                    <div>
                                                        <div class="div-row-label">Mobile</div>
                                                        <div class="div-row-val">012 365 411</div>
                                                    </div>
                                                    <div class="ml-2">
                                                        <div class="div-row-label">Status</div>
                                                        <div class="div-row-val text-success">Active</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-2 pt-2 d-none d-sm-block">
                                            <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i><span class="ml-2">Update</span></button>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i><span class="ml-2">Delete</span></button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row px-2">
                                            <div class="col-sm-3 col-4">
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
                                            <div class="col-sm-3 col-12">
                                                <div class="div-row-label">Visa Expire</div>
                                                <div class="div-row-val">05-12-2023</div>
                                            </div>
                                            <div class="col-sm-3 col-6">
                                                <div class="div-row-label">Passport Photo</div>
                                                <div class="">
                                                    <img src="{{asset("images/passport_sample.jpg")}}" style="max-height: 90px;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-6">
                                                <div class="div-row-label">Visa Photo</div>
                                                <div class="">
                                                    <img src="{{asset("images/Cambodia_Visa_2017.jpg")}}" style="max-height: 90px;" alt="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="div-row-label">Description</div>
                                                <div class="div-row-val">Accountant at MBO Department. Live in room number 7.</div>
                                            </div>
                                            <div class="col-12 d-sm-none mt-2">
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
                            <button class="btn btn-sm btn-passport-row-togle elevation-1 m-2 mt-3"
                            style="transform: rotate(180deg);"
                            ><i class="fas fa-angle-down"></i></button>
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
    function toggleDetail(id){
        // console.log($('#'+id).find("[data-detail]")).removeClass('d-none');


       if($('#'+id).find("[data-toggle]").data('toggle') == 'show'){
        $('#'+id).find("[data-detail]").removeClass('d-none');
        $('#'+id).find("[data-detailbtn]").addClass('d-sm-block');
        $('#'+id).addClass('row-panel-show');
        $('#'+id).find("[data-toggle]").data('toggle','hiden');
        // document.getElementById(id).removeEventListener("transitionend",e,true);

       }else{
       document.getElementById(id).addEventListener('transitionend', e(id),true);
        // $('#'+id).find("[data-detail]").addClass('d-none');
        // $('#'+id).find("[data-detailbtn]").removeClass('d-sm-block');
        $('#'+id).removeClass('row-panel-show');
        $('#'+id).find("[data-toggle]").data('toggle','show');
       }
        // $('#'+id).children().data('detail').css({'color':'red'});
    }
    function e(id){
        console.log('Animation ended'+ id);
        $('#'+id).find("[data-detail]").addClass('d-none');
        $('#'+id).find("[data-detailbtn]").removeClass('d-sm-block');
        // document.getElementById(id).removeEventListener('transitionend', e,true);

    }

    function getScreenType(){
        if(screen.width<768){
            return "xs";
        }elseif(screen.width>=768 && screen.width < 992){
            return "sm";
        }elseif(screen.width>=992 && screen.width < 1200){
            return "md";
        }else{
            return "lg";
        }
    }
</script>
@endpush
