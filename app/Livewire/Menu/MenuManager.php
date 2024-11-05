<?php

namespace App\Livewire\Menu;

use App\Livewire\Forms\MenuForm;
use App\Models\Menu;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage; // Pastikan untuk mengimpor namespace Storage

class MenuManager extends Component
{
    public MenuForm $form;
    public $photo;
    public $show = false;
    public $search;
    
    use WithFileUploads;

    // Dispatch reload
    protected $listeners = ['reload' => '$refresh'];

    // Dispatch ketika button add diklik
    #[On('createMenu')]
    public function createMenu()
    {
        $this->show = true;
        $this->form->reset(); // Reset the form when creating a new menu
    }

    // Function simpan pada wire:submit action
    public function simpan()
    {
        // Validasi foto yang diupload
        $this->validate([
            'photo' => 'nullable|image|max:1024', // Validasi gambar (1MB max)
        ]);
    
        // Simpan foto jika ada
        if ($this->photo) {
            // Simpan foto ke storage dan dapatkan nama file
            $foto_name = $this->photo->store('menu', 'public'); // Simpan di public/menu
        }
    
        // Jika ada menu yang sedang diedit
        if (isset($this->form->menu)) {
            // Update menu
            $this->form->update();
            // Jika foto diupload, pastikan untuk memperbarui nama foto di menu
            if ($this->photo) {
                // Hapus foto lama dari storage
                if ($this->form->menu->photo) {
                    Storage::disk('public')->delete($this->form->menu->photo);
                }
                // Update foto baru
                $this->form->menu->photo = $foto_name; // Gunakan nama file yang disimpan
                $this->form->menu->save(); // Simpan perubahan pada menu
            }
        } else {
            // Store new menu
            Menu::create([
                'name' => $this->form->name,
                'price' => $this->form->price,
                'desc' => $this->form->desc,
                'type' => $this->form->type,
                'photo' => isset($foto_name) ? $foto_name : null, // Pastikan foto_name ada
            ]);
        }
    
        // Tutup modal dan reload data
        $this->closeModal();
        $this->dispatch('reload');
    }
    

    // Dispatch edit data dari menu index
    #[On('editMenu')]
    public function editMenu(Menu $menu)
    {
        $this->form->setMenu($menu);
        $this->show = true;
        $this->photo = null; // Reset photo for editing
    }

    // Dispatch delete data dari menu index
    #[On('deleteMenu')]
    public function deleteMenu(Menu $menu)
    {
        // Hapus foto dari storage jika ada
        if ($menu->photo) {
            Storage::disk('public/menu')->delete($menu->photo);
        }

        $menu->delete();
        $this->dispatch('reload');
    }

    // Close modal
    public function closeModal()
    {
        $this->show = false;
        $this->photo = null; // Reset photo
        $this->form->reset(); // Reset all form
    }

    public function render()
    {
        // Query menus with search functionality
        $menus = Menu::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('type', 'like', '%' . $this->search . '%')
                  ->orWhere('desc', 'like', '%' . $this->search . '%');
        })->get();

        return view('livewire.menu.menu', [
            'menus' => $menus,
            'types' => Menu::$types // static menu $types pada model
        ]);
    }
}
