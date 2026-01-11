@extends('admin.main')
@section('contents')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
    <div class="card">
        <div class="d-flex p-4 justify-content-between">
            <h5 class="fw-bold">Danh sách Cấu hình QR</h5>
            <div>
                <a href="{{ route('qr-payment-configs.create') }}" class="btn btn-success text-dark px-3 py-2 fw-bolder">
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
                        <th>QR Code</th>
                        <th>Ngân hàng</th>
                        <th>Số tài khoản</th>
                        <th>Chủ tài khoản</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($configs as $index => $config)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($config->qr_image)
                                <img src="/temp/images/qr-payment/{{ $config->qr_image }}" 
                                     alt="QR Code" 
                                     style="width: 80px; height: 80px; object-fit: contain; border: 1px solid #ddd; border-radius: 4px; padding: 2px;">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $config->bank_name ?? '-' }}</strong>
                        </td>
                        <td>{{ $config->account_number ?? '-' }}</td>
                        <td>{{ $config->account_name ?? '-' }}</td>
                        <td>{{ $config->sort_order }}</td>
                        <td>
                            @if($config->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Tạm dừng</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('qr-payment-configs.edit', $config->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-edit"></i>
                                </a>
                                <form action="{{ route('qr-payment-configs.destroy', $config->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
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
                        <td colspan="8" class="text-center">Chưa có cấu hình QR nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
