@extends('admin.main')
@section('contents')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
    <div class="card">
        <div class="card-header">
            <h5 class="fw-bold">Chỉnh sửa slider</h5>
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
            
            <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data" data-validate="false">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tiêu đề</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $slider->title) }}" placeholder="VD: Bộ sưu tập Thu - Đông 2030">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Phụ đề</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $slider->subtitle) }}" placeholder="VD: Bộ sưu tập mùa hè">
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Mô tả</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Mô tả về slider">{{ old('description', $slider->description) }}</textarea>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Chọn sản phẩm (tùy chọn)</label>
                        <select name="product_id" id="product_id" class="form-select">
                            <option value="">-- Chọn sản phẩm để lấy ảnh --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                    data-thumb="{{ $product->thumb }}" 
                                    data-slug="{{ $product->slug }}" 
                                    data-title="{{ $product->Title }}"
                                    {{ $slider->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->Title }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Nếu chọn sản phẩm, ảnh và link sẽ tự động lấy từ sản phẩm</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Hình ảnh hiện tại</label>
                        <div class="mb-2">
                            @if($slider->image)
                                <img src="{{ strpos($slider->image, 'http') === 0 ? $slider->image : (strpos($slider->image, 'sliders/') !== false ? Storage::url($slider->image) : '/' . $slider->image) }}" 
                                     alt="{{ $slider->title }}" 
                                     id="current_image_preview"
                                     style="max-width: 300px; height: auto; border-radius: 4px;">
                            @endif
                        </div>
                        <label class="form-label fw-bold">Hoặc upload hình ảnh mới</label>
                        <input type="file" name="image" id="image_input" class="form-control" accept="image/*">
                        <small class="text-muted">Để trống nếu không muốn thay đổi. Định dạng: jpeg, png, jpg, gif. Kích thước tối đa: 2MB</small>
                        <div id="product_image_preview" class="mt-2" style="display: none;">
                            <img id="preview_img" src="" alt="Preview" style="max-width: 200px; height: auto; border-radius: 4px;">
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Link</label>
                        <input type="url" name="link" class="form-control" value="{{ old('link', $slider->link) }}" placeholder="VD: https://example.com hoặc /shop">
                        <small class="text-muted">Link khi click vào slider</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Text nút</label>
                        <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $slider->button_text) }}" placeholder="VD: Khám phá cửa hàng">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Thứ tự hiển thị</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $slider->order) }}" min="0">
                        <small class="text-muted">Số nhỏ hơn sẽ hiển thị trước</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Kích hoạt slider
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const imageInput = document.getElementById('image_input');
    const previewDiv = document.getElementById('product_image_preview');
    const previewImg = document.getElementById('preview_img');
    const currentImagePreview = document.getElementById('current_image_preview');
    const titleInput = document.querySelector('input[name="title"]');
    const linkInput = document.querySelector('input[name="link"]');
    
    console.log('Elements:', {productSelect, previewDiv, previewImg, titleInput, linkInput});
    
    // Khi chọn sản phẩm - sử dụng jQuery để tránh conflict
    if (typeof jQuery !== 'undefined' && productSelect) {
        jQuery(productSelect).off('change').on('change', function(e) {
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            const $select = jQuery(this);
            const selectedOption = this.options[this.selectedIndex];
            const productId = this.value;
            
            console.log('Product selected:', productId, selectedOption);
            
            if (productId && selectedOption) {
                const thumb = jQuery(selectedOption).data('thumb') || selectedOption.getAttribute('data-thumb');
                const slug = jQuery(selectedOption).data('slug') || selectedOption.getAttribute('data-slug');
                const title = jQuery(selectedOption).data('title') || selectedOption.getAttribute('data-title');
                
                console.log('Product data:', {thumb, slug, title});
                
                // Hiển thị preview ảnh sản phẩm
                if (thumb && previewImg && previewDiv) {
                    let imageUrl = thumb;
                    if (!thumb.startsWith('http') && !thumb.startsWith('/')) {
                        imageUrl = '/' + thumb;
                    } else if (!thumb.startsWith('http')) {
                        imageUrl = thumb;
                    }
                    
                    previewImg.src = imageUrl;
                    previewImg.onerror = function() {
                        console.error('Failed to load image:', imageUrl);
                        this.style.display = 'none';
                    };
                    previewImg.onload = function() {
                        this.style.display = 'block';
                        previewDiv.style.display = 'block';
                        console.log('Preview image loaded:', imageUrl);
                    };
                    previewDiv.style.display = 'block';
                    
                    if (currentImagePreview) {
                        currentImagePreview.style.display = 'none';
                    }
                }
                
                // Tự động điền title và link (luôn điền khi chọn sản phẩm)
                if (title && titleInput) {
                    titleInput.value = title;
                    console.log('Title set:', title);
                }
                if (slug && linkInput) {
                    linkInput.value = '/products/details/' + slug;
                    console.log('Link set:', '/products/details/' + slug);
                }
            } else {
                if (previewDiv) {
                    previewDiv.style.display = 'none';
                }
                if (currentImagePreview) {
                    currentImagePreview.style.display = 'block';
                }
            }
        });
    } else if (productSelect) {
        // Fallback nếu không có jQuery
        productSelect.addEventListener('change', function(e) {
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            const selectedOption = this.options[this.selectedIndex];
            const productId = this.value;
            
            console.log('Product selected:', productId, selectedOption);
            
            if (productId && selectedOption) {
                const thumb = selectedOption.getAttribute('data-thumb');
                const slug = selectedOption.getAttribute('data-slug');
                const title = selectedOption.getAttribute('data-title');
                
                console.log('Product data:', {thumb, slug, title});
                
                // Hiển thị preview ảnh sản phẩm
                if (thumb && previewImg && previewDiv) {
                    let imageUrl = thumb;
                    if (!thumb.startsWith('http') && !thumb.startsWith('/')) {
                        imageUrl = '/' + thumb;
                    }
                    
                    previewImg.src = imageUrl;
                    previewImg.onerror = function() {
                        console.error('Failed to load image:', imageUrl);
                    };
                    previewDiv.style.display = 'block';
                    console.log('Preview image set:', imageUrl);
                    
                    if (currentImagePreview) {
                        currentImagePreview.style.display = 'none';
                    }
                }
                
                // Tự động điền title và link
                if (title && titleInput) {
                    titleInput.value = title;
                    console.log('Title set:', title);
                }
                if (slug && linkInput) {
                    linkInput.value = '/products/details/' + slug;
                    console.log('Link set:', '/products/details/' + slug);
                }
            } else {
                if (previewDiv) {
                    previewDiv.style.display = 'none';
                }
                if (currentImagePreview) {
                    currentImagePreview.style.display = 'block';
                }
            }
        });
    }
    
    // Khi upload ảnh, clear product selection
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            e.stopPropagation();
            if (this.files.length > 0 && productSelect) {
                productSelect.value = '';
                if (previewDiv) {
                    previewDiv.style.display = 'none';
                }
                if (currentImagePreview) {
                    currentImagePreview.style.display = 'none';
                }
            }
        });
    }
    
    // Load preview nếu đã chọn sản phẩm
    if (productSelect && productSelect.value) {
        productSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection

