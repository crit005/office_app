<?php

namespace App\Http\Livewire\Setting;

use App\Models\Depatment;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListDepatment extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Component variable //
    protected $paginationTheme = 'bootstrap';

    public $form = [];
    public $showEditModal = false;
    public $depatment;
    public $depatmentIdBegingRemoved = null;
    public $search = null;
    public $creater = null;

    protected $depatmentRules = [
        'name' => 'required|unique:depatments',
        'position' => 'required|integer',
        'status' => 'required',
    ];


    protected $depatmentValidationAttributes = [
        'name' => 'depatment name',
    ];
    // End component variable //

    // Realtime validation //
    public function updatedForm($value)
    {
        if ($this->showEditModal) {
            $rules = $this->depatmentRules;
            $rules['name'] = $rules['name'] . ',name,' . $this->form['id'];
            $rules = array_filter($rules, function ($key) {
                return in_array($key, array_keys($this->form));
            }, ARRAY_FILTER_USE_KEY);
        } else {
            $rules = array_filter($this->depatmentRules, function ($key) {
                return in_array($key, array_keys($this->form));
            }, ARRAY_FILTER_USE_KEY);
        }
        Validator::make($this->form, $rules, [], $this->depatmentValidationAttributes)->validate();
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
        $this->reset(['form', 'showEditModal', 'depatmentIdBegingRemoved', 'depatment']);
    }
    // End Realtime validation //

    // New Depatment //
    public function addNew()
    {
        $this->resetComponentVariables();
        $this->showEditModal = false;
        $this->creater = $this->getCreater();

        $this->dispatchBrowserEvent('show-depatment-form');
    }

    public function createDepatment()
    {
        Validator::make($this->form, $this->depatmentRules, [], $this->depatmentValidationAttributes)->validate();

        $dataRecord = $this->form;

        $dataRecord['created_by'] = auth()->user()->id;

        Depatment::create($dataRecord);

        $this->resetComponentVariables();
        $this->dispatchBrowserEvent('alert-success', ['message' => 'Depatment created successfully.']);
        $this->dispatchBrowserEvent('hide-depatment-form');
    }
    // End New Depatment //

    // Update user //
    public function edit(Depatment $depatment)
    {
        $this->resetComponentVariables();
        $this->showEditModal = true;
        $this->depatment = $depatment;
        $this->form = $depatment->toArray();
        $this->creater = $this->getCreater();
        $this->dispatchBrowserEvent('show-depatment-form');
    }

    public function updateDepatment()
    {
        $rules = $this->depatmentRules;
        $rules['name'] = $rules['name'] . ',name,' . $this->form['id'];

        $validatedData = Validator::make($this->form, $rules, [], $this->depatmentValidationAttributes)->validate();

        $this->depatment->update($this->form);

        $this->resetComponentVariables();

        $this->dispatchBrowserEvent('alert-success', ['message' => 'Depatment updated successfully.']);
        $this->dispatchBrowserEvent('hide-depatment-form');
    }
    // End Update Depatment //

    // Trash user //
    public function confirmTrash(Depatment $depatment)
    {
        $this->resetComponentVariables();
        $this->depatment = $depatment;
        $this->form = $depatment->toArray();
        $this->dispatchBrowserEvent('show-confirm-trash');
    }

    public function putDepatmentToTrash()
    {
        $this->form['name'] = $this->form['name'] . "#d#" . $this->form['id'];
        $this->form['status'] = "DELETED";
        $this->depatment->update($this->form);

        $this->dispatchBrowserEvent('alert-success', ['message' => 'Depatment ID: ' . $this->form['id'] . ', has delete successfully!']);
        $this->resetComponentVariables();
    }
    // End Trash user

    // Remove user //
    public function confirmDepatmentRemoval($depatmentId)
    {
        $this->resetComponentVariables();
        $this->depatmentIdBegingRemoved = $depatmentId;

        $this->dispatchBrowserEvent('show-confirm-delete');
    }

    public function deleteDepatment()
    {
        $depatment = Depatment::findOrFail($this->depatmentIdBegingRemoved);
        $depatment->delete();
        $this->dispatchBrowserEvent('alert-success', ['message' => 'Depatment ID: ' . $this->depatmentIdBegingRemoved . ', has delete successfully!']);
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

    public function updateDepatmentOrder($items)
    {
        // dd($this->page);
        // dd($items);
        foreach($items as $item){
            Depatment::find($item['value'])->update(['position' => (($this->page - 1)* 10) + $item['order']]);
        }
    }


    public function render()
    {        
        if (auth()->user()->isAdmin()) {
            $depatments = Depatment::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('position', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%');
            })        
            ->orderBy('status', 'desc')
            ->orderBy('position', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10);

        }else{
            $depatments = Depatment::query()
            ->where('status', '!=', 'DELETED')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('position', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%');
            })        
            ->orderBy('status', 'desc')
            ->orderBy('position', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10);
        }
      
        return view('livewire.setting.list-depatment',['depatments' => $depatments]);
    }
}
