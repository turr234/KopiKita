<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart_item extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'card_id',
        'product_id',
        'quantity'
    ];
}
