<?php

namespace App\Http\Livewire\Setting;

use App\Models\Items;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListItems extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Component variable //
    protected $paginationTheme = 'bootstrap';

    public $form = [];
    public $showEditModal = false;
    public $item;
    public $itemIdBegingRemoved = null;
    public $search = null;
    public $creater = null;

    protected $itemRules = [
        'name' => 'required|unique:items',
        'position' => 'required|integer',
        'status' => 'required',
    ];


    protected $itemValidationAttributes = [
        'name' => 'item name',
    ];
    // End component variable //

    // Realtime validation //
    public function updatedForm($value)
    {
        if ($this->showEditModal) {
            $rules = $this->itemRules;
            $rules['name'] = $rules['name'] . ',name,' . $this->form['id'];
            $rules = array_filter($rules, function ($key) {
                return in_array($key, array_keys($this->form));
            }, ARRAY_FILTER_USE_KEY);
        } else {
            $rules = array_filter($this->itemRules, function ($key) {
                return in_array($key, array_keys($this->form));
            }, ARRAY_FILTER_USE_KEY);
        }
        Validator::make($this->form, $rules, [], $this->itemValidationAttributes)->validate();
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
        $this->reset(['form', 'showEditModal', 'itemIdBegingRemoved', 'item']);
    }
    // End Realtime validation //

    // New Item //
    public function addNew()
    {
        $this->resetComponentVariables();
        $this->showEditModal = false;
        $this->creater = $this->getCreater();

        $this->dispatchBrowserEvent('show-item-form');
    }

    public function createItem()
    {
        Validator::make($this->form, $this->itemRules, [], $this->itemValidationAttributes)->validate();

        $dataRecord = $this->form;

        $dataRecord['created_by'] = auth()->user()->id;

        Items::create($dataRecord);

        $this->resetComponentVariables();
        $this->dispatchBrowserEvent('alert-success', ['message' => 'Item created successfully.']);
        $this->dispatchBrowserEvent('hide-item-form');
    }
    // End New Item //

    // Update user //
    public function edit(Items $item)
    {
        $this->resetComponentVariables();
        $this->showEditModal = true;
        $this->item = $item;
        $this->form = $item->toArray();
        $this->creater = $this->getCreater();
        $this->dispatchBrowserEvent('show-item-form');
    }

    public function updateItem()
    {
        $rules = $this->itemRules;
        $rules['name'] = $rules['name'] . ',name,' . $this->form['id'];

        Validator::make($this->form, $rules, [], $this->itemValidationAttributes)->validate();

        $this->item->update($this->form);

        $this->resetComponentVariables();

        $this->dispatchBrowserEvent('alert-success', ['message' => 'Item updated successfully.']);
        $this->dispatchBrowserEvent('hide-item-form');
    }
    // End Update Item //

    // Trash user //
    public function confirmTrash(Items $item)
    {
        $this->resetComponentVariables();
        $this->item = $item;
        $this->form = $item->toArray();
        $this->dispatchBrowserEvent('show-confirm-trash');
    }

    public function putItemToTrash()
    {
        $this->form['name'] = $this->form['name'] . "#d#" . $this->form['id'];
        $this->form['status'] = "DELETED";
        $this->item->update($this->form);

        $this->dispatchBrowserEvent('alert-success', ['message' => 'Item ID: ' . $this->form['id'] . ', has delete successfully!']);
        $this->resetComponentVariables();
    }
    // End Trash user

    // Remove user //
    public function confirmItemRemoval($itemId)
    {
        $this->resetComponentVariables();
        $this->itemIdBegingRemoved = $itemId;

        $this->dispatchBrowserEvent('show-confirm-delete');
    }

    public function deleteItem()
    {
        $item = Items::findOrFail($this->itemIdBegingRemoved);
        $item->delete();
        $this->dispatchBrowserEvent('alert-success', ['message' => 'Item ID: ' . $this->itemIdBegingRemoved . ', has delete successfully!']);
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

    public function updateItemOrder($items)
    {
        foreach($items as $item){
            Items::find($item['value'])->update(['position' => (($this->page - 1)* env('PAGINATE')) + $item['order']]);
        }

        $this->dispatchBrowserEvent('toast',["title"=>"Item reposition are successfully!"]);
    }

    public function togleStatus($id)
    {
        $item = Items::findOrFail($id);
        $item->status = $item->status == 'ENABLED'? 'DISABLED':'ENABLED';
        $item->update();
        $this->dispatchBrowserEvent('toast', ['message' => "Item status updated successfully!"]);
    }

    public function render()
    {
        if (auth()->user()->isAdmin()) {
            $items = Items::query()
            ->where('status', '!=', 'SYSTEM')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('position', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%');
            })
            ->orderBy('status', 'desc')
            ->orderBy('position', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(env('PAGINATE'));

        }else{
            $items = Items::query()
            ->where('status', '!=', 'DELETED')
            ->where('status', '!=', 'SYSTEM')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('position', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%');
            })
            ->orderBy('status', 'desc')
            ->orderBy('position', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(env('PAGINATE'));
        }

        return view('livewire.setting.list-items',['items' => $items]);
    }
}
