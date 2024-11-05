<?php

namespace App\Livewire\BarangMasuk;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BarangMasuk;
use App\Models\Supplier;

class BarangMasukIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $supplier_id = '';
    public $item_name = '';
    public $quantity = '';
    public $date = '';
    public $editingId = null;
    public $confirmingDelete = false;
    public $barangMasukIdToDelete;
    public $suppliers;

    protected $listeners = ['supplierAdded' => 'getSuppliers'];

    public function mount()
    {
        $this->getSuppliers();
    }

    public function getSuppliers()
    {
        $this->suppliers = Supplier::all();
    }

    public function render()
    {
        $barangMasuks = BarangMasuk::where('item_name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.barang-masuk.barang-masuk-index', [
            'barangMasuks' => $barangMasuks,
        ]);
    }

    public function save()
    {
        // Validasi input
        $this->validate([
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        // Simpan atau perbarui data barang masuk
        BarangMasuk::updateOrCreate(
            ['id' => $this->editingId],
            [
                'supplier_id' => $this->supplier_id,
                'item_name' => $this->item_name,
                'quantity' => $this->quantity,
                'date' => $this->date,
            ]
        );

        // Reset form dan tutup modal
        $this->reset(['showModal', 'supplier_id', 'item_name', 'quantity', 'date', 'editingId']);
        session()->flash('message', 'Data barang masuk berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        $this->barangMasukIdToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function delete()
    {
        BarangMasuk::destroy($this->barangMasukIdToDelete);

        // Reset state setelah menghapus
        $this->confirmingDelete = false;
        $this->barangMasukIdToDelete = null;
        session()->flash('message', 'Data barang masuk berhasil dihapus.');
    }

    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $this->editingId = $barangMasuk->id;
        $this->supplier_id = $barangMasuk->supplier_id;
        $this->item_name = $barangMasuk->item_name;
        $this->quantity = $barangMasuk->quantity;
        $this->date = $barangMasuk->date;

        $this->showModal = true;
    }
}
