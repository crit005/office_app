<div>
    @dump($searchs)
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 main-title-block">
                    <h1 class="m-0 text-white">Cash Transactions</h1>
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
                        <div class="card-header"  style="z-index: 10001">
                            <div class="d-flex flex-row justify-content-between mb-2">
                                <div class="total-info-top d-flex flex-row">
                                    <div class="mr-3">
                                        <span class="info-label">Date:</span>
                                        <span class="info-number">{{$fromDate??"..."}}</span>
                                        <i class="fas fa-angle-double-right"></i>
                                        <span class="info-number">{{$toDate??"..."}}</span>
                                    </div>
                                </div>

                                <div class="total-info-top d-flex flex-row">
                                    <div class="mr-3">
                                        <span class="info-label">CashIn:</span> <span class="info-number">861285 ฿ / 6538
                                            $</span>
                                    </div>
                                </div>

                                <div class="total-info-top d-flex flex-row">
                                    <div>
                                        <span class="info-label">Expand:</span> <span class="info-number">861285 ฿ /
                                            6538 $</span>
                                    </div>
                                </div>

                                <div class="total-info-top d-flex flex-row">
                                    <div>
                                        <span class="info-label">Balance:</span> <span class="info-number">861285 ฿ /
                                            6538 $</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row justify-content-center">
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
                                            <i class="fas fa-grip-horizontal"></i></label>
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

                                <button class="btn btn-primary btn-sm elevation-1" wire:click="clearFilter">All</button>

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
                            </div> --}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body-v1 p-0">
                            <table class="table table-v1 table-hover">
                                {{-- <thead>
                                    <tr class="tr-th-border-0 stick-top-0">
                                        <th scope="col" class="text-center text-info minimal-table-column">Date</th>
                                        <th scope="col" class="text-right text-info minimal-table-column">#</th>
                                        <th scope="col" class="text-left text-info" style="white-space: nowrap;">Pament Name</th>
                                        <th scope="col" class="text-center text-info minimal-table-column">Amount</th>
                                        <th scope="col" class="text-center text-info minimal-table-column">Pay On</th>
                                        <th scope="col" class="text-center text-info">Detail</th>
                                        <th scope="col" class="text-center text-info minimal-table-column">Created By</th>
                                        <th scope="col" class="text-center text-info minimal-table-column">Options</th>
                                    </tr>
                                </thead> --}}
                                <tbody id="sortable">
                                    <?php
                                        $trRowNumber = 0;
                                    ?>
                                    @forelse ($trCashs as $indext => $transaction)
                                        {{-- detail record  animate__animated animate__fadeInUp --}}
                                        @if ($this->isNewMonth($transaction->month))
                                            <?php
                                            $trRowNumber = 0;
                                            ?>
                                            <tr class="tr-td-border-0 stick-top-0 bg-wite">
                                                <td scope="col"
                                                    class="text-left text-info text-bold minimal-table-column">
                                                    {{ date('M-Y', strtotime($transaction->month)) }}
                                                </td>
                                                <td scope="col" colspan="7" class="text-left">
                                                    <livewire:components.transaction.tr-monthly-sumary :totals="$transaction->currency->getTotal($searchs,['month'=>$transaction->month,'createdBy'=>$createdBy])"
                                                        wire:key="tr-total-{{ $transaction->id.$updateTime }}" />
                                                </td>
                                            </tr>
                                            <tr class="tr-th-border-0 stick-top-next">
                                                <th scope="col" class="text-center text-info minimal-table-column m-0 p-0"><div class="border-bottom pb-2">Date</div></th>
                                                <th scope="col" class="text-right text-info minimal-table-column m-0 p-0"><div class="border-bottom pb-2">#</div></th>
                                                <th scope="col" class="text-left text-info m-0 p-0" style="white-space: nowrap;"><div class="border-bottom pb-2">Pament Name</div></th>
                                                <th scope="col" class="text-center text-info minimal-table-column m-0 p-0"><div class="border-bottom pb-2">Amount</div></th>
                                                <th scope="col" class="text-center text-info minimal-table-column m-0 p-0"><div class="border-bottom pb-2">Pay On</div></th>
                                                <th scope="col" class="text-center text-info m-0 p-0"><div class="border-bottom pb-2">Detail</div></th>
                                                <th scope="col" class="text-center text-info minimal-table-column m-0 p-0"><div class="border-bottom pb-2">Created By</div></th>
                                                <th scope="col" class="text-center text-info minimal-table-column m-0 p-0"><div class="border-bottom pb-2">Options</div></th>
                                            </tr>
                                        @endif
                                        <tr class="tr-td-border-0 bg-wite  text-sm-small-screen" wire:key="tr-{{ $transaction->id }}"
                                            id="{{ $transaction->id }}">
                                            <td scope="col" class="pl-5 text-sm text-left minimal-table-column">
                                                {{ date(env('DATE_FORMAT','d-m-Y'), strtotime($transaction->tr_date)) }}
                                            </td>
                                            <td scope="col"
                                                class="text-right minimal-table-column border-left position-relative">
                                                <div
                                                    class="
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
                                            <td scope="col"
                                                class="text-center minimal-table-column
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
                                                <a tabindex="0" role="button" data-toggle="popover" data-trigger="focus"
                                                    data-placement="auto"
                                                    data-content="{{ $transaction->description }}">{{ $transaction->getDescription() }}</a>
                                            </td>
                                            <td scope="col" class="text-center minimal-table-column">
                                                {{ $transaction->createdByUser->name }}</td>
                                            <td scope="col" class="text-center minimal-table-column">
                                                <button class="btn btn-sm text-success" wire:click="showView({{$transaction->id}})">
                                                    <i wire:loading.remove wire:target='showView({{$transaction->id}})' onclick="clearEditPaymentForm()" class="fas fa-eye"></i>
                                                    <i wire:loading='showView({{$transaction->id}})' wire:target='showView({{$transaction->id}})' class="fas fa-spinner fa-spin"></i>
                                                </button>
                                                <button id="tr_btn_edit_{{$transaction->id}}" class="btn btn-sm text-primary" wire:click="showEdit({{$transaction->id}})" onclick="clearEditPaymentForm()"
                                                @if ($editTransaction)
                                                    {{$editTransaction->id == $transaction->id ? 'disabled':''}}
                                                @endif
                                                    >
                                                    <i wire:loading.remove wire:target='showEdit({{$transaction->id}})' class="fas fa-edit"></i>
                                                    <i wire:loading='showEdit({{$transaction->id}})' wire:target='showEdit({{$transaction->id}})' class="fas fa-spinner fa-spin"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @if ($editTransaction)
                                            @if ($editTransaction->id == $transaction->id)
                                                <tr class="tr-td-border-0 white-hover tr-edit-payment-form">
                                                    <td scope="col" class="pl-5 text-sm text-left minimal-table-column"></td>
                                                    <td scope="col"
                                                        class="text-right minimal-table-column border-left position-relative">
                                                    <td scope="col" colspan="6" class="text-left p-0">
                                                        @if ($transaction->type == 2)
                                                        {{-- edit pament --}}
                                                        <livewire:components.transaction.tr-edit-form :id="$transaction->id" wire:key="tr_edit_payment-{{ $transaction->id }}"/>
                                                        @elseif($transaction->type == 1)
                                                        {{-- edit add cash --}}
                                                        <livewire:components.transaction.tr-edit-add-cash-form :id="$transaction->id" wire:key="tr_edit_add_cash-{{ $transaction->id }}"/>
                                                        @elseif($transaction->type == 3)
                                                        {{-- edit exchange --}}
                                                        <livewire:components.transaction.tr-edit-exchange-form :id="$transaction->id" wire:key="tr_edit_exchange-{{ $transaction->id }}"/>
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
                                                {{-- <button onClick = 'goToTop()'>TOP</button> --}}
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
                            {{-- @if (!$reachLastRecord)
                                <div class="text-center text-info w-100 p-3" wire:loading="" wire:target="inceaseTakeAmount">
                                <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            @endif --}}

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
        <livewire:components.transaction.tr-view-form :id="$viewId" wire:key="tr_view-form-{{ $viewId }}"/>
    @endif
</div>
@push('js')
<script src="{{ asset('backend/dist/js/transactions/tr_list.js') }}"></script>
@endpush
