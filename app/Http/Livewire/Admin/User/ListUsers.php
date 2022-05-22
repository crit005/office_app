<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListUsers extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $form = [];
    public $photo;
    public $showEditModal = false;
    public $user;

    protected $createUserRules = [
        'name' => 'required',
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'group_id' => 'required|integer',
        'status' => 'required',
        'password' => 'required|confirmed',
        'password_confirmation' => 'required',
    ];

    protected $editUserRules = [
        'name' => 'required',
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'group_id' => 'required|integer',
        'status' => 'required',
        'password' => 'sometimes|confirmed',
        'password_confirmation' => 'sometimes',
    ];

    protected $photoRules = ['photo' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg',];

    protected $userValidationAttributes = [
        'group_id' => 'group',
        'password_confirmation' => 'password',
    ];

    public function updated($propertyName)
    {
        if ($this->showEditModal) {
            $rules = $this->editUserRules;
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

        if ($this->photo) {
            $this->validateOnly('photo', $this->photoRules);
        }
    }

    public function addNew()
    {
        $this->reset(['form', 'photo']);
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-user-form',["photo"=>asset("images/no_profile.jpg")]);
    }

    public function createUser()
    {
        $validatedData = Validator::make($this->form, $this->createUserRules, [], $this->userValidationAttributes)->validate();

        if ($this->photo) {
            $this->validate($this->photoRules);
            $imageUrl = $this->photo->store('/', 'avatars');
            // $validatedData['photo'] = $imageUrl;           
        }

        // Generate dataRecord (form + imageUrl + password_incripted - password_confirmation)
        $dataRecord = $this->form;
        if ($this->photo) {
            $dataRecord['photo'] = $imageUrl;
        }
        $dataRecord['password'] = bcrypt($dataRecord['password']);
        unset($dataRecord['password_confirmation']);

        // dd($dataRecord);
        User::create($dataRecord);

        $this->reset();
        // $this->reset(['form', 'photo']);
        $this->dispatchBrowserEvent('alert-success', ['message' => 'User created successfully.']);
        $this->dispatchBrowserEvent('hide-user-form', ['message' => 'User Created Succesfully!']);
    }

    public function getValidClass(String $fieldName)
    {
        return array_key_exists($fieldName, $this->form) ? 'is-valid' : '';
    }

    public function edit(User $user)
    {
        $this->reset(['form','photo']);
        $this->showEditModal = true;
        $this->user = $user;
        $this->form = $user->toArray();
        // dd($this->form);
        $this->dispatchBrowserEvent('show-user-form',["photo"=>$user->photo_url]);
    }

    public function clearPhoto()
    {
        $this->photo = null;
        $this->resetValidation('photo');
    }

    public function render()
    {
        $groups = Group::query()
            ->where('status', '=', 'ENABLED')
            ->where('id', '!=', 1)
            ->get();

        $users = User::query()
            ->where('status', '=', 'ACTIVE')
            ->where('group_id', '!=', '1')
            ->paginate(10);
            // ->get();
        return view('livewire.admin.user.list-users', ['groups' => $groups, 'users' => $users]);
    }
}
