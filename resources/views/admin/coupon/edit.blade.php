@extends('admin.main')
@section('contents')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
    <div class="card">
        <div class="card-header">
            <h5 class="fw-bold">Chỉnh sửa mã giảm giá</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ url('/admin/coupons/' . $coupon->id) }}" method="POST" data-action="/admin/coupons/{{ $coupon->id }}" data-validate="false">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Mã giảm giá <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $coupon->code) }}" required placeholder="VD: SALE2024" maxlength="50">
                        <small class="text-muted">Mã sẽ được chuyển thành chữ hoa tự động</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tên mã giảm giá</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $coupon->name) }}" placeholder="VD: Giảm giá năm mới">
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Mô tả</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Mô tả về mã giảm giá">{{ old('description', $coupon->description) }}</textarea>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Loại giảm giá <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>Phần trăm (%)</option>
                            <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Số tiền cố định</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Giá trị giảm giá <span class="text-danger">*</span></label>
                        <input type="number" name="value" class="form-control" value="{{ old('value', $coupon->value) }}" required min="0" step="0.01" placeholder="VD: 10 (10% hoặc 10.000 VNĐ)">
                    </div>
                    
                    <div class="col-md-6 mb-3" id="max_discount_field">
                        <label class="form-label fw-bold">Giảm giá tối đa (VNĐ)</label>
                        <input type="number" name="max_discount" class="form-control" value="{{ old('max_discount', $coupon->max_discount) }}" min="0" step="0.01" placeholder="Chỉ áp dụng cho loại phần trăm">
                        <small class="text-muted">Chỉ áp dụng khi chọn loại phần trăm</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Giá trị đơn hàng tối thiểu (VNĐ)</label>
                        <input type="number" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', $coupon->min_order_amount) }}" min="0" step="0.01" placeholder="0 = không giới hạn">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Số lần sử dụng tối đa</label>
                        <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit) }}" min="1" placeholder="Để trống = không giới hạn">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Số lần mỗi user có thể dùng</label>
                        <input type="number" name="usage_per_user" class="form-control" value="{{ old('usage_per_user', $coupon->usage_per_user) }}" min="1" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Ngày bắt đầu</label>
                        <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date', $coupon->start_date ? date('Y-m-d\TH:i', strtotime($coupon->start_date)) : '') }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Ngày kết thúc</label>
                        <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date', $coupon->end_date ? date('Y-m-d\TH:i', strtotime($coupon->end_date)) : '') }}">
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Kích hoạt mã giảm giá
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.querySelector('select[name="type"]');
    const maxDiscountField = document.getElementById('max_discount_field');
    
    function toggleMaxDiscount() {
        if (typeSelect.value === 'percentage') {
            maxDiscountField.style.display = 'block';
        } else {
            maxDiscountField.style.display = 'none';
        }
    }
    
    typeSelect.addEventListener('change', toggleMaxDiscount);
    toggleMaxDiscount();
});
</script>
@endsection

