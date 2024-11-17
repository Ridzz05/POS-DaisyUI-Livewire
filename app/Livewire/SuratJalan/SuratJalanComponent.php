<?php

namespace App\Livewire\SuratJalan;

use App\Models\SuratJalan;
use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class SuratJalanComponent extends Component
{
    use WithPagination;

    public $nomor_surat, $tanggal, $customer_id, $alamat, $barang = [], $keterangan;
    public $showModal = false;
    public $editingId = null;
    public $confirmingDelete = false;
    public $deleteId = null;

    protected function rules()
    {
        return [
            'nomor_surat' => 'required|unique:surat_jalans,nomor_surat,' . $this->editingId,
            'tanggal' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'alamat' => 'required',
            'barang' => 'required|array|min:1',
            'barang.*' => 'required|string', // Validasi tiap elemen barang
            'keterangan' => 'nullable|string',
        ];
    }
    

    public function render()
    {
        $customers = Customer::all();
        $suratjalans = SuratJalan::paginate(10);

        return view('livewire.surat-jalan.component', compact('suratjalans', 'customers'));
    }

    public function print($id)
    {
        $suratJalan = SuratJalan::findOrFail($id);
        return redirect()->route('surat-jalan.print', ['id' => $suratJalan->id]);
    }


    public function create()
    {
        $this->resetInputFields();
        $this->editingId = null;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $suratJalan = SuratJalan::findOrFail($id);
        $this->editingId = $suratJalan->id;
        $this->nomor_surat = $suratJalan->nomor_surat;
        $this->tanggal = $suratJalan->tanggal;
        $this->customer_id = $suratJalan->customer_id;
        $this->alamat = $suratJalan->alamat;
        $this->barang = $suratJalan->barang; // sudah di-cast sebagai array
        $this->keterangan = $suratJalan->keterangan;
        $this->showModal = true;
    }

    public function save()
{
    $this->validate();

    // Debugging untuk memastikan `barang` berbentuk array
    logger($this->barang);

    if ($this->editingId) {
        $suratJalan = SuratJalan::find($this->editingId);
        $suratJalan->update([
            'nomor_surat' => $this->nomor_surat,
            'tanggal' => $this->tanggal,
            'customer_id' => $this->customer_id,
            'alamat' => $this->alamat,
            'barang' => $this->barang,
            'keterangan' => $this->keterangan,
        ]);
        session()->flash('message', 'Surat Jalan berhasil diperbarui.');
    } else {
        SuratJalan::create([
            'nomor_surat' => $this->nomor_surat,
            'tanggal' => $this->tanggal,
            'customer_id' => $this->customer_id,
            'alamat' => $this->alamat,
            'barang' => $this->barang,
            'keterangan' => $this->keterangan,
        ]);
        session()->flash('message', 'Surat Jalan berhasil ditambahkan.');
    }

    $this->resetInputFields();
    $this->showModal = false;
}


    public function addBarang()
    {
    $this->barang[] = ''; // Menambahkan item kosong ke array barang
    }



    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->nomor_surat = '';
        $this->tanggal = '';
        $this->customer_id = '';
        $this->alamat = '';
        $this->barang = [];
        $this->keterangan = '';
        $this->editingId = null;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = true;
        $this->deleteId = $id;
    }

    public function delete()
    {
        if ($this->deleteId) {
            $suratJalan = SuratJalan::find($this->deleteId);
            $suratJalan->delete();
            session()->flash('message', 'Surat Jalan berhasil dihapus.');
            $this->confirmingDelete = false;
            $this->deleteId = null;
        }
    }
}
