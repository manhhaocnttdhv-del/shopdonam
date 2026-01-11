@extends('layouts.layout')
@section('content')

    <!-- Start Breadcrumbs -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Đăng nhập</h4>
                        <div class="breadcrumb__links">
                            <a href="/">Trang chủ</a>
                            <span>Đăng nhập</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Breadcrumbs -->

    <!-- start login section -->
    <section class="login section py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                    <div class="form-head bg-white border rounded-5 p-4">
                        <h2 class="title text-center font-weight-bold mb-5">Đăng nhập</h2>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label>Địa Chỉ Email</label>
                                <input name="email" type="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="check-and-pass">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-check">
                                            <input type="checkbox" name="remember" id="remember" class="form-check-input width-auto" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label">Nhớ mật khẩu </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="lost-pass text-primary float-right">Quên mật khẩu?</a>
                                    @endif

                                    </div>
                                </div>
                            </div>
                            <div class="button text-center mt-5">
                                <button type="submit" class="btn btn-dark">Đăng nhập ngay</button>
                            </div>
                            <p class="outer-link mt-4">Bạn chưa có tài khoản? <a href="{{route('register')}}" class="text-primary">Đăng ký</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
