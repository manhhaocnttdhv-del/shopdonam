@extends('admin.main')
@section('contents')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
    <div class="card">
        <div class="d-flex p-4 justify-content-between">
            <h5 class="fw-bold">Danh sách Slider</h5>
            <div>
                <a href="{{ route('admin.sliders.create') }}" class="btn btn-success text-dark px-3 py-2 fw-bolder">
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
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Phụ đề</th>
                        <th>Link</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sliders as $index => $slider)
                    <tr>
                        <td>{{ ($sliders->currentPage() - 1) * $sliders->perPage() + $index + 1 }}</td>
                        <td>
                            @if($slider->image)
                                <img src="{{ strpos($slider->image, 'http') === 0 ? $slider->image : (strpos($slider->image, 'sliders/') !== false ? Storage::url($slider->image) : '/' . $slider->image) }}" 
                                     alt="{{ $slider->title }}" 
                                     style="width: 100px; height: 60px; object-fit: cover; border-radius: 4px;">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $slider->title ?? '-' }}</strong>
                            @if($slider->product)
                                <br><small class="text-muted">Từ: {{ $slider->product->Title }}</small>
                            @endif
                        </td>
                        <td>{{ $slider->subtitle ?? '-' }}</td>
                        <td>
                            @if($slider->link)
                                <a href="{{ $slider->link }}" target="_blank" class="text-primary">
                                    <i class="bx bx-link-external"></i> Xem
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $slider->order }}</td>
                        <td>
                            @if($slider->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Tạm dừng</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger btnDeleteAsk" data-id="{{ $slider->id }}" data-url="{{ route('admin.sliders.destroy', $slider->id) }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Chưa có slider nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $sliders->links() }}
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa slider này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger delete-forever">Xóa</button>
            </div>
        </div>
    </div>
</div>
@endsection

