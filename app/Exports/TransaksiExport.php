<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiExport implements FromView
{
    public $month;
    public $year;

    // Constructor
    public function __construct($bulan) // data yang dibawa 2024-05 (misalkan)
    {
        // Memastikan format bulan sesuai
        if (strpos($bulan, '-') !== false) {
            // explode digunakan untuk memecah string menjadi array
            [$this->year, $this->month] = explode('-', $bulan);
        } else {
            throw new \Exception("Format bulan tidak valid. Harus dalam format YYYY-MM.");
        }
    }

    public function view(): View
    {
        // Menyaring data berdasarkan tahun dan bulan yang sudah diparsing
        $transaksis = Transaksi::whereYear('created_at', $this->year)
                                ->whereMonth('created_at', $this->month)
                                ->get();

        // Mengembalikan tampilan untuk eksport
        return view('export.transaksi', [
            'transaksis' => $transaksis
        ]);
    }
}
