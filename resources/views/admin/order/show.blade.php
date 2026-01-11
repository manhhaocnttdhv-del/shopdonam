@extends('admin.main')
@section('contents')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">{{$title}}</h3>
        <div>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Quay lại
            </a>
            <a href="{{ route('orders.exportPdf', $order->id) }}" class="btn btn-danger" target="_blank">
                <i class="bx bx-file-blank"></i> Xuất PDF
            </a>
        </div>
    </div>
    
    <div class="row">
        <!-- Thông tin đơn hàng -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bx bx-info-circle"></i> Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Mã đơn hàng:</strong><br>
                            <span class="text-primary fs-5">#{{ $order->order_number ?? $order->id }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Ngày đặt hàng:</strong><br>
                            {{ $order->created_at->format('d/m/Y H:i:s') }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Trạng thái đơn hàng:</strong><br>
                            @if($order->status == 1)
                                <span class="badge bg-info fs-6">Đã đặt hàng</span>
                            @elseif($order->status == 2)
                                <span class="badge bg-warning fs-6">Đang giao hàng</span>
                            @elseif($order->status == 3)
                                <span class="badge bg-success fs-6">Giao hàng thành công</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <strong>Phương thức thanh toán:</strong><br>
                            @if($order->payment_method == 'cod')
                                <span class="badge bg-secondary">Thanh toán khi nhận hàng (COD)</span>
                            @elseif($order->payment_method == 'qr')
                                <span class="badge bg-primary">QR Code</span>
                            @else
                                <span class="badge bg-info">{{ $order->payment_method }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Trạng thái thanh toán:</strong><br>
                            @if($order->payment_status == 'paid' || $order->payment_status == 'cod')
                                <span class="badge bg-success">Đã thanh toán</span>
                            @elseif($order->payment_status == 'pending')
                                <span class="badge bg-warning">Chờ thanh toán</span>
                            @else
                                <span class="badge bg-danger">{{ $order->payment_status }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <strong>Cập nhật lần cuối:</strong><br>
                            {{ $order->updated_at->format('d/m/Y H:i:s') }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sản phẩm -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bx bx-package"></i> Sản phẩm đã đặt</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Size</th>
                                    <th>Màu</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $orderItems = $order->orderItems;
                                    $products = is_array($order->products) ? $order->products : json_decode($order->products, true);
                                    $index = 1;
                                @endphp
                                
                                @if($orderItems && $orderItems->count() > 0)
                                    @foreach($orderItems as $item)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>
                                            <strong>{{ $item->product_name }}</strong>
                                            @if($item->product)
                                                <br><small class="text-muted">SKU: {{ $item->product->id }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $item->size ?? '-' }}</td>
                                        <td>{{ $item->color ?? '-' }}</td>
                                        <td class="text-end">{{ number_format($item->price) }} VNĐ</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end"><strong>{{ number_format($item->subtotal) }} VNĐ</strong></td>
                                    </tr>
                                    @endforeach
                                @elseif(is_array($products) && count($products) > 0)
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>
                                            <strong>{{ $product['title'] ?? 'N/A' }}</strong>
                                        </td>
                                        <td>{{ $product['sizes'] ?? '-' }}</td>
                                        <td>{{ $product['colors'] ?? '-' }}</td>
                                        <td class="text-end">{{ number_format($product['price'] ?? 0) }} VNĐ</td>
                                        <td class="text-center">{{ $product['quantity'] ?? 1 }}</td>
                                        <td class="text-end"><strong>{{ number_format($product['subtotal'] ?? 0) }} VNĐ</strong></td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">Không có sản phẩm</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Thông tin khách hàng và tổng tiền -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bx bx-user"></i> Thông tin khách hàng</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tên:</strong><br>{{ $order->user->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong><br>{{ $order->user->email ?? 'N/A' }}</p>
                    @if($order->address)
                    <hr>
                    <p><strong>Địa chỉ giao hàng:</strong></p>
                    <p class="mb-1">{{ $order->address->name }}</p>
                    <p class="mb-1">{{ $order->address->address }}</p>
                    <p class="mb-1">{{ $order->address->wards }}, {{ $order->address->district }}</p>
                    <p class="mb-1">{{ $order->address->province }}, {{ $order->address->Country }}</p>
                    <p class="mb-0"><strong>SĐT:</strong> {{ $order->address->sdt }}</p>
                    @endif
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bx bx-calculator"></i> Tổng tiền</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <strong>{{ number_format($order->total + ($order->discount_amount ?? 0)) }} VNĐ</strong>
                    </div>
                    @if($order->discount_amount && $order->discount_amount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Giảm giá:</span>
                        <strong>- {{ number_format($order->discount_amount) }} VNĐ</strong>
                        @if($order->coupon)
                            <br><small class="text-muted">({{ $order->coupon->code }})</small>
                        @endif
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fs-5"><strong>Tổng cộng:</strong></span>
                        <span class="fs-4 text-primary"><strong>{{ number_format($order->total) }} VNĐ</strong></span>
                    </div>
                </div>
            </div>
            
            <!-- Cập nhật trạng thái -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Cập nhật trạng thái</h5>
                </div>
                <div class="card-body">
                    <select name="status" class="form-select" id="order-status-select">
                        <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Đã đặt hàng</option>
                        <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Đang giao hàng</option>
                        <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Giao hàng thành công</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('order-status-select');
    
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            const newStatus = this.value;
            const orderId = {{ $order->id }};
            
            fetch("{{ route('orders.updateStatus') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    order_id: orderId,
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                alert('Có lỗi xảy ra khi cập nhật trạng thái!');
                console.error('Error:', error);
            });
        });
    }
});
</script>
@endsection

