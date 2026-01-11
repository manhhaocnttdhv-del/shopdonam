<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_order_amount',
        'max_discount',
        'usage_limit',
        'used_count',
        'usage_per_user',
        'start_date',
        'end_date',
        'is_active',
    ];
    
    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'usage_per_user' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];
    
    /**
     * Kiểm tra coupon có hợp lệ không
     */
    public function isValid($userId = null, $orderAmount = 0)
    {
        // Kiểm tra trạng thái
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Mã giảm giá không còn hiệu lực'];
        }
        
        // Kiểm tra ngày bắt đầu
        if ($this->start_date && Carbon::now()->lt($this->start_date)) {
            return ['valid' => false, 'message' => 'Mã giảm giá chưa có hiệu lực'];
        }
        
        // Kiểm tra ngày kết thúc
        if ($this->end_date && Carbon::now()->gt($this->end_date)) {
            return ['valid' => false, 'message' => 'Mã giảm giá đã hết hạn'];
        }
        
        // Kiểm tra số lần sử dụng
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'Mã giảm giá đã hết lượt sử dụng'];
        }
        
        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($orderAmount < $this->min_order_amount) {
            return [
                'valid' => false, 
                'message' => 'Đơn hàng tối thiểu ' . number_format($this->min_order_amount) . ' VNĐ để sử dụng mã này'
            ];
        }
        
        // Kiểm tra số lần sử dụng của user
        if ($userId && $this->usage_per_user) {
            $userUsageCount = CouponUsage::where('coupon_id', $this->id)
                ->where('user_id', $userId)
                ->count();
            
            if ($userUsageCount >= $this->usage_per_user) {
                return ['valid' => false, 'message' => 'Bạn đã sử dụng mã này rồi'];
            }
        }
        
        return ['valid' => true];
    }
    
    /**
     * Tính toán số tiền giảm giá
     */
    public function calculateDiscount($orderAmount)
    {
        if ($this->type === 'percentage') {
            $discount = ($orderAmount * $this->value) / 100;
            
            // Áp dụng giới hạn tối đa nếu có
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
            
            return $discount;
        } else {
            // Fixed amount
            return min($this->value, $orderAmount);
        }
    }
    
    /**
     * Quan hệ với CouponUsage
     */
    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }
}
