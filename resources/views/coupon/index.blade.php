@extends('layouts.layout')
@section('content')

<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Mã giảm giá</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <span>Mã giảm giá</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="coupon-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Mã giảm giá hiện có</h2>
                    <p>Sao chép mã giảm giá và sử dụng khi thanh toán để nhận ưu đãi</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            @forelse($coupons as $coupon)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="coupon-card">
                    <div class="coupon-card-header">
                        <div class="coupon-icon">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 4H4C2.89 4 2 4.89 2 6V18C2 19.11 2.89 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.11 4 20 4ZM20 18H4V8H20V18Z" fill="#ff6b6b"/>
                                <path d="M6 10H18V12H6V10ZM6 14H14V16H6V14Z" fill="#ff6b6b"/>
                            </svg>
                        </div>
                        <h5 class="coupon-title">{{ $coupon->name ?? 'Mã giảm giá' }}</h5>
                    </div>
                    
                    <div class="coupon-card-body">
                        @if($coupon->description)
                        <p class="coupon-description">{{ $coupon->description }}</p>
                        @endif
                        
                        <div class="coupon-code-section">
                            <div class="coupon-code-display">
                                <span class="coupon-code-text" id="coupon-code-{{ $coupon->id }}">{{ $coupon->code }}</span>
                                <button class="btn-copy-coupon" data-coupon-id="{{ $coupon->id }}" data-coupon-code="{{ $coupon->code }}" title="Sao chép mã">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 1H4C2.9 1 2 1.9 2 3V17H4V3H16V1ZM19 5H8C6.9 5 6 5.9 6 7V21C6 22.1 6.9 23 8 23H19C20.1 23 21 22.1 21 21V7C21 5.9 20.1 5 19 5ZM19 21H8V7H19V21Z" fill="currentColor"/>
                                    </svg>
                                    <span class="copy-text">Sao chép</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="coupon-details">
                            <div class="coupon-discount">
                                @if($coupon->type == 'percentage')
                                    <span class="discount-value">{{ $coupon->value }}%</span>
                                    @if($coupon->max_discount)
                                        <span class="discount-max">Tối đa {{ number_format($coupon->max_discount) }} VNĐ</span>
                                    @endif
                                @else
                                    <span class="discount-value">{{ number_format($coupon->value) }} VNĐ</span>
                                @endif
                            </div>
                            
                            @if($coupon->min_order_amount > 0)
                            <div class="coupon-condition">
                                <small>Áp dụng cho đơn hàng từ {{ number_format($coupon->min_order_amount) }} VNĐ</small>
                            </div>
                            @endif
                            
                            @if($coupon->start_date || $coupon->end_date)
                            <div class="coupon-dates">
                                @if($coupon->start_date)
                                    <small>Từ: {{ \Carbon\Carbon::parse($coupon->start_date)->format('d/m/Y') }}</small>
                                @endif
                                @if($coupon->end_date)
                                    <small>Đến: {{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}</small>
                                @endif
                            </div>
                            @endif
                            
                            @if($coupon->usage_limit)
                            <div class="coupon-usage">
                                <small>Còn lại: {{ $coupon->usage_limit - $coupon->used_count }} lượt</small>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="coupon-card-footer">
                        <a href="{{ route('checkout.showcheckout') }}" class="btn-use-coupon">Sử dụng ngay</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h5>Hiện tại không có mã giảm giá nào</h5>
                    <p class="mb-0">Vui lòng quay lại sau!</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<style>
.coupon-section {
    padding: 60px 0;
}

.section-title {
    text-align: center;
    margin-bottom: 50px;
}

.section-title h2 {
    font-size: 36px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 10px;
}

.section-title p {
    color: #666;
    font-size: 16px;
}

.coupon-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.coupon-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.coupon-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 25px;
    text-align: center;
    color: white;
}

.coupon-icon {
    margin-bottom: 10px;
}

.coupon-title {
    font-size: 20px;
    font-weight: 700;
    margin: 0;
    color: white;
}

.coupon-card-body {
    padding: 25px;
    flex-grow: 1;
}

.coupon-description {
    color: #666;
    font-size: 14px;
    margin-bottom: 20px;
    line-height: 1.6;
}

.coupon-code-section {
    margin-bottom: 20px;
}

.coupon-code-display {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8f9fa;
    border: 2px dashed #667eea;
    border-radius: 8px;
    padding: 15px;
    gap: 10px;
}

.coupon-code-text {
    font-size: 24px;
    font-weight: 700;
    color: #667eea;
    letter-spacing: 2px;
    flex-grow: 1;
    text-align: center;
}

.btn-copy-coupon {
    background: #667eea;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 8px 15px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s ease;
    font-size: 14px;
    font-weight: 600;
}

.btn-copy-coupon:hover {
    background: #5568d3;
    transform: scale(1.05);
}

.btn-copy-coupon.copied {
    background: #28a745;
}

.btn-copy-coupon svg {
    width: 18px;
    height: 18px;
}

.coupon-details {
    margin-top: 20px;
}

.coupon-discount {
    text-align: center;
    margin-bottom: 15px;
}

.discount-value {
    font-size: 32px;
    font-weight: 700;
    color: #ff6b6b;
    display: block;
}

.discount-max {
    font-size: 14px;
    color: #666;
    display: block;
    margin-top: 5px;
}

.coupon-condition,
.coupon-dates,
.coupon-usage {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #eee;
}

.coupon-condition small,
.coupon-dates small,
.coupon-usage small {
    color: #666;
    font-size: 13px;
    display: block;
}

.coupon-card-footer {
    padding: 20px 25px;
    background: #f8f9fa;
    border-top: 1px solid #eee;
}

.btn-use-coupon {
    display: block;
    width: 100%;
    background: #28a745;
    color: white;
    text-align: center;
    padding: 12px;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-use-coupon:hover {
    background: #218838;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const copyButtons = document.querySelectorAll('.btn-copy-coupon');
    
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const couponCode = this.getAttribute('data-coupon-code');
            const couponId = this.getAttribute('data-coupon-id');
            const copyText = this.querySelector('.copy-text');
            
            // Copy to clipboard
            navigator.clipboard.writeText(couponCode).then(function() {
                // Thay đổi text và style
                const originalText = copyText.textContent;
                copyText.textContent = 'Đã sao chép!';
                button.classList.add('copied');
                
                // Hiển thị toast notification nếu có toastr
                if (typeof toastr !== 'undefined') {
                    toastr.success('Đã sao chép mã: ' + couponCode, 'Thành công!');
                } else {
                    // Fallback alert
                    alert('Đã sao chép mã: ' + couponCode);
                }
                
                // Khôi phục sau 2 giây
                setTimeout(function() {
                    copyText.textContent = originalText;
                    button.classList.remove('copied');
                }, 2000);
            }).catch(function(err) {
                console.error('Lỗi khi sao chép:', err);
                // Fallback: select text
                const codeElement = document.getElementById('coupon-code-' + couponId);
                if (codeElement) {
                    const range = document.createRange();
                    range.selectNode(codeElement);
                    window.getSelection().removeAllRanges();
                    window.getSelection().addRange(range);
                    try {
                        document.execCommand('copy');
                        if (typeof toastr !== 'undefined') {
                            toastr.success('Đã sao chép mã: ' + couponCode);
                        } else {
                            alert('Đã sao chép mã: ' + couponCode);
                        }
                    } catch (err) {
                        alert('Không thể sao chép. Vui lòng chọn và copy thủ công: ' + couponCode);
                    }
                    window.getSelection().removeAllRanges();
                }
            });
        });
    });
});
</script>

@endsection

