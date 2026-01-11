@extends('layouts.layout')
@section('content')
<!-- Bản đồ Bắt Đầu -->
<div class="map">
    {{-- <iframe src="" height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> --}}
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.3069539447374!2d105.78895517587223!3d21.020400588064476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab574d3c3a81%3A0x13c86d5801615ba1!2zMjE5IFAuIFRydW5nIEtpzIFuaCwgWcOqbiBIb8OgLCBD4bqndSBHaeG6pXksIEjDoCBO4buZaSAxMDAwMDAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1734015964731!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
<!-- Bản đồ Kết Thúc -->

<!-- Phần Liên Hệ Bắt Đầu -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="contact__text">
                    <div class="section-title">
                        <span>Thông Tin</span>
                        <h2>Liên Hệ Với Chúng Tôi</h2>
                        <p>Như bạn có thể mong đợi từ một công ty bắt đầu như là một nhà thầu nội thất cao cấp, chúng tôi chú trọng đến từng chi tiết.</p>
                    </div>
                    <ul>
                        <li>
                            <h4>Sài Gòn</h4>
                            <p>88 Hoàng Văn Thái, Tân Phú, Quận 7, TP Hồ Chí Minh <br />+43 982-314-0958</p>
                        </li>
                        <li>
                            <h4>Hà Nội</h4>
                            <p>219 Trung Kính, Yên Hoà, Cầu Giấy, Hà Nội <br />+84 06-270-1994</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="contact__form">
                    <form action="#">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" placeholder="Họ và Tên">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Email">
                            </div>
                            <div class="col-lg-12">
                                <textarea placeholder="Lời Nhắn"></textarea>
                                <button type="submit" class="site-btn">Gửi Lời Nhắn</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Phần Liên Hệ Kết Thúc -->


@endsection
