<div>
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
                                        <span class="info-number">01-01-2022</span>
                                        <i class="fas fa-angle-double-right"></i>
                                        <span class="info-number">01-11-2022</span>
                                    </div>
                                </div>

                                <div class="total-info-top d-flex flex-row">
                                    <div class="mr-3">
                                        <span class="info-label">Incom:</span> <span class="info-number">861285 ฿ / 6538
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
                                    <x-datepicker-normal id="from_date" :format="'DD-MMM-Y'" :placeholder="'From'" />
                                </div>
                                <div class="input-group input-group-sm mr-2 sort-input-date elevation-1">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text"><i class="fas fa-calendar mr-1"></i></label>
                                    </div>
                                    <x-datepicker-normal id="to_date" :format="'DD-MMM-Y'" :placeholder="'To'" />
                                </div>

                                <div class="input-group input-group-sm mr-2 sort-input-date elevation-1">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">
                                            <i class="fas fa-grip-horizontal"></i></label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect01">
                                        <option selected>Depatment</option>
                                        <option value="1">ACC</option>
                                        <option value="2">BANDA</option>
                                        <option value="3">CBO</option>
                                    </select>
                                </div>

                                <div class="input-group input-group-sm mr-2 sort-input-date elevation-1">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01"><i
                                                class="fas fa-money-bill"></i></label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect01">
                                        <option selected>Currency</option>
                                        <option value="1">$ USD</option>
                                        <option value="2">B THB</option>
                                        <option value="3">Rp IND</option>
                                    </select>
                                </div>

                                <button class="btn btn-primary btn-sm elevation-1">All</button>

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
                                <thead>
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
                                </thead>
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
                                            <tr class="tr-td-border-0 border-bottom stick-top-next bg-wite">
                                                <td scope="col"
                                                    class="text-left text-info text-bold minimal-table-column">
                                                    {{ date('M-Y', strtotime($transaction->month)) }}
                                                </td>
                                                <td scope="col" colspan="7" class="text-left">
                                                    <livewire:components.transaction.tr-monthly-sumary :totals="$transaction->currency->getTotal($transaction->month)"
                                                        wire:key="tr-total-{{ $transaction->id.$updateTime }}" />
                                                </td>
                                            </tr>
                                        @endif
                                        <tr class="tr-td-border-0 bg-wite" wire:key="tr-{{ $transaction->id }}"
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
                                            <td scope="col" class="text-center minimal-table-column">
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
                                    @endif


                                </tbody>
                            </table>
                            @if (!$reachLastRecord)
                                <div class="text-center text-info w-100 p-3" wire:loading="" wire:target="inceaseTakeAmount">
                                <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            @endif

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
    <script>
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                @this.inceaseTakeAmount();
            }
        });

        // call by tr-edit-form x button
        // Cancel button click
        function hideEditPaymentForm(){
            $('.tr-edit-payment-form-controller').css({"height":$('.inline-form').height()+'px',"overflow":"hidden"});
            $('.tr-edit-payment-form-controller').css({"height":0});
            $('.tr-edit-payment-form-controller').on('transitionend webkitTransitionEnd oTransitionEnd', function () {
                $('.tr-edit-payment-form').css("display","none");
            });
            // $('.tr-edit-payment-form-controller').css({"height":0});
            Livewire.emit('clearEditTransactionCashList');
        };

        // Edit button click
        function clearEditPaymentForm(){
            $('.tr-edit-payment-form-controller').css({"overflow":"hidden"});
            $('.tr-edit-payment-form-controller').on('transitionend webkitTransitionEnd oTransitionEnd', function () {
                $('.tr-edit-payment-form').css("display","none");
            });
            $('.tr-edit-payment-form-controller').css({"height":0});
        };

        window.addEventListener('update-payment-alert-success', e => {
            Swal.fire({
                title: 'Success!',
                text: 'Payment update successfully.',
                icon: 'success',
                confirmButtonText: 'OK',

            }).then((e) => {
                // Hide from
                // Clear emit transaction
                // Livewire.emit('refreshCashList');
                Livewire.emit('clearEditTransactionCashList');
            });
        });

        function showConfirmDelete(eventName){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // @this.deletePaymenet();
                    // Livewire.emit('trEditPaymentFormDelete');
                    Livewire.emit(eventName);

                }
            });
        }

        window.addEventListener('update-add-cash-alert-success', e => {
            Swal.fire({
                title: 'Success!',
                text: 'Cash update successfully.',
                icon: 'success',
                confirmButtonText: 'OK',

            }).then((e) => {
                // Hide from
                // Clear emit transaction
                // Livewire.emit('refreshCashList');
                Livewire.emit('clearEditTransactionCashList');
            });
        });

        window.addEventListener('update-exchange-alert-success', e => {
            Swal.fire({
                title: 'Success!',
                text: 'Exchange update successfully.',
                icon: 'success',
                confirmButtonText: 'OK',

            }).then((e) => {
                // Hide from
                // Clear emit transaction
                // Livewire.emit('refreshCashList');
                Livewire.emit('clearEditTransactionCashList');
            });
        });



        // javascript event hooks
        document.addEventListener("DOMContentLoaded", () => {

                // Livewire.hook('component.initialized', (component) => {
                //     console.log('component.name');
                // })

                // Livewire.hook('element.initialized', (el, component) => {
                //     console.log('element.initialized');
                // })

                // Livewire.hook('element.updating', (fromEl, toEl, component) => {
                //     // console.log('element.updating')
                // })

                Livewire.hook('element.updated', (el, component) => {
                    $('[data-toggle="tooltip"]').tooltip();
                    $('[data-toggle="popover"]').popover();
                    // console.log(component.name);

                })

                // Livewire.hook('element.removed', (el, component) => {
                //     console.log('element.removed');
                // })

                // Livewire.hook('message.sent', (message, component) => {
                //     console.log('message.sent');
                // })

                // Livewire.hook('message.failed', (message, component) => {
                //     console.log('message.failed');
                // })

                // Livewire.hook('message.received', (message, component) => {
                //     console.log('message.received');
                // })

                // Livewire.hook('message.processed', (message, component) => {
                //     console.log('message.processed');
                // })

                });
    </script>
@endpush
