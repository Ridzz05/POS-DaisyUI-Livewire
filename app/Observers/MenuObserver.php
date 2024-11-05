<?php

namespace App\Observers;

use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class MenuObserver
{
    /**
     * Handle the Menu "created" event.
     */
    public function created(Menu $menu): void
    {
        //
    }

    /**
     * Handle the Menu "updated" event.
     */
    public function updated(Menu $menu): void
    {
        // Ketika data diupdate, hapus foto lama jika ada
        if ($menu->getOriginal('photo') && $menu->getOriginal('photo') !== $menu->photo) {
            Storage::disk('public')->delete($menu->getOriginal('photo'));
        }
    }

    /**
     * Handle the Menu "deleted" event.
     */
    public function deleting(Menu $menu): void
    {
        // Hapus foto dari Storage jika data dihapus
        if ($menu->photo) {
            Storage::disk('public')->delete($menu->photo);
        }
    }

    /**
     * Handle the Menu "restored" event.
     */
    public function restored(Menu $menu): void
    {
        //
    }

    /**
     * Handle the Menu "force deleted" event.
     */
    public function forceDeleted(Menu $menu): void
    {
        //
    }
}
