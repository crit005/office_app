<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 main-title-block">
                    <h1 class="m-0 text-white">{{$mode==1?'Cash Lists':($mode==2?'Deparment Expend':'Payment')}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                    <div class="clearfix"></div>
                    <livewire:components.transaction.top-tr-button-group />

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
                        <div class="card-header @if($type == 1) modal-blur-light-green @endif @if($type == 2) modal-blur-light-red @endif @if($type == 3) modal-blur-light-blue @endif "  style="z-index: 10001">
                            {{-- <livewire:components.transaction.tr-sumary :mode="$type??0" :arrSearchs="$searchs" :arrOptional="['createdBy'=>$createdBy]" wire:key="tr-head-sumary-{{$updateTime}}" /> --}}
                                <livewire:components.transaction.tr-sumary :arrSearchs="$searchs" :mode="$type??0" :arrOptional="['createdBy'=>$createdBy]" />

                            <div class="float-lg-left mb-2 text-center">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    {{-- <button value='' wire:click="resetUser" class="btn btn-sm elevation-1 bg-gradient-blue @if(!$createdBy) active @endif">
                                        <i class="fas fa-users"></i>
                                    </button> --}}
                                    @if(in_array(auth()->user()->group_id,[1,2]))
                                    <label wire:click.prevent="resetUser" class="btn btn-sm elevation-1 bg-gradient-blue @if(!$createdBy) active @endif">
                                        <input type="radio" name="tr_user" id="user_b1" value='' autocomplete="off"> <i class="fas fa-users"></i>
                                    </label>
                                    @endif
                                    <label class="btn btn-sm elevation-1 bg-gradient-blue @if($type != 1 && $type != 2 && $type != 3) active @endif">
                                        <input type="radio" name="tr_mode" id="type_b1" wire:model='type' value='' autocomplete="off" checked> All
                                        </label>
                                    <label class="btn btn-sm elevation-1 bg-gradient-blue @if($type==1) active @endif">
                                        <input type="radio" name="tr_mode" id="type_b2" wire:model='type' value=1 autocomplete="off"> Cash In
                                    </label>
                                    <label class="btn btn-sm elevation-1 bg-gradient-blue @if($type==2) active @endif">
                                        <input type="radio" name="tr_mode" id="type_b3" wire:model='type' value=2 autocomplete="off"> Expend
                                    </label>
                                    <label class="btn btn-sm elevation-1 bg-gradient-blue @if($type==3) active @endif">
                                        <input type="radio" name="tr_mode" id="type_b4" wire:model='type' value=3 autocomplete="off"> Exchange
                                    </label>
                                </div>
                            </div>

                            <div class="row float-md-right mb-2 text-center">
                                <div class="input-group input-group-sm mr-2 sort-input-date elevation-1">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text"><i class="fas fa-calendar"></i></label>
                                    </div>
                                    <x-datepicker-normal wire:model="fromDate" :id="'tr_from_date'" :linked="'tr_to_date'" :format="'DD-MMM-Y'" :placeholder="'From'" />
                                </div>
                                <div class="input-group input-group-sm mr-2 sort-input-date elevation-1">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text"><i class="fas fa-calendar mr-1"></i></label>
                                    </div>
                                    <x-datepicker-normal wire:model="toDate" id="tr_to_date" :format="'DD-MMM-Y'" :placeholder="'To'" />
                                </div>

                                <div class="input-group input-group-sm mr-2 sort-input-date elevation-1">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">
                                            {{-- <i class="fas fa-grip-horizontal"></i> --}}
                                            <i class="fas fa-sitemap"></i>
                                        </label>
                                    </div>
                                    <select wire:model="depatmentId" class="custom-select form-select">
                                        <option value="">* Depatment</option>
                                        @foreach ($depatments as $depatment )
                                            <option value={{$depatment->id}}>{{$depatment->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group input-group-sm mr-2 sort-input-date elevation-1">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">
                                            <i class="fas fa-shopping-cart"></i>
                                        </label>
                                    </div>
                                    <select wire:model="itemId" class="custom-select">
                                        <option value="" selected>* Payment</option>
                                        @foreach ($items as $item)
                                        <option value={{$item->id}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if ($isOther)
                                   <div class="input-group input-group-sm mr-2 sort-input-date elevation-1">
                                    <input type="text" wire:model="otherName" class="form-control" placeholder="Other name"/>
                                    </div>
                                @endif

                                <div class="input-group input-group-sm mr-2 sort-input-date elevation-1">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01"><i
                                                class="fas fa-money-bill"></i></label>
                                    </div>
                                    <select wire:model="currencyId" class="custom-select selectpicker">
                                        <option value="" selected>* Currency</option>
                                        @foreach ($currencys as $currency)
                                        <option value={{$currency->id}}>{{$currency->symbol}} {{$currency->code}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button class="btn btn-primary btn-sm elevation-1" wire:click="clearFilter" onclick="clearSearchDate()">
                                    <i class="fas fa-brush"></i>
                                </button>
                                {{-- <button class="btn btn-primary btn-sm elevation-1 ml-2" wire:click.prevent='print' > --}}
                                {{-- <button class="btn btn-primary btn-sm elevation-1 ml-2" wire:click.prevent="printDataTableMode('Test')" > --}}
                                <button class="btn btn-primary btn-sm elevation-1 ml-2" onclick="printTableRequest()" >
                                    <i class="fas fa-print"></i>
                                </button>

                                <div class="btn-group btn-group-sm ml-2">
                                    {{-- <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> --}}
                                    {{-- <button type="button" class="btn text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> --}}
                                    <button type="button" class="btn text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right text-sm">
                                        <button class="dropdown-item" type="button" wire:click.prevent="changeMode(1)"><i class="fas fa-donate mr-2"></i>Cash Mode</button>
                                        <button class="dropdown-item" type="button" wire:click.prevent="changeMode(2)"><i class="fas fa-sitemap mr-2"></i>Department Mode</button>
                                        <button class="dropdown-item" type="button" wire:click.prevent="changeMode(3)"><i class="fas fa-shopping-cart mr-2"></i>Payment Mode</button>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input wire:model.debounce='search' type="text" name="table_search"
                                        class="form-control float-right" placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body-v1 p-0">
                            {{-- @dump($this->getChartDatas($trCashs)) --}}
                            {{-- Data Table Mode --}}
                            @if ($mode==1)
                            <table class="table table-v1 table-hover">

                                <tbody id="sortable">
                                    <?php
                                        $trRowNumber = 0;
                                    ?>
                                    @forelse ($trCashs as $indext => $transaction)
                                    {{-- detail record animate__animated animate__fadeInUp --}}
                                    @if ($this->isNewMonth($transaction->month))
                                    <?php
                                            $trRowNumber = 0;
                                            ?>
                                    <tr class="tr-td-border-0 stick-top-0 bg-wite">
                                        <td scope="col" class="text-left text-info text-bold minimal-table-column">
                                            {{ date('M-Y', strtotime($transaction->month)) }}
                                            <div wire:click="switchMonthOrder" class="btn btn-sm text-smmr-2"
                                                style="margin-bottom: -8px; margin-top: -11px;">
                                                @if ($order['month']=='asc')
                                                <i class="fas fa-sort-alpha-down"></i>
                                                @else
                                                <i class="fas fa-sort-alpha-up"></i>
                                                @endif
                                            </div>

                                        </td>
                                        <td scope="col" colspan="7" class="text-left">
                                            <livewire:components.transaction.tr-monthly-sumary :mode="$type??0"
                                                :totals="$transaction->currency->getTotal($searchs,['month'=>$transaction->month,'createdBy'=>$createdBy])"
                                                wire:key="tr-total-{{ $transaction->id.$updateTime }}" />
                                        </td>
                                    </tr>
                                    <tr class="tr-th-border-0 stick-top-next">
                                        <th scope="col" class="text-center text-info minimal-table-column m-0 p-0">
                                            <div class="border-bottom pb-2">
                                                Date
                                                <div wire:click="switchDateOrder" class="btn btn-sm text-smmr-2"
                                                    style="margin-bottom: -8px; margin-top: -11px;">
                                                    @if ($order['tr_date']=='asc')
                                                    <i class="fas fa-sort-alpha-down"></i>
                                                    @else
                                                    <i class="fas fa-sort-alpha-up"></i>
                                                    @endif
                                                </div>

                                            </div>
                                        </th>
                                        <th scope="col" class="text-right text-info minimal-table-column m-0 p-0">
                                            <div class="border-bottom pb-2">#</div>
                                        </th>
                                        <th scope="col" class="text-left text-info m-0 p-0" style="white-space: nowrap;">
                                            <div class="border-bottom pb-2">Pament Name</div>
                                        </th>
                                        <th scope="col" class="text-center text-info minimal-table-column m-0 p-0">
                                            <div class="border-bottom pb-2">Amount</div>
                                        </th>
                                        <th scope="col" class="text-center text-info minimal-table-column m-0 p-0">
                                            <div class="border-bottom pb-2">Pay On</div>
                                        </th>
                                        <th scope="col" class="text-center text-info m-0 p-0">
                                            <div class="border-bottom pb-2">Detail</div>
                                        </th>
                                        <th scope="col" class="text-center text-info minimal-table-column m-0 p-0">
                                            <div class="border-bottom pb-2">Created By</div>
                                        </th>
                                        <th scope="col" class="text-center text-info minimal-table-column m-0 p-0">
                                            <div class="border-bottom pb-2">Options</div>
                                        </th>
                                    </tr>
                                    @endif
                                    <tr class="tr-td-border-0 bg-wite  text-sm-small-screen" wire:key="tr-{{ $transaction->id }}"
                                        id="{{ $transaction->id }}">
                                        <td scope="col" class="pl-5 text-sm text-left minimal-table-column">
                                            {{ date(env('DATE_FORMAT','d-m-Y'), strtotime($transaction->tr_date)) }}
                                        </td>
                                        <td scope="col" class="text-right minimal-table-column border-left position-relative">
                                            <div class="
                                                @if ($transaction->type == 1) badge-time-line-incom
                                                @elseif ($transaction->type == 2)
                                                badge-time-line-expend
                                                @elseif ($transaction->type == 3)
                                                badge-time-line-exchange @endif
                                                badge-time-line">
                                            </div>
                                            <?php $trRowNumber+=1; ?>
                                            {{ $trRowNumber }}

                                        </td>
                                        <td scope="col" class="text-left">
                                            @if ($transaction->item_id != 13)
                                            {{ $transaction->item->name }}
                                            @else
                                            {{ $transaction->other_name }}
                                            @endif
                                        </td>
                                        <td scope="col" class="text-center minimal-table-column
                                                @if ($transaction->type == 1) text-success
                                                @elseif ($transaction->type == 2)
                                                text-danger
                                                @elseif ($transaction->type == 3)
                                                text-info @endif ">
                                            {{ $transaction->amount . $transaction->currency->symbol }}
                                        </td>
                                        <td scope="col" class="text-center text-sm minimal-table-column">
                                            @if ($transaction->type == 1)
                                            {{-- <i class="fas fa-user-circle text-lg text-success mr-1"></i> --}}
                                            <i class="fas fa-user text-success mr-1"></i>
                                            {{ $transaction->toFromUser->name }}
                                            @elseif ($transaction->type == 2)
                                            <span class="pl-2 pr-2 pt-1 pb-1" style="
                                                    background:{{$transaction->depatment->bg_color}};
                                                    color:{{$transaction->depatment->text_color}};
                                                    border-radius: 2px;
                                                    ">{{ $transaction->depatment->name }}</span>
                                            @elseif ($transaction->type == 3)
                                            <div class="text-success">{{ $transaction->other_name }}</div>
                                            @endif

                                        </td>
                                        <td scope="col" class="text-center text-nowrap">
                                            <a tabindex="0" role="button" data-toggle="popover" data-trigger="focus" data-placement="auto"
                                                data-content="{{ $transaction->description }}">{{ $transaction->getDescription() }}</a>
                                        </td>
                                        <td scope="col" class="text-center minimal-table-column">
                                            {{ $transaction->created_by == auth()->user()->id ? 'You': $transaction->createdByUser->name }}</td>
                                        <td scope="col" class="text-center minimal-table-column">
                                            <button class="btn btn-sm text-success" wire:click="showView({{$transaction->id}})">
                                                <i wire:loading.remove wire:target='showView({{$transaction->id}})' onclick="clearEditPaymentForm()"
                                                    class="fas fa-eye"></i>
                                                <i wire:loading='showView({{$transaction->id}})' wire:target='showView({{$transaction->id}})'
                                                    class="fas fa-spinner fa-spin"></i>
                                            </button>
                                            <button id="tr_btn_edit_{{$transaction->id}}" class="btn btn-sm text-primary"
                                                wire:click="showEdit({{$transaction->id}})" onclick="clearEditPaymentForm()" @if ($editTransaction)
                                                {{$editTransaction->id == $transaction->id ? 'disabled':''}}
                                                @endif
                                                >
                                                <i wire:loading.remove wire:target='showEdit({{$transaction->id}})' class="fas fa-edit"></i>
                                                <i wire:loading='showEdit({{$transaction->id}})' wire:target='showEdit({{$transaction->id}})'
                                                    class="fas fa-spinner fa-spin"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @if ($editTransaction)
                                    @if ($editTransaction->id == $transaction->id)
                                    <tr class="tr-td-border-0 white-hover tr-edit-payment-form">
                                        <td scope="col" class="pl-5 text-sm text-left minimal-table-column"></td>
                                        <td scope="col" class="text-right minimal-table-column border-left position-relative">
                                        <td scope="col" colspan="6" class="text-left p-0">
                                            @if ($transaction->type == 2)
                                            {{-- edit pament --}}
                                            <livewire:components.transaction.tr-edit-form :id="$transaction->id"
                                                wire:key="tr_edit_payment-{{ $transaction->id }}" />
                                            @elseif($transaction->type == 1)
                                            {{-- edit add cash --}}
                                            <livewire:components.transaction.tr-edit-add-cash-form :id="$transaction->id"
                                                wire:key="tr_edit_add_cash-{{ $transaction->id }}" />
                                            @elseif($transaction->type == 3)
                                            {{-- edit exchange --}}
                                            <livewire:components.transaction.tr-edit-exchange-form :id="$transaction->id"
                                                wire:key="tr_edit_exchange-{{ $transaction->id }}" />
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @endif
                                    @empty
                                    <tr class="bg-wite">
                                        <td colspan="8" class="text-center"> No record found...</td>
                                    </tr>
                                    @endforelse
                                    @if ($reachLastRecord)
                                    <tr class="tr-td-border-0 border-bottom stick-top-next bg-wite">
                                        <th scope="col" colspan="8" class="text-center text-info">
                                            You have reach the bottom!
                                            {{-- <button onClick='goToTop()'>TOP</button> --}}
                                        </th>
                                    </tr>
                                    @else
                                    <tr class="tr-td-border-0 border-bottom stick-top-next bg-wite">
                                        <th scope="col" colspan="8" class="text-center text-info">
                                            <button class="btn btn-sm btn-info" wire:click='inceaseTakeAmount'>
                                                Load More <i wire:loading="" wire:target="inceaseTakeAmount" class="fas fa-spinner fa-spin"></i>
                                            </button>
                                        </th>
                                    </tr>
                                    @endif


                                </tbody>
                            </table>
                            @elseif ($mode == 2 )
                                {{-- depatment mode --}}
                                @if($trCashs)
                                <div class="row pt-3">
                                    <div class="col">
                                        <table class="table table-v1 table-hover">
                                            <thead>
                                                <tr class="tr-th-border-0">
                                                    <th scope="col" class="text-center bg-info text-white  minimal-table-column px-0">
                                                        <div>#</div>
                                                    </th>
                                                    <th scope="col" class="text-left bg-info text-white  px-0 minimal-table-column" style="white-space: nowrap;">
                                                        <div>Department Name</div>
                                                    </th>
                                                    @foreach ( $trCashs[0] as $key => $value )
                                                        @if ($key != 'name' && $key != 'text_color' && $key != 'bg_color')
                                                        <th scope="col" class="text-center bg-info text-white  px-0">
                                                            <div>
                                                                {{$key}}
                                                            </div>
                                                        </th>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            </thead>

                                            <tbody id="sortable2">
                                                @forelse ($trCashs as $indext => $transaction)
                                                    <tr class="tr-td-border-0 bg-wite  text-sm-small-screen border-bottom-1" wire:key="dp-{{$indext}}"
                                                        id="dp-{{ $indext }}">
                                                        <td scope="col" class="text-sm text-left py-0 pt-1">
                                                            <div class="p-1">
                                                                {{$indext +1}}
                                                            </div>
                                                        </td>

                                                        <td scope="col" class="text-center text-sm py-0 pt-1">
                                                            <div class="text-left p-1 pl-2" style=" background:{{$transaction->bg_color}}; color:{{$transaction->text_color}};border-radius: 3px;">
                                                                {{ $transaction->name }}
                                                            </div>
                                                        </td>

                                                        @foreach ( $transaction as $key => $value )
                                                            @if ($key != 'name' && $key != 'text_color' && $key != 'bg_color')
                                                            <td scope="col" class="text-right py-0 text-danger pt-1">
                                                                <div class="p-1">
                                                                    {{$value?-$value:0}}{{explode('_',$key)[1]}}
                                                                    <div class="progress progress-xxs">
                                                                        <div class="progress-bar bg-info progress-bar-danger progress-bar-striped"
                                                                         role="progressbar" aria-valuenow="{{$value?$value/($totalDepartments[$key]/100):0}}"
                                                                         aria-valuemin="0" aria-valuemax="100"
                                                                         style="width: {{$value?$value/($totalDepartments[$key]/100):0}}%;">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            @endif
                                                        @endforeach

                                                    </tr>
                                                @endforeach
                                                <tr class="border-bottom-1">
                                                    <th colspan="2" class="text-center text-sm py-0 bg-gray-light-h" style="background-color:rgb(235 235 235) !important;">
                                                        <div class="text-right text-info p-1 pl-2">
                                                            Total:
                                                        </div>
                                                    </th>
                                                    @foreach ( $trCashs[0] as $key => $value )
                                                        @if ($key != 'name' && $key != 'text_color' && $key != 'bg_color')
                                                        <th class="text-right py-0  bg-gray-light-h" style="background-color:rgb(235 235 235) !important;">
                                                            <div class="p-1 text-bold text-danger">
                                                                {{-$totalDepartments[$key]}}{{explode('_',$key)[1]}}
                                                            </div>
                                                        </th>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col">
                                        {{-- chart --}}
                                        {{-- <livewire:components.transaction.depatment-chart :transactions="$this->getDepatmentTransaction()" wire:key='test_{{strtotime("now")}}'/> --}}
                                        <?php
                                            $chartId = 'chart'.strtotime('now');
                                            // $chartId = 'chart';
                                        ?>
                                        <div id="{{$chartId}}" name='chart1'></div>
                                        <script>
                                        var options = {
                                            chart: {
                                            type: 'bar',
                                            // type: 'area',
                                            },
                                            series: @json($this->getDepartmentDataset()) ,
                                            xaxis: {
                                            // categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
                                            categories: @json($this->getLabels())
                                            },
                                            dataLabels: {
                                            enabled: true,
                                            formatter: function (val) {
                                                return val + "%";
                                                },
                                                offsetY: -20,
                                                style: {
                                                    // fontSize: '12px',
                                                    colors: ["#304758"]
                                                }
                                            },
                                            plotOptions: {
                                                bar: {
                                                    borderRadius: 3,
                                                    dataLabels: {
                                                    position: 'top', // top, center, bottom
                                                    }
                                                }
                                            },
                                            stroke: {
                                            show: true,
                                            width: 2,
                                            colors: ['transparent']
                                            },
                                            title: {
                                                text: 'Expend in Percentage',
                                                floating: true,

                                                align: 'center',
                                                style: {
                                                    color: '#444'
                                                }
                                            },
                                        }
                                            // chartDepartment?chartDepartment.destroy():null;
                                            var chartDepartment = new ApexCharts(document.querySelector("#{{$chartId}}"), options);

                                            chartDepartment.render();
                                        </script>
                                    </div>
                                </div>
                                @endif
                            @else
                                {{-- item mode --}}
                                @if($trCashs)
                                <div class="row pt-3">
                                    <div class="col">
                                        <table class="table table-v1 table-hover">
                                            <thead>
                                                <tr class="tr-th-border-0">
                                                    <th scope="col" class="text-center text-white minimal-table-column px-0 bg-info">
                                                        <div>#</div>
                                                    </th>
                                                    <th scope="col" class="text-left text-white text-nowrap px-0 minimal-table-column bg-info">
                                                        <div>Payment Name</div>
                                                    </th>
                                                    @foreach ( $trCashs[0] as $key => $value )
                                                        @if ($key != 'name' && $key != 'text_color' && $key != 'bg_color')
                                                        <th scope="col" class="text-center text-whithe px-0  bg-info">
                                                            <div>
                                                                {{$key}}
                                                            </div>
                                                        </th>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            </thead>

                                            <tbody id="sortable2">
                                                @forelse ($trCashs as $indext => $transaction)

                                                    <tr class="tr-td-border-0 bg-wite  text-sm-small-screen border-bottom-1" wire:key="dp-{{$indext}}"
                                                        id="dp-{{ $indext }}">
                                                        <td scope="col" class="text-sm text-left py-0">
                                                            <div class="p-1">
                                                                {{$indext +1}}
                                                            </div>
                                                        </td>

                                                        <td scope="col" class="text-center text-sm py-0">
                                                            <div class="text-left p-1 pl-2 text-nowrap">
                                                                {{ $transaction->name }}
                                                            </div>
                                                        </td>

                                                        @foreach ( $transaction as $key => $value )
                                                            @if ($key != 'name')
                                                            <td scope="col" class="text-right py-0 text-danger">
                                                                <div class="p-1">
                                                                    {{$value?-$value:0}}{{explode('_',$key)[1]}}
                                                                    <div class="progress progress-xxs">
                                                                        <div class="progress-bar bg-warning progress-bar-danger progress-bar-striped"
                                                                         role="progressbar" aria-valuenow="{{$value?$value/($totalDepartments[$key]/100):0}}"
                                                                         aria-valuemin="0" aria-valuemax="100"
                                                                         style="width: {{$value?$value/($totalDepartments[$key]/100):0}}%;">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            @endif
                                                        @endforeach

                                                    </tr>
                                                @endforeach
                                                <tr class="border-bottom-1">
                                                    <th colspan="2" class="text-center text-sm py-0 bg-gray-light-h" style="background-color:rgb(235 235 235) !important;">
                                                        <div class="text-right text-info p-1 pl-2">
                                                            Total:
                                                        </div>
                                                    </th>
                                                    @foreach ( $trCashs[0] as $key => $value )
                                                        @if ($key != 'name' && $key != 'text_color' && $key != 'bg_color')
                                                        <th class="text-right py-0  bg-gray-light-h" style="background-color:rgb(235 235 235) !important;">
                                                            <div class="p-1 text-bold text-danger">
                                                                {{-$totalDepartments[$key]}}{{explode('_',$key)[1]}}
                                                            </div>
                                                        </th>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col">
                                        {{-- chart --}}
                                        {{-- <livewire:components.transaction.depatment-chart :transactions="$this->getDepatmentTransaction()" wire:key='test_{{strtotime("now")}}'/> --}}
                                        <?php $chartItemId = 'chart'.strtotime('now');?>
                                        <div id="{{$chartItemId}}"></div>
                                        <script>
                                            var options = {
                                                title: {
                                                    text: 'Expend in Percentage',
                                                    floating: true,
                                                    align: 'center',
                                                    style: {
                                                        color: '#444'
                                                    }
                                                },
                                                chart: {
                                                type: 'bar',
                                                // type: 'area',
                                                },
                                                series: @json($this->getDepartmentDataset()) ,
                                                xaxis: {
                                                // categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
                                                categories: @json($this->getLabels())
                                                },
                                                dataLabels: {
                                                enabled: true,
                                                formatter: function (val) {
                                                    return val + "%";
                                                    },
                                                    offsetY: -20,
                                                    style: {
                                                        // fontSize: '12px',
                                                        colors: ["#304758"]
                                                    }
                                                },
                                                plotOptions: {
                                                    bar: {
                                                        borderRadius: 3,
                                                        dataLabels: {
                                                        position: 'top', // top, center, bottom
                                                        }
                                                    }
                                                },
                                                stroke: {
                                                show: true,
                                                width: 2,
                                                colors: ['transparent']
                                                },
                                            }

                                            const chartItemtment = new ApexCharts(document.querySelector("#{{$chartItemId}}"), options);
                                            chartItemtment.render();

                                        </script>
                                    </div>
                                </div>
                                @endif

                            @endif
                            {{--End Data Table Mode --}}

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
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.Row for table -->

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <livewire:components.transaction.add-cash-form />
    <livewire:components.transaction.add-payment-form />
    <livewire:components.transaction.add-exchange-from />
    @if ($viewId)
        <livewire:components.transaction.tr-view-form :id="$viewId" wire:key="tr_view_form-{{ $viewId }}"/>
    @endif
    <livewire:components.transaction.tr-import-expend />
    @if($printRequest && $mode == 1)
    <livewire:components.transaction.cash-report :title="$reportTitle??null" :search="$searchs??[]" :order="$order??[]" wire:key="tr_report_form-{{ strtotime('now') }}" />
    @elseif ($printRequest && $mode == 2)
    <livewire:components.transaction.department-report :title="$reportTitle??null" :search="$searchs??[]" wire:key="depatment_report_form-{{ strtotime('now') }}" />
    @elseif($printRequest && $mode == 3)
    <livewire:components.transaction.item-report :title="$reportTitle??null" :search="$searchs??[]" wire:key="item_report_form-{{ strtotime('now') }}" />
    @endif
</div>
@push('js')
<script src="{{ asset('backend/dist/js/transactions/tr_list.js') }}"></script>
{{-- Cash-report script --}}
<script>
    function cashResetPrintRequest(){
        Livewire.emit('cashResetPrintRequest');
    }

    function PrintElem(elem)
    {
        let l = (window.screen.width - 1250)/2;
        // window.screen.width;
        var mywindow = window.open('', 'PRINT', 'height=1122,width=1250,left='+l);

        mywindow.document.write('<html><head><title>' + document.title  + '</title>');
        mywindow.document.write(`<link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">`);
        mywindow.document.write(`<link rel="stylesheet" href="{{ asset('css/style.css') }}">`);

        mywindow.document.write('</head><body >');
        mywindow.document.write(document.getElementById(elem).outerHTML);
        // mywindow.document.write(document.getElementById(elem).innerHTML);
        mywindow.document.write('</body></html>');
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.onload=function(){ // necessary if the div contain images
            mywindow.focus(); // necessary for IE >= 10
            mywindow.print();
            mywindow.close();
        };
        //mywindow.print();
        //mywindow.close();
        return true;
    }

    async function printTableRequest(){
        const { value: title } = await Swal.fire({
            title: 'Enter Your Report Title',
            input: 'text',
            inputLabel: 'Title:',
            // inputValue: inputValue,
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                return 'You need to write something!'
                }
            }
        })
        if (title) {
            // Swal.fire(`Your report title is ${title}`);
            @this.printDataTableMode(title);
        }
   }
</script>
{{-- Cash-report script --}}

@endpush
