<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class store_setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_name',
        'tagline',
        'logo',
        'favicon',
        'email',
        'phone',
        'whatsapp',
        'address',
        'instagram_url',
        'tiktok_url',
        'facebook_url',
        'about',
        'minimum_stock_warning'
    ];
}
