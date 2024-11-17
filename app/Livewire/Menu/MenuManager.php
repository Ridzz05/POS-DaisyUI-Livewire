<?php

namespace App\Livewire\Menu;

use App\Livewire\Forms\MenuForm;
use App\Models\Menu;
use App\Models\Stock;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

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
        $this->form->reset(); // Reset form saat membuat menu baru
    }

    // Function simpan pada wire:submit action
    public function simpan()
    {
        // Validasi foto yang diupload
        $this->validate([
            'photo' => 'nullable|image|max:1024',
        ]);

        // Simpan foto jika ada
        if ($this->photo) {
            // Hapus foto lama jika ada
            if (isset($this->form->menu) && $this->form->menu->photo) {
                Storage::disk('public')->delete($this->form->menu->photo);
            }
            
            // Simpan foto baru
            $foto_name = $this->photo->storeAs('menu', time() . '_' . $this->photo->getClientOriginalName(), 'public');
        }

        if (isset($this->form->menu)) {
            // Update menu
            $this->form->update();
            if ($this->photo) {
                $this->form->menu->photo = $foto_name;
                $this->form->menu->save();
            }
        } else {
            // Simpan menu baru
            Menu::create([
                'name' => $this->form->name,
                'price' => $this->form->price,
                'desc' => $this->form->desc,
                'type' => $this->form->type,
                'stock' => $this->form->stock,
                'availability' => $this->form->availability,
                'photo' => $foto_name ?? null,
            ]);
        }

        $this->closeModal();
        $this->dispatch('reload');
    }

    // Dispatch edit data dari menu index
    #[On('editMenu')]
    public function editMenu(Menu $menu)
    {
        $this->form->setMenu($menu);
        $this->show = true;
        $this->photo = null; // Reset photo untuk editing
    }

    // Dispatch delete data dari menu index
    #[On('deleteMenu')]
    public function deleteMenu(Menu $menu)
    {
        // Hapus foto dari storage jika ada
        if ($menu->photo) {
            Storage::disk('public')->delete($menu->photo); // Perbaikan: gunakan disk public saja
        }

        $menu->delete();
        $this->dispatch('reload');
    }

    // Tutup modal
    public function closeModal()
    {
        $this->show = false;
        $this->photo = null; // Reset photo
        $this->form->reset(); // Reset semua form
    }

    public function render()
    {
        $menus = Menu::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('type', 'like', '%' . $this->search . '%')
                  ->orWhere('desc', 'like', '%' . $this->search . '%');
        })->get();

        return view('livewire.menu.menu', [
            'menus' => $menus,
            'types' => Menu::$types,
            'stocks' => Stock::where('status', 'tersedia')->get()
        ]);
    }
}
