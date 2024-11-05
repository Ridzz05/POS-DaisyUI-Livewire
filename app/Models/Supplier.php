<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email'
    ];

    /**
     * Get the barang masuks for the supplier.
     */
    public function barangMasuks(): HasMany
    {
        return $this->hasMany(BarangMasuk::class);
    }
}
