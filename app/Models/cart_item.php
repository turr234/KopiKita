<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart_item extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'cart_id',
        'product_id',
        'jenis_product_id',
        'quantity',
        'price'
    ];

    // Relasi ke Produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke Jenis Product / Varian
    public function jenisProduct()
    {
        return $this->belongsTo(JenisProducts::class, 'jenis_product_id');
    }

    // Relasi ke Cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
