<?php

namespace App\Livewire\Partials;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public $activeRoute;

    public function mount()
    {
        // Mengatur rute aktif saat komponen di-mount
        $this->activeRoute = request()->route()->getName();
    }

    public function logout()
    {
        Auth::logout();
        // Setelah logout, arahkan kembali ke halaman login menggunakan Livewire
        $this->dispatchBrowserEvent('logout-success'); // Menandakan bahwa logout berhasil
    }

    public function render()
    {
        return view('livewire.partials.sidebar', [
            'activeRoute' => $this->activeRoute,
        ]);
    }
}
