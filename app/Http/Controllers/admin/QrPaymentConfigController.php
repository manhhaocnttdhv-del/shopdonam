<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\QrPaymentConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QrPaymentConfigController extends Controller
{
    public function index()
    {
        $configs = QrPaymentConfig::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.qr-payment-config.index', compact('configs'), [
            'title' => 'Quản lý cấu hình QR thanh toán'
        ]);
    }

    public function create()
    {
        return view('admin.qr-payment-config.create', [
            'title' => 'Thêm cấu hình QR thanh toán'
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'bank_name' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
            'qr_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'bank_name.required' => 'Vui lòng nhập tên ngân hàng!',
            'account_number.required' => 'Vui lòng nhập số tài khoản!',
            'account_name.required' => 'Vui lòng nhập tên chủ tài khoản!',
            'qr_image.required' => 'Vui lòng chọn ảnh QR code!',
            'qr_image.image' => 'File phải là ảnh!',
        ]);

        $config = new QrPaymentConfig();
        $config->bank_name = $request->bank_name;
        $config->account_number = $request->account_number;
        $config->account_name = $request->account_name;
        $config->note = $request->note;
        $config->is_active = $request->is_active ? 1 : 0;
        $config->sort_order = $request->sort_order ?? 0;

        $qrImage = $request->file('qr_image');
        if ($qrImage) {
            $fileName = 'qr_' . time() . '_' . Str::random(10) . '.jpg';
            $qrImage->move(public_path('temp/images/qr-payment'), $fileName);
            $config->qr_image = $fileName;
        }

        $config->save();
        return redirect()->route('qr-payment-configs.index')
            ->with('success', 'Thêm cấu hình QR thanh toán thành công!');
    }

    public function edit(QrPaymentConfig $qrPaymentConfig)
    {
        return view('admin.qr-payment-config.edit', compact('qrPaymentConfig'), [
            'title' => 'Sửa cấu hình QR thanh toán'
        ]);
    }

    public function update(Request $request, QrPaymentConfig $qrPaymentConfig)
    {
        $this->validate($request, [
            'bank_name' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
            'qr_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'bank_name.required' => 'Vui lòng nhập tên ngân hàng!',
            'account_number.required' => 'Vui lòng nhập số tài khoản!',
            'account_name.required' => 'Vui lòng nhập tên chủ tài khoản!',
        ]);

        $qrPaymentConfig->bank_name = $request->bank_name;
        $qrPaymentConfig->account_number = $request->account_number;
        $qrPaymentConfig->account_name = $request->account_name;
        $qrPaymentConfig->note = $request->note;
        $qrPaymentConfig->is_active = $request->is_active ? 1 : 0;
        $qrPaymentConfig->sort_order = $request->sort_order ?? 0;

        $qrImage = $request->file('qr_image');
        if ($qrImage) {
            // Xóa ảnh cũ nếu có
            if ($qrPaymentConfig->qr_image && file_exists(public_path('temp/images/qr-payment/' . $qrPaymentConfig->qr_image))) {
                unlink(public_path('temp/images/qr-payment/' . $qrPaymentConfig->qr_image));
            }
            $fileName = 'qr_' . time() . '_' . Str::random(10) . '.jpg';
            $qrImage->move(public_path('temp/images/qr-payment'), $fileName);
            $qrPaymentConfig->qr_image = $fileName;
        }

        $qrPaymentConfig->save();
        return redirect()->route('qr-payment-configs.index')
            ->with('success', 'Cập nhật cấu hình QR thanh toán thành công!');
    }

    public function destroy(QrPaymentConfig $qrPaymentConfig)
    {
        // Xóa ảnh nếu có
        if ($qrPaymentConfig->qr_image && file_exists(public_path('temp/images/qr-payment/' . $qrPaymentConfig->qr_image))) {
            unlink(public_path('temp/images/qr-payment/' . $qrPaymentConfig->qr_image));
        }
        $qrPaymentConfig->delete();
        return redirect()->back()->with('success', 'Xóa cấu hình QR thanh toán thành công!');
    }
}
