<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    
    protected $fillable = [
        'thumb',
        'nameProduct',
        'price',
        'quantity',
        'quanity', // Giữ lại để tương thích
        'subtotal',
        'product_id',
        'address_id',
        'user_id',
        'sizes',
        'colors',
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];
    
    // Accessor để tương thích với cả quantity và quanity
    public function getQuantityAttribute($value)
    {
        return $value ?? $this->attributes['quanity'] ?? 1;
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
