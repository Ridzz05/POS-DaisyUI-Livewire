<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    // agar tidak mengisi 1 1 lagi, isi default value
    public $email = 'admin@example.com';
    public $password = 'password123';
    public $errorMessage;

    //function login
    public function login()
    {
        //validasi input
        $valid = $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //cek apakah email dan password benar
        if (Auth::attempt($valid)) {
            $this->redirect(route('home'), true);
        } else {
            // Set pesan error
            $this->errorMessage = 'Email atau password salah';
        }
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
