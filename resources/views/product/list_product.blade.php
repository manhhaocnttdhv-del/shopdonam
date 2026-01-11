@extends('layouts.layout')
@section('content')
<style>
    .pagination nav {
    margin: 0 auto; }
.pagination nav div:nth-child(1) {
    display: none; }
.pagination nav div:nth-child(2) span {
    box-shadow: none !important; }
.pagination nav div:nth-child(2) span span span {
    padding: 10px 14px !important;
    border: none !important;
    margin: 0 5px;
    background-color: #696cff !important;
    color: white; }
.pagination nav div:nth-child(2) span a {
    padding: 10px 14px !important;
    border: none !important;
    margin: 0 5px;
    transition: all .3s; }
.pagination nav div:nth-child(2) span a:hover {
    background-color: #696cff !important;
    color: white;
    transition: all .3s; }
.pagination svg {
    width: 20px; }
</style>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shop</h4>
                        <div class="breadcrumb__links">
                            <a href="/">Trang chủ</a>
                            <a href="./shop.html">Cửa hàng</a>
                            <span class="text-info">{{$category->title}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="{{ route('products.showProduct', ['categorySlug' => $categorySlug]) }}">
                                <input type="text" name="nameProduct" class="text-dark" value="{{$nameProduct}}" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Danh mục</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    @foreach($category_no_parent_ids as $item)
                                                        <li><a class="text-dark" href="{{ route('products.showProduct', ['categorySlug' => $item->slug]) }}">{{$item->title}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Hiển thị 1–{{$pages}} trên {{ $products->total() }} kết quả:</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if(count($products) > 0)
                        @foreach($products as $product)
                        <div id="product-infor-list-{{$product->id}}" class="col-lg-4 col-md-6 col-sm-6 product-infor-main">
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
                        @else
                            <h1 class="mt-3">Chưa có sản phẩm!</h1>
                        @endif
                    </div>
                    <div class="row">
                        <div class="pagination">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

@endsection
