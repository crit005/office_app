<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-white">Cash Transactions</h1>
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
                        <div class="card-header">
                            {{-- <h3 class="card-title text-white">List Users</h3> --}}
                            <a href="{{ route('cash.addcash') }}">
                                <button type="button" class="btn btn-primary" {{-- data-toggle="modal"
                                    data-target="#depatmentModal" --}}>
                                    <i class="fa fa-plus-circle mr-2"></i>
                                    Add Cash
                                </button>
                            </a>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input wire:model.debounce='search' type="text" name="table_search"
                                        class="form-control float-right" placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive rounded" style="background:none; border: none;">
                                <table class="table table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" class="text-center">Date</th>
                                            <th scope="col" class="text-center">Item</th>
                                            {{-- <th scope="col" class="text-center">Last Balance</th> --}}
                                            <th scope="col" class="text-center">Amount</th>
                                            <th scope="col" class="text-center">Current Balance</th>
                                            <th scope="col" class="text-center">Use On</th>
                                            <th scope="col" class="text-center">Month</th>
                                            <th scope="col" class="text-center">Created By</th>
                                            <th scope="col" class="text-center">Type</th>
                                            <th scope="col" class="text-center">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable">
                                        @forelse ($transactions as $indext => $transaction)
                                            <tr wire:key="depatment-{{ $transaction->id }}"
                                                id="{{ $transaction->id }}">
                                                <th scope="row">
                                                    {{ $transactions->firstItem() + $indext }}
                                                </th>

                                                <td>{{ date(env('DATE_FORMAT'), strtotime($transaction->tr_date)) }}</td>
                                                <td class="text-center">{{ $transaction->item_name }}</td>

                                                <td class="text-center">
                                                    {{ $transaction->amount .
                                                        "
                                                                                                    " .
                                                        $transaction->currency->symbol }}
                                                </td>

                                                @if ($globleBalance)
                                                    <td class="text-center">
                                                        {{ $transaction->balance . ' ' . $transaction->currency->symbol }}
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        {{ $transaction->user_balance .
                                                            "
                                                                                                        " .
                                                            $transaction->currency->symbol }}
                                                    </td>
                                                @endif

                                                <td class="text-center">{{ $transaction->use_on }}</td>

                                                <td class="text-center">{{ $transaction->month }}</td>
                                                <td class="text-center">{{ $transaction->owner_name }}</td>
                                                <td class="text-center">{{ $transaction->type }}</td>

                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center">
                                                        @if (auth()->user()->id == $transaction->owner)
                                                            @if ($transaction->item_name == 'Exchange' && $transaction->item->status == 'SYSTEM')
                                                                <a href="{{ route('cash.editexchange', $transaction) }}"
                                                                    class="btn btn-xs btn-primary mr-2">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>

                                                                <button
                                                                    wire:click.prevent='confirmTrash({{ $transaction }})'
                                                                    class="btn btn-xs btn-danger mr-2">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            @elseif($transaction->item_name == 'Add Cash' && $transaction->item->status == 'SYSTEM')
                                                                <a href="{{ route('cash.editcash', $transaction) }}"
                                                                    class="btn btn-xs btn-primary mr-2">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>

                                                                <button
                                                                    wire:click.prevent='confirmTrash({{ $transaction }})'
                                                                    class="btn btn-xs btn-danger mr-2">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            @else
                                                                <a href="{{ route('cash.editexpand', $transaction) }}"
                                                                    class="btn btn-xs btn-primary mr-2">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>

                                                                <button
                                                                    wire:click.prevent='confirmTrash({{ $transaction }})'
                                                                    class="btn btn-xs btn-danger mr-2">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center"> No record found...</td>
                                            </tr>
                                        @endforelse


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="d-flex flex-row justify-content-center">
                                <div>
                                    {{ $transactions->links() }}
                                </div>

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

</div>
@push('js')
    <script>
        window.addEventListener('changeCashTransactionMode', e => {
            @this.globleBalance = e.detail.globleMode;
        });


        function globleSearch(val) {
            @this.search = val;
        }

        window.addEventListener('show-confirm-trash', e => {
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
                    @this.putItemToTrash();
                }
            });
        })
    </script>
@endpush
