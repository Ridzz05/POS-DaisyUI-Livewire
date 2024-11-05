<?php

namespace App\Livewire\Customer;

use App\Livewire\Forms\CustomerForm;
use App\Models\Customer;
use App\Models\Menu;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Actions extends Component
{
    //ambil menu form yang telah dibuat
    public CustomerForm $form;

    //attribute photo untuk menyimpan file upload
    public $photo;

    // attribute show untuk menampilkan modal, dengan default false
    public $show = false;

    //with file upload dari livewire
    use WithFileUploads;

    //dispatch ketika button add diclick pada blade menggunakan wire:click
    #[On('createCustomer')]
    public function createCustomer()
    {
        // ketika button di click show akan bernilai 'true'
        $this->show = true;
    }

    // function simpan pada wire:submit action
    public function simpan()
    {
        if (isset($this->form->customer)) {
            // jika membawa data maka lakukan update
            $this->form->update();
        } else {
            // jika data kosong maka lakukan store
            $this->form->store();
        }

        $this->closeModal();

        // ketika data sudah selesai ditambah/diupdate maka reload data (refresh web), edit juga pada Menu.index Livewire
        // untuk melakukan dispatch reload
        $this->dispatch('reload');
    }

    // dispatch edit data dari menu index
    #[On('editCustomer')]
    public function editCustomer(Customer $customer)
    {
        //data diambil dari setMenu di MenuForm
        $this->form->setCustomer($customer);
        //show modal
        $this->show = true;
    }

    // dispatch delete data dari menu index
    #[On('deleteCustomer')]
    public function deleteCustomer(Customer $customer)
    {
        $customer->delete();

        // reload data
        $this->dispatch('reload');
    }

    //close modal
    public function closeModal()
    {
        $this->show = false;
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.customer.actions');
    }
}
