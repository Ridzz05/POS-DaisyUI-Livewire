<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'price',
        'desc',
        'type',
        'stock',
        'availability',
        'photo'
    ];

    // Definisikan tipe menu yang tersedia
    public static $types = [
        'makanan',
        'minuman',
        'snack'
    ];

    // Accessor untuk URL foto
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/no-image.png');
    }

    // Relasi ke Transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
