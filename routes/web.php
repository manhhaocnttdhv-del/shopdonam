<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MainCartController;
use App\Http\Controllers\MainPostController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\MainProductController;
use App\Http\Controllers\MainCheckoutController;
use App\Http\Controllers\admin\AddressController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/clear-cache',function(){
    $exitCode = Artisan::call('cache:clear');
});
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/posts', [MainPostController::class, 'index'])->name('post');
Route::get('/posts/{slug}', [MainPostController::class, 'details'])->name('posts.details');

// Danh sách sản phẩm theo danh mục
Route::get('/shop', [MainProductController::class, 'shop'])->name('products.shop');
Route::get('/products/{categorySlug}', [MainProductController::class, 'ShowProduct'])->name('products.showProduct');

// Chi tiết sản phẩm
Route::get('/products/details/{slug}', [MainProductController::class, 'ProductDetail'])->name('products.details');

Auth::routes();

// Bài viết
Route::get('/about',[PageController::class,'about']);
Route::get('/contact',[PageController::class,'contact']);
Route::get('/search',[App\Http\Controllers\HomeController::class,'search'])->name('search');

// Mã giảm giá công khai
Route::get('/coupons', [App\Http\Controllers\CouponController::class, 'index'])->name('coupons.index');


Route::middleware(['auth'])->group(function() {
    // Tài khoản người dùng
    Route::get('/user/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/user/password', [App\Http\Controllers\UserController::class, 'password'])->name('user.password');
    Route::post('/user/password', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('user.password.update');
    Route::get('/user/orders', [App\Http\Controllers\UserController::class, 'orders'])->name('user.orders');

    // Thêm vào giỏ hàng
    Route::post('/addToCart',[MainProductController::class,'addToCart']);

// Giỏ hàng
    Route::get('/carts', [MainCartController::class, 'cart'])->name('carts.index');

// Xóa sản phẩm ở  giỏ hàng
    Route::delete('/carts/{id}', [MainCartController::class,'destroy'])->name('carts.destroy');

// Cập nhật sản phẩm ở giỏ
    Route::post('/carts/updateQuantities', [MainCartController::class, 'updateQuantities'])->name('carts.updateQuantities');

// Chuyển sang trang checkout
    Route::get('/checkout', [MainCheckoutController::class, 'ShowToCheckout'])->name('checkout.showcheckout');

// Validate mã giảm giá
    Route::post('/checkout/validate-coupon', [MainCheckoutController::class, 'validateCoupon'])->name('checkout.validateCoupon');

// Thực hiện thanh toán
    Route::post('/process-checkout', [MainCheckoutController::class, 'checkout'])->name('checkout.checkout');

// Thanh toán thành công
    Route::get('/checkout-success', [MainCheckoutController::class, 'showOrder'])->name('checkout.success');
    
    // Upload payment proof (bill)
    Route::post('/orders/{order}/upload-payment-proof', [App\Http\Controllers\PaymentProofController::class, 'upload'])->name('orders.upload-payment-proof');
    
    // Cancel order
    Route::post('/orders/{order}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Admin
    Route::middleware(['auth', 'checkLevel'])->group(function() {
//    Route::post('/logout',[UsersController::class,'logout'])->name('logout');
        Route::prefix('admin')->group(function () {
            Route::get('/', [HomeController::class, 'home'])->name('admin');

            //            User
            Route::get('/userAdmin',[UsersController::class,'userAdmin'])->name('userAdmin');
            Route::get('/user',[UsersController::class,'user'])->name('user');
            Route::post('/userAdmin',[UsersController::class,'store'])->name('user.store');
            Route::patch('/userAdmin/{user}',[UsersController::class,'update'])->name('user.update');
            Route::delete('/users/{id}', [UsersController::class,'destroy'])->name('users.destroy');

            //            Categories
            Route::resource('cates', CategoryController::class);
            Route::delete('/cates/{id}', [CategoryController::class,'destroy'])->name('cates.destroy');
            Route::post('cates/delete-all', [CategoryController::class,'deleteAllCates'])->name('deleteAllCate');

            //            Products
            Route::resource('products', ProductController::class);
            Route::delete('/products/{id}', [ProductController::class,'destroy'])->name('products.destroy');
            Route::post('products/delete-all', [ProductController::class,'deleteAllProducts'])->name('deleteAllProduct');

            //            Posts
            Route::resource('posts', PostController::class);
            // Route::delete('/posts/{id}', [PostController::class,'destroy'])->name('posts.destroy');
            Route::post('posts/delete-all', [PostController::class,'deleteAllPosts'])->name('deleteAllPost');

            //        Address
            Route::resource('addresses', AddressController::class);

            //        Orders
            Route::resource('orders', OrderController::class);
            Route::post('/orders/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
            Route::get('/orders/{id}/export-pdf', [OrderController::class, 'exportPdf'])->name('orders.exportPdf');

            //        Reports
            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/export-csv', [ReportController::class, 'exportCsv'])->name('reports.exportCsv');
            Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');
            
            //        Coupons
            Route::get('/coupons', [\App\Http\Controllers\admin\CouponController::class, 'index'])->name('admin.coupons.index');
            Route::get('/coupons/create', [\App\Http\Controllers\admin\CouponController::class, 'create'])->name('admin.coupons.create');
            Route::post('/coupons', [\App\Http\Controllers\admin\CouponController::class, 'store'])->name('admin.coupons.store');
            Route::get('/coupons/{id}', [\App\Http\Controllers\admin\CouponController::class, 'show'])->name('admin.coupons.show');
            Route::get('/coupons/{id}/edit', [\App\Http\Controllers\admin\CouponController::class, 'edit'])->name('admin.coupons.edit');
            Route::put('/coupons/{id}', [\App\Http\Controllers\admin\CouponController::class, 'update'])->name('admin.coupons.update');
            Route::delete('/coupons/{id}', [\App\Http\Controllers\admin\CouponController::class, 'destroy'])->name('admin.coupons.destroy');
            
            //        Sliders
            Route::get('/sliders', [\App\Http\Controllers\admin\SliderController::class, 'index'])->name('admin.sliders.index');
            Route::get('/sliders/create', [\App\Http\Controllers\admin\SliderController::class, 'create'])->name('admin.sliders.create');
            Route::post('/sliders', [\App\Http\Controllers\admin\SliderController::class, 'store'])->name('admin.sliders.store');
            Route::get('/sliders/{id}/edit', [\App\Http\Controllers\admin\SliderController::class, 'edit'])->name('admin.sliders.edit');
            Route::put('/sliders/{id}', [\App\Http\Controllers\admin\SliderController::class, 'update'])->name('admin.sliders.update');
            Route::delete('/sliders/{id}', [\App\Http\Controllers\admin\SliderController::class, 'destroy'])->name('admin.sliders.destroy');
            
            //        QR Payment Configs
            Route::resource('qr-payment-configs', \App\Http\Controllers\admin\QrPaymentConfigController::class);
            
            //        Payment Proofs (Admin review)
            Route::get('/payment-proofs', [\App\Http\Controllers\admin\PaymentProofController::class, 'index'])->name('admin.payment-proofs.index');
            Route::post('/payment-proofs/{proof}/approve', [\App\Http\Controllers\admin\PaymentProofController::class, 'approve'])->name('admin.payment-proofs.approve');
            Route::post('/payment-proofs/{proof}/reject', [\App\Http\Controllers\admin\PaymentProofController::class, 'reject'])->name('admin.payment-proofs.reject');

        });
    });
});

