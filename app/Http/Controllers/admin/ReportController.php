<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Hiển thị trang báo cáo
     */
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        $status = $request->get('status');

        $query = Order::query()
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->orderByDesc('created_at')->paginate(20);

        // Thống kê tổng quan
        $stats = [
            'total_orders' => Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count(),
            'total_revenue' => Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('payment_status', 'paid')
                ->sum('total'),
            'pending_orders' => Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('status', 1)->count(),
            'completed_orders' => Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('status', 3)->count(),
        ];

        return view('admin.report.index', compact('orders', 'stats', 'startDate', 'endDate', 'status'), [
            'title' => 'Báo cáo đơn hàng'
        ]);
    }

    /**
     * Export báo cáo ra CSV
     */
    public function exportCsv(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        $status = $request->get('status');

        $query = Order::query()
            ->with(['user', 'address', 'orderItems'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->orderByDesc('created_at')->get();

        $filename = 'bao_cao_don_hang_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Thêm BOM để Excel hiển thị tiếng Việt đúng
        $output = "\xEF\xBB\xBF";

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, [
                'Mã đơn hàng',
                'Số đơn hàng',
                'Ngày đặt',
                'Khách hàng',
                'Email',
                'Số điện thoại',
                'Địa chỉ',
                'Tổng tiền',
                'Phương thức thanh toán',
                'Trạng thái thanh toán',
                'Trạng thái đơn hàng',
                'Sản phẩm',
                'Số lượng',
                'Giá',
                'Thành tiền',
            ], ',');

            // Data
            foreach ($orders as $order) {
                $user = $order->user;
                $address = $order->address;
                
                $customerName = $user ? $user->name : 'N/A';
                $customerEmail = $user ? $user->email : 'N/A';
                $phone = $address ? $address->sdt : 'N/A';
                $fullAddress = $address ? 
                    ($address->address . ', ' . $address->wards . ', ' . $address->district . ', ' . $address->province) : 
                    'N/A';
                
                $statusText = $this->getStatusText($order->status);
                $paymentStatusText = $this->getPaymentStatusText($order->payment_status);
                $paymentMethodText = $this->getPaymentMethodText($order->payment_method);

                if ($order->orderItems && $order->orderItems->count() > 0) {
                    // Nếu có order_items, export từng item
                    foreach ($order->orderItems as $item) {
                        fputcsv($file, [
                            $order->id,
                            $order->order_number ?? 'N/A',
                            $order->created_at->format('d/m/Y H:i'),
                            $customerName,
                            $customerEmail,
                            $phone,
                            $fullAddress,
                            number_format($order->total, 0, ',', '.') . ' VNĐ',
                            $paymentMethodText,
                            $paymentStatusText,
                            $statusText,
                            $item->product_name,
                            $item->quantity,
                            number_format($item->price, 0, ',', '.') . ' VNĐ',
                            number_format($item->subtotal, 0, ',', '.') . ' VNĐ',
                        ], ',');
                    }
                } else {
                    // Nếu không có order_items, export từ JSON products
                    $products = is_array($order->products) ? $order->products : json_decode($order->products, true);
                    if (is_array($products) && count($products) > 0) {
                        foreach ($products as $product) {
                            fputcsv($file, [
                                $order->id,
                                $order->order_number ?? 'N/A',
                                $order->created_at->format('d/m/Y H:i'),
                                $customerName,
                                $customerEmail,
                                $phone,
                                $fullAddress,
                                number_format($order->total, 0, ',', '.') . ' VNĐ',
                                $paymentMethodText,
                                $paymentStatusText,
                                $statusText,
                                $product['title'] ?? 'N/A',
                                $product['quantity'] ?? 1,
                                number_format($product['price'] ?? 0, 0, ',', '.') . ' VNĐ',
                                number_format($product['subtotal'] ?? 0, 0, ',', '.') . ' VNĐ',
                            ], ',');
                        }
                    } else {
                        // Nếu không có sản phẩm
                        fputcsv($file, [
                            $order->id,
                            $order->order_number ?? 'N/A',
                            $order->created_at->format('d/m/Y H:i'),
                            $customerName,
                            $customerEmail,
                            $phone,
                            $fullAddress,
                            number_format($order->total, 0, ',', '.') . ' VNĐ',
                            $paymentMethodText,
                            $paymentStatusText,
                            $statusText,
                            'N/A',
                            '0',
                            '0 VNĐ',
                            '0 VNĐ',
                        ], ',');
                    }
                }
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Lấy text trạng thái đơn hàng
     */
    private function getStatusText($status)
    {
        $statuses = [
            1 => 'Đã đặt hàng',
            2 => 'Đang giao hàng',
            3 => 'Giao hàng thành công',
        ];
        return $statuses[$status] ?? 'Không xác định';
    }

    /**
     * Lấy text trạng thái thanh toán
     */
    private function getPaymentStatusText($status)
    {
        $statuses = [
            'pending' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thanh toán thất bại',
            'cod' => 'Thanh toán khi nhận hàng',
        ];
        return $statuses[$status] ?? 'Không xác định';
    }

    /**
     * Lấy text phương thức thanh toán
     */
    private function getPaymentMethodText($method)
    {
        $methods = [
            'cod' => 'Thanh toán khi nhận hàng',
            'qr' => 'QR Code',
            'bank_transfer' => 'Chuyển khoản',
        ];
        return $methods[$method] ?? 'Không xác định';
    }
    
    /**
     * Export báo cáo ra PDF
     */
    public function exportPdf(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        $status = $request->get('status');

        $query = Order::query()
            ->with(['user', 'address', 'orderItems'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->orderByDesc('created_at')->get();
        
        // Thống kê tổng quan
        $stats = [
            'total_orders' => $orders->count(),
            'total_revenue' => $orders->where('payment_status', 'paid')->sum('total'),
            'pending_orders' => $orders->where('status', 1)->count(),
            'completed_orders' => $orders->where('status', 3)->count(),
        ];
        
        $pdf = Pdf::loadView('admin.report.pdf', compact('orders', 'stats', 'startDate', 'endDate', 'status'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('bao_cao_don_hang_' . date('Y-m-d_His') . '.pdf');
    }
}


