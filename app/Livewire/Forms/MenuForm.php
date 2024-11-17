<?php

namespace App\Livewire\Forms;

use App\Models\Menu;
use Livewire\Form;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class MenuForm extends Form
{
    use WithFileUploads;

    public $name;
    public $price;
    public $desc;
    public $type;
    public $stock;
    public $availability;
    public $photo;
    public ?Menu $menu = null;

    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required',
            'desc' => 'nullable',
            'stock' => 'required|numeric|min:0',
            'availability' => 'required|in:tersedia,tidak_tersedia',
            'photo' => 'nullable|image|max:1024',
        ];
    }

    public function setMenu(Menu $menu)
    {
        $this->menu = $menu;
        $this->name = $menu->name;
        $this->price = $menu->price;
        $this->type = $menu->type;
        $this->desc = $menu->desc;
        $this->stock = $menu->stock;
        $this->availability = $menu->availability;
        $this->photo = null;
    }

    public function store()
    {
        $validatedData = $this->validate();

        if ($this->photo) {
            $validatedData['photo'] = $this->photo->storeAs(
                'menu', 
                date('YmdHis') . '_' . str_replace(' ', '_', $this->photo->getClientOriginalName()), 
                'public'
            );
        }

        Menu::create($validatedData);
        $this->reset();
    }

    public function update()
    {
        $validatedData = $this->validate();

        if ($this->photo) {
            // Hapus foto lama jika ada
            if ($this->menu->photo) {
                Storage::disk('public')->delete($this->menu->photo);
            }

            // Simpan foto baru dengan format: menu/TIMESTAMP_namafile.ekstensi
            $validatedData['photo'] = $this->photo->storeAs(
                'menu', 
                date('YmdHis') . '_' . str_replace(' ', '_', $this->photo->getClientOriginalName()), 
                'public'
            );
        } else {
            $validatedData['photo'] = $this->menu->photo;
        }

        $this->menu->update($validatedData);
        $this->reset();
    }

    public function reset(...$properties)
    {
        $this->menu = null;
        parent::reset(...$properties);
    }
}