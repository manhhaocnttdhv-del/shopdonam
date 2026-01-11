@extends('admin.main')
@section('contents')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
    <div class="card">
        <div class="d-flex p-4 justify-content-between">
            <h5 class="fw-bold">Danh sách mã giảm giá</h5>
            <div>
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-success text-dark px-3 py-2 fw-bolder">
                    <i class="bx bx-plus"></i> Thêm mới
                </a>
            </div>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success mx-4">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã</th>
                        <th>Tên</th>
                        <th>Loại</th>
                        <th>Giá trị</th>
                        <th>Đơn tối thiểu</th>
                        <th>Đã dùng</th>
                        <th>Trạng thái</th>
                        <th>Hạn sử dụng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $index => $coupon)
                    <tr>
                        <td>{{ ($coupons->currentPage() - 1) * $coupons->perPage() + $index + 1 }}</td>
                        <td><strong class="text-primary">{{ $coupon->code }}</strong></td>
                        <td>{{ $coupon->name ?? '-' }}</td>
                        <td>
                            @if($coupon->type == 'percentage')
                                <span class="badge bg-info">Phần trăm</span>
                            @else
                                <span class="badge bg-warning">Số tiền</span>
                            @endif
                        </td>
                        <td>
                            @if($coupon->type == 'percentage')
                                {{ $coupon->value }}%
                                @if($coupon->max_discount)
                                    <br><small>(Tối đa: {{ number_format($coupon->max_discount) }} VNĐ)</small>
                                @endif
                            @else
                                {{ number_format($coupon->value) }} VNĐ
                            @endif
                        </td>
                        <td>{{ number_format($coupon->min_order_amount) }} VNĐ</td>
                        <td>
                            {{ $coupon->used_count }}
                            @if($coupon->usage_limit)
                                / {{ $coupon->usage_limit }}
                            @else
                                / ∞
                            @endif
                        </td>
                        <td>
                            @if($coupon->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Tạm khóa</span>
                            @endif
                        </td>
                        <td>
                            @if($coupon->start_date || $coupon->end_date)
                                @if($coupon->start_date)
                                    <small>Từ: {{ date('d/m/Y', strtotime($coupon->start_date)) }}</small><br>
                                @endif
                                @if($coupon->end_date)
                                    <small>Đến: {{ date('d/m/Y', strtotime($coupon->end_date)) }}</small>
                                @endif
                            @else
                                <small class="text-muted">Không giới hạn</small>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-edit"></i>
                                </a>
                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">Chưa có mã giảm giá nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4">
            {{ $coupons->links() }}
        </div>
    </div>
</div>
@endsection

