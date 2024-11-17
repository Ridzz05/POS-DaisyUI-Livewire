<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Home extends Component
{
    public function toggleDone(Transaksi $transaksi)
    {
        $transaksi->done = !$transaksi->done;
        $transaksi->save();
    }

    public function render()
    {
        $timezone = 'Asia/Jakarta';
        $currentDate = Carbon::now($timezone);
        
        // Data bulanan
        $monthlyData = Transaksi::whereYear('created_at', $currentDate->year)
            ->whereMonth('created_at', $currentDate->month)
            ->selectRaw('COUNT(*) as total_transactions, COALESCE(SUM(price), 0) as total_revenue')
            ->first();

        // Data hari ini
        $todayData = Transaksi::whereDate('created_at', $currentDate->toDateString())
            ->selectRaw('COUNT(*) as total_transactions, COALESCE(SUM(price), 0) as total_revenue')
            ->first();

        // Transaksi pending
        $pendingTransactions = Transaksi::where('done', false)
            ->with('customer')
            ->latest()
            ->get();

        // Pesanan hari ini
        $todayOrders = Transaksi::whereDate('created_at', $currentDate->toDateString())->count();

        return view('livewire.home', [
            'monthly' => $monthlyData->total_revenue ?? 0,
            'monthlyCount' => $monthlyData->total_transactions ?? 0,
            'today' => collect([
                'revenue' => $todayData->total_revenue ?? 0,
                'count' => $todayData->total_transactions ?? 0,
                'orders' => $todayOrders
            ]),
            'datas' => $pendingTransactions,
        ]);
    }
}