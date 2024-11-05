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
    public $type = 'coffee';
    public $photo;
    public ?Menu $menu = null;

    // Set menu name
    public function setMenu(Menu $menu)
    {
        $this->menu = $menu;
        $this->name = $menu->name;
        $this->price = $menu->price;
        $this->type = $menu->type;
        $this->desc = $menu->desc;
        $this->photo = null; // Reset photo for editing
    }

    // Function to save data
    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required',
            'desc' => 'nullable',
            'photo' => 'nullable|image|max:1024', // Validate image size (1MB max)
        ]);

        // Upload and save photo if available
        if ($this->photo) {
            $validatedData['photo'] = $this->photo->store('menu', 'public'); // Store in 'menu' directory
        }

        // Create the menu
        Menu::create($validatedData);

        // Reset the form
        $this->resetForm(); // Reset all relevant fields after saving
    }

    // Function to update data
    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required',
            'desc' => 'nullable',
            'photo' => 'nullable|image|max:1024', // Validate image size (1MB max)
        ]);

        // Check if a new photo has been uploaded
        if ($this->photo) {
            // Store new photo and delete the old one if exists
            $validatedData['photo'] = $this->photo->store('menu', 'public'); // Store in 'menu' directory
            
            // Optionally delete the old photo if it exists
            if ($this->menu->photo && Storage::disk('public')->exists($this->menu->photo)) {
                Storage::disk('public')->delete($this->menu->photo);
            }
        } else {
            // If no new photo, retain the old photo
            $validatedData['photo'] = $this->menu->photo;
        }

        // Update the menu data
        $this->menu->update($validatedData);

        // Reset the form
        $this->resetForm(); // Reset all relevant fields after updating
    }

    // Reset form fields
    protected function resetForm()
    {
        $this->reset(['name', 'price', 'desc', 'type', 'photo']); // Reset relevant fields
    }
}
