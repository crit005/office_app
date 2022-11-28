<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-white">List Customer: {{ $customers->total() }}</h1>
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
                            <livewire:components.export-button :firstData="$firstData" />
                            {{-- <div class="d-flex flex-row float-left">
                                @if (!$exporting)
                                    <button wire:click.prevent="protectDownload()"
                                        class="btn btn-success btn-sm elevation-1">
                                        <i class="far fa-file-excel"></i>
                                    </button>
                                @endif

                                <div wire:poll='checkExportJob()'>
                                    @if ($exporting)
                                        <div class="customer-list-exporting text-white ml-2">
                                            @if ($exporting['status'] == 'PROCESSING')
                                                <i class="fas fa-spinner fa-spin align-self-center"></i>
                                                Exporting...
                                            @else
                                                Your Export is ready
                                                <button wire:click.prevent="doDeleteExport()"
                                                    class="btn btn-danger btn-sm elevation-1">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <button wire:click.prevent="doDownload()"
                                                    class="btn btn-success btn-sm elevation-1">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                            </div> --}}


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
                                <table class="table table-hover customer-table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('customer_id')">ID
                                                    <span wire:loading.class="d-none" wire:target="setOrderField('customer_id')">
                                                        {!! $this->getSortIcon('customer_id') !!}
                                                    </span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('customer_id')"></i>
                                                </a>
                                            </th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('login_id')">Login
                                                    <span wire:loading.class="d-none"
                                                        wire:target="setOrderField('login_id')">
                                                        {!! $this->getSortIcon('login_id') !!}
                                                    </span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('login_id')"></i>
                                                </a></th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('mobile')">Phone
                                                    <span wire:loading.class="d-none"
                                                        wire:target="setOrderField('mobile')">{!! $this->getSortIcon('mobile') !!}</span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('mobile')"></i>
                                                </a></th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('email')">Email
                                                    <span wire:loading.class="d-none"
                                                        wire:target="setOrderField('email')">{!! $this->getSortIcon('email') !!}</span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('email')"></i>
                                                </a></th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('club_name')">Club
                                                    <span wire:loading.class="d-none"
                                                        wire:target="setOrderField('club_name')">{!! $this->getSortIcon('club_name') !!}</span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('club_name')"></i>
                                                </a></th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('first_join')">First Join
                                                    <span wire:loading.class="d-none"
                                                        wire:target="setOrderField('first_join')">{!! $this->getSortIcon('first_join') !!}</span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('first_join')"></i>
                                                </a></th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('last_dp')">Last DP
                                                    <span wire:loading.class="d-none"
                                                        wire:target="setOrderField('last_dp')">{!! $this->getSortIcon('last_dp') !!}</span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('last_dp')"></i>
                                                </a></th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('last_wd')">Last WD
                                                    <span wire:loading.class="d-none"
                                                        wire:target="setOrderField('last_wd')">{!! $this->getSortIcon('last_wd') !!}</span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('last_wd')"></i>
                                                </a></th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('last_active')">Last Active
                                                    <span wire:loading.class="d-none"
                                                        wire:target="setOrderField('last_active')">{!! $this->getSortIcon('last_active') !!}</span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('last_active')"></i>
                                                </a>
                                            </th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('total_dp')">Total_DP
                                                    <span wire:loading.class="d-none"
                                                        wire:target="setOrderField('total_dp')">{!! $this->getSortIcon('total_dp') !!}</span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('total_dp')"></i>
                                                </a></th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('total_wd')">Total_WD
                                                    <span wire:loading.class="d-none"
                                                        wire:target="setOrderField('total_wd')">{!! $this->getSortIcon('total_wd') !!}</span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('total_wd')"></i>
                                                </a></th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('total_turnover')">Turnover
                                                    <span wire:loading.class="d-none"
                                                        wire:target="setOrderField('total_turnover')">{!! $this->getSortIcon('total_turnover') !!}</span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('total_turnover')"></i>
                                                </a>
                                            </th>
                                            <th scope="col" class="text-center"><a
                                                    class="d-flex justify-content-between" href=""
                                                    wire:click.prevent="setOrderField('totall_winlose')">Winlose
                                                    <span wire:loading.class="d-none"
                                                        wire:target="setOrderField('totall_winlose')">{!! $this->getSortIcon('totall_winlose') !!}</span>
                                                    <i class="fas fa-spinner fa-spin align-self-center" wire:loading
                                                        wire:target="setOrderField('totall_winlose')"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable">
                                        @forelse ($customers as $indext => $customer)
                                            <tr wire:key="depatment-{{ $customer->id }}" id="{{ $customer->id }}">
                                                <th scope="row">
                                                    {{ $customers->firstItem() + $indext }}
                                                </th>
                                                <td scope="row">
                                                    <a href="{{ route('customer.detail', $customer->customer_id) }}">
                                                        {{ $customer->customer_id }}
                                                    </a>
                                                </td>
                                                <td>{{ $customer->login_id }}</td>
                                                <td>{{ str_replace("'", '', $customer->mobile) }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->club_name }}</td>
                                                <td class="@if (strtotime($customer->first_join) > strtotime(now())) text-danger @endif">
                                                    {{ $customer->first_join }}</td>
                                                <td class="@if (strtotime($customer->last_dp) > strtotime(now())) text-danger @endif">
                                                    {{ $customer->last_dp }}</td>
                                                <td class="@if (strtotime($customer->last_wd) > strtotime(now())) text-danger @endif">
                                                    {{ $customer->last_wd }}</td>
                                                <td class="@if (strtotime($customer->last_active) > strtotime(now())) text-danger @endif">
                                                    {{ $customer->last_active }}</td>
                                                <td class="text-right">{{ $customer->total_dp }}</td>
                                                <td class="text-right">{{ $customer->total_wd }}</td>
                                                <td class="text-right">{{ $customer->total_turnover }}</td>
                                                <td class="text-right">{{ $customer->totall_winlose }}</td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12" class="text-center"> No record found...</td>
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
                                    {{ $customers->links() }}
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
        $("document").ready(function(){
           console.log(window.location.href);
        });

        function globleSearch(val) {
            @this.search = val;
        }

        // window.addEventListener('protectDownload', e => {
        //     Swal.fire({
        //         title: 'Protect Your File',
        //         icon: 'info',
        //         html: `<input type="text" id="fileName" class="swal2-input" placeholder="File Name">
        //             <input type="password" id="password" class="swal2-input" placeholder="Password">
        //             <input type="password" id="cpassword" class="swal2-input" placeholder="confirm Password">`,
        //         confirmButtonText: 'Submit',
        //         focusConfirm: false,
        //         preConfirm: () => {
        //             const fileName = Swal.getPopup().querySelector('#fileName').value
        //             const password = Swal.getPopup().querySelector('#password').value
        //             const cpassword = Swal.getPopup().querySelector('#cpassword').value
        //             const rg1 =
        //                 /^[^\\/:\*\?"<>\|\.@\$#]+$/; // forbidden characters \ / : * ? " < > | . @.# $
        //             if (!fileName || !password) {
        //                 Swal.showValidationMessage(`Please enter fiename and password`)
        //             } else if (!rg1.test(fileName)) {
        //                 Swal.showValidationMessage(`Invalid filename`)
        //             } else if (password != cpassword) {
        //                 Swal.showValidationMessage(`Password are not match`)
        //             }
        //             return {
        //                 fileName: fileName,
        //                 password: password
        //             }
        //         }
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             @this.doExport({
        //                 "fileName": result.value.fileName,
        //                 "password": result.value.password
        //             });
        //             // Swal.fire(`
        //         //         Filename: ${result.value.fileName + '.xlsx'}
        //         //         Password: ${result.value.password}
        //         //     `.trim())
        //         } else {
        //             console.log("no result");
        //         }

        //     })
        // });
    </script>
@endpush
