<?php

namespace App\Livewire\Stok;

use App\Models\Stock;
use Livewire\Component;
use Livewire\WithPagination;

class StockManagement extends Component
{
    use WithPagination;

    public $nama_barang;
    public $kode_barang;
    public $jumlah;
    public $harga_beli;
    public $harga_jual;
    public $deskripsi;
    public $status = 'tersedia';
    public $supplier_id;
    public $search = '';
    public $showModal = false;
    public $editingId = null;
    public $confirmingDelete = false;

    protected $rules = [
        'nama_barang' => 'required|min:3',
        'kode_barang' => 'required|unique:stok,kode_barang',
        'jumlah' => 'required|integer|min:0',
        'harga_beli' => 'required|numeric|min:0',
        'harga_jual' => 'required|numeric|min:0',
        'deskripsi' => 'nullable',
        'status' => 'required|in:tersedia,menipis,habis',
        'supplier_id' => 'nullable|exists:suppliers,id'
    ];

    public function render()
    {
        $stocks = Stock::where('nama_barang', 'like', '%' . $this->search . '%')
            ->orWhere('kode_barang', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.stok.stok', [
            'stocks' => $stocks
        ]);
    }

    public function save()
    {
        $this->validate();

        Stock::create([
            'nama_barang' => $this->nama_barang,
            'kode_barang' => $this->kode_barang,
            'jumlah' => $this->jumlah,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'deskripsi' => $this->deskripsi,
            'status' => $this->status,
            'supplier_id' => $this->supplier_id,
        ]);

        $this->resetFields();
        session()->flash('message', 'Stok berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        $this->editingId = $id;
        $this->nama_barang = $stock->nama_barang;
        $this->kode_barang = $stock->kode_barang;
        $this->jumlah = $stock->jumlah;
        $this->harga_beli = $stock->harga_beli;
        $this->harga_jual = $stock->harga_jual;
        $this->deskripsi = $stock->deskripsi;
        $this->status = $stock->status;
        $this->supplier_id = $stock->supplier_id;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'nama_barang' => 'required|min:3',
            'kode_barang' => 'required|unique:stok,kode_barang,' . $this->editingId,
            'jumlah' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'deskripsi' => 'nullable',
            'status' => 'required|in:tersedia,menipis,habis',
            'supplier_id' => 'nullable|exists:suppliers,id'
        ]);

        $stock = Stock::findOrFail($this->editingId);
        $stock->update([
            'nama_barang' => $this->nama_barang,
            'kode_barang' => $this->kode_barang,
            'jumlah' => $this->jumlah,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'deskripsi' => $this->deskripsi,
            'status' => $this->status,
            'supplier_id' => $this->supplier_id,
        ]);

        $this->resetFields();
        session()->flash('message', 'Stok berhasil diperbarui.');
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->editingId = $id;
    }

    public function delete()
    {
        Stock::findOrFail($this->editingId)->delete();
        session()->flash('message', 'Stok berhasil dihapus.');
        $this->confirmingDelete = false;
        $this->editingId = null;
    }

    private function resetFields()
    {
        $this->nama_barang = '';
        $this->kode_barang = '';
        $this->jumlah = '';
        $this->harga_beli = '';
        $this->harga_jual = '';
        $this->deskripsi = '';
        $this->status = 'tersedia';
        $this->supplier_id = null;
        $this->showModal = false;
        $this->editingId = null;
    }
}
