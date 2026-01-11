<?php

namespace App\Http\Controllers;

use App\Models\PaymentProof;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentProofController extends Controller
{
    public function upload(Request $request, Order $order)
    {
        // Kiểm tra quyền
        if ($order->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền thực hiện thao tác này!');
        }

        // Kiểm tra đơn hàng đã có payment proof chưa
        $existingProof = PaymentProof::where('order_id', $order->id)->first();
        if ($existingProof && $existingProof->status == PaymentProof::STATUS_APPROVED) {
            return redirect()->back()->with('error', 'Đơn hàng này đã được xác minh thanh toán!');
        }

        $this->validate($request, [
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'proof_image.required' => 'Vui lòng chọn ảnh bill/screenshot thanh toán!',
            'proof_image.image' => 'File phải là ảnh!',
        ]);

        // Xóa proof cũ nếu có và bị reject
        if ($existingProof && $existingProof->status == PaymentProof::STATUS_REJECTED) {
            if ($existingProof->proof_image && file_exists(public_path('temp/images/payment-proofs/' . $existingProof->proof_image))) {
                unlink(public_path('temp/images/payment-proofs/' . $existingProof->proof_image));
            }
            $existingProof->delete();
        }

        $proof = new PaymentProof();
        $proof->order_id = $order->id;
        $proof->user_id = Auth::id();
        $proof->status = PaymentProof::STATUS_PENDING;

        $proofImage = $request->file('proof_image');
        if ($proofImage) {
            $fileName = 'proof_' . $order->id . '_' . time() . '_' . Str::random(10) . '.jpg';
            $proofImage->move(public_path('temp/images/payment-proofs'), $fileName);
            $proof->proof_image = $fileName;
        }

        $proof->save();

        // Cập nhật trạng thái đơn hàng
        $order->payment_status = 'pending';
        $order->save();

        return redirect()->back()->with('success', 'Đã gửi ảnh bill thanh toán! Vui lòng chờ admin xác minh.');
    }
}
