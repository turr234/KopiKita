<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'description',
        'origin',
        'tasting_notes',
        'price',
        'discount_price',
        'stock',
        'weight',
        'main_image',
        'is_featured',
        'is_active',
        'sold_count'
    ];
}
