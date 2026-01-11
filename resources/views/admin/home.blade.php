@extends('admin.main')
@section('contents')
    <!-- / Navbar -->
    <!-- Content wrapper -->
    <div class='content-wrapper'>
        <!-- Content -->
        <div class='container-xxl flex-grow-1 container-p-y'>
            <div class='row'>
                <div class='col-12 mb-4 order-0'>
                    <div class='card'>
                        <div class='d-flex align-items-end row'>
                            <div class='col-sm-7'>
                                <div class='card-body'>
                                    <h5
                                        class='card-title text-primary'
                                    >Chúc Mừng {{ Auth::user()->name }}! 🎉</h5>
                                    <p class='mb-4'>
                                        Hôm nay bạn đã bán được nhiều hơn 
                                        <span class='fw-bold'>72%</span>
                                        Kiểm tra huy hiệu mới của bạn trong.
                                        Hồ sơ của bạn.
                                    </p>
                                    <a
                                        href='javascript:;'
                                        class='btn btn-sm btn-outline-primary'
                                    >Xem Huy Hiệu</a>
                                </div>
                            </div>
                            <div class='col-sm-5 text-center text-sm-left'>
                                <div class='card-body pb-0 px-0 px-md-4'>
                                    <img
                                        src='/temp/admin/assets/img/illustrations/man-with-laptop-light.png'
                                        height='140'
                                        alt='View Badge User'
                                        data-app-dark-img='illustrations/man-with-laptop-dark.png'
                                        data-app-light-img='illustrations/man-with-laptop-light.png'
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Access Cards -->
                <div class="col-12 order-1 mb-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <i class="bx bx-purchase-tag fs-1 text-primary mb-2"></i>
                                    <h5 class="card-title">Mã giảm giá</h5>
                                    <p class="card-text text-muted">Quản lý mã giảm giá và khuyến mãi</p>
                                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary">
                                        <i class="bx bx-right-arrow-alt"></i> Quản lý mã giảm giá
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <i class="bx bx-bar-chart-alt-2 fs-1 text-success mb-2"></i>
                                    <h5 class="card-title">Báo cáo</h5>
                                    <p class="card-text text-muted">Xem báo cáo và thống kê chi tiết</p>
                                    <a href="{{ route('reports.index') }}" class="btn btn-success">
                                        <i class="bx bx-right-arrow-alt"></i> Xem báo cáo
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <i class="bx bx-food-menu fs-1 text-info mb-2"></i>
                                    <h5 class="card-title">Đơn hàng</h5>
                                    <p class="card-text text-muted">Quản lý và xử lý đơn hàng</p>
                                    <a href="{{ route('orders.index') }}" class="btn btn-info">
                                        <i class="bx bx-right-arrow-alt"></i> Quản lý đơn hàng
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Báo cáo đơn hàng -->
                <div class="col-12 order-2">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bx bx-bar-chart-alt-2"></i> Báo cáo đơn hàng</h5>
                            <div>
                                <a href="{{ route('reports.index') }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-file"></i> Xem báo cáo chi tiết
                                </a>
                                <a href="{{ route('reports.exportPdf') }}" class="btn btn-sm btn-danger">
                                    <i class="bx bx-file-blank"></i> Export PDF
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Thống kê đơn hàng -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1 text-white">Đơn hôm nay</h6>
                                                    <h3 class="mb-0 text-white">{{ number_format($orders_today) }}</h3>
                                                    <small class="text-white">Doanh thu: {{ number_format($revenue_today) }} VNĐ</small>
                                                </div>
                                                <div class="fs-1">
                                                    <i class="bx bx-calendar-check"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1 text-white" style="color: white !important; ">Đơn tháng này</h6>
                                                    <h3 class="mb-0 text-white" style="color: white !important; ">{{ number_format($orders_month) }}</h3>
                                                    <small class="text-white">Doanh thu: {{ number_format($revenue_month) }} VNĐ</small>
                                                </div>
                                                <div class="fs-1">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h6 class="mb-1 text-white" style="color: white !important; ">Chờ xử lý</h6>
                                            <h3 class="mb-0 text-white" style="color: white !important; ">{{ number_format($pending_orders) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card bg-secondary text-white">
                                        <div class="card-body text-center">
                                            <h6 class="mb-1 text-white" style="color: white !important; ">Đang giao</h6>
                                            <h3 class="mb-0 text-white" style="color: white !important; ">{{ number_format($shipping_orders) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h6 class="mb-1 text-white" style="color: white !important; ">Hoàn thành</h6>
                                            <h3 class="mb-0 text-white" style="color: white !important; ">{{ number_format($completed_orders) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Đơn hàng gần đây -->
                            <h6 class="mb-3"><i class="bx bx-time"></i> Đơn hàng gần đây</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Mã đơn</th>
                                            <th>Khách hàng</th>
                                            <th>SĐT</th>
                                            <th>Tổng tiền</th>
                                            <th>Phương thức</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày đặt</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recent_orders as $order)
                                        <tr>
                                            <td><strong class="text-primary">#{{ $order->order_number ?? $order->id }}</strong></td>
                                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                                            <td>{{ $order->address->sdt ?? 'N/A' }}</td>
                                            <td><strong>{{ number_format($order->total) }} VNĐ</strong></td>
                                            <td>
                                                @if($order->payment_method == 'cod')
                                                    <span class="badge bg-secondary">COD</span>
                                                @elseif($order->payment_method == 'qr')
                                                    <span class="badge bg-primary">QR Code</span>
                                                @else
                                                    <span class="badge bg-info">{{ $order->payment_method }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->status == 1)
                                                    <span class="badge bg-info">Đã đặt hàng</span>
                                                @elseif($order->status == 2)
                                                    <span class="badge bg-warning">Đang giao hàng</span>
                                                @elseif($order->status == 3)
                                                    <span class="badge bg-success">Hoàn thành</span>
                                                @else
                                                    <span class="badge bg-secondary">Không xác định</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Chưa có đơn hàng nào</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Total Revenue -->
                <!--/ Total Revenue -->
            </div>
        </div>
        <!-- / Content -->
        <!-- Footer -->
        <footer class='content-footer footer bg-footer-theme'>
            <div
                class='container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column'
            >
                <div class='mb-2 mb-md-0'>
                    © {{ date('Y') }} ,  ❤️ 
                    <a
                        href='https://themeselection.com'
                        target='_blank'
                        class='footer-link fw-bolder'
                    >Lựa chọn chủ đề</a>
                </div>
                <div>
                    <a
                        href='https://themeselection.com/license/'
                        class='footer-link me-4'
                        target='_blank'
                    >Giấy phép</a>
                    <a
                        href='https://themeselection.com/'
                        target='_blank'
                        class='footer-link me-4'
                    >Thêm chủ đề</a>
                    <a
                        href='https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/'
                        target='_blank'
                        class='footer-link me-4'
                    >Tài liệu</a>
                    <a
                        href='https://github.com/themeselection/sneat-html-admin-template-free/issues'
                        target='_blank'
                        class='footer-link me-4'
                    >Ủng hộ</a>
                </div>
            </div>
        </footer>
        <!-- / Footer -->
        <div class='content-backdrop fade'></div>
    </div>
    <!-- Content wrapper -->
@endsection
