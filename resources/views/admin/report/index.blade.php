@extends('admin.main')
@section('contents')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
    
    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3" data-validate="false">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Từ ngày</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Đến ngày</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="1" {{ $status == '1' ? 'selected' : '' }}>Đã đặt hàng</option>
                        <option value="2" {{ $status == '2' ? 'selected' : '' }}>Đang giao hàng</option>
                        <option value="3" {{ $status == '3' ? 'selected' : '' }}>Giao hàng thành công</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-search"></i> Lọc
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Tổng đơn hàng</h6>
                            <h3 class="mb-0">{{ number_format($stats['total_orders']) }}</h3>
                        </div>
                        <div class="fs-1">
                            <i class="bx bx-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Tổng doanh thu</h6>
                            <h3 class="mb-0">{{ number_format($stats['total_revenue']) }} VNĐ</h3>
                        </div>
                        <div class="fs-1">
                            <i class="bx bx-money"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Đơn chờ xử lý</h6>
                            <h3 class="mb-0">{{ number_format($stats['pending_orders']) }}</h3>
                        </div>
                        <div class="fs-1">
                            <i class="bx bx-time"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Đơn hoàn thành</h6>
                            <h3 class="mb-0">{{ number_format($stats['completed_orders']) }}</h3>
                        </div>
                        <div class="fs-1">
                            <i class="bx bx-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Export Buttons -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Xuất báo cáo</h5>
            <div>
                <a href="{{ route('reports.exportCsv', request()->all()) }}" class="btn btn-success">
                    <i class="bx bx-file"></i> Export CSV
                </a>
                <a href="{{ route('reports.exportPdf', request()->all()) }}" class="btn btn-danger">
                    <i class="bx bx-file-blank"></i> Export PDF
                </a>
            </div>
        </div>
    </div>
    
    <!-- Orders Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"></h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Tổng tiền</th>
                        <th>Phương thức</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong class="text-primary">#{{ $order->order_number ?? $order->id }}</strong></td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ $order->address->sdt ?? 'N/A' }}</td>
                        <td><strong>{{ number_format($order->total) }} VNĐ</strong></td>
                        <td>
                            @if($order->payment_method == 'cod')
                                <span class="badge bg-secondary">COD</span>
                            @elseif($order->payment_method == 'qr')
                                <span class="badge bg-primary">QR Code</span>
                            @else
                                <span class="badge bg-info">{{ $order->payment_method }}</span>
                            @endif
                        </td>
                        <td>
                            @if($order->status == 1)
                                <span class="badge bg-info">Đã đặt hàng</span>
                            @elseif($order->status == 2)
                                <span class="badge bg-warning">Đang giao hàng</span>
                            @elseif($order->status == 3)
                                <span class="badge bg-success">Hoàn thành</span>
                            @else
                                <span class="badge bg-secondary">Không xác định</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                <i class="bx bx-show"></i> Chi tiết
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Không có đơn hàng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<style>
.card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border: none;
    margin-bottom: 1.5rem;
}
.card.bg-primary, .card.bg-success, .card.bg-warning, .card.bg-info {
    border: none;
}
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
</style>
@endsection

