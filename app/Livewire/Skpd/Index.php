<?php

namespace App\Livewire\Skpd;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Skpd')]

class Index extends Component
{
    public function render()
    {
        return view('livewire.skpd.index');
    }
}
