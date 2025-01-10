<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Beranda')]

class Beranda extends Component
{
    public function render()
    {
        return view('livewire.beranda');
    }
}
