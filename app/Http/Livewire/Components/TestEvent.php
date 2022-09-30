<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class TestEvent extends Component
{
    public function doTest()
    {
        // dd('testevent');
        $this->emit('dotest','testvar','ff');

    }
    public function render()
    {
        return view('livewire.components.test-event');
    }
}
