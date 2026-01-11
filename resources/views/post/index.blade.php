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
    <section class="breadcrumb-blog set-bg" data-setbg="/temp/assets/img/breadcrumb-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Bài viết</h2>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                @foreach($posts as $post)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="/temp/images/post/{{$post->thumb}}" ></div>
                        <div class="blog__item__text">
                            <span><img src="/temp/assets/img/icon/calendar.png" alt=""> {{$post->updated_at}}</span>
                            <h5>{{$post->Title}}</h5>
                            <a href="{{ route('posts.details', ['slug' =>$post->slug]) }}">Đọc thêm</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="pagination">
                    {{ $posts->links() }}
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
