<?php

namespace App\Http\Livewire\Pament;

use App\Models\Cashdrawer;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListCashdrawer extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Component variable //
    protected $paginationTheme = 'bootstrap';

    public $form = [];
    // public $showEditModal = false;
    public $cashdrawer;
    public $cashdrawerIdBegingRemoved = null;
    public $search = null;
    // public $creater = null;

    protected $cashdrawerRules = [
        'name' => 'required|unique:cashdrawers',
        'group' => 'required|date',
        // 'status' => 'required',
    ];



    protected $cashdrawerValidationAttributes = [
        'name' => 'name',
    ];
    // End component variable //

    // Realtime validation //
    public function updatedForm($value)
    {
            $rules = array_filter($this->cashdrawerRules, function ($key) {
                return in_array($key, array_keys($this->form));
            }, ARRAY_FILTER_USE_KEY);

        Validator::make($this->form, $rules, [], $this->cashdrawerValidationAttributes)->validate();
    }

    public function updatedSearch($var)
    {
        $this->resetPage();
    }

    public function getValidClass(String $fieldName)
    {
        return array_key_exists($fieldName, $this->form) ? 'is-valid' : '';
    }

    function resetComponentVariables()
    {
        $this->reset(['form', 'cashdrawerIdBegingRemoved', 'cashdrawer']);
    }
    // End Realtime validation //

    // New Cashdrawer //
    public function addNew()
    {
        date_default_timezone_set('Asia/Phnom_Penh');
        $this->resetComponentVariables();
        $this->form['name'] = auth()->user()->id . "#" . date('M-Y',strtotime(now()));
        $this->form['group'] = date('M-Y',strtotime(now()));
        $this->dispatchBrowserEvent('show-cashdrawer-form');
    }

    public function createCashdrawer()
    {
        Validator::make($this->form, $this->cashdrawerRules, [], $this->cashdrawerValidationAttributes)->validate();

        $dataRecord = $this->form;

        $dataRecord['owner'] = auth()->user()->id;
        $dataRecord['group'] = date("Y-m-01", strtotime($dataRecord['group']));

        Cashdrawer::create($dataRecord);

        $this->resetComponentVariables();
        $this->dispatchBrowserEvent('alert-success', ['message' => 'Cashdrawer created successfully.']);
        $this->dispatchBrowserEvent('hide-cashdrawer-form');
    }
    // End New Cashdrawer //

    // Update user //
    public function edit(Cashdrawer $cashdrawer)
    {
        // $this->resetComponentVariables();
        // // $this->showEditModal = true;
        // $this->cashdrawer = $cashdrawer;
        // $this->form = $cashdrawer->toArray();
        // // $this->creater = $this->getCreater();
        // $this->dispatchBrowserEvent('show-cashdrawer-form');
    }

    public function updateCashdrawer()
    {
        // $rules = $this->cashdrawerRules;
        // $rules['name'] = $rules['name'] . ',name,' . $this->form['id'];

        // $validatedData = Validator::make($this->form, $rules, [], $this->cashdrawerValidationAttributes)->validate();

        // $this->cashdrawer->update($this->form);

        // $this->resetComponentVariables();

        // $this->dispatchBrowserEvent('alert-success', ['message' => 'Cashdrawer updated successfully.']);
        // $this->dispatchBrowserEvent('hide-cashdrawer-form');
    }
    // End Update Cashdrawer //

    // Trash user //
    public function confirmTrash(Cashdrawer $cashdrawer)
    {
        // $this->resetComponentVariables();
        // $this->cashdrawer = $cashdrawer;
        // $this->form = $cashdrawer->toArray();
        // $this->dispatchBrowserEvent('show-confirm-trash');
    }

    public function putCashdrawerToTrash()
    {
        // $this->form['name'] = $this->form['name'] . "#d#" . $this->form['id'];
        // $this->form['status'] = "DELETED";
        // $this->cashdrawer->update($this->form);

        // $this->dispatchBrowserEvent('alert-success', ['message' => 'Cashdrawer ID: ' . $this->form['id'] . ', has delete successfully!']);
        // $this->resetComponentVariables();
    }
    // End Trash user

    // Remove user //
    public function confirmCashdrawerRemoval($cashdrawerId)
    {
        // $this->resetComponentVariables();
        // $this->cashdrawerIdBegingRemoved = $cashdrawerId;

        // $this->dispatchBrowserEvent('show-confirm-delete');
    }

    public function deleteCashdrawer()
    {
        // $cashdrawer = Cashdrawer::findOrFail($this->cashdrawerIdBegingRemoved);
        // $cashdrawer->delete();
        // $this->dispatchBrowserEvent('alert-success', ['message' => 'Cashdrawer ID: ' . $this->cashdrawerIdBegingRemoved . ', has delete successfully!']);
        // $this->resetComponentVariables();
    }
    // End remove user

    public function getCreater()
    {
        // if ($this->showEditModal) {
        //     if (!$this->form['created_by']) {
        //         return null;
        //     }
        //     return User::find($this->form['created_by'])->toArray();
        // }
        // return auth()->user();
    }


    public function togleStatus($id)
    {
        $cashdrawer = Cashdrawer::findOrFail($id);
        $cashdrawer->status = $cashdrawer->status == 'OPEN'? 'CLOSED':'OPEN';
        $cashdrawer->update();
        $this->dispatchBrowserEvent('toast', ['message' => "Cashdrawer status updated successfully!"]);
    }

    public function render()
    {

            $cashdrawers = Cashdrawer::query()
            ->orderBy('status', 'desc')
            ->orderBy('name', 'asc')
            ->paginate(env('PAGINATE'));

        return view('livewire.pament.list-cashdrawer',['cashdrawers'=>$cashdrawers]);
    }
}
