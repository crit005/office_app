<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-white">{{ $customer->name }} [{{ $customer->login_id }} #
                        {{ $customer->id }}]
                    </h1>
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
                                <div class="input-group input-group-sm mr-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From:</div>
                                    </div>
                                    <x-datepicker-normal wire:model="fromDate" id="from_date" :format="'DD-MMM-Y'" />
                                </div>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To:</div>
                                    </div>
                                    <x-datepicker-normal wire:model="toDate" id="to_date" :format="'DD-MMM-Y'" />
                                </div>
                                <button wire:click.prevent="setToDate('-180 days')"
                                    class="btn btn-primary btn-sm ml-2">6M(-180ds)</button>
                                <button wire:click.prevent="setToDate('-90 days')"
                                    class="btn btn-primary btn-sm ml-2">3M(-90ds)</button>
                                <button wire:click.prevent="setToDate('-30 days')"
                                    class="btn btn-primary btn-sm ml-2">1M(-30ds)</button>
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
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a wire:click.prvent="selecteTab('info')"
                                                class="nav-link @if ($selectedTab == 'info') active @endif"
                                                href="#">Customer Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a wire:click.prvent="selecteTab('dp')"
                                                class="nav-link @if ($selectedTab == 'dp') active @endif"
                                                href="#">Deposit</a>
                                        </li>
                                        <li class="nav-item">
                                            <a wire:click.prvent="selecteTab('wd')"
                                                class="nav-link @if ($selectedTab == 'wd') active @endif"
                                                href="#">Withdraw</a>
                                        </li>
                                        <li class="nav-item">
                                            <a wire:click.prvent="selecteTab('wl')"
                                                class="nav-link @if ($selectedTab == 'wl') active @endif"
                                                href="#">Winlose</a>
                                        </li>
                                    </ul>

                                    @if ($selectedTab == 'info')
                                        <div>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">ID</th>
                                                        <td>{{ $customer->id }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">LoginID</th>
                                                        <td>{{ $customer->login_id }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Phone</th>
                                                        <td>{{ $customer->mobile }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Email</th>
                                                        <td>{{ $customer->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Club Name</th>
                                                        <td>{{ $customer->club_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">First Join</th>
                                                        <td>{{ $customer->first_join }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Last DP</th>
                                                        <td>{{ $customer->last_dp }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Last WD</th>
                                                        <td>{{ $customer->last_wd }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Last Active</th>
                                                        <td>{{ $customer->last_active }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total DP</th>
                                                        <td>{{ $customer->total_dp }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total WD</th>
                                                        <td>{{ $customer->total_wd }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total TurnOver</th>
                                                        <td>{{ $customer->total_turnover }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Total Winlose</th>
                                                        <td>{{ $customer->totall_winlose }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @elseif ($selectedTab == 'dp')
                                        <div id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">LoginID</th>
                                                        <th scope="col">Club</th>
                                                        <th scope="col">
                                                            <a class="d-flex justify-content-between" href=""
                                                                wire:click.prevent="setOrderField('groupfor')">Date
                                                                <span wire:loading.class="d-none"
                                                                    wire:target="setOrderField('groupfor')">
                                                                    {!! $this->getSortIcon('groupfor') !!}
                                                                </span>
                                                                <i class="fas fa-spinner fa-spin align-self-center"
                                                                    wire:loading
                                                                    wire:target="setOrderField('groupfor')"></i>
                                                            </a>
                                                        </th>
                                                        <th scope="col">
                                                            <a class="d-flex justify-content-between" href=""
                                                                wire:click.prevent="setOrderField('inputAmount')">Amount
                                                                <span wire:loading.class="d-none"
                                                                    wire:target="setOrderField('inputAmount')">
                                                                    {!! $this->getSortIcon('inputAmount') !!}
                                                                </span>
                                                                <i class="fas fa-spinner fa-spin align-self-center"
                                                                    wire:loading
                                                                    wire:target="setOrderField('inputAmount')"></i>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($listDeposit as $deposit)
                                                        <tr>
                                                            <th scope="row">{{ $deposit->id }}</th>
                                                            <td>{{ $deposit->webAccountLoginId }}</td>
                                                            <td>{{ $deposit->clubId }}</td>
                                                            <td>{{ $deposit->groupfor }}</td>
                                                            <td>{{ $deposit->inputAmount }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                            <div class="d-flex flex-row justify-content-center">
                                                <div>
                                                    {{ $listDeposit->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($selectedTab == 'wd')
                                        <div id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">LoginID</th>
                                                        <th scope="col">Club</th>
                                                        <th scope="col">
                                                            <a class="d-flex justify-content-between" href=""
                                                                wire:click.prevent="setOrderField('groupfor')">Date
                                                                <span wire:loading.class="d-none"
                                                                    wire:target="setOrderField('groupfor')">
                                                                    {!! $this->getSortIcon('groupfor') !!}
                                                                </span>
                                                                <i class="fas fa-spinner fa-spin align-self-center"
                                                                    wire:loading
                                                                    wire:target="setOrderField('groupfor')"></i>
                                                            </a>
                                                        </th>
                                                        <th scope="col">
                                                            <a class="d-flex justify-content-between" href=""
                                                                wire:click.prevent="setOrderField('inputAmount')">Amount
                                                                <span wire:loading.class="d-none"
                                                                    wire:target="setOrderField('inputAmount')">
                                                                    {!! $this->getSortIcon('inputAmount') !!}
                                                                </span>
                                                                <i class="fas fa-spinner fa-spin align-self-center"
                                                                    wire:loading
                                                                    wire:target="setOrderField('inputAmount')"></i>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($listWithdraws as $withdraw)
                                                        <tr>
                                                            <th scope="row">{{ $withdraw->id }}</th>
                                                            <td>{{ $withdraw->webAccountLoginId }}</td>
                                                            <td>{{ $withdraw->clubId }}</td>
                                                            <td>{{ $withdraw->groupfor }}</td>
                                                            <td>{{ $withdraw->inputAmount }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                            <div class="d-flex flex-row justify-content-center">
                                                <div>
                                                    {{ $listWithdraws->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($selectedTab == 'wl')
                                        <div id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">LoginID</th>
                                                        <th scope="col">Club</th>
                                                        <th scope="col">
                                                            <a class="d-flex justify-content-between" href=""
                                                                wire:click.prevent="setOrderField('groupfor')">Date
                                                                <span wire:loading.class="d-none"
                                                                    wire:target="setOrderField('groupfor')">
                                                                    {!! $this->getSortIcon('groupfor') !!}
                                                                </span>
                                                                <i class="fas fa-spinner fa-spin align-self-center"
                                                                    wire:loading
                                                                    wire:target="setOrderField('groupfor')"></i>
                                                            </a>
                                                        </th>
                                                        <th scope="col">
                                                            <a class="d-flex justify-content-between" href=""
                                                                wire:click.prevent="setOrderField('wlamt')">Winlose
                                                                <span wire:loading.class="d-none"
                                                                    wire:target="setOrderField('wlamt')">
                                                                    {!! $this->getSortIcon('wlamt') !!}
                                                                </span>
                                                                <i class="fas fa-spinner fa-spin align-self-center"
                                                                    wire:loading
                                                                    wire:target="setOrderField('wlamt')"></i>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($listWinloses as $winlose)
                                                        <tr>
                                                            <th scope="row">{{ $winlose->id }}</th>
                                                            <td>{{ $winlose->loginId }}</td>
                                                            <td>{{ $winlose->clubId }}</td>
                                                            <td>{{ $winlose->groupfor }}</td>
                                                            <td>{{ $winlose->wlamt }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                            <div class="d-flex flex-row justify-content-center">
                                                <div>
                                                    {{ $listWinloses->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="d-flex flex-row justify-content-center">
                                <div>

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
