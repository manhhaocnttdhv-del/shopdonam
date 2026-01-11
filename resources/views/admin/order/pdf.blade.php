<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hóa đơn #{{ $order->order_number ?? $order->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section h3 {
            background-color: #f0f0f0;
            padding: 10px;
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-section {
            margin-top: 20px;
            border-top: 2px solid #333;
            padding-top: 10px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HÓA ĐƠN BÁN HÀNG</h1>
        <p>Mã đơn hàng: #{{ $order->order_number ?? $order->id }}</p>
        <p>Ngày đặt: {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <div class="row" style="display: flex; justify-content: space-between;">
        <div class="info-section" style="width: 48%;">
            <h3>Thông tin khách hàng</h3>
            <p><strong>Tên:</strong> {{ $order->user->name ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
            @if($order->address)
            <p><strong>Địa chỉ:</strong><br>
                {{ $order->address->address }}<br>
                {{ $order->address->wards }}, {{ $order->address->district }}<br>
                {{ $order->address->province }}, {{ $order->address->Country }}<br>
                <strong>SĐT:</strong> {{ $order->address->sdt }}
            </p>
            @endif
        </div>
        
        <div class="info-section" style="width: 48%;">
            <h3>Thông tin đơn hàng</h3>
            <p><strong>Trạng thái:</strong> 
                @if($order->status == 1) Đã đặt hàng
                @elseif($order->status == 2) Đang giao hàng
                @elseif($order->status == 3) Giao hàng thành công
                @endif
            </p>
            <p><strong>Phương thức thanh toán:</strong> 
                @if($order->payment_method == 'cod') COD
                @elseif($order->payment_method == 'qr') QR Code
                @else {{ $order->payment_method }}
                @endif
            </p>
            <p><strong>Trạng thái thanh toán:</strong> {{ $order->payment_status }}</p>
        </div>
    </div>
    
    <div class="info-section">
        <h3>Chi tiết sản phẩm</h3>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Size</th>
                    <th>Màu</th>
                    <th class="text-right">Đơn giá</th>
                    <th class="text-center">SL</th>
                    <th class="text-right">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $orderItems = $order->orderItems;
                    $products = is_array($order->products) ? $order->products : json_decode($order->products, true);
                    $index = 1;
                    $subtotal = 0;
                @endphp
                
                @if($orderItems && $orderItems->count() > 0)
                    @foreach($orderItems as $item)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->size ?? '-' }}</td>
                        <td>{{ $item->color ?? '-' }}</td>
                        <td class="text-right">{{ number_format($item->price) }} VNĐ</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->subtotal) }} VNĐ</td>
                    </tr>
                    @php $subtotal += $item->subtotal; @endphp
                    @endforeach
                @elseif(is_array($products) && count($products) > 0)
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $product['title'] ?? 'N/A' }}</td>
                        <td>{{ $product['sizes'] ?? '-' }}</td>
                        <td>{{ $product['colors'] ?? '-' }}</td>
                        <td class="text-right">{{ number_format($product['price'] ?? 0) }} VNĐ</td>
                        <td class="text-center">{{ $product['quantity'] ?? 1 }}</td>
                        <td class="text-right">{{ number_format($product['subtotal'] ?? 0) }} VNĐ</td>
                    </tr>
                    @php $subtotal += ($product['subtotal'] ?? 0); @endphp
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    
    <div class="total-section">
        <div class="total-row">
            <span><strong>Tạm tính:</strong></span>
            <span><strong>{{ number_format($order->total + ($order->discount_amount ?? 0)) }} VNĐ</strong></span>
        </div>
        @if($order->discount_amount && $order->discount_amount > 0)
        <div class="total-row" style="color: #28a745;">
            <span>Giảm giá @if($order->coupon)({{ $order->coupon->code }})@endif:</span>
            <span>- {{ number_format($order->discount_amount) }} VNĐ</span>
        </div>
        @endif
        <div class="total-row" style="font-size: 16px; margin-top: 10px;">
            <span><strong>TỔNG CỘNG:</strong></span>
            <span><strong>{{ number_format($order->total) }} VNĐ</strong></span>
        </div>
    </div>
    
    <div class="footer">
        <p>Cảm ơn quý khách đã mua hàng!</p>
        <p>Hóa đơn được tạo tự động từ hệ thống</p>
    </div>
</body>
</html>

