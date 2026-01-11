<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Hiển thị danh sách slider
     */
    public function index()
    {
        $sliders = Slider::with('product')->orderBy('order')->orderByDesc('created_at')->paginate(10);
        return view('admin.slider.index', compact('sliders'), [
            'title' => 'Quản lý Slider'
        ]);
    }

    /**
     * Hiển thị form tạo slider mới
     */
    public function create()
    {
        $products = Product::where('active', 1)->orderBy('Title')->get();
        return view('admin.slider.create', compact('products'), [
            'title' => 'Tạo slider mới'
        ]);
    }

    /**
     * Lưu slider mới
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|max:255',
            'subtitle' => 'nullable|max:255',
            'description' => 'nullable',
            'product_id' => 'nullable|exists:products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|max:500',
            'button_text' => 'nullable|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'image.image' => 'File phải là hình ảnh!',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif!',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB!',
            'product_id.exists' => 'Sản phẩm không tồn tại!',
        ]);

        // Kiểm tra: phải có product_id HOẶC image
        if (!$request->has('product_id') && !$request->hasFile('image')) {
            return redirect()->back()
                ->withErrors(['image' => 'Vui lòng chọn sản phẩm hoặc upload hình ảnh!'])
                ->withInput();
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagePath = null;
        $productId = $request->product_id;

        // Nếu chọn sản phẩm, lấy ảnh từ sản phẩm
        if ($productId) {
            $product = Product::find($productId);
            if ($product && $product->thumb) {
                $imagePath = $product->thumb;
                // Nếu chưa có link, tự động set link đến sản phẩm
                if (!$request->link) {
                    $request->merge(['link' => '/products/details/' . $product->slug]);
                }
                // Nếu chưa có title, tự động set title từ sản phẩm
                if (!$request->title) {
                    $request->merge(['title' => $product->Title]);
                }
            }
        }

        // Nếu upload ảnh mới, lưu ảnh
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('sliders', $imageName, 'public');
        }

        Slider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'image' => $imagePath,
            'link' => $request->link,
            'button_text' => $request->button_text ?? 'Khám phá',
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
            'product_id' => $productId,
        ]);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Tạo slider thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa slider
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        $products = Product::where('active', 1)->orderBy('Title')->get();
        return view('admin.slider.edit', compact('slider', 'products'), [
            'title' => 'Chỉnh sửa slider'
        ]);
    }

    /**
     * Cập nhật slider
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'nullable|max:255',
            'subtitle' => 'nullable|max:255',
            'description' => 'nullable',
            'product_id' => 'nullable|exists:products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|max:500',
            'button_text' => 'nullable|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'image.image' => 'File phải là hình ảnh!',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif!',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB!',
            'product_id.exists' => 'Sản phẩm không tồn tại!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'link' => $request->link,
            'button_text' => $request->button_text ?? 'Khám phá',
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
            'product_id' => $request->product_id,
        ];

        $productId = $request->product_id;
        $hasNewImage = $request->hasFile('image');

        // Nếu chọn sản phẩm và không upload ảnh mới, lấy ảnh từ sản phẩm
        if ($productId && !$hasNewImage) {
            $product = Product::find($productId);
            if ($product && $product->thumb) {
                $data['image'] = $product->thumb;
                // Tự động set link nếu chưa có
                if (!$request->link) {
                    $data['link'] = '/products/details/' . $product->slug;
                }
            }
        }

        // Xử lý upload ảnh mới nếu có
        if ($hasNewImage) {
            // Xóa ảnh cũ nếu là ảnh đã upload (không phải từ product)
            if ($slider->image && strpos($slider->image, 'sliders/') !== false && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $data['image'] = $image->storeAs('sliders', $imageName, 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Cập nhật slider thành công!');
    }

    /**
     * Xóa slider
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        
        // Xóa ảnh
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }
        
        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Xóa slider thành công!');
    }
}

