<aside
    id='layout-menu'
    class='layout-menu menu-vertical menu bg-menu-theme'
    data-bg-class='bg-menu-theme'
>
    <div class='app-brand demo'>
        <a href='/admin' class='app-brand-link'>
            <img src='/temp/assets/img/logo.png' width='200' alt='' />
        </a>

        <a
            href='javascript:void(0);'
            class='layout-menu-toggle menu-link text-large ms-auto d-xl-none'
        >
            <i class='bx bx-chevron-left bx-sm align-middle'></i>
        </a>
    </div>

    <div class='menu-inner-shadow'></div>

    <ul class='menu-inner py-1 ps ps--active-y'>
        <!-- Dashboard -->
        <li class='menu-item active'>
            <a href='/admin' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-home-circle'></i>
                <div data-i18n='Analytics'>Bảng Điều Khiển</div>
            </a>
        </li>


        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Tài Khoản</span>
        </li>
        <li class='menu-item'>
            <a href='javascript:void(0);' class='menu-link menu-toggle'>
                <i class='menu-icon tf-icons bx bxs-user-account'></i>
                <div data-i18n='Layouts'>Quản lý tài khoản</div>
            </a>
            <ul class='menu-sub'>
                <li class='menu-item'>
                    <a href='{{route('userAdmin')}}' class='menu-link'>
                        <div data-i18n='Without menu'>Tài khoản quản trị</div>
                    </a>
                </li>
                <li class='menu-item'>
                    <a href='{{route('user')}}' class='menu-link'>
                        <div data-i18n='Without menu'>Tài khoản người dùng</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Cửa Hàng</span>
        </li>
        <li class='menu-item'>
            <a href='{{route('cates.index')}}' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-category-alt'></i>
                <div data-i18n='Layouts'>Quản lý danh mục</div>
            </a>
        </li>
        <li class='menu-item'>
            <a href='{{route('products.index')}}' class='menu-link '>
                <i class='menu-icon tf-icons bx bx-store-alt'></i>
                <div data-i18n='Layouts'>Quản lý sản phẩm</div>
            </a>
        </li>
        <li class='menu-item'>
            <a href='{{route('posts.index')}}' class='menu-link '>
                <i class='menu-icon tf-icons bx bx-news'></i>
                <div data-i18n='Layouts'>Quản lý bài viết</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Mục Khác</span>
        </li>
        <li class='menu-item'>
            <a href='{{route('addresses.index')}}' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-street-view'></i>
                <div data-i18n='Layouts'>Địa chỉ</div>
            </a>
        </li>
        <li class='menu-item'>
            <a href='{{route('orders.index')}}' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-food-menu'></i>
                <div data-i18n='Layouts'>Quản lý đơn hàng</div>
            </a>
        </li>
        <li class='menu-item'>
            <a href='{{route('admin.coupons.index')}}' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-purchase-tag'></i>
                <div data-i18n='Layouts'>Quản lý mã giảm giá</div>
            </a>
        </li>
        <li class='menu-item'>
            <a href='{{route('admin.sliders.index')}}' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-slider-alt'></i>
                <div data-i18n='Layouts'>Quản lý Slider</div>
            </a>
        </li>
        <li class='menu-item'>
            <a href='{{route('reports.index')}}' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-bar-chart-alt-2'></i>
                <div data-i18n='Layouts'>Báo cáo</div>
            </a>
        </li>
        <li class='menu-item'>
            <a href='{{route('qr-payment-configs.index')}}' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-qr'></i>
                <div data-i18n='Layouts'>Cấu hình QR</div>
            </a>
        </li>
        <li class='menu-item'>
            <a href='{{route('admin.payment-proofs.index')}}' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-check-shield'></i>
                <div data-i18n='Layouts'>Xác minh thanh toán</div>
            </a>
        </li>

    </ul>
</aside>
