<?php

namespace App\Livewire\Supplier;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Supplier;

class SupplierIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $name = '';
    public $address = '';
    public $phone = '';
    public $email = '';
    public $editingId = null;
    public $confirmingDelete = false; // Variabel untuk mengontrol dialog konfirmasi
    public $supplierIdToDelete;

    public function render()
    {
        $suppliers = Supplier::where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.supplier.supplier-index', [
            'suppliers' => $suppliers,
        ]);
    }

    public function save()
    {
        // Validasi input
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
        ]);

        // Simpan atau perbarui data supplier
        Supplier::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
            ]
        );

        // Reset form dan tutup modal
        $this->reset(['showModal', 'name', 'address', 'phone', 'email', 'editingId']);
        session()->flash('message', 'Supplier berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        $this->supplierIdToDelete = $id;
        $this->confirmingDelete = true;
    }

    public function delete()
    {
        // Hapus supplier berdasarkan ID yang telah dipilih
        Supplier::destroy($this->supplierIdToDelete);
        $this->confirmingDelete = false;
        $this->supplierIdToDelete = null;
        session()->flash('message', 'Supplier berhasil dihapus.');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->editingId = $supplier->id;
        $this->name = $supplier->name;
        $this->address = $supplier->address;
        $this->phone = $supplier->phone;
        $this->email = $supplier->email;

        $this->showModal = true;
    }
}
