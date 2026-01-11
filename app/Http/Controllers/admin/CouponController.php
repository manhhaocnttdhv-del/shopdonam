<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.coupon.index', compact('coupons'), [
            'title' => 'Quản lý mã giảm giá'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create', [
            'title' => 'Tạo mã giảm giá mới'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons,code|max:50',
            'name' => 'nullable|max:255',
            'description' => 'nullable',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_per_user' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ], [
            'code.required' => 'Vui lòng nhập mã giảm giá!',
            'code.unique' => 'Mã giảm giá này đã tồn tại!',
            'type.required' => 'Vui lòng chọn loại giảm giá!',
            'value.required' => 'Vui lòng nhập giá trị giảm giá!',
            'value.numeric' => 'Giá trị giảm giá phải là số!',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu!',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.coupons.create')
                ->withErrors($validator)
                ->withInput();
        }

        $coupon = Coupon::create([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'usage_per_user' => $request->usage_per_user ?? 1,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Tạo mã giảm giá thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $coupon = Coupon::with('usages.user', 'usages.order')->findOrFail($id);
        return view('admin.coupon.show', compact('coupon'), [
            'title' => 'Chi tiết mã giảm giá'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit', compact('coupon'), [
            'title' => 'Chỉnh sửa mã giảm giá'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons,code,' . $id . '|max:50',
            'name' => 'nullable|max:255',
            'description' => 'nullable',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_per_user' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ], [
            'code.required' => 'Vui lòng nhập mã giảm giá!',
            'code.unique' => 'Mã giảm giá này đã tồn tại!',
            'type.required' => 'Vui lòng chọn loại giảm giá!',
            'value.required' => 'Vui lòng nhập giá trị giảm giá!',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu!',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.coupons.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $coupon->update([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'usage_per_user' => $request->usage_per_user ?? 1,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Xóa mã giảm giá thành công!');
    }
}
