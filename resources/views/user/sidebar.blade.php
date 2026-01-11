<div class="user-sidebar">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                    <i class="fa fa-user-circle-o mr-2"></i> Thông tin cá nhân
                </a>
                <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action {{ request()->routeIs('user.orders') ? 'active' : '' }}">
                    <i class="fa fa-shopping-bag mr-2"></i> Đơn hàng của tôi
                </a>
                <a href="{{ route('user.password') }}" class="list-group-item list-group-item-action {{ request()->routeIs('user.password') ? 'active' : '' }}">
                    <i class="fa fa-lock mr-2"></i> Đổi mật khẩu
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="list-group-item list-group-item-action text-danger">
                        <i class="fa fa-sign-out mr-2"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .user-sidebar .list-group-item {
        padding: 15px 20px;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .user-sidebar .list-group-item:hover {
        background-color: #f8f9fa;
        color: #e53637;
    }
    
    .user-sidebar .list-group-item.active {
        background-color: #e53637;
        border-color: #e53637;
        color: #fff;
    }
</style>
