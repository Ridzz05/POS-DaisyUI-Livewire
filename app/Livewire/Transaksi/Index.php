<?php

namespace App\Livewire\Transaksi;

use App\Models\Transaksi;
use Livewire\Component;

class Index extends Component
{

    public $date;
    public $totalPenjualan;

    //function toggle change
    public function toggleDone(Transaksi $transaksi)
    {
        //change done value
        $transaksi->done = !$transaksi->done;
        //save
        $transaksi->save();

        // Recalculate total penjualan
        $this->calculateTotalPenjualan();
    }

    //ketika halaman dijalankan akan set tanggal hari ini dengan function mount
    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->calculateTotalPenjualan();
    }

    //function deleteTransaksi
    public function deleteTransaksi(Transaksi $transaksi)
    {
        //delete
        $transaksi->delete();

        // Recalculate total penjualan
        $this->calculateTotalPenjualan();
    }

    public function calculateTotalPenjualan()
    {
        $this->totalPenjualan = Transaksi::when($this->date, function ($query) {
            $query->whereDate('created_at', $this->date);
        })->sum('price');
    }

    public function render()
    {
        $transaksis = Transaksi::when($this->date, function ($query) {
            $query->whereDate('created_at', $this->date);
        })->latest()->get();

        return view('livewire.transaksi.index', [
            'transaksis' => $transaksis,
            'totalPenjualan' => $this->totalPenjualan,
        ]);
    }

    public function getTotalPenjualan($transaksis)
    {
        return $transaksis->sum('price');
    }
}
