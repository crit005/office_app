<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-white">Dashboard</h1>
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

            @if(in_array(auth()->user()->group_id,[1,2,6]))
            <div class="d-flex flex-row justify-content-between flex-wrap">
                @foreach ($connections as $connection)
                    @livewire('components.system-panel',['connection'=>$connection], key($connection->id))
                @endforeach
            </div>
            @else
            <div class="jumbotron text-center blur-light text-uppercase text-white center-screen">
                <h1>Wlcom to Office</h1>
            </div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
