<?php

namespace App\Livewire\Transaksi;

use App\Models\Transaksi;
use Livewire\Component;

class Cetak extends Component
{
    public Transaksi $transaksi;

    //mount pertama untuk mengambil nilai transaksi yang dipilih (id), sesuai dengan web routes
    public function mount(Transaksi $transaksi)
    {
        //untuk mengambil nilai transaksi
        $this->transaksi = $transaksi;
    }

    public function render()
    {
        return view('livewire.transaksi.cetak');
    }
}
