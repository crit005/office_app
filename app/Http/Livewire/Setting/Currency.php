<?php

namespace App\Http\Livewire\Setting;

use App\Models\Currency as ModelsCurrency;
use Livewire\Component;
use Livewire\WithPagination;

class Currency extends Component
{
    use WithPagination;

    public function render()
    {
        $currencies = ModelsCurrency::query()->where('status','=','ENABlED')->paginate(10);
        return view('livewire.setting.currency',['currencies'=>$currencies]);
    }
}
