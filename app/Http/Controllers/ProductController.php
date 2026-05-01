<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * 1. عرض القائمة (Index)
     * الموظف: يشاهد فقط ساعات مستودعه.
     * المدير: يشاهد كل الساعات في النظام.
     */
    public function index()
    {
        $user = Auth::user();

        $query = DB::table('PRODUCT')
            ->leftJoin('WAREHOUSE_PRODUCT', 'PRODUCT.product_id', '=', 'WAREHOUSE_PRODUCT.product_id')
            ->leftJoin('WAREHOUSE', 'WAREHOUSE_PRODUCT.warehouse_id', '=', 'WAREHOUSE.warehouse_id')
            ->select('PRODUCT.*', 'WAREHOUSE.warehouse_name as warehouse_name');

        // تطبيق الفلترة حسب الصلاحية (المطلب 7)
        if ($user->role === 'staff') {
            $query->where('WAREHOUSE_PRODUCT.warehouse_id', $user->warehouse_id);
        }

        $products = $query->get();

        return view('products.index', compact('products'));
    }

    /**
     * 2. واجهة الإضافة (Create)
     */
    public function create()
    {
        $user = Auth::user();
        
        // المدير يختار أي مستودع، الموظف مقيد بمستودعه فقط
        if ($user->role === 'manager') {
            $warehouses = DB::table('WAREHOUSE')->get();
        } else {
            $warehouses = DB::table('WAREHOUSE')->where('warehouse_id', $user->warehouse_id)->get();
        }
        
        return view('products.create', compact('warehouses'));
    }

    /**
     * 3. تخزين البيانات (Store)
     */
    public function store(Request $request)
    {
        // المطلب 2: السعر (Price) يقبل فواصل برمجية Decimal
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01', 
            'warehouse_id' => 'required|exists:WAREHOUSE,warehouse_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
        }

        // إدخال المنتج في جدول PRODUCT
        $productId = DB::table('PRODUCT')->insert([
            'product_name' => $request->name,
            'upload_file'  => $imageName,
            'price'        => $request->price,
            'description'  => $request->description,
            'warehouse_id'=>$request->warehouse_id,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // الربط التلقائي بالكمية في الجدول الوسيط
        DB::table('WAREHOUSE_PRODUCT')->insert([
            'warehouse_id' => $request->warehouse_id,
            'product_id'   => $productId,
            'quantity'     => 1, // كمية افتراضية
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    /**
     * 4. التعديل (Edit)
     */
    public function edit($id)
    {
        $user = Auth::user();
        $product = DB::table('PRODUCT')->where('product_id', $id)->first();

        // حماية المسار: الموظف لا يعدل إلا ساعات مستودعه
        if ($user->role === 'staff') {
            $check = DB::table('WAREHOUSE_PRODUCT')
                       ->where('product_id', $id)
                       ->where('warehouse_id', $user->warehouse_id)
                       ->exists();
            if (!$check) {
                return redirect()->route('products.index')->with('error', 'Access Denied.');
            }
        }

        $warehouses = DB::table('WAREHOUSE')->get(); 
        return view('products.edit', compact('product', 'warehouses'));
    }

    /**
     * 5. التحديث (Update)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'product_name' => $request->name,
            'price'        => $request->price,
            'description'  => $request->description,
            'updated_at'   => now(),
        ];

        if ($request->hasFile('image')) {
            $product = DB::table('PRODUCT')->where('product_id', $id)->first();
            if ($product && $product->upload_file) {
                File::delete(public_path('uploads/products/' . $product->upload_file));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['upload_file'] = $imageName;
        }

        DB::table('PRODUCT')->where('product_id', $id)->update($data);
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * 6. الحذف (Destroy)
     */
    public function destroy($id)
    {
        $product = DB::table('PRODUCT')->where('product_id', $id)->first();
        
        if ($product && $product->upload_file) {
            File::delete(public_path('uploads/products/' . $product->upload_file));
        }

        // حذف علاقة الكمية أولاً ثم المنتج
        DB::table('WAREHOUSE_PRODUCT')->where('product_id', $id)->delete();
        DB::table('PRODUCT')->where('product_id', $id)->delete();
        
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}