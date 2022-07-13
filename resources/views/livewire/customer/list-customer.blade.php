<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-white">List Customer</h1>
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
                            <a href="">
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
                                            <th scope="col" class="text-center">ID</th>
                                            <th scope="col" class="text-center">Login</th>
                                            <th scope="col" class="text-center">Phone</th>
                                            <th scope="col" class="text-center">Email</th>
                                            <th scope="col" class="text-center">Club</th>
                                            <th scope="col" class="text-center">First Join</th>
                                            <th scope="col" class="text-center">Last Active</th>
                                            <th scope="col" class="text-center">Total_DP</th>
                                            <th scope="col" class="text-center">Total_WD</th>
                                            <th scope="col" class="text-center">Turnover</th>
                                            <th scope="col" class="text-center">Winlose</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable">
                                        @forelse ($customers as $indext => $customer)
                                            <tr wire:key="depatment-{{ $customer->id }}"
                                                id="{{ $customer->id }}">
                                                <th scope="row">{{ $customer->id}}</th>
                                                <td>{{$customer->login_id}}</td>
                                                <td>{{$customer->mobile}}</td>
                                                <td>{{$customer->email}}</td>
                                                <td>{{$customer->club_name}}</td>
                                                <td>{{$customer->first_join}}</td>
                                                <td>{{$customer->last_active}}</td>
                                                <td>{{$customer->total_dp}}</td>
                                                <td>{{$customer->total_wd}}</td>
                                                <td>{{$customer->total_turnover}}</td>
                                                <td>{{$customer->total_winlose}}</td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center"> No record found...</td>
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
                                    {{-- {{ $customers->links() }} --}}
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
