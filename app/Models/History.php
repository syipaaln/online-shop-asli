<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    // protected $table = 'histories';

    protected $fillable = [
        'user_id',
        'product_id',
        'checkout_id',
        'pembelian_id',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
}
