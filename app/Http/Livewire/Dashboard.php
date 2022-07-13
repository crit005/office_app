<?php

namespace App\Http\Livewire;

use App\Models\ConnectionName;
use Livewire\Component;

class Dashboard extends Component
{
    public $connections =null;

    public function mount()
    {
        // $this->connections = ConnectionName::where('id','=','1')->get();
        $this->connections = ConnectionName::where('status','=','ENABLED')->get();

    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
