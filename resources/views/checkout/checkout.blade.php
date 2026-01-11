@extends('layouts.layout')
@section('content')

<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Mua hàng</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <a href="/cart">Giỏ hàng</a>
                        <span>Mua hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <div class="container my-5">
        <div class="row">
            <div class="dashboard-block col-md-9 col-12 mt-0">

                <div class="my-items">
                    <!-- Start List Title -->
                    <div class="item-list-title">
                        <div class="row align-items-center text-center bg-light pt-2">
                            <div class="col-1 ">
                                <p>STT</p>
                            </div>
                            <div class="col-md-1 col-12">
                                <p>Ảnh</p>
                            </div>
                            <div class="col-md-4 col-12">
                                <p>Tên sản phẩm</p>
                            </div>
                            <div class="col-md-2 col-12 ">
                                <p>Size-Color</p>
                            </div>
                            <div class="col-md-2 col-12 ">
                                <p>Số lượng</p>
                            </div>
                            <div class="col-md-2 col-12 ">
                                <p>Tổng</p>
                            </div>
                        </div>
                    </div>
                    <!-- End List Title -->
                    <!-- Start Single List -->
                    <div class="infor-product-session"></div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-end">
                            <div class="order-summary-details" style="min-width: 300px;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Tổng tiền sản phẩm:</span>
                                    <span class="font-weight-bold original-total">0 VNĐ</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 discount-row" style="display: none !important;">
                                    <span class="text-success">
                                        <i class="bx bx-gift"></i> Giảm giá:
                                    </span>
                                    <span class="text-success font-weight-bold discount-amount">0 VNĐ</span>
                                </div>
                                <div class="border-top pt-2 mt-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="font-weight-bold mb-0">Tổng thanh toán:</h5>
                                        <h5 class="total mb-0 ms-2 font-weight-bold text-primary">0 VNĐ</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End Items Area -->
            </div>
            <div class="col-md-3 col-12">
                <ul id="nav" class="navbar-nav ms-auto mb-2">
                    <li class="nav-item">
                        <div class="header__top__hover">
                            <h5 class="font-weight-bold">- Địa chỉ đã có <i class="arrow_carrot-down"></i></h5>
                            <ul>
                                @if(count($addresses) > 0)
                                @foreach($addresses as $address)
                                    <li data-address-id="{{$address->id}}" class="nav-item address-exist py-2 border" id="address-exist-{{$address->id}}">
                                        <a href="javascript:void(0)">
                                            <span style="width:max-content" class="text-dark font-weight-bold sdt">{{$address->sdt}} </span>
                                            <span style="width:max-content" class="text-dark font-weight-bold name">{{$address->name}} </span>
                                            <span style="width:max-content" class="text-dark font-weight-bold country">{{$address->Country}} </span>
                                            <span style="width:max-content" class="text-dark font-weight-bold province">{{$address->province}} </span>
                                            <span style="width:max-content" class="text-dark font-weight-bold district">{{$address->district}} </span>
                                            <span style="width:max-content" class="text-dark font-weight-bold wards">{{$address->wards}} </span>
                                            <span style="width:max-content" class="text-dark font-weight-bold address">{{$address->address}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li  class="nav-item address-exist" >
                                    <a href="javascript:void(0)">
                                        Chưa có địa chỉ nào, vui lòng nhập địa chỉ!
                                    </a>
                                </li>
                            @endif
                            </ul>
                        </div>
                    </li>

                </ul>

                <h5 class="font-weight-bold">- Nhập địa chỉ mới:</h5>
                <form method="post" action="{{route('checkout.checkout')}}" id="form-process-checkout" class=" mt-4">
                    @csrf
                    <input type="hidden" name="coupon_code" id="hidden_coupon_code" value="">
                    <div id="total-price"></div>
                    <div id="total-price2"></div>
                    <div class="error">
                        @include('admin.error')
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Số điện thoại</label>
                        <input type="text" name="sdt" class="input-field form-control input-sdt" data-required="Mời nhập số điện thoại" id="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Họ tên</label>
                        <input type="text" name="name" class="input-field form-control input-name" data-required="Mời nhập tên" id="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Đất nước</label>
                        <input type="text" name="Country" class="input-field form-control input-country" data-required="Mời nhập quốc gia" id="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Tỉnh / Thành phố</label>
                        <input type="text" name="province" class="input-field form-control input-province" data-required="Mời nhập tỉnh " id="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Quận / Huyện</label>
                        <input type="text" name="district" class="input-field form-control input-district" data-required="Mời nhập quận / huyện " id="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Xã / Phường</label>
                        <input type="text" name="wards" class="input-field form-control input-wards" data-required="Mời nhập xã / phường" id="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Thôn / Xóm / Đường / Số nhà</label>
                        <input type="text" name="address" class="input-field form-control input-address" data-required="Mời nhập địa chỉ cụ thể" id="" aria-describedby="emailHelp">
                    </div>
                    
                    <!-- Mã giảm giá -->
                    <div class="mb-3 mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-bold text-dark fs-6 mb-0">Mã giảm giá</label>
                            <a href="{{ route('coupons.index') }}" class="btn btn-sm btn-link text-primary p-0" target="_blank">
                                <i class="bx bx-gift"></i> Xem mã giảm giá có sẵn
                            </a>
                        </div>
                        <div class="coupon-section">
                            <div class="input-group">
                                <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="Nhập mã giảm giá" value="">
                                <button type="button" class="btn btn-outline-primary" id="btn-apply-coupon">
                                    <span class="btn-text-apply">Áp dụng</span>
                                    <span class="btn-loading-apply d-none">
                                        <span class="spinner-border spinner-border-sm" role="status"></span>
                                    </span>
                                </button>
                            </div>
                            <div id="coupon-message" class="mt-2"></div>
                            <div id="coupon-info" class="mt-2 d-none">
                                <div class="alert alert-success d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong id="coupon-name"></strong>
                                        <div class="small">Giảm: <span id="coupon-discount"></span> VNĐ</div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0" id="btn-remove-coupon">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Phương thức thanh toán -->
                    <div class="mb-3 mt-4">
                        <label class="form-label fw-bold text-dark fs-6 mb-3">Phương thức thanh toán</label>
                        <div class="payment-methods">
                            <div class="payment-option mb-2">
                                <input type="radio" name="payment_method" id="payment_cod" value="cod" checked class="payment-method-radio">
                                <label for="payment_cod" class="payment-method-label">
                                    <div class="d-flex align-items-center p-3 border rounded payment-card">
                                        <div class="payment-icon me-3">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20 4H4C2.89 4 2 4.89 2 6V18C2 19.11 2.89 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.11 4 20 4ZM20 18H4V8H20V18ZM20 6H4V6H20Z" fill="#28a745"/>
                                                <path d="M6 14H18V16H6V14Z" fill="#28a745"/>
                                            </svg>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">Thanh toán khi nhận hàng (COD)</h6>
                                            <small class="text-muted">Thanh toán bằng tiền mặt khi nhận được hàng</small>
                                        </div>
                                        <div class="payment-check">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="12" r="10" fill="#28a745"/>
                                                <path d="M8 12L11 15L16 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @if(isset($qrConfigs) && $qrConfigs->count() > 0)
                            <div class="payment-option mb-2">
                                <input type="radio" name="payment_method" id="payment_qr" value="qr" class="payment-method-radio">
                                <label for="payment_qr" class="payment-method-label">
                                    <div class="d-flex align-items-center p-3 border rounded payment-card">
                                        <div class="payment-icon me-3">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="3" y="3" width="18" height="18" rx="2" stroke="#0052A5" stroke-width="2" fill="white"/>
                                                <rect x="6" y="6" width="4" height="4" fill="#0052A5"/>
                                                <rect x="14" y="6" width="4" height="4" fill="#0052A5"/>
                                                <rect x="6" y="14" width="4" height="4" fill="#0052A5"/>
                                                <rect x="12" y="10" width="6" height="2" fill="#0052A5"/>
                                                <rect x="12" y="14" width="6" height="2" fill="#0052A5"/>
                                            </svg>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">Thanh toán qua QR Code</h6>
                                            <small class="text-muted">Quét QR code để thanh toán, sau đó upload bill để xác minh</small>
                                        </div>
                                        <div class="payment-check">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="12" r="10" fill="#0052A5"/>
                                                <path d="M8 12L11 15L16 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <button class="btn btn-success btn-checkout w-100 fw-bold mt-3 py-3" type="submit" id="btn-submit-checkout">
                        <span class="btn-text">Hoàn tất đặt hàng</span>
                        <span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Đang xử lý...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

<style>
    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .payment-option {
        position: relative;
    }
    
    .payment-method-radio {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .payment-method-label {
        cursor: pointer;
        display: block;
        margin: 0;
    }
    
    .payment-card {
        transition: all 0.3s ease;
        background: #fff;
        cursor: pointer;
        position: relative;
    }
    
    .payment-card:hover {
        border-color: #28a745 !important;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.15);
        transform: translateY(-2px);
    }
    
    .payment-method-radio:checked + .payment-method-label .payment-card {
        border-color: #28a745 !important;
        border-width: 2px;
        background: #f8fff9;
        box-shadow: 0 2px 12px rgba(40, 167, 69, 0.2);
    }
    
    .payment-check {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .payment-method-radio:checked + .payment-method-label .payment-check {
        opacity: 1;
    }
    
    .payment-icon svg {
        transition: transform 0.3s ease;
    }
    
    .payment-card:hover .payment-icon svg {
        transform: scale(1.1);
    }
    
    .btn-checkout {
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }
    
    .btn-checkout:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    .address-exist {
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 6px;
        margin-bottom: 8px;
    }
    
    .address-exist:hover {
        background-color: #f8f9fa;
        border-color: #28a745 !important;
    }
    
    .address-exist.active {
        background-color: #e8f5e9;
        border-color: #28a745 !important;
        border-width: 2px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý chọn địa chỉ đã có
    const addressItems = document.querySelectorAll('.address-exist[data-address-id]');
    addressItems.forEach(item => {
        item.addEventListener('click', function() {
            // Xóa active từ các item khác
            addressItems.forEach(i => i.classList.remove('active'));
            // Thêm active cho item được chọn
            this.classList.add('active');
            
            // Điền thông tin vào form
            const sdt = this.querySelector('.sdt').textContent.trim();
            const name = this.querySelector('.name').textContent.trim();
            const country = this.querySelector('.country').textContent.trim();
            const province = this.querySelector('.province').textContent.trim();
            const district = this.querySelector('.district').textContent.trim();
            const wards = this.querySelector('.wards').textContent.trim();
            const address = this.querySelector('.address').textContent.trim();
            
            document.querySelector('.input-sdt').value = sdt;
            document.querySelector('.input-name').value = name;
            document.querySelector('.input-country').value = country;
            document.querySelector('.input-province').value = province;
            document.querySelector('.input-district').value = district;
            document.querySelector('.input-wards').value = wards;
            document.querySelector('.input-address').value = address;
        });
    });
    
    // Xử lý submit form với loading
    const form = document.getElementById('form-process-checkout');
    const btnSubmit = document.getElementById('btn-submit-checkout');
    
    if (form && btnSubmit) {
        form.addEventListener('submit', function(e) {
            const btnText = btnSubmit.querySelector('.btn-text');
            const btnLoading = btnSubmit.querySelector('.btn-loading');
            
            if (btnText && btnLoading) {
                btnSubmit.disabled = true;
                btnText.classList.add('d-none');
                btnLoading.classList.remove('d-none');
            }
        });
    }
    
    // Hiệu ứng khi chọn phương thức thanh toán
    const paymentRadios = document.querySelectorAll('.payment-method-radio');
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Có thể thêm logic khác nếu cần
        });
    });
    
    // Xử lý mã giảm giá
    const couponCodeInput = document.getElementById('coupon_code');
    const btnApplyCoupon = document.getElementById('btn-apply-coupon');
    const btnRemoveCoupon = document.getElementById('btn-remove-coupon');
    const couponMessage = document.getElementById('coupon-message');
    const couponInfo = document.getElementById('coupon-info');
    let appliedCoupon = null;
    
    function formatNumber(num) {
        return num.toLocaleString('vi-VN');
    }
    
    function getOrderTotal() {
        const totalElement = document.querySelector('.total');
        if (totalElement) {
            const totalText = totalElement.textContent.trim();
            return parseFloat(totalText.replace(/[^\d]/g, '')) || 0;
        }
        return 0;
    }
    
    function getOriginalTotal() {
        const originalTotalElement = document.querySelector('.original-total');
        if (originalTotalElement) {
            const totalText = originalTotalElement.textContent.trim();
            return parseFloat(totalText.replace(/[^\d]/g, '')) || 0;
        }
        // Fallback: lấy từ total nếu chưa có giảm giá
        return getOrderTotal();
    }
    
    if (btnApplyCoupon) {
        btnApplyCoupon.addEventListener('click', function() {
            const code = couponCodeInput.value.trim().toUpperCase();
            
            if (!code) {
                couponMessage.innerHTML = '<div class="alert alert-warning mb-0">Vui lòng nhập mã giảm giá!</div>';
                return;
            }
            
            const btnText = btnApplyCoupon.querySelector('.btn-text-apply');
            const btnLoading = btnApplyCoupon.querySelector('.btn-loading-apply');
            
            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');
            btnApplyCoupon.disabled = true;
            couponMessage.innerHTML = '';
            
            const orderAmount = getOrderTotal();
            
            fetch('{{ route("checkout.validateCoupon") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    coupon_code: code,
                    order_amount: orderAmount
                })
            })
            .then(response => response.json())
            .then(data => {
                btnText.classList.remove('d-none');
                btnLoading.classList.add('d-none');
                btnApplyCoupon.disabled = false;
                
                if (data.success) {
                    appliedCoupon = data.coupon;
                    couponCodeInput.value = data.coupon.code;
                    couponCodeInput.disabled = true;
                    
                    document.getElementById('coupon-name').textContent = data.coupon.name || 'Mã giảm giá: ' + data.coupon.code;
                    document.getElementById('coupon-discount').textContent = formatNumber(data.discount_amount);
                    couponInfo.classList.remove('d-none');
                    couponMessage.innerHTML = '<div class="alert alert-success mb-0">' + data.message + '</div>';
                    
                    // Cập nhật tổng tiền với chi tiết giảm giá
                    updateTotalWithCoupon(data.final_total, data.discount_amount, getOriginalTotal());
                    
                    // Lưu mã vào hidden input
                    document.getElementById('hidden_coupon_code').value = data.coupon.code;
                } else {
                    couponMessage.innerHTML = '<div class="alert alert-danger mb-0">' + data.message + '</div>';
                    couponInfo.classList.add('d-none');
                }
            })
            .catch(error => {
                btnText.classList.remove('d-none');
                btnLoading.classList.add('d-none');
                btnApplyCoupon.disabled = false;
                couponMessage.innerHTML = '<div class="alert alert-danger mb-0">Có lỗi xảy ra! Vui lòng thử lại.</div>';
            });
        });
    }
    
    if (btnRemoveCoupon) {
        btnRemoveCoupon.addEventListener('click', function() {
            appliedCoupon = null;
            couponCodeInput.value = '';
            couponCodeInput.disabled = false;
            couponInfo.classList.add('d-none');
            couponMessage.innerHTML = '';
            
            // Khôi phục tổng tiền ban đầu
            const originalTotal = getOriginalTotal();
            updateTotalWithCoupon(originalTotal, 0, originalTotal);
            
            // Xóa mã khỏi hidden input
            document.getElementById('hidden_coupon_code').value = '';
        });
    }
    
    function updateTotalWithCoupon(newTotal, discountAmount = 0, originalTotal = null) {
        // Cập nhật tổng tiền cuối cùng
        const totalElement = document.querySelector('.total');
        if (totalElement) {
            totalElement.textContent = formatNumber(newTotal) + ' VNĐ';
        }
        
        // Cập nhật tổng tiền ban đầu nếu chưa có
        if (originalTotal !== null) {
            const originalTotalElement = document.querySelector('.original-total');
            if (originalTotalElement && !originalTotalElement.dataset.initialized) {
                originalTotalElement.textContent = formatNumber(originalTotal) + ' VNĐ';
                originalTotalElement.dataset.initialized = 'true';
            }
        }
        
        // Hiển thị/ẩn phần giảm giá
        const discountRow = document.querySelector('.discount-row');
        const discountAmountElement = document.querySelector('.discount-amount');
        
        if (discountAmount > 0 && discountRow && discountAmountElement) {
            discountAmountElement.textContent = '-' + formatNumber(discountAmount) + ' VNĐ';
            discountRow.style.display = 'flex';
        } else if (discountRow) {
            discountRow.style.display = 'none';
        }
        
        // Cập nhật hidden input nếu có
        const totalInput = document.querySelector('input[name="total"]');
        if (totalInput) {
            totalInput.value = newTotal;
        }
    }
    
    // Khởi tạo tổng tiền ban đầu khi trang load (fallback nếu main.js chưa load)
    setTimeout(function() {
        const totalElement = document.querySelector('.total');
        const originalTotalElement = document.querySelector('.original-total');
        if (totalElement && originalTotalElement && !originalTotalElement.dataset.initialized) {
            const currentTotal = getOrderTotal();
            if (currentTotal > 0) {
                originalTotalElement.textContent = formatNumber(currentTotal) + ' VNĐ';
                originalTotalElement.dataset.initialized = 'true';
            }
        }
    }, 1000); // Đợi main.js load xong
    
    // Cho phép nhấn Enter để áp dụng mã
    if (couponCodeInput) {
        couponCodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (btnApplyCoupon && !btnApplyCoupon.disabled) {
                    btnApplyCoupon.click();
                }
            }
        });
    }
});
</script>
@endsection
