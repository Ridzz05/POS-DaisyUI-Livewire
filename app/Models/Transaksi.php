<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // casts the items from json to array
    public function casts()
    {
        return [
            'items' => 'array'
        ];
    }

    //relation customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
