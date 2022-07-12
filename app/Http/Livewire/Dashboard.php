<?php

namespace App\Http\Livewire;

use App\Models\ConnectionName;
use Livewire\Component;

class Dashboard extends Component
{
    public $connections =null;

    public function mount()
    {
        $this->connections = ConnectionName::where('id','=','1')->get();
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
