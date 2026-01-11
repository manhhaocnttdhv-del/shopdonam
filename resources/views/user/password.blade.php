@extends('layouts.layout')

@section('content')
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Tài khoản của tôi</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <span>Đổi mật khẩu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="user-password spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                @include('user.sidebar')
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold">Đổi mật khẩu</h5>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success mt-1 mb-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('user.password.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Mật khẩu hiện tại<span>*</span></p>
                                        <input type="password" name="current_password" class="@error('current_password') is-invalid @enderror">
                                        @error('current_password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Mật khẩu mới<span>*</span></p>
                                        <input type="password" name="password" class="@error('password') is-invalid @enderror">
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Xác nhận mật khẩu mới<span>*</span></p>
                                        <input type="password" name="password_confirmation">
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <button type="submit" class="site-btn">Đổi mật khẩu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
