<?php

namespace App\Http\Controllers\admin;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Models\SizePartern;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $cates = Category::all();
        $sizePatterns = SizePartern::all();
        $products = Product::paginate(10);
        return view('admin.product.index',compact('products','cates','sizePatterns'),[
            'title' => 'Quản lý sản phẩm'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:products',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề!',
            'slug.required' => 'Vui lòng nhập slug!',
            'slug.unique' => 'Slug này đã tồn tại!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = new Product;
        $product->Title = $request->title;

        $thumb = $request->file('thumb');
        if ($thumb) {
            $fileName = Str::slug($request->title) . '.jpg';
            $thumb->move(public_path('temp/images/product'), $fileName);
            $product->thumb = $fileName;
        }

        $product->description = $request->desc;
        $product->slug = $request->slug;
        $product->cate_id = $request->cate_id;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->active = $request->active ? 1 : 0;
        $product->ishot = $request->ishot ? 1 : 0;
        $product->Amounts = $request->amount;
        $product->content = $request->content;
        $product->sizes = $request->sizes;
        $product->colors = $request->colors;
        $product->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Sản phẩm đã được thêm thành công!'
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request,[
            'title' => 'required',
            'slug' => 'required',
        ],[
            'title.required' => 'Vui lòng nhập tiêu đề !',
            'slug.required' => 'Vui lòng nhập slug',
        ]);
        // Kiểm tra xem product_id có tồn tại trong bảng Product hay không
        $product->Title = $request->title;
        $title = $product->Title;
        $thumb = $request->file('thumb'); // Lấy file ảnh từ file Upload
        if ($thumb) {
            $fileName = Str::slug($title) . '.jpg'; // Tên ảnh theo Slug Title
//                $avatar->storeAs('public/images/avatars', $fileName); // Lưu ảnh đã thêm vào đường dẫn này
            $thumb->move(public_path('temp/images/product'), $fileName); // Di chuyển ảnh vào thư mục này

            $product->thumb = $fileName; // Lưu tên file ảnh theo slug Title
        }
        $product->description = $request->desc;
        $product->slug = $request->slug;
        $product->cate_id = $request->cate_id;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->active = $request->active ? 1 : 0;
        $product->ishot = $request->ishot ? 1 : 0;
        // $product->isnewfeed = $request->isnewfeed ? 1 : 0;
        $product->Amounts = $request->amount;
        $product->content = $request->content;
        $product->sizes = $request->sizes;
        $product->colors = $request->colors;
        $product->save();
        // Chuyển hướng về trang hiển thị danh sách product hoặc trang khác tùy theo yêu cầu của bạn
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        // Chuyển hướng về trang danh sách product hoặc trang khác (tuỳ ý)
        return response()->json(['message' => 'Sản phẩm đã được xóa thành công']);
    }
    public function deleteAllProducts() {
        // Tạm thời vô hiệu hóa ràng buộc khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
        // Truncate bảng products
        Product::truncate();
    
        // Bật lại ràng buộc khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
        return redirect()->back();
    }
    
    
}
