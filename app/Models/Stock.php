<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stok';

    protected $fillable = [
        'supplier_id',
        'nama_barang',
        'kode_barang',
        'jumlah',
        'harga_beli',
        'harga_jual',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
