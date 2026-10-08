<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_status_historie extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'address_id',
        'order_id',
        'recipient_name',
        'recipient_phone',
        'province',
        'city',
        'district',
        'village',
        'postal_code',
        'shipping_address',
        'subtotal',
        'shipping_cost',
        'discount',
        'total',
        'payment_method',
        'shipping_method',
        'status',
        'payment_status',
        'tracking_number',
        'notes',
        'cancellation_reason',
        'paid_at',
        'shipped_at',
        'cancelled_at',
        'completed_at'
    ];
}
