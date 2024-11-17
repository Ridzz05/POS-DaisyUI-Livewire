<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'items',
        'desc',
        'price',
        'done'
    ];

    protected $casts = [
        'items' => 'array',
        'done' => 'boolean'
    ];

    // Tambahkan dates
    protected $dates = ['created_at', 'updated_at'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Tambahkan relasi ke TransaksiItem
    public function transaksiItems(): HasMany
    {
        return $this->hasMany(TransaksiItem::class);
    }

    // Relasi ke Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
