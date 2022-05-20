<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class ListUsers extends Component
{
    use WithFileUploads;

    public $form = [];
    public $photo;
    public $showEditModal = false;

    protected $createUserRules = [
        'name' => 'required',
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'group' => 'required',
        'status' => 'required',
        'password' => 'required|confirmed',
        'password_confirmation' => 'required',
    ];

    protected $editUserRules = [
        'name' => 'required',
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'group' => 'required',
        'status' => 'required',
        'password' => 'sometimes|confirmed',
        'password_confirmation' => 'sometimes',
    ];

    protected $userValidationAttributes = [
        'group_id' => 'group',
        'password_confirmation' => 'password',
    ];

    public function updated($propertyName)
    {
        if($propertyName != 'photo'){
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
        }

    }

    public function addNew()
    {
        $this->reset(['form', 'photo']);
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-user-form');
    }

    public function createUser()
    {
        $validatedData = Validator::make($this->form, $this->createUserRules, [], $this->userValidationAttributes)->validate();

        // encrypt password
        $validatedData['password'] = bcrypt($validatedData['password']);

        if ($this->photo) {
            $imageUrl = $this->photo->store('/', 'avatars');
            $validatedData['avatar'] = $imageUrl;
        }
        unset($validatedData['password_confirmation']);
        dd($validatedData);
        User::create($validatedData);


        // $this->reset();
        $this->reset(['form', 'photo']);
        $this->dispatchBrowserEvent('alert-success', ['message' => 'User created successfully.']);
        $this->dispatchBrowserEvent('hide-user-form', ['message' => 'User Created Succesfully!']);
    }

    public function getValidClass(String $fieldName)
    {
        return array_key_exists($fieldName, $this->form) ? 'is-valid' : '';
    }

    public function render()
    {
        $groups = Group::query()
            ->where('status', '=', 'ENABLED')
            // ->where('id','!=',1)
            ->get();

        $users = User::query()
            ->where('status', '=', 'ACTIVE')
            ->where('group_id', '!=', '1')
            ->get();
        return view('livewire.admin.user.list-users', ['groups' => $groups, 'users' => $users]);
    }
}
