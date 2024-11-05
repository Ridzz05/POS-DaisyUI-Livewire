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
    //constructor
    public function __construct($bulan) //data yang dibawa 2024-05 (misalkan)
    {
        //explode digunakan untuk memecah string menjadi array
        [$this->year, $this->month] = explode('-', $bulan);

        dd($this->month);
        dd($this->year);
    }
    public function view(): View
    {
        return view('export.transaksi', [
            'transaksis' => Transaksi::whereYear('created_at', $this->year)->whereMonth('created_at', $this->month)->get()
        ]);
    }
}
