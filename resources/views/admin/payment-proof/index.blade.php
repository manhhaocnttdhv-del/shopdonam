@extends('admin.main')
@section('contents')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Danh sách yêu cầu xác minh</h5>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success mx-4 mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mx-4 mt-3">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Ngày gửi</th>
                        <th>Khách hàng</th>
                        <th>Đơn hàng</th>
                        <th>Ảnh Bill</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proofs as $index => $proof)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $proof->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <strong>{{ $proof->user->name ?? 'N/A' }}</strong>
                            <br><small>{{ $proof->user->email ?? '' }}</small>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $proof->order_id) }}" target="_blank" class="fw-bold">
                                #{{ $proof->order->order_number ?? $proof->order_id }}
                            </a>
                            <br><small class="text-danger fw-bold">{{ number_format($proof->order->total) }} VNĐ</small>
                        </td>
                        <td>
                            <a href="/temp/images/payment-proofs/{{ $proof->proof_image }}" target="_blank">
                                <img src="/temp/images/payment-proofs/{{ $proof->proof_image }}" 
                                     alt="Payment Proof" 
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                            </a>
                        </td>
                        <td>
                            @if($proof->status == 'pending')
                                <span class="badge bg-label-info">Chờ duyệt</span>
                            @elseif($proof->status == 'approved')
                                <span class="badge bg-label-success">Đã duyệt</span>
                            @else
                                <span class="badge bg-label-danger">Từ chối</span>
                                @if($proof->rejection_reason)
                                    <br><small class="text-muted">Lý do: {{ $proof->rejection_reason }}</small>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($proof->status == 'pending')
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.payment-proofs.approve', $proof->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn DUYỆT thanh toán này?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bx bx-check me-1"></i> Duyệt
                                    </button>
                                </form>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $proof->id }}">
                                    <i class="bx bx-x me-1"></i> Từ chối
                                </button>
                            </div>

                            <!-- Modal Từ chối -->
                            <div class="modal fade" id="rejectModal{{ $proof->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('admin.payment-proofs.reject', $proof->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Lý do từ chối</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <textarea name="rejection_reason" class="form-control" rows="3" placeholder="Nhập lý do khách hàng chuyển khoản sai, thiếu tiền..." required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                                                <button type="submit" class="btn btn-danger">Xác nhận từ chối</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Chưa có yêu cầu xác minh nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $proofs->links() }}
        </div>
    </div>
</div>
@endsection
