<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-white">Users</h1>
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
                                data-toggle="modal" data-target="#userModal" --}}>
                                <i class="fa fa-user-plus mr-2"></i>
                                New User
                            </button>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" >
                            <div class="table-responsive rounded" style="background:none; border: none;">
                                <table class="table table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Group</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->group->name}}</td>
                                            <td class="text-center"><i class="far fa-circle {{$user->getStatusTextCollor()}}"></i></td>
                                            <td>
                                                <a href="" wire:click.prevent="edit({{$user}})"><i class="fa fa-edit mr-2"></i></a>
                                                <a href="" ><i class="fa fa-trash text-danger"></i></a>
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
                                    {{ $users->links() }}
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.Row for table -->

            <!-- Modal -->
            <div wire:ignore.self class="modal fade" id="userModal" tabindex="-1" role="dialog"
                aria-labelledby="userModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-blur-light">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title text-white" id="exampleModalLongTitle">New User</h5>
                                <span class="d-block small text-white">Input By: <strong>Konteha</strong></span>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form wire:submit.prevent='createUser()'>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            @error('form.name')
                                            {{$message}}
                                            @enderror
                                            <label for="name">Name:</label>
                                            <input wire:model.debounce='form.name' type="text"
                                                class="form-control @error('name') is-invalid @else {{$this->getValidClass('name')}} @enderror" id="name"
                                                placeholder="Your name">
                                            @error('name')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="username">Username:</label>
                                            <input wire:model.debounce='form.username' type="text"
                                                class="form-control  @error('username') is-invalid @else {{$this->getValidClass('username')}} @enderror"
                                                name="username" id="username" placeholder="Username">
                                            @error('username')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Email:</label>
                                            <input wire:model.debounce='form.email' type="email"
                                                class="form-control  @error('email') is-invalid @else {{$this->getValidClass('email')}} @enderror" name="email"
                                                id="email" placeholder="Enter email">
                                            @error('email')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Password:</label>
                                            <input wire:model.debounce='form.password_confirmation' type="password"
                                                class="form-control @error('password_confirmation') is-invalid @else {{$this->getValidClass('password_confirmation')}} @enderror"
                                                name="password_confirmation" id="password_confirmation"
                                                placeholder="Confirm password">
                                            @error('password_confirmation')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="confirm_password">Confirm Password:</label>
                                            <input wire:model.debounce='form.password' type="password"
                                                class="form-control @error('password') is-invalid @else {{$this->getValidClass('password')}} @enderror"
                                                name="password" id="password" placeholder="Password">
                                            @error('password')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="group">Group:</label>
                                            <select wire:model.debounce='form.group_id'
                                                class="form-control @error('group_id') is-invalid @else {{$this->getValidClass('group_id')}} @enderror" name="group"
                                                id="group">
                                                <option value="">Select group</option>
                                                @foreach ($groups as $group)
                                                <option value="{{$group['id']}}">{{$group['name']}}</option>
                                                @endforeach

                                            </select>
                                            @error('group_id')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status:</label>
                                            <select wire:model.debounce='form.status'
                                                class="form-control @error('status') is-invalid @else {{$this->getValidClass('status')}} @enderror" name="status"
                                                id="status">
                                                <option value="">Select satus</option>
                                                <option value="ACTIVE">Active</option>
                                                <option value="INACTIVE">Inactive</option>
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group" >
                                            @if ($photo)
                                            <script>let imagePreview = "{{$photo->temporaryUrl()}}";</script>
                                            @else
                                            <script>let imagePreview = "{{$photo['photo_url']?? asset('images/no_profile.jpg')}}";</script>                                            
                                            @endif

                                            {{-- <script>let imagePreview = null;</script> --}}
                                            <div x-data="{isUploading: false, progress: 0}"
                                            x-on:livewire-upload-start="isUploading = true; progress = 0;"
                                            x-on:livewire-upload-finish="isUploading = false"
                                            x-on:livewire-upload-error="isUploading = false"
                                            x-on:livewire-upload-progress="progress = $event.detail.progress"                                            
                                            >
                                                <label for="photo" >Photo:</label>

                                                <input type="file"
                                                    wire:model='photo'
                                                    accept="image/png, image/jpeg"
                                                    x-ref="image"
                                                    class="form-control d-none @error('photo') is-invalid @enderror"
                                                    name="photo" id="photo"
                                                    x-on:change="
                                                        FileUploadPath = $refs.image.value;
                                                        extention = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
                                                        if(extention == 'jpg' || extention == 'png' || extention == 'jpeg' || extention == 'gif' || extention == 'svg'){
                                                            reader = new FileReader();
                                                            reader.onload = function(e){
                                                                imagePreview = e.target.result;
                                                            };
                                                            reader.readAsDataURL($refs.image.files[0]);
                                                        }
                                                        else{
                                                            imagePreview=null;
                                                            $refs.image.value=null;
                                                        } 
                                                    "
                                                >

                                                <div style="position: relative;" class="img-thumbnail text-center  @error('photo') is-invalid @enderror">
                                                    <img x-on:click="$refs.image.click()" x-bind:src ="imagePreview ? imagePreview : '{{asset("images/no_profile.jpg")}}'" alt=""
                                                        style="height: 100%; width: 100%;">
                                                    @if ($photo)
                                                        
                                                    <button wire:click.prevent='clearPhoto()' class="btn btn-sm btn-danger m-2" style="position: absolute; bottom: 0; right:0;"
                                                    wire:loading.attr="disabled" wire:target='clearPhoto'
                                                    x-on:click="imagePreview = null;">                                                    
                                                        <i wire:loading class="fa fa-spinner fa-spin"></i>
                                                        <i wire:loading.remove class="fa fa-trash"></i>
                                                    </button> 
                                                    @endif
                                                </div>
                                                <div class="text-center" x-show="!isUploading">
                                                    @if ($photo)
                                                    {{$photo->getClientOriginalName()}}
                                                    @else
                                                    Choose Image
                                                    @endif
                                                </div>                                                
                                                <div x-show="isUploading" style="margin-top: 5px">       
                                                    <div class="progress rounded" style="height: 5px">
                                                        <div class="progress-bar bg-primary progress-bar-striped rounded" x-bind:style="`width: ${progress}%`"></div>
                                                    </div>
                                                    <div class="text-sm text-center">Uploading: <span x-text='progress'></span>%</div>
                                                </div>

                                                @error('photo')

                                                <div class="invalid-feedback">{{$message}}</div>

                                                @enderror

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    {{-- @dump($photo) --}}
                                    <div class="col-12">
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
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-times mr-2"></i>Cancel</button>
                                <button type="submit" class="btn btn-primary"
                                wire:loading.attr="disabled"
                                ><i
                                        class="fa fa-save mr-2"></i>Save</button>
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
    window.addEventListener('show-user-form', e =>{   
        imagePreview = e.detail.photo;
        $('#userModal').modal({backdrop: 'static', keyboard: false});
    });
    window.addEventListener('hide-user-form', e =>{        
        $('#userModal').modal('hide');
    });

    // public event
    window.addEventListener('alert-success', e =>{
        Swal.fire({
            title: 'Success!',
            text: e.detail.message,
            icon: 'success',
            confirmButtonText: 'OK'
        });
    });    

</script>
@endpush

