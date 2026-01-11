@extends('layouts.layout')
@section('content')

<section class="hero">
    <div class="hero__slider owl-carousel">
        @forelse($sliders as $slider)
        <div class="hero__items set-bg" data-setbg="{{ strpos($slider->image, 'http') === 0 ? $slider->image : (strpos($slider->image, 'sliders/') !== false ? Storage::url($slider->image) : '/' . $slider->image) }}" style="background-image: url('{{ strpos($slider->image, 'http') === 0 ? $slider->image : (strpos($slider->image, 'sliders/') !== false ? Storage::url($slider->image) : '/' . $slider->image) }}');">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-7 col-md-8">
                        <div class="hero__text">
                            @if($slider->subtitle)
                            <h6>{{ $slider->subtitle }}</h6>
                            @endif
                            @if($slider->title)
                            <h2>{{ $slider->title }}</h2>
                            @endif
                            @if($slider->description)
                            <p>{{ $slider->description }}</p>
                            @endif
                            @if($slider->link)
                            <a href="{{ $slider->link }}" class="primary-btn">
                                {{ $slider->button_text ?? 'Khám phá' }} <span class="arrow_right"></span>
                            </a>
                            @endif
                            <div class="hero__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        {{-- Fallback nếu không có slider nào --}}
        <div class="hero__items set-bg" data-setbg="/temp/assets/img/hero/hero-1.jpg" style="background-image: url('/temp/assets/img/hero/hero-1.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-7 col-md-8">
                        <div class="hero__text">
                            <h6>Bộ sưu tập mùa hè</h6>
                            <h2>Bộ sưu tập Thu - Đông 2030</h2>
                            <p>Một thương hiệu chuyên sản xuất các sản phẩm thiết yếu cao cấp. Được chế tác một cách có đạo đức với cam kết không thay đổi về chất lượng xuất sắc.</p>                            
                            <a href="/shop" class="primary-btn">Khám phá cửa hàng <span class="arrow_right"></span></a>
                            <div class="hero__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</section>
{{-- 
<section class="banner spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 offset-lg-4">
                <div class="banner__item">
                    <div class="banner__item__pic">
                        <img src="/temp/assets/img/banner/banner-1.jpg" alt="">
                    </div>
                    <div class="banner__item__text">
                        <h2>Bộ sưu tập trang phục 2030</h2>
                        <a href="/shop">Khám phá cửa hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="banner__item banner__item--middle">
                    <div class="banner__item__pic">
                        <img src="/temp/assets/img/banner/banner-2.jpg" alt="">
                    </div>
                    <div class="banner__item__text">
                        <h2>Phụ kiện</h2>
                        <a href="/shop">Khám phá cửa hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="banner__item banner__item--last">
                    <div class="banner__item__pic">
                        <img src="/temp/assets/img/banner/banner-3.jpg" alt="">
                    </div>
                    <div class="banner__item__text">
                        <h2>Giày mùa xuân 2030</h2>
                        <a href="/shop">Khám phá cửa hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">Sản phẩm mới</li>
                </ul>
            </div>
        </div>
        <div class="row product__filter" id="MixItUp086433">
            @foreach($product_hots as $product)
                <div id="product-infor-list-{{$product->id}}" class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals product-infor-main">
                    <input type="number" hidden class="quantity" value="1">
                    <div class="product__item">
                        <div class="product__item__pic set-bg position-relative" data-setbg="/temp/images/product/{{$product->thumb}}">
                            <img class="thumb-product d-none" src="/temp/images/product/{{$product->thumb}}" alt="{{$product->title}}">
                            <a href="{{ route('products.details', ['slug' =>$product->slug]) }}" class="detail-product-bg position-absolute" style="bottom: 0; top: 0; right: 0; left: 0"></a>
                            <a href="" class="badge badge-warning position-relative z-20">{{$product->Category->title}}</a>
                            <ul class="product__hover">
                                <li><a href="{{ route('products.details', ['slug' =>$product->slug]) }}"><img src="/temp/assets/img//icon/search.png" alt=""><span>Chi tiết</span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6 class="my-2 title-product">{{$product->Title}}</h6>
                            <a data-user-id="{{ Auth::id() }}" data-product-id="{{$product->id}}" data-quantity="{{ $product->Amounts }}" href="{{ route('products.details', ['slug' =>$product->slug]) }}"class="add-cart">Chi tiết sản phẩm</a>
                            <div class="border-top pt-2">
                                @if($product->discount > 0)
                                    <div class="discount text-danger font-weight-bold" style="text-decoration: line-through; font-size:13px">{{ number_format($product->price) }} VNĐ</div>
                                    <div class="price okPrice-product text-info font-weight-bold">{{ number_format($product->discount) }} VNĐ</div>
                                @else
                                    <div class="price okPrice-product text-info font-weight-bold">{{ number_format($product->price) }} VNĐ</div>
                                @endif
                            </div>
                            <div class="product__color__select">
                                <label for="pc-4">
                                    <input type="radio" id="pc-4">
                                </label>
                                <label class="active black" for="pc-5">
                                    <input type="radio" id="pc-5">
                                </label>
                                <label class="grey" for="pc-6">
                                    <input type="radio" id="pc-6">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="latest spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Tin tức mới</span>
                    <h2>Xu hướng thời trang mới</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($post_hots as $item)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="/temp/images/post/{{$item->thumb}}" alt="{{ $item->Title }}"></div>
                        <div class="blog__item__text">
                            <span><img src="/temp/assets/img/icon/calendar.png" alt=""> {{$item->updated_at}}</span>
                            <h5>{{ $item->Title }}</h5>
                            <a href="{{ route('posts.details', ['slug' =>$item->slug]) }}">Đọc thêm</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
