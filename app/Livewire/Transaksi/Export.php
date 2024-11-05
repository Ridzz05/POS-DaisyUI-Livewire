<?php

namespace App\Livewire\Transaksi;

use App\Exports\TransaksiExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Export extends Component
{
    // model, ketika wire : model="bulan"
    public $bulan;

    public function export()
    {
        //validate bulan
        $this->validate([
            'bulan' => 'required',
        ]);

        return Excel::download(new TransaksiExport($this->bulan), "laporan-transaksi-{$this->bulan}.xlsx");
    }
    public function render()
    {
        return view('livewire.transaksi.export');
    }
}
