<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Product;
use App\Models\AdminHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;

class HomeController extends Controller
{
    public function home(){
        $user_count = User::where("role",0)->get();
        $count_post = Post::count();
        $count_userAdmin = User::where('level',1)->count();
        $count_user= User::where('level','!=',1)->count();
        $count_cate= Category::count();
        $count_type_product= Product::count();
        $count_products= Product::Sum('Amounts');
        $count_order= Order::count();
        $tongdoanhthu = AdminHistory::Sum('amount');
        $tongdoanhthuHomNay = AdminHistory::whereDate('created_at', Carbon::today())->sum('amount');
        $tongdoanhthuThangNay = AdminHistory::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('amount');
        
        // Thống kê đơn hàng chi tiết
        $orders_today = Order::whereDate('created_at', Carbon::today())->count();
        $orders_month = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $revenue_today = Order::whereDate('created_at', Carbon::today())
            ->where(function($q) {
                $q->where('payment_status', 'paid')
                  ->orWhere('payment_status', 'cod');
            })
            ->sum('total');
        $revenue_month = Order::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where(function($q) {
                $q->where('payment_status', 'paid')
                  ->orWhere('payment_status', 'cod');
            })
            ->sum('total');
        
        // Đơn hàng theo trạng thái
        $pending_orders = Order::where('status', 1)->count();
        $shipping_orders = Order::where('status', 2)->count();
        $completed_orders = Order::where('status', 3)->count();
        
        // Đơn hàng gần đây
        $recent_orders = Order::with(['user', 'address'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        
        return view ('admin.home',compact(
            'user_count','count_post','tongdoanhthu','tongdoanhthuHomNay','tongdoanhthuThangNay','count_userAdmin',
            'count_user','count_cate','count_type_product','count_products','count_order',
            'orders_today','orders_month','revenue_today','revenue_month',
            'pending_orders','shipping_orders','completed_orders','recent_orders'
        ),[
            'title' => 'Trang quản trị'
        ]);
    }
}
