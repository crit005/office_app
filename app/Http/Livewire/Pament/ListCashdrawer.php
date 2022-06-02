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
    public $cashdrawer;
    public $cashdrawerIdBegingRemoved = null;
    public $cashdrawerIdBegingClose = null;
    public $search = null;
    public $minDate = null;
    public $maxDate = null;
    public $showNewButton = false;

    protected $cashdrawerRules = [
        'name' => 'required|unique:cashdrawers',
        'month' => 'required|date',
    ];



    protected $cashdrawerValidationAttributes = [
        'month' => 'month',
    ];
    // End component variable //

    // Realtime validation //
    public function updatedForm($value)
    {
        $rules = array_filter($this->cashdrawerRules, function ($key) {
            return in_array($key, array_keys($this->form));
        }, ARRAY_FILTER_USE_KEY);
        if (array_key_exists('month', $this->form)) {
            $this->form['name'] = auth()->user()->id . "#" . date('M-Y', strtotime($this->form['month']));
            $rules['month'] = $rules['month'] . '|after:"' . $this->minDate . '"' . '|before_or_equal:"' . $this->maxDate . '"';
        }
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

    public function mount()
    {
        $this->minDate = $this->getMinDate();
        $this->maxDate = $this->getMaxDate();
    }


    // New Cashdrawer //
    public function addNew()
    {
        $this->minDate = $this->getMinDate();
        $this->maxDate = $this->getMaxDate();
        $this->resetComponentVariables();
        $this->form['name'] = auth()->user()->id . "#" . date('M-Y', strtotime(now()));
        $this->form['month'] = date('M-Y', strtotime(now()));
        $this->dispatchBrowserEvent('show-cashdrawer-form');
    }

    public function createCashdrawer()
    {
        $this->minDate = $this->getMinDate();
        $this->maxDate = $this->getMaxDate();

        $rules = $this->cashdrawerRules;
        $rules['month'] = $rules['month'] . '|after:"' . $this->minDate . '"' . '|before_or_equal:"' . $this->maxDate . '"';
        Validator::make($this->form, $rules, [], $this->cashdrawerValidationAttributes)->validate();

        $dataRecord = $this->form;

        $dataRecord['owner'] = auth()->user()->id;
        $dataRecord['month'] = date("Y-m-01", strtotime($dataRecord['month']));

        Cashdrawer::create($dataRecord);

        $this->resetComponentVariables();
        $this->dispatchBrowserEvent('alert-success', ['message' => 'Cashdrawer created successfully.']);
        $this->dispatchBrowserEvent('hide-cashdrawer-form');
    }
    // End New Cashdrawer //


    public function confirmCloseCashdrawer($id)
    {
        $cashdrawer = Cashdrawer::where('id', '=', $id)->where('owner', '=', auth()->user()->id)->first();
        if (!$cashdrawer) {
            $this->dispatchBrowserEvent('alert-warning', ['message' => "Cashdrawer not found!"]);
            return;
        }
        if ($cashdrawer['status'] == 'CLOSED') {
            $this->dispatchBrowserEvent('alert-info', ['message' => "This cashdrawer cannot bo open again!"]);
            return;
        }
        $this->cashdrawerIdBegingClose = $id;
        $this->dispatchBrowserEvent('show-confirm-close', ['message' => 'You will not be able to opent this cashdrawer again!']);
    }

    public function closeCashdrawer()
    {
        $cashdrawer = Cashdrawer::findOrFail($this->cashdrawerIdBegingClose);
        $cashdrawer->status = 'CLOSED';
        $cashdrawer->update();
        $this->dispatchBrowserEvent('toast', ['title' => "Cashdrawer has closed successfully!"]);
    }

    public function getMinDate()
    {
        $minDate = Cashdrawer::where('owner', '=', auth()->user()->id)->max('month');
        return $minDate = $minDate ? date('M-Y', strtotime($minDate)) : env('MINDATE');
    }

    public function getMaxDate()
    {
        return date('M-Y', strtotime(now()));
    }

    public function render()
    {
        $countCashdrawer = Cashdrawer::where('owner', '=', auth()->user()->id)->where('status', '=', 'OPEN')->count('owner');
        $countCashdrawer > 0 ? $this->showNewButton = false : $this->showNewButton = true;
        // $this->showNewButton = true;

        if (auth()->user()->group_id > 2) {
            $cashdrawers = Cashdrawer::query()
                ->where('owner', '=', auth()->user()->id)
                ->orderBy('status', 'desc')
                ->orderBy('month', 'desc')
                ->paginate(env('PAGINATE'));
        } else {
            $cashdrawers = Cashdrawer::query()
                ->orderBy('status', 'desc')
                ->orderBy('month', 'desc')
                ->paginate(env('PAGINATE'));
        }

        return view('livewire.pament.list-cashdrawer', ['cashdrawers' => $cashdrawers]);
    }
}
