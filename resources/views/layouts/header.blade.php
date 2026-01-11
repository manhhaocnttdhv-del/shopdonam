<style>
    /* Dropdown menu improvements */
    .navbar-nav li:hover > ul.dropdown-menu {
        display: block;
        animation: fadeInDown 0.3s ease;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .dropdown-submenu {
        position: relative;
    }
    
    .dropdown-submenu > .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-radius: 8px;
    }
    
    .dropdown-menu {
        border-radius: 8px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        padding: 8px 0;
    }
    
    .dropdown-menu > li > a {
        padding: 10px 20px;
        transition: all 0.3s ease;
    }
    
    .dropdown-menu > li > a:hover {
        background-color: #f8f9fa;
        padding-left: 25px;
    }
    
    /* Cart badge improvements */
    .header__nav__option a {
        position: relative;
        transition: transform 0.3s ease;
    }
    
    .header__nav__option a:hover {
        transform: scale(1.1);
    }
    
    .header__nav__option .text-danger {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ff4757;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }
    
    /* Toast notifications */
    .toast-success {
        background-color: #198754 !important;
    }
    
    .toast-error {
        background-color: #dc3545 !important;
    }
    
    /* Header top improvements */
    .header__top {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .header__top__left p {
        color: white;
        margin: 0;
        font-weight: 500;
    }
    
    /* Logo hover effect */
    .header__logo img {
        transition: transform 0.3s ease;
    }
    
    .header__logo:hover img {
        transform: scale(1.05);
    }
    
    /* Mobile menu improvements */
    @media (max-width: 991px) {
        .mobile-menu {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            height: 100vh;
            background: white;
            z-index: 9999;
            transition: left 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .mobile-menu.active {
            left: 0;
        }
    }
</style>
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7">
                    <div class="header__top__left">
                    </div>
                </div>
                <div class="col-lg-6 col-md-5">
                    <div class="header__top__right">
                        @if(Auth::check())
                            <p class="check-auth d-none">1</p>
                            <div class="header__top__hover">
                                <span>{{ Auth::user()->name }} <i class="arrow_carrot-down"></i></span>
                                <ul>
                                    <li>
                                        <a href="{{ route('user.profile') }}" class="dropdown-item"><h6>Thông tin cá nhân</h6></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.orders') }}" class="dropdown-item"><h6>Đơn hàng của tôi</h6></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.password') }}" class="dropdown-item"><h6>Đổi mật khẩu</h6></a>
                                    </li>
                                    <li>
                                        <form action="{{route('logout')}}" method="post" class="logout">
                                            @csrf
                                            <button type="submit" class="dropdown-item fw-bold">
                                                <i class="lni lni-enter"></i>
                                                <h6>Đăng xuất</h6>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <p class="check-auth d-none">0</p>
                            <div class="header__top__links">
                                <a href="{{route('login')}}">Đăng nhập</a>
                                <a href="{{route('register')}}">Đăng ký</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="header__logo">
                    <a href="/"><img src="/temp/assets/img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <nav class="header__menu mobile-menu">
                    <ul class="text-nowrap navbar-nav d-flex flex-row">
                        <li class="active"><a href="/">Trang chủ</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{route('products.shop')}}">
                              Cửa hàng
                            </a>
                            <ul class="dropdown-menu position-absolute text-wrap" aria-labelledby="navbarDropdownMenuLink" style="top: 20px">
                                @foreach($menus as $menu)
                                    @if($menu->parent_id == null)
                                    <li class="dropdown-submenu w-100 px-3 py-2">
                                        <a class="dropdown-item dropdown-toggle" href="javascript:void(0)">{{$menu->title}}</a>
                                            @if($menu->children->isNotEmpty())
                                            <ul class="dropdown-menu p-3 position-absolute" style="top: 5px">
                                                    @foreach($menu->children as $child)
                                                        <li class="text-nowrap py-2 w-100">
                                                            <a href="{{ route('products.showProduct', ['categorySlug' => $child->slug]) }}">{{$child->title}}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="/about">Giới thiệu</a></li>

                        <li><a href="{{route('post')}}">Bài viết</a></li>
                        <li><a href="/contact">Liên hệ</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="header__nav__option">
                    {{-- <a href="#" class="search-switch"><img width="24" src="/temp/assets/img/icon/search.png" alt=""></a> --}}
                    <a href="{{route('carts.index')}}"><img width="24" src="/temp/assets/img/icon/cart.png" alt=""> <span class="text-danger font-weight-bold" style="font-size: 18px">{{ $count_cart }}</span></a>
                </div>
            </div>
        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
</header>