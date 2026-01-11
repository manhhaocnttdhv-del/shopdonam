<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    
    const DaDatHang = 1;
    const DangGiaoHang = 2;
    const GiaoHangThanhCong = 3;
    
    protected $fillable = [
        'user_id',
        'order_number',
        'address_id',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'payment_transaction_id',
        'coupon_id',
        'discount_amount',
        'products',
        'is_cancelled',
        'cancelled_at',
        'cancellation_reason',
        'refund_method',
        'refund_qr_image',
        'refund_bank_account',
        'refund_bank_name',
    ];
    
    protected $casts = [
        'total' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'products' => 'array',
        'is_cancelled' => 'boolean',
        'cancelled_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
    
    public function paymentTransaction()
    {
        return $this->belongsTo(PaymentTransaction::class, 'payment_transaction_id', 'id');
    }
    
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function paymentProof()
    {
        return $this->hasOne(PaymentProof::class, 'order_id', 'id');
    }

    public function canBeCancelled()
    {
        if ($this->is_cancelled) {
            return false;
        }
        
        $orderCreatedAt = \Carbon\Carbon::parse($this->created_at);
        $hoursDiff = $orderCreatedAt->diffInHours(\Carbon\Carbon::now());
        
        return $hoursDiff <= 2;
    }
}
