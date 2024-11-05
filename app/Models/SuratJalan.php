<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratJalan extends Model
{
    use HasFactory;

    protected $table = 'surat_jalans';

    protected $fillable = [
        'nomor_surat',
        'tanggal',
        'customer_id',
        'alamat',
        'barang',
        'keterangan',
    ];

    protected $casts = [
        'barang' => 'array',  // Cast barang sebagai array untuk JSON
    ];

    // Relasi dengan customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
