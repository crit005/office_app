<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-white">Depatments</h1>
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
                            <button wire:click.prevent='addNew()' type="button" class="btn btn-primary" {{--
                                data-toggle="modal" data-target="#depatmentModal" --}}>
                                <i class="fa fa-user-plus mr-2"></i>
                                New Depatment
                            </button>

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
                                            <th scope="col">Depatment Name</th>
                                            <th scope="col">Position</th>
                                            <th scope="col">Created By</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($depatments as $indext => $depatment)
                                        <tr>
                                            <th scope="row">{{$depatments->firstItem() + $indext}}</th>
                                            <td>{{$depatment->name}}</td>
                                            <td>{{$depatment->position}}</td>
                                            <td class="text-center">{{$depatment->user->name}}</td>

                                            <td class="text-center">
                                                {{$depatment->status}}
                                            </td>

                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-xs btn-primary mr-2"
                                                        wire:click.prevent="edit({{$depatment}})"><i
                                                            class="fa fa-edit"></i>
                                                    </button>

                                                    <button class="btn btn-xs btn-danger mr-2"
                                                        wire:click.prevent="confirmTrash({{$depatment}})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>

                                                    @if (Auth()->user()->isAdmin())
                                                    <button class="btn btn-xs btn-danger"
                                                        wire:click.prevent="confirmUserRemoval({{$depatment->id}})">
                                                        <i class="fas fa-eraser"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center"> No depatment found...</td>
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
                                    {{ $depatments->links() }}
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.Row for table -->

            <!-- Modal -->
            <div wire:ignore.self class="modal fade" id="depatmentModal" tabindex="-1" role="dialog"
                aria-labelledby="depatmentModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-blur-light">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title text-white" id="exampleModalLongTitle">
                                    @if ($showEditModal)
                                    Edit Depatment
                                    @else
                                    New Depatment
                                    @endif
                                </h5>
                                <span class="d-block small text-white">Input By: <strong>
                                        @if ($creater)
                                        {{$creater['name']}}
                                        @endif
                                    </strong></span>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form wire:submit.prevent='{{$showEditModal?' updateDepatment':'createDepatment'}}'>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            @error('form.name')
                                            {{$message}}
                                            @enderror
                                            <label for="name">Depatment Name:</label>
                                            <input wire:model.debounce='form.name' type="text"
                                                class="form-control @error('name') is-invalid @else {{$this->getValidClass('name')}} @enderror"
                                                name="name" id="name" placeholder="Your name">
                                            @error('name')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="position">Position:</label>
                                            <input wire:model.debounce='form.position' type="number"
                                                class="form-control  @error('position') is-invalid @else {{$this->getValidClass('position')}} @enderror"
                                                name="position" id="position" placeholder="position">
                                            @error('position')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="status">Status:</label>
                                            <select wire:model.debounce='form.status'
                                                class="form-control @error('status') is-invalid @else {{$this->getValidClass('status')}} @enderror"
                                                name="status" id="status">
                                                <option value="">Select satus</option>
                                                <option value="ENABLED">Enabled</option>
                                                <option value="DISABLED">Disabled</option>
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Description:</label>
                                            <textarea wire:model.debounce='form.description' name="description"
                                                id="description" class="form-control" rows="3"
                                                placeholder="Enter ..."></textarea>
                                        </div>


                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="d-flex justify-content-between" style="width: 100%;">
                                    <div class="text-white">Created_at:
                                        @if (array_key_exists('created_at',$form))
                                        {{date('Y-m-d',strtotime($form['created_at']))}}
                                        @else
                                        ...
                                        @endif
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                                class="fa fa-times mr-2"></i>Cancel</button>

                                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"><i
                                                class="fa fa-save mr-2"></i>{{$showEditModal ? 'Save Change' :
                                            'Save'}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
@push('js')
<script>
    window.addEventListener('show-depatment-form', e =>{
        $('#depatmentModal').modal({backdrop: 'static', keyboard: false});
    });

    window.addEventListener('hide-depatment-form', e =>{
        $('#depatmentModal').modal('hide');
    });

    window.addEventListener('show-confirm-trash', e =>{
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
              @this.putUserToTrash();
            }
          })
    });

    window.addEventListener('show-confirm-delete', e =>{
        Swal.fire({
            title: 'Are you sure?',
            text: "This depatment will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              @this.deleteUser();
            }
          })
    });

</script>
@endpush
