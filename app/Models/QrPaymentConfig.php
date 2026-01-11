<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrPaymentConfig extends Model
{
    use HasFactory;

    protected $table = 'qr_payment_configs';

    protected $fillable = [
        'bank_name',
        'account_number',
        'account_name',
        'qr_image',
        'note',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
