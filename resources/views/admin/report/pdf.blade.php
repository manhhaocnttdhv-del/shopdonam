<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Báo cáo đơn hàng</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
        }
        .stat-item {
            text-align: center;
        }
        .stat-item strong {
            display: block;
            font-size: 18px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 9px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        table th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BÁO CÁO ĐƠN HÀNG</h1>
        <p>Từ ngày: {{ date('d/m/Y', strtotime($startDate)) }} - Đến ngày: {{ date('d/m/Y', strtotime($endDate)) }}</p>
        @if($status)
        <p>Trạng thái: 
            @if($status == 1) Đã đặt hàng
            @elseif($status == 2) Đang giao hàng
            @elseif($status == 3) Giao hàng thành công
            @endif
        </p>
        @endif
    </div>
    
    <div class="stats">
        <div class="stat-item">
            <div>Tổng đơn hàng</div>
            <strong>{{ number_format($stats['total_orders']) }}</strong>
        </div>
        <div class="stat-item">
            <div>Tổng doanh thu</div>
            <strong>{{ number_format($stats['total_revenue']) }} VNĐ</strong>
        </div>
        <div class="stat-item">
            <div>Đơn chờ xử lý</div>
            <strong>{{ number_format($stats['pending_orders']) }}</strong>
        </div>
        <div class="stat-item">
            <div>Đơn hoàn thành</div>
            <strong>{{ number_format($stats['completed_orders']) }}</strong>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Ngày đặt</th>
                <th>Khách hàng</th>
                <th>SĐT</th>
                <th>Tổng tiền</th>
                <th>Phương thức</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->order_number ?? $order->id }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>{{ $order->address->sdt ?? 'N/A' }}</td>
                <td class="text-right">{{ number_format($order->total) }} VNĐ</td>
                <td>
                    @if($order->payment_method == 'cod') COD
                    @elseif($order->payment_method == 'qr') QR Code
                    @else {{ $order->payment_method }}
                    @endif
                </td>
                <td>
                    @if($order->status == 1) Đã đặt
                    @elseif($order->status == 2) Đang giao
                    @elseif($order->status == 3) Hoàn thành
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f8f9fa; font-weight: bold;">
                <td colspan="4" class="text-right">TỔNG CỘNG:</td>
                <td class="text-right">{{ number_format($orders->sum('total')) }} VNĐ</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
    
    <div class="footer">
        <p>Báo cáo được tạo tự động từ hệ thống</p>
        <p>Ngày xuất: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>

