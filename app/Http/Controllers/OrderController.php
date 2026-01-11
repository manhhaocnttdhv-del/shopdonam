<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function cancel(Request $request, Order $order)
    {
        // Kiểm tra quyền
        if ($order->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền thực hiện thao tác này!');
        }

        // Kiểm tra đơn hàng đã bị hủy chưa
        if ($order->is_cancelled) {
            return redirect()->back()->with('error', 'Đơn hàng này đã bị hủy!');
        }

        // Kiểm tra thời gian hủy (trong vòng 2 tiếng)
        $orderCreatedAt = Carbon::parse($order->created_at);
        $now = Carbon::now();
        $hoursDiff = $orderCreatedAt->diffInHours($now);

        if ($hoursDiff > 2) {
            return redirect()->back()->with('error', 'Chỉ có thể hủy đơn hàng trong vòng 2 tiếng kể từ khi đặt hàng!');
        }

        // Nếu đơn hàng đã thanh toán QR, yêu cầu thông tin hoàn tiền
        if ($order->payment_method == 'qr' && $order->payment_status == 'paid') {
            $this->validate($request, [
                'refund_method' => 'required|in:qr_image,bank_account',
                'refund_qr_image' => 'required_if:refund_method,qr_image|image|mimes:jpeg,png,jpg,gif|max:2048',
                'refund_bank_account' => 'required_if:refund_method,bank_account|string|max:50',
                'refund_bank_name' => 'required_if:refund_method,bank_account|string|max:100',
            ], [
                'refund_method.required' => 'Vui lòng chọn phương thức hoàn tiền!',
                'refund_qr_image.required_if' => 'Vui lòng upload ảnh QR code để hoàn tiền!',
                'refund_bank_account.required_if' => 'Vui lòng nhập số tài khoản!',
                'refund_bank_name.required_if' => 'Vui lòng nhập tên ngân hàng!',
            ]);

            $order->refund_method = $request->refund_method;
            
            if ($request->refund_method == 'qr_image') {
                $refundQrImage = $request->file('refund_qr_image');
                if ($refundQrImage) {
                    $fileName = 'refund_qr_' . $order->id . '_' . time() . '_' . Str::random(10) . '.jpg';
                    $refundQrImage->move(public_path('temp/images/refund-qr'), $fileName);
                    $order->refund_qr_image = $fileName;
                }
            } else {
                $order->refund_bank_account = $request->refund_bank_account;
                $order->refund_bank_name = $request->refund_bank_name;
            }
        }

        // Hủy đơn hàng
        $order->is_cancelled = true;
        $order->cancelled_at = now();
        $order->cancellation_reason = $request->cancellation_reason ?? 'Khách hàng hủy đơn';
        $order->status = 0; // Hủy đơn
        $order->save();

        return redirect()->back()->with('success', 'Đã hủy đơn hàng thành công!' . ($order->payment_method == 'qr' && $order->payment_status == 'paid' ? ' Thông tin hoàn tiền đã được gửi, admin sẽ xử lý sớm nhất.' : ''));
    }
}
