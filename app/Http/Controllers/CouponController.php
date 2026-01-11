<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Hiển thị danh sách mã giảm giá công khai
     */
    public function index()
    {
        $now = Carbon::now();
        
        $coupons = Coupon::where('is_active', true)
            ->where(function($query) use ($now) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', $now);
            })
            ->where(function($query) use ($now) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $now);
            })
            ->where(function($query) {
                $query->whereNull('usage_limit')
                    ->orWhereRaw('used_count < usage_limit');
            })
            ->orderByDesc('created_at')
            ->get();

        return view('coupon.index', compact('coupons'))->with([
            'title' => 'Mã giảm giá'
        ]);
    }
}

