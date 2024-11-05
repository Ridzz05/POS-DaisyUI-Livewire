<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Livewire\Component;
use Carbon\Carbon;

class Home extends Component
{
    public function toggleDone(Transaksi $transaksi)
    {
        $transaksi->done = !$transaksi->done;
        $transaksi->save();
    }

    public function render()
    {
        // Mendapatkan tahun, bulan, dan tanggal saat ini
        [$tahun, $bulan] = explode('-', date('Y-m'));
        $today = date('Y-m-d');

        // Query transaksi bulanan
        $transaksi = Transaksi::whereMonth('created_at', $bulan)->whereYear('created_at', $tahun);

        // Hitung pendapatan bulan ini, hari ini, dan bulan lalu
        $monthly = $transaksi->sum('price');
        $todaySales = $transaksi->whereDate('created_at', $today)->get();
        $previousMonth = Transaksi::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('price');

        // Data untuk chart (statistik penjualan per hari dalam bulan ini)
        $chartLabels = [];
        $chartData = [];
        $daysInMonth = Carbon::createFromDate($tahun, $bulan)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($tahun, $bulan, $day)->toDateString();
            $dailySales = Transaksi::whereDate('created_at', $date)->sum('price');

            $chartLabels[] = $day; // Menambahkan hari ke label chart
            $chartData[] = $dailySales; // Menambahkan pendapatan harian ke data chart
        }

        return view('livewire.home', [
            'monthly' => $monthly,
            'today' => $todaySales,
            'previousMonth' => $previousMonth,
            'datas' => Transaksi::where('done', false)->get(),
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
    }
}
    