<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email = 'admin@example.com';
    public $password = 'password123';
    public $remember = false;
    public $errorMessage;

    public function login()
    {
        $valid = $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($valid, $this->remember)) {
            $this->redirect(route('home'), true);
        } else {
            $this->errorMessage = 'Email atau password salah';
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
