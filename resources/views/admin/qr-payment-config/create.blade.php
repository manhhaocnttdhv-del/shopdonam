@extends('admin.main')
@section('contents')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
    <div class="card">
        <div class="card-header">
            <h5 class="fw-bold">Thêm cấu hình QR mới</h5>
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
            
            <form action="{{ route('qr-payment-configs.store') }}" method="POST" enctype="multipart/form-data" data-validate="false">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tên ngân hàng <span class="text-danger">*</span></label>
                        <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name') }}" placeholder="VD: Vietcombank, MBBank..." required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Số tài khoản <span class="text-danger">*</span></label>
                        <input type="text" name="account_number" class="form-control" value="{{ old('account_number') }}" placeholder="VD: 1234567890" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tên chủ tài khoản <span class="text-danger">*</span></label>
                        <input type="text" name="account_name" class="form-control" value="{{ old('account_name') }}" placeholder="VD: NGUYEN VAN A" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Ảnh QR Code <span class="text-danger">*</span></label>
                        <input type="file" name="qr_image" class="form-control" accept="image/*" required>
                        <small class="text-muted">Định dạng: jpeg, png, jpg, gif. Kích thước tối đa: 2MB</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Thứ tự hiển thị</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Ghi chú</label>
                        <textarea name="note" class="form-control" rows="1" placeholder="Ghi chú thêm (tùy chọn)">{{ old('note') }}</textarea>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">
                                Kích hoạt
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-success">Lưu lại</button>
                    <a href="{{ route('qr-payment-configs.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
