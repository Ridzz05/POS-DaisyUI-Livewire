<?php

namespace App\Livewire\Partials;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
        //atau
        // $this->redirect(route('login'), true);
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
