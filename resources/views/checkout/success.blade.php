@extends('layouts.layout')
@section('content')

<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Thanh toán thành công!</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <span>thanh toán thành công</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <div class="success-info text-center mt-5 mb-4">
        <div class="success-animation">
            <svg style="width: 120px; height: 120px" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#28a745" viewBox="0 0 256 256">
                <circle cx="128" cy="128" r="120" fill="#28a745" opacity="0.1"/>
                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm45.66,85.66-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35a8,8,0,0,1,11.32,11.32Z" fill="#28a745"/>
            </svg>
        </div>
        <h1 class="mt-4 mb-2" style="color: #28a745; font-weight: 700;">Đặt hàng thành công!</h1>
        <p class="text-muted mb-4">Cảm ơn bạn đã mua sắm tại cửa hàng chúng tôi</p>
        <div class="success-actions">
            <a href="{{ route('home') }}" class="btn btn-outline-primary me-2">
                <i class="fa fa-home me-2"></i>Về trang chủ
            </a>
            <a href="{{ route('products.shop') }}" class="btn btn-primary">
                <i class="fa fa-shopping-bag me-2"></i>Tiếp tục mua sắm
            </a>
        </div>
    </div>
    <div class="container my-5 pb-5">
        <div class="dashboard-block  mt-0">
            <h4 class="block-title mb-3 bg-success p-2 text-white" style="border-radius: 6px; width:fit-content">Đơn hàng</h4>

            <div class="my-items">
                <!-- Start List Title -->
                <div class="item-list-title">
                    <div class="row align-items-center text-center bg-light pt-2">
                        <div class="col-1 ">
                            <p class="font-weight-bold">STT</p>
                        </div>
                        <div class="col-md-1 col-12">
                            <p class="font-weight-bold">Ảnh</p>
                        </div>
                        <div class="col-md-4 col-12">
                            <p class="font-weight-bold">Tên sản phẩm</p>
                        </div>
                        <div class="col-md-2 col-12 ">
                            <p class="font-weight-bold">Giá</p>
                        </div>
                        <div class="col-md-2 col-12 ">
                            <p class="font-weight-bold">Số lượng</p>
                        </div>
                        <div class="col-md-2 col-12 ">
                            <p class="font-weight-bold">Tổng</p>
                        </div>
                    </div>
                </div>
                <!-- End List Title -->
                <!-- Start Single List -->
                <div class="infor-product-session"></div>

                <h4 class="mt-4 mb-3">Địa chỉ người nhận: </h4>
                <div class="infor-address-session"></div>

                <div class="order-summary-card mt-4 p-4 bg-light rounded">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-clock-o me-2 text-primary" style="font-size: 20px;"></i>
                                <div>
                                    <small class="text-muted d-block">Thời gian đặt hàng</small>
                                    <h6 class="mb-0 fw-bold">{{$time}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-money me-2 text-success" style="font-size: 20px;"></i>
                                <div>
                                    <small class="text-muted d-block">Tổng tiền</small>
                                    <h5 class="total mb-0 fw-bold text-success"></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
                <!-- End Items Area -->
                
                @if($order->payment_method == 'qr' && isset($qrConfigs) && $qrConfigs->count() > 0)
                <div class="qr-payment-section mt-5">
                    <div class="card border-primary shadow-sm" style="border-width: 2px;">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h5 class="mb-0 fw-bold text-white"><i class="fa fa-qrcode me-2"></i> THÔNG TIN THANH TOÁN CHUYỂN KHOẢN</h5>
                        </div>
                        <div class="card-body p-4 bg-white">
                            <div class="row align-items-center">
                                @foreach($qrConfigs as $config)
                                <div class="col-md-5 text-center mb-4 mb-md-0">
                                    <div class="qr-image-wrapper p-3 border rounded bg-white d-inline-block shadow-sm">
                                        <img src="/temp/images/qr-payment/{{ $config->qr_image }}" alt="QR Code" class="img-fluid" style="max-height: 250px;">
                                        <div class="mt-2 small text-muted">Quét mã để thanh toán</div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="bank-details p-3 bg-light rounded border">
                                        <div class="mb-3 d-flex justify-content-between border-bottom pb-2">
                                            <span class="text-muted">Ngân hàng:</span>
                                            <span class="fw-bold">{{ $config->bank_name }}</span>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-between border-bottom pb-2">
                                            <span class="text-muted">Số tài khoản:</span>
                                            <span class="fw-bold text-primary">{{ $config->account_number }}</span>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-between border-bottom pb-2">
                                            <span class="text-muted">Chủ tài khoản:</span>
                                            <span class="fw-bold">{{ $config->account_name }}</span>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-between border-bottom pb-2">
                                            <span class="text-muted">Số tiền:</span>
                                            <span class="fw-bold text-danger fs-5">{{ number_format($order->total) }} VNĐ</span>
                                        </div>
                                        <div class="mb-0">
                                            <small class="text-muted d-block mb-1">Nội dung chuyển khoản:</small>
                                            <div class="p-2 bg-white border rounded fw-bold text-center text-primary shadow-sm">
                                                THANH TOAN DON HANG {{ $order->order_number }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <hr class="my-4">

                            <div class="payment-proof-upload">
                                <h6 class="fw-bold mb-3"><i class="fa fa-upload me-2 text-primary"></i> Gửi hóa đơn/Bill thanh toán:</h6>
                                
                                @php
                                    $proof = \App\Models\PaymentProof::where('order_id', $order->id)->first();
                                @endphp

                                @if($proof)
                                    <div class="alert {{ $proof->status == 'approved' ? 'alert-success border-success' : ($proof->status == 'rejected' ? 'alert-danger border-danger' : 'alert-info border-info') }} d-flex align-items-center mb-0">
                                        <div class="flex-grow-1">
                                            @if($proof->status == 'pending')
                                                <i class="fa fa-spinner fa-spin me-2"></i> <strong>Đang chờ xác minh:</strong> Admin đang kiểm tra bill của bạn.
                                            @elseif($proof->status == 'approved')
                                                <i class="fa fa-check-circle me-2"></i> <strong>Đã hoàn tất:</strong> Thanh toán đã được xác nhận.
                                            @else
                                                <i class="fa fa-times-circle me-2"></i> <strong>Bị từ chối:</strong> 
                                                {{ $proof->rejection_reason ?? 'Vui lòng kiểm tra lại thông tin chuyển khoản.' }}
                                            @endif
                                        </div>
                                        @if($proof->status == 'rejected')
                                            <button class="btn btn-sm btn-danger ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#re-upload-form">Gửi lại bill</button>
                                        @endif
                                    </div>
                                @endif

                                @if(!$proof || $proof->status == 'rejected')
                                    <div id="re-upload-form" class="{{ $proof && $proof->status == 'rejected' ? 'collapse' : '' }} mt-3">
                                        <form action="{{ route('orders.upload-payment-proof', $order->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group mb-2">
                                                <input type="file" name="proof_image" class="form-control" accept="image/*" required>
                                                <button class="btn btn-primary px-4 fw-bold" type="submit">Gửi bill thanh toán</button>
                                            </div>
                                            <div class="form-text text-muted"><i class="fa fa-info-circle me-1"></i> Định dạng ảnh: JPG, PNG. Dung lượng tối đa: 2MB.</div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
    </div>

<style>
    .success-animation {
        animation: scaleIn 0.5s ease-out;
    }
    
    @keyframes scaleIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    .success-info h1 {
        animation: fadeInUp 0.6s ease-out 0.2s both;
    }
    
    .success-info p {
        animation: fadeInUp 0.6s ease-out 0.4s both;
    }
    
    .success-actions {
        animation: fadeInUp 0.6s ease-out 0.6s both;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .order-summary-card {
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .order-summary-card:hover {
        border-color: #28a745;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.1);
    }
    
    .item-list-title {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 8px 8px 0 0;
    }
    
    .item-list-title p {
        color: white;
        font-weight: 600;
        margin: 0;
        padding: 12px 0;
    }
</style>
@endsection
