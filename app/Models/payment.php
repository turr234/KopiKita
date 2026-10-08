<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'bank_account_id',
        'payment_code',
        'method',
        'string',
        'sender_name',
        'amount',
        'proof_image',
        'status',
        'rejection_reason',
        'verified_by',
        'verified_at'
    ];
}
