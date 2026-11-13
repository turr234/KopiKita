<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'order_number',
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
        'payment_url',
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

    protected $casts = [
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(order_item::class, 'order_id');
    }

    public function address()
    {
        return $this->belongsTo(addresse::class, 'address_id');
    }

    public function statusHistories()
    {
        return $this->hasMany(order_status_historie::class, 'order_id');
    }

    public function payment()
    {
        return $this->hasOne(payment::class, 'order_id');
    }
}
