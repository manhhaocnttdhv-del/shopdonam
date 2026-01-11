<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;
    
    protected $table = 'payment_transactions';

    protected $fillable = [
        'order_id',
        'transaction_code',
        'payment_method',
        'amount',
        'status',
        'vnpay_response',
        'bank_code',
        'card_type',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'vnpay_response' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}







