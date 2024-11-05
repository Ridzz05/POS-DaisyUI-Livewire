<?php

namespace App\Models;

use App\Observers\MenuObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

// Observer
#[ObservedBy([MenuObserver::class])]
class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'desc',
        'type',
        'photo',
    ];

    // Helper untuk format harga
    public function getHargaAttribute()
    {
        return 'Rp. ' . number_format($this->price, 0, ',', '.');
    }

    // Static data type
    public static $types = [
        'Wet Food Kemasan',
        'Wet Food Kaleng',
        'Wet Food Sachet',
        'Dry Food Kemasan',
        'Dry Food Kaleng',
        'Dry Food Sachet',        
    ];

    // Akses gambar
    public function getGambarAttribute()
    {
        // Mengembalikan URL gambar atau gambar default jika tidak ada
        return $this->photo ? Storage::url($this->photo) : asset('no-image.png');
    }
}
