<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-white">Inactive Customer: {{ $customers->total() }}</h1>
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
                            <div class="d-flex flex-row justify-content-start float-left">
                                {{-- <div class="input-group input-group-sm mr-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From:</div>
                                    </div>
                                    <x-datepicker-normal wire:model="fromDate" id="from_date" :format="'DD-MMM-Y'" />
                                </div> --}}
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Untill:</div>
                                    </div>
                                    <x-datepicker-normal wire:model="toDate" id="to_date" :format="'DD-MMM-Y'" />
                                </div>
                                <button wire:click.prevent="setToDate('-180 days')" class="btn btn-primary btn-sm elevation-1 ml-2">6M(-180ds)</button>
                                <button wire:click.prevent="setToDate('-90 days')" class="btn btn-primary btn-sm elevation-1 ml-2">3M(-90ds)</button>
                                <button wire:click.prevent="setToDate('-30 days')" class="btn btn-primary btn-sm elevation-1 ml-2 mr-2">1M(-30ds)</button>

                                <livewire:components.export-button :firstData="$firstData" />
                                {{-- <button wire:click.prevent="setToDate('-30 days')" class="btn btn-success btn-sm elevation-1 ml-2">
                                    <i class="far fa-file-excel"></i>
                                </button> --}}
                            </div>

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
                                                <td>{{ $customer->first_join }}</td>
                                                <td>{{ $customer->last_dp }}</td>
                                                <td>{{ $customer->last_wd }}</td>
                                                <td>{{ $customer->last_active }}</td>
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
        function globleSearch(val) {
            @this.search = val;
        }
    </script>
@endpush
