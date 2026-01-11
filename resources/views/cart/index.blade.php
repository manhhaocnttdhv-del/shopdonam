@extends('layouts.layout')
@section('content')
<style>
    .number{
        border: 1px solid #D6D8DB;
        border-radius: 3px;
        width: fit-content;
    }
    .numberInput {
        width: 50px;
        text-align: center;
        height: 45px;
        border-top: 0;
        border-bottom: 0;
        border-left: 1px solid #D6D8DB;
        border-right: 1px solid #D6D8DB;
    }
    .product-infor .numberInput:focus{
        outline: none;
    }
    .number {
        display: flex;
        flex-direction: row;
        width: fit-content;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        background: white;
        border: 1px solid #e9ecef;
    }
    
    .numberInput {
        width: 60px;
        text-align: center;
        height: 50px;
        border: none;
        border-left: 1px solid #e9ecef;
        border-right: 1px solid #e9ecef;
        font-size: 18px;
        font-weight: 600;
        color: #333;
        background: white;
    }
    
    .product-infor .numberInput:focus {
        outline: none;
        background: #f8f9fa;
    }
    
    .decreaseButton, .increaseButton {
        width: 45px;
        height: 50px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 24px;
        color: white;
    }
    
    .decreaseButton {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px 0 0 8px;
    }
    
    .increaseButton {
        background: white;
        color: #333;
        border-radius: 0 8px 8px 0;
        position: relative;
    }
    
    .increaseButton::before {
        content: '+';
        position: absolute;
        background: linear-gradient(135deg, #ff6b6b 0%, #667eea 50%, #4ecdc4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: bold;
    }
    
    .decreaseButton:hover {
        background: linear-gradient(135deg, #5568d3 0%, #653a8f 100%);
        transform: translateX(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .increaseButton:hover {
        background: #f8f9fa;
    }
    
    .increaseButton:hover::before {
        background: linear-gradient(135deg, #ff4757 0%, #5568d3 50%, #3db9a8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .decreaseButton:active, .increaseButton:active {
        transform: scale(0.95);
    }
    
    .decreaseButton:disabled, .increaseButton:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0; 
    }
    .product__details__tab__content img{
        height: auto !important;
        width: auto !important;
    }
</style>
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Giỏ hàng</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <a href="/shop">Cửa hàng</a>
                        <span>Giỏ hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <div class="container my-5">
        <div class="dashboard-block mt-0">
            <div class="bg-warning p-2 font-weight-bold" style="width:fit-content; border-radius: 6px">Số lượng: <span>{{count($carts)}}</span></div>
            <!-- Start Items Area -->
            <form class="" action="">

            </form>
            <div class="my-items">
                <!-- Start List Title -->
                <div class="item-list-title">
                    <div class="row align-items-center text-center bg-light mt-3">
                        <div class="col-1 ">
                            <p class="font-weight-bold">STT</p>
                        </div>
                        <div class="col-md-1 col-12">
                            <p class="font-weight-bold">Ảnh</p>
                        </div>
                        <div class="col-md-2 col-12">
                            <p class="font-weight-bold">Tên sản phẩm</p>
                        </div>
                        <div class="col-md-2 col-12 ">
                            <p class="font-weight-bold">Giá</p>
                        </div>
                        <div class="col-md-2 col-12 ">
                            <p class="font-weight-bold">Số lượng</p>
                        </div>
                        <div class="col-md-1 col-12 ">
                            <p class="font-weight-bold">Size-Color</p>
                        </div>
                        <div class="col-md-2 col-12 ">
                            <p class="font-weight-bold">Tổng</p>
                        </div>
                        <div class="col-md-1 col-12 ">
                            <p class="font-weight-bold">Xóa</p>
                        </div>
                    </div>
                </div>
                <!-- End List Title -->
                <!-- Start Single List -->
                @foreach($carts as $cart)
                    <div class="single-item-list text-center border-bottom py-3">
                        <div class="row align-items-center">
                            <div class="col-1">{{ $loop->iteration }}</div>
                            <div class="col-md-1 col-12">
                                <img class="w-100 thumb-product" src="{{$cart->thumb}}" alt="{{$cart->nameProduct}}">
                            </div>
                            <div class="col-md-2 col-12">
                                <a class="title-product" href="{{ route('products.details', ['slug' =>$cart->product->slug]) }}"><h6 class="text-primary font-weight-bold ">{{$cart->nameProduct}}</h6></a>
                            </div>
                            <div class="col-md-2 col-12">
                                <span class="price price-product">{{ number_format($cart->price) }} VNĐ</span>
                            </div>
                            <div class="col-md-2 col-12 product-infor form-add-to-cart" id="form-add-to-cart-{{$cart->id}}">
                                <div class="number mx-auto">
                                    <button type="button" class="decreaseButton">-</button>
                                    <input name="quanity" class="quantity numberInput" type="number" inputmode="numeric" data-cart-id="{{ $cart->id }}"
                                           value="{{ $cart->quanity ?? $cart->quantity ?? 1 }}" min="1" max="{{ $cart->product->Amounts ?? 999 }}">
                                    <button type="button" class="increaseButton">+</button>
                                </div>
                            </div>
                            <div class="col-md-1 col-12">
                                <span class="size_color">{{$cart->sizes}} - {{$cart->colors}} </span>
                            </div>
                            <div class="col-md-2 col-12">
                                <span id="subtotal-{{ $cart->id }}" class="subtotal">{{ number_format($cart->subtotal) }} VNĐ</span>
                            </div>
                            <div class="col-md-1 col-12 align-right">
                                <form method="post" action="{{ route('carts.destroy', ['id' => $cart->id]) }}" class="action-btn text-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 bg-transparent">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between  mt-3">
                    <a href="" id="updateCartButton" class="btn btn-success">Cập nhật</a>
                    <a href="" id="buy-products" class="btn btn-info">Mua hàng</a>
                </div>

                <!-- End Single List -->
                <!-- Pagination -->
                <div class="pagination left">
                    <div class="pagination mt-4 pb-4">
                        {{ $carts->links() }}
                    </div>
                </div>
                <!--/ End Pagination -->
            </div>
            <!-- End Items Area -->
        </div>

    </div>

<script>
// Fix ngay: Tăng giảm số lượng trong giỏ hàng
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý button giảm
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('decreaseButton') || e.target.closest('.decreaseButton')) {
            e.preventDefault();
            e.stopPropagation();
            
            var button = e.target.classList.contains('decreaseButton') ? e.target : e.target.closest('.decreaseButton');
            var formContainer = button.closest('.form-add-to-cart');
            var numberInput = formContainer ? formContainer.querySelector('.numberInput') : null;
            
            if (numberInput) {
                var currentValue = parseInt(numberInput.value, 10) || 0;
                var minValue = parseInt(numberInput.getAttribute('min')) || 1;
                
                if (currentValue > minValue) {
                    numberInput.value = currentValue - 1;
                    numberInput.dispatchEvent(new Event('change', { bubbles: true }));
                    updateSubtotal(numberInput);
                }
            }
        }
        
        // Xử lý button tăng
        if (e.target.classList.contains('increaseButton') || e.target.closest('.increaseButton')) {
            e.preventDefault();
            e.stopPropagation();
            
            var button = e.target.classList.contains('increaseButton') ? e.target : e.target.closest('.increaseButton');
            var formContainer = button.closest('.form-add-to-cart');
            var numberInput = formContainer ? formContainer.querySelector('.numberInput') : null;
            
            if (numberInput) {
                var currentValue = parseInt(numberInput.value, 10) || 0;
                var maxValue = parseInt(numberInput.getAttribute('max')) || 9999;
                
                if (currentValue < maxValue) {
                    numberInput.value = currentValue + 1;
                    numberInput.dispatchEvent(new Event('change', { bubbles: true }));
                    updateSubtotal(numberInput);
                }
            }
        }
    });
    
    // Hàm cập nhật subtotal
    function updateSubtotal(numberInput) {
        var cartId = numberInput.getAttribute('data-cart-id');
        if (cartId) {
            var newQuantity = parseInt(numberInput.value, 10) || 0;
            var priceElement = numberInput.closest('.single-item-list').querySelector('.price-product');
            if (priceElement) {
                var priceText = priceElement.textContent;
                var price = parseFloat(priceText.replace(/[^\d]/g, '')) || 0;
                var subtotal = newQuantity * price;
                var subtotalElement = document.getElementById('subtotal-' + cartId);
                if (subtotalElement) {
                    subtotalElement.textContent = subtotal.toLocaleString('en-US') + ' VNĐ';
                }
            }
        }
    }
    
    // Fallback với jQuery
    if (typeof jQuery !== 'undefined') {
        jQuery(document).ready(function($) {
            $(document).off('click', '.decreaseButton').on('click', '.decreaseButton', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var formContainer = $(this).closest('.form-add-to-cart');
                var numberInput = formContainer.find('.numberInput');
                var currentValue = parseInt(numberInput.val(), 10) || 0;
                var minValue = parseInt(numberInput.attr('min')) || 1;
                
                if (currentValue > minValue) {
                    numberInput.val(currentValue - 1).trigger('change');
                }
            });
            
            $(document).off('click', '.increaseButton').on('click', '.increaseButton', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var formContainer = $(this).closest('.form-add-to-cart');
                var numberInput = formContainer.find('.numberInput');
                var currentValue = parseInt(numberInput.val(), 10) || 0;
                var maxValue = parseInt(numberInput.attr('max')) || 9999;
                
                if (currentValue < maxValue) {
                    numberInput.val(currentValue + 1).trigger('change');
                }
            });
        });
    }
});
</script>
@endsection
