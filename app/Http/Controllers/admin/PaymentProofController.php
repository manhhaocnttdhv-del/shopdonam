<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentProof;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentProofController extends Controller
{
    public function index()
    {
        $proofs = PaymentProof::with(['order', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.payment-proof.index', compact('proofs'), [
            'title' => 'Quản lý xác minh thanh toán'
        ]);
    }

    public function approve(Request $request, PaymentProof $proof)
    {
        $proof->status = PaymentProof::STATUS_APPROVED;
        $proof->reviewed_by = Auth::id();
        $proof->reviewed_at = now();
        $proof->rejection_reason = null;
        $proof->save();

        // Cập nhật trạng thái đơn hàng
        $order = $proof->order;
        $order->payment_status = 'paid';
        $order->status = Order::DaDatHang;
        $order->save();

        return redirect()->back()->with('success', 'Đã duyệt thanh toán thành công!');
    }

    public function reject(Request $request, PaymentProof $proof)
    {
        $this->validate($request, [
            'rejection_reason' => 'required|string|max:500',
        ], [
            'rejection_reason.required' => 'Vui lòng nhập lý do từ chối!',
        ]);

        $proof->status = PaymentProof::STATUS_REJECTED;
        $proof->reviewed_by = Auth::id();
        $proof->reviewed_at = now();
        $proof->rejection_reason = $request->rejection_reason;
        $proof->save();

        // Cập nhật trạng thái đơn hàng
        $order = $proof->order;
        $order->payment_status = 'failed';
        $order->save();

        return redirect()->back()->with('success', 'Đã từ chối thanh toán và gửi lý do cho khách hàng!');
    }
}
