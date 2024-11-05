<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'item_name',
        'quantity',
        'date',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the supplier that owns the BarangMasuk.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
