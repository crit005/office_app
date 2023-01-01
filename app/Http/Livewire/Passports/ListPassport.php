<?php

namespace App\Http\Livewire\Passports;

use Livewire\Component;

class ListPassport extends Component
{
    public $form =[];
    // return is-valid class to inform the field is valid
    public function getValidClass(String $fieldName)
    {
        return array_key_exists($fieldName, $this->form) ? 'is-valid' : '';
    }

    public function render()
    {
        return view('livewire.passports.list-passport');
    }
}
