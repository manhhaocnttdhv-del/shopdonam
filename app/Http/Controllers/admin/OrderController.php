<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Lấy giá trị lọc trạng thái từ request
        $status = $request->get('status');
    
        // Kiểm tra nếu có lọc trạng thái
        $query = Order::query();
        if ($status) {
            $query->where(function($q) use ($status) {
                $q->where('status', $status)
                  ->orWhere('Status', $status); // Tương thích với dữ liệu cũ
            });
        }
    
        // Lấy danh sách đơn hàng, sắp xếp theo thời gian và phân trang
        $orders = $query->with(['user', 'address'])->orderByDesc('created_at')->paginate(10);
    
        return view('admin.order.index', compact('orders'), [
            'title' => 'Danh sách đơn hàng',
            'selectedStatus' => $status, // Truyền trạng thái hiện tại để hiển thị trên form
        ]);
    }
        public function updateStatus(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($order) {
            $order->status = $request->status;
            $order->Status = $request->status; // Giữ lại để tương thích
            $order->save();

            return response()->json(['success' => true, 'message' => 'Cập nhật trạng thái thành công!']);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy đơn hàng!']);
    }
    
    /**
     * Xem chi tiết đơn hàng
     */
    public function show($id)
    {
        $order = Order::with(['user', 'address', 'orderItems.product', 'coupon'])->findOrFail($id);
        
        return view('admin.order.show', compact('order'), [
            'title' => 'Chi tiết đơn hàng #' . $order->order_number
        ]);
    }
    
    /**
     * Export PDF đơn hàng
     */
    public function exportPdf($id)
    {
        $order = Order::with(['user', 'address', 'orderItems.product', 'coupon'])->findOrFail($id);
        
        $pdf = Pdf::loadView('admin.order.pdf', compact('order'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('don_hang_' . $order->order_number . '.pdf');
    }

}
