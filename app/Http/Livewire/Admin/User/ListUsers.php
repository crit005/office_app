<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListUsers extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Component variable //
    protected $paginationTheme = 'bootstrap';

    public $form = [];
    public $photo;
    public $showEditModal = false;
    public $user;
    public $userIdBegingRemoved = null;
    public $search = null;
    public $creater = null;

    protected $createUserRules = [
        'name' => 'required',
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'group_id' => 'required|integer',
        'status' => 'required',
        'password' => 'required|confirmed',
        'password_confirmation' => 'required|same:password',
    ];

    protected $editUserRules = [
        'name' => 'required',
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'group_id' => 'required|integer',
        'status' => 'required',
        'password' => 'sometimes|confirmed',
        'password_confirmation' => 'sometimes|same:password',
    ];

    protected $photoRules = ['photo' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg',];

    protected $userValidationAttributes = [
        'group_id' => 'group',
        'password_confirmation' => 'confirm password',
    ];
    // End component variable //

    // Realtime validation //
    public function updatedForm($value)
    {
        if ($this->showEditModal) {
            $rules = $this->editUserRules;
            $rules['username'] = $rules['username'] . ',username,' . $this->form['id'];
            $rules['email'] = $rules['email'] . ',email,' . $this->form['id'];
            $rules = array_filter($rules, function ($key) {
                return in_array($key, array_keys($this->form));
            }, ARRAY_FILTER_USE_KEY);
        } else {
            $rules = array_filter($this->createUserRules, function ($key) {
                return in_array($key, array_keys($this->form));
            }, ARRAY_FILTER_USE_KEY);
        }
        Validator::make($this->form, $rules, [], $this->userValidationAttributes)->validate();
    }

    public function updatedPhoto($var)
    {
        if ($this->photo) {
            $this->validateOnly('photo', $this->photoRules);
        } else {
            $this->resetValidation('photo');
        }
    }

    public function updatedSearch($var)
    {
        $this->resetPage();
    }

    public function getValidClass(String $fieldName)
    {
        return array_key_exists($fieldName, $this->form) ? 'is-valid' : '';
    }

    public function clearPhoto()
    {
        $this->photo = null;
        if ($this->showEditModal) {
            $this->form['photo_url'] = asset("images/no_profile.jpg");
            $this->form['photo'] = null;
        }
        $this->resetValidation('photo');
    }

    function resetComponentVariables()
    {
        $this->reset(['form', 'photo', 'showEditModal', 'userIdBegingRemoved', 'user']);
    }
    // End Realtime validation //

    // New User //
    public function addNew()
    {
        $this->resetComponentVariables();
        $this->showEditModal = false;
        $this->creater = $this->getCreater();

        $this->dispatchBrowserEvent('show-user-form', ["photo" => asset("images/no_profile.jpg")]);
    }

    public function createUser()
    {
        Validator::make($this->form, $this->createUserRules, [], $this->userValidationAttributes)->validate();

        if ($this->photo) {
            $this->validate($this->photoRules);
            $imageUrl = $this->photo->store('/', 'avatars');
        }

        // Generate dataRecord (form + imageUrl + password_incripted - password_confirmation)
        $dataRecord = $this->form;
        if ($this->photo) {
            $dataRecord['photo'] = $imageUrl;
        }
        $dataRecord['password'] = bcrypt($dataRecord['password']);
        $dataRecord['created_by'] = auth()->user()->id;

        // unset($dataRecord['password_confirmation']);

        User::create($dataRecord);

        $this->resetComponentVariables();
        $this->dispatchBrowserEvent('alert-success', ['message' => 'User created successfully.']);
        $this->dispatchBrowserEvent('hide-user-form', ['message' => 'User Created Succesfully!']);
    }
    // End New User //

    // Update user //
    public function edit(User $user)
    {
        $this->resetComponentVariables();
        $this->showEditModal = true;
        $this->user = $user;
        $this->form = $user->toArray();
        $this->creater = $this->getCreater();
        $this->dispatchBrowserEvent('show-user-form', ["photo" => $user->photo_url]);
    }

    public function updateUser()
    {
        $rules = $this->editUserRules;
        $rules['username'] = $rules['username'] . ',username,' . $this->form['id'];
        $rules['email'] = $rules['email'] . ',email,' . $this->form['id'];

        $validatedData = Validator::make($this->form, $rules, [], $this->userValidationAttributes)->validate();

        // photo validation
        if ($this->photo) {
            // delete old photo befor update
            if (!is_null($this->user->photo)) {
                Storage::disk('avatars')->delete($this->user->photo);
            }
            // Stor new photo
            $imageUrl = $this->photo->store('/', 'avatars');
            $this->form['photo'] = $imageUrl;
        }

        // encrypt new password
        if (!empty($validatedData['password'])) {
            $this->form['password'] = bcrypt($validatedData['password']);
        }



        $this->user->update($this->form);

        $this->user = null;

        $this->resetComponentVariables();

        $this->dispatchBrowserEvent('alert-success', ['message' => 'User updated successfully.']);
        $this->dispatchBrowserEvent('hide-user-form', ['message' => 'User Updated Succesfully!']);
    }
    // End Update User //

    // Trash user //
    public function confirmTrash(User $user)
    {
        $this->resetComponentVariables();
        $this->user = $user;
        $this->form = $user->toArray();
        $this->dispatchBrowserEvent('show-confirm-trash');
    }

    public function putUserToTrash()
    {
        $this->form['username'] = $this->form['username'] . "#d#" . $this->form['id'];
        $this->form['email'] = $this->form['email'] . "#d#" . $this->form['id'];
        $this->form['status'] = "DELETED";
        $this->user->update($this->form);

        $this->dispatchBrowserEvent('alert-success', ['message' => 'User ID: ' . $this->form['id'] . ', has delete successfully!']);
        $this->resetComponentVariables();
    }
    // End Trash user

    // Remove user //
    public function confirmUserRemoval($userId)
    {
        $this->resetComponentVariables();
        $this->userIdBegingRemoved = $userId;

        $this->dispatchBrowserEvent('show-confirm-delete');
    }

    public function deleteUser()
    {
        $user = User::findOrFail($this->userIdBegingRemoved);
        // delete old photo befor update
        if (!is_null($user->photo)) {
            Storage::disk('avatars')->delete($user->photo);
        }
        $user->delete();
        $this->dispatchBrowserEvent('alert-success', ['message' => 'User ID: ' . $this->userIdBegingRemoved . ', has delete successfully!']);
        $this->resetComponentVariables();
    }
    // End remove user

    public function getCreater()
    {
        if ($this->showEditModal) {
            if (!$this->form['created_by']) {
                return null;
            }
            return User::find($this->form['created_by'])->toArray();
        }
        return auth()->user();
    }

    public function render()
    {
        $groups = Group::query()
            ->where('status', '=', 'ENABLED')
            ->where('id', '!=', 1)
            ->get();

        $userDeleted = User::query()
            ->latest()
            ->where('status', '=', 'DELETED')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });

        $userInactive = User::query()
            ->latest()
            ->where('status', '=', 'INACTIVE')
            ->where('group_id', '!=', '1')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });

        if (auth()->user()->isAdmin()) {
            $userInactive->union($userDeleted);
        }

        $users = User::where('status', '=', 'ACTIVE')
            ->where('group_id', '!=', '1')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            // ->latest()
            ->union($userInactive)
            ->paginate(10);

        return view('livewire.admin.user.list-users', ['groups' => $groups, 'users' => $users]);
    }
}
