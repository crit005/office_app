<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-white">Currency</h1>
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
                                            <th scope="col">Country and Currency</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Symbol</th>
                                            <th scope="col" class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($currencies as $indext => $currency)
                                        <tr>
                                            <th scope="row">{{ $currencies->firstItem() + $indext }}</th>
                                            <td>{{ $currency->country_and_currency }}</td>
                                            <td>{{ $currency->code }}</td>
                                            <td>{{ $currency->symbol }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" value="{{$currency->id}}"
                                                        wire:click.prevent="togleStatus(event.target.value)"
                                                        @if($currency->status == 'ENABLED') checked @endif>
                                                    <span class="slider round"></span>
                                                </label>

                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center"> No user found...</td>
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
                                    {{ $currencies->links() }}
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