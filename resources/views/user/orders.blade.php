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
                        <span>Đơn hàng của tôi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="user-orders spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                @include('user.sidebar')
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold">Lịch sử đơn hàng</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Mã đơn</th>
                                        <th class="border-0 py-3">Ngày đặt</th>
                                        <th class="border-0 py-3 text-right">Tổng tiền</th>
                                        <th class="border-0 py-3 text-center">Trạng thái</th>
                                        <th class="border-0 px-4 py-3 text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td class="px-4 py-4 align-middle font-weight-bold">
                                            #{{ $order->order_number }}
                                        </td>
                                        <td class="py-4 align-middle">
                                            {{ $order->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="py-4 align-middle text-right text-danger font-weight-bold">
                                            {{ number_format($order->total) }} VNĐ
                                        </td>
                                        <td class="py-4 align-middle text-center">
                                            @if($order->is_cancelled)
                                                <span class="badge badge-secondary p-2">Đã hủy</span>
                                            @elseif($order->status == 1)
                                                <span class="badge badge-info p-2">Đã đặt hàng</span>
                                            @elseif($order->status == 2)
                                                <span class="badge badge-primary p-2">Đang giao hàng</span>
                                            @elseif($order->status == 3)
                                                <span class="badge badge-success p-2">Đã giao hàng</span>
                                            @else
                                                <span class="badge badge-warning p-2">Chờ xử lý</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 align-middle text-center">
                                            <a href="{{ route('checkout.success', ['order_id' => $order->id]) }}" class="btn btn-sm btn-outline-info">
                                                Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="py-5 text-center text-muted">
                                            Bạn chưa có đơn hàng nào.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($orders->hasPages())
                    <div class="card-footer bg-white py-3">
                        {{ $orders->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
