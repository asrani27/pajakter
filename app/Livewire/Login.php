<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('Login')]

class Login extends Component
{
    #[Rule('required')]
    public string $username = '';

    #[Rule('required')]
    public string $password = '';

    public function login()
    {
        $this->validate();

        if (Auth::attempt($this->validate())) {
            return redirect()->route('beranda');
        }

        session()->flash('error', 'Invalid credentials.');
    }
    public function render()
    {
        return view('livewire.login');
    }
}
