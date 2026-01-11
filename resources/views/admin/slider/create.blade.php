@extends('admin.main')
@section('contents')
<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
    <div class="card">
        <div class="card-header">
            <h5 class="fw-bold">Tạo slider mới</h5>
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
            
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" data-validate="false">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tiêu đề</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="VD: Bộ sưu tập Thu - Đông 2030">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Phụ đề</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}" placeholder="VD: Bộ sưu tập mùa hè">
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Mô tả</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Mô tả về slider">{{ old('description') }}</textarea>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Chọn sản phẩm (tùy chọn)</label>
                        <select name="product_id" id="product_id" class="form-select">
                            <option value="">-- Chọn sản phẩm để lấy ảnh --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-thumb="{{ $product->thumb }}" data-slug="{{ $product->slug }}" data-title="{{ $product->Title }}">
                                    {{ $product->Title }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Nếu chọn sản phẩm, ảnh và link sẽ tự động lấy từ sản phẩm</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Hoặc upload hình ảnh</label>
                        <input type="file" name="image" id="image_input" class="form-control" accept="image/*">
                        <small class="text-muted">Định dạng: jpeg, png, jpg, gif. Kích thước tối đa: 2MB</small>
                        <div id="product_image_preview" class="mt-2" style="display: none;">
                            <img id="preview_img" src="" alt="Preview" style="max-width: 200px; height: auto; border-radius: 4px;">
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Link</label>
                        <input type="url" name="link" class="form-control" value="{{ old('link') }}" placeholder="VD: https://example.com hoặc /shop">
                        <small class="text-muted">Link khi click vào slider</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Text nút</label>
                        <input type="text" name="button_text" class="form-control" value="{{ old('button_text', 'Khám phá') }}" placeholder="VD: Khám phá cửa hàng">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Thứ tự hiển thị</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                        <small class="text-muted">Số nhỏ hơn sẽ hiển thị trước</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Kích hoạt slider
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-success">Tạo slider</button>
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
                
                // Hiển thị preview ảnh
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
                
                // Disable image input
                if (imageInput) {
                    imageInput.disabled = true;
                    imageInput.removeAttribute('required');
                    imageInput.value = '';
                }
            } else {
                // Enable image input
                if (imageInput) {
                    imageInput.disabled = false;
                    imageInput.setAttribute('required', 'required');
                }
                if (previewDiv) {
                    previewDiv.style.display = 'none';
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
                
                // Hiển thị preview ảnh
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
                
                // Disable image input
                if (imageInput) {
                    imageInput.disabled = true;
                    imageInput.removeAttribute('required');
                    imageInput.value = '';
                }
            } else {
                // Enable image input
                if (imageInput) {
                    imageInput.disabled = false;
                    imageInput.setAttribute('required', 'required');
                }
                if (previewDiv) {
                    previewDiv.style.display = 'none';
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
            }
        });
    }
});
</script>
@endsection

