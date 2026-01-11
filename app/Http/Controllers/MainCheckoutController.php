<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Product;
use App\Models\AdminHistory;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\QrPaymentConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

session_start();
class MainCheckoutController extends Controller
{
    public function ShowToCheckout(){
        $addresses = Address::where('user_id',Auth::user()->id)->get();
        $qrConfigs = QrPaymentConfig::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
        return view('checkout.checkout',compact('addresses', 'qrConfigs'),[
            'title' => 'Mua hàng'
        ]);
    }

//    Thanh toán
    public function checkout(Request $request){
        $this->validate($request,[
            'sdt' => 'required',
            'name' => 'required',
            'Country' => 'required',
            'district' => 'required',
            'province' => 'required',
            'wards' => 'required',
            'address' => 'required',
        ],[
            'sdt.required' => 'Vui lòng nhập số điện thoại !',
            'name.required' => 'Vui lòng nhập tên !',
            'Country.required' => 'Vui lòng điền Quốc gia !',
            'province.required' => 'Vui lòng nhập Tỉnh / Thành phố !',
            'wards.required' => 'Vui lòng nhập Xã / Phường !',
            'district.required' => 'Vui lòng nhập Quận / Huyện !',
            'address.required' => 'Vui lòng nhập Số đường / số nhà !',
        ]);
        $order = new Order;
        $existingRecord = Address::where('sdt', $request->sdt)
            ->where('name', $request->name)
            ->where('Country', $request->Country)
            ->where('province', $request->province)
            ->where('district', $request->district)
            ->where('wards', $request->wards)
            ->where('address', $request->address)
            ->first();
        if(!$existingRecord){
            $address = new Address;
            $address->sdt = $request->sdt;
            $address->name = $request->name;
            $address->user_id = Auth::id();
            $address->Country = $request->Country;
            $address->province = $request->province;
            $address->district = $request->district;
            $address->wards = $request->wards;
            $address->address = $request->address;
            $address->save();
            $order->address_id = $address->id;

        }else{
            $order->address_id = $existingRecord->id;
        }

        $cartItems = Cart::where('user_id', Auth::id())->get();
        
        // Tạo order number và lưu order trước
        $order->order_number = 'ORD' . strtoupper(Str::random(8)) . time();
        $order->user_id = Auth::id();
        $order->status = 1;
        $order->payment_method = $request->payment_method ?? 'cod';
        $order->payment_status = $request->payment_method == 'qr' ? 'pending' : 'cod';
        $order->products = json_encode([]); // Set products rỗng trước khi save
        $order->total = 0; // Set total tạm thời
        $order->discount_amount = 0; // Set discount_amount mặc định
        $order->save(); // Lưu order trước để có ID
        
        // Tính tổng tiền
        $totalAmount = 0;
        $productsData = []; // Giữ lại để tương thích với dữ liệu cũ
        
        foreach ($cartItems as $cartItem) {
            $quantity = $cartItem->quantity ?? $cartItem->quanity ?? 1;
            $price = (float) str_replace([',', ' VNĐ', ' '], '', $cartItem->price);
            $subtotal = $price * $quantity;
            $totalAmount += $subtotal;
            
            $product = Product::find($cartItem->product_id);
            
            // Lưu vào order_items
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->nameProduct ?? ($product ? $product->Title : 'Sản phẩm'),
                'product_slug' => $product ? $product->slug : null,
                'price' => $price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'size' => $cartItem->sizes,
                'color' => $cartItem->colors,
            ]);
            
            // Giữ lại JSON cho tương thích
            $productsData[] = [
                'title' => $cartItem->nameProduct ?? ($product ? $product->Title : 'Sản phẩm'),
                'slug' => $product ? $product->slug : '',
                'price' => $price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'sizes' => $cartItem->sizes,
                'colors' => $cartItem->colors,
            ];

            // Cập nhật số lượng sản phẩm
            if($product){
                $newQuantity = (int)$product->Amounts - $quantity;
                $product->Amounts = $newQuantity >= 0 ? $newQuantity : 0;
                $product->save();
            }
        }
        
        // Xử lý mã giảm giá
        $discountAmount = 0;
        $couponId = null;
        
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();
            
            if ($coupon) {
                $validation = $coupon->isValid(Auth::id(), $totalAmount);
                
                if ($validation['valid']) {
                    $discountAmount = $coupon->calculateDiscount($totalAmount);
                    $couponId = $coupon->id;
                    
                    // Tăng số lần sử dụng
                    $coupon->used_count += 1;
                    $coupon->save();
                    
                    // Lưu lịch sử sử dụng (sẽ cập nhật order_id sau)
                    $couponUsage = CouponUsage::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => Auth::id(),
                        'discount_amount' => $discountAmount,
                    ]);
                }
            }
        }
        
        // Tính tổng tiền sau giảm giá
        $finalTotal = $totalAmount - $discountAmount;
        if ($finalTotal < 0) $finalTotal = 0;
        
        // Cập nhật order với tổng tiền và products JSON
        $order->products = json_encode($productsData);
        $totalFromRequest = (float) str_replace([',', ' VNĐ', ' '], '', $request->total);
        $order->total = $totalFromRequest > 0 ? $totalFromRequest : $finalTotal;
        $order->coupon_id = $couponId;
        $order->discount_amount = $discountAmount;
        $order->save();
        
        // Cập nhật coupon_usage với order_id nếu có
        if ($couponId && isset($couponUsage)) {
            $couponUsage->order_id = $order->id;
            $couponUsage->save();
        }
        
        // Lưu admin history
        $admin_history = new AdminHistory;
        $admin_history->amount = $request->total2 ?? $order->total;
        $admin_history->order_id = $order->id;
        $admin_history->user_id = Auth::user()->id;
        $admin_history->save();
        
        // Xóa giỏ hàng
        Cart::where('user_id', Auth::id())->delete();
        
        // Nếu thanh toán QR, chuyển đến trang hiển thị QR code
        if ($request->payment_method == 'qr') {
            return redirect()->route('checkout.success', ['order_id' => $order->id])
                ->with('show_qr', true);
        }
        
        return redirect()->route('checkout.success');
    }

    /**
     * Validate và áp dụng mã giảm giá
     */
    public function validateCoupon(Request $request)
    {
        $couponCode = strtoupper($request->coupon_code);
        $orderAmount = (float) str_replace([',', ' VNĐ', ' '], '', $request->order_amount ?? 0);
        
        $coupon = Coupon::where('code', $couponCode)->first();
        
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không tồn tại!'
            ]);
        }
        
        $validation = $coupon->isValid(Auth::id(), $orderAmount);
        
        if (!$validation['valid']) {
            return response()->json([
                'success' => false,
                'message' => $validation['message']
            ]);
        }
        
        $discountAmount = $coupon->calculateDiscount($orderAmount);
        $finalTotal = $orderAmount - $discountAmount;
        if ($finalTotal < 0) $finalTotal = 0;
        
        return response()->json([
            'success' => true,
            'coupon' => [
                'code' => $coupon->code,
                'name' => $coupon->name,
                'type' => $coupon->type,
                'value' => $coupon->value,
            ],
            'discount_amount' => $discountAmount,
            'order_amount' => $orderAmount,
            'final_total' => $finalTotal,
            'message' => 'Áp dụng mã giảm giá thành công!'
        ]);
    }

//    Thanh toán thành công - xuất hóa đơn
    public function showOrder(Request $request){
        $orderId = $request->order_id ?? null;
        if ($orderId) {
            $order = Order::find($orderId);
        } else {
            $order = Order::where('user_id', Auth::id())->latest('id')->first();
        }
        
        if (!$order) {
            return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng!');
        }
        
        $time = $order->updated_at;
        $qrConfigs = null;
        // Hiển thị mã QR nếu là thanh toán QR và chưa hoàn tất thanh toán
        if ($order->payment_method == 'qr') {
            $qrConfigs = QrPaymentConfig::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();
        }
        
        return view("checkout.success",compact('time', 'order', 'qrConfigs'),[
            'title' => 'Thanh toán thành công!'
        ]);
    }
}
