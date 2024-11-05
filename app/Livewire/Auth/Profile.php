<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;

class Profile extends Component
{
    // lakukan public property deklarasi
    public $name;
    public $email;
    public $password;

    //variable user dari atribut yang ada pada model user
    public ?User $user;

    // function mount untuk mendapatkan data user yang sedang login -> pada edit profile
    public function mount()
    {
        // user yang sedang login
        $user = auth()->user();

        //ambil nilai dari user id
        $this->user = User::find(auth()->id());
        //ambil nilai dari user nama
        $this->name = $user->name;
        //ambil nilai dari user email
        $this->email = $user->email;
    }

    //function simpan data user
    public function simpan()
    {
        //buat validation input ubah data
        $valid = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'min:8',
        ]);

        //password checker update
        if (!isset($this->password)) {
            unset($valid['password']);
        }

        //update data baru dari form
        $this->user->update($valid);

        //setelah update data lalu di reset pada name, email, dan password
        $this->reset();

        //lalu jalankan mount untuk get data user yang sedang login
        $this->mount();
    }

    public function render()
    {
        return view('livewire.auth.profile');
    }
}
