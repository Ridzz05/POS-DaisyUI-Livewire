<?php

namespace App\Livewire\Transaksi;

use App\Models\Transaksi;
use Livewire\Component;

class Index extends Component
{

    public $date;

    //function toggle change
    public function toggleDone(Transaksi $transaksi)
    {
        //change done value
        $transaksi->done = !$transaksi->done;
        //save
        $transaksi->save();
    }

    //ketika halaman dijalankan akan set tanggal hari ini dengan function mount
    public function mount()
    {
        $this->date = now()->format('Y-m-d');
    }

    //function deleteTransaksi
    public function deleteTransaksi(Transaksi $transaksi)
    {
        //delete
        $transaksi->delete();
    }


    public function render()
    {
        return view('livewire.transaksi.index', [
            'transaksis' => Transaksi::when($this->date, function ($transaksi) {
                $transaksi->whereDate('created_at', $this->date);
            })->latest()->get()
        ]);
    }
}
