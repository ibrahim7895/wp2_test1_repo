<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Store; 
use App\Models\User;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WarehouseController extends Controller
{
    /**
     * 1. عرض القائمة باستخدام الـ Stored Procedure
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // استدعاء البروسيدجر الذي صممناه للبحث
        // ملاحظة: البروسيدجر يعيد مصفوفة من الكائنات (Objects)
        $warehouses = DB::select("CALL GetWarehouses(?)", [$search]);

        // التحقق من طلب AJAX لتحديث القائمة فقط
        if ($request->ajax()) {
            return view('warehouses._list', compact('warehouses'))->render();
        }

        return view('warehouses.index', compact('warehouses'));
    }

    /**
     * 2. واجهة الإضافة
     */
   public function create()
{
    // 1. تأكد أن المستخدم "موظف" (Staff) لكي يرى صفحة الإضافة
    if (Auth::user()->role !== 'staff') {
        abort(403, 'عذراً، إضافة المستودعات من صلاحية الموظفين فقط.');
    }

    // 2. جلب المتاجر والمديرين لعرضهم في القائمة المنسدلة (Dropdown)
    $stores = Store::all();
    $managers = User::where('role', 'manager')->get();

   $staffs = User::where('role', 'staff')->get();

    return view('warehouses.create', compact('stores', 'managers', 'staffs'));
}

    /**
     * 3. تخزين البيانات مع رفع الملفات
     */
   public function store(Request $request)
{
    // 1. شرط الصلاحية: المنع الفوري للمدير والسماح للموظف فقط
    if (Auth::user()->role !== 'staff') {
        return back()->with('error', 'عذراً، إضافة مستودع جديد هي صلاحية الموظف فقط.');
    }

    // 2. التحقق من البيانات (نفس شروطك مع التأكد من أن المتجر nullable)
    $request->validate([
        'warehouse_name' => 'required|min:3|max:100',
        'city'           => 'required',
        'store_id'       => 'nullable|exists:stores,store_id', // nullable لجعل الاختيار اختيارياً
        'manager_id'     => 'required|exists:users,user_id',
        'staff_ids'      => 'required|array|min:1',
        'brochure'       => 'nullable|file|mimes:pdf,jpg,png|max:2048',
    ]);

    // 3. معالجة رفع الملف (نفس منطقك البرمجي)
    $fileName = null;
    if ($request->hasFile('brochure')) {
        $file = $request->file('brochure');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/brochures'), $fileName);
    }

    // 4. الإنشاء في قاعدة البيانات
    $warehouse =Warehouse::create([
        'warehouse_name' => $request->warehouse_name,
        'city'           => $request->city,
        'store_id'       => $request->store_id,
        'manager_id'     => $request->manager_id,
        'description'    => $request->description, 
        'brochure'       => $fileName,
    ]);
    User::whereIn('user_id', $request->staff_ids)
        ->update(['warehouse_id' => $warehouse->warehouse_id]);

    return redirect()->route('warehouses.index')->with('success', 'Warehouse established successfully.');
}

    /**
     * 4. عرض التفاصيل مع المنتجات المرتبطة
     */
    public function show($id)
    {
        // جلب المستودع مع علاقاته (المنتجات، المتجر، المدير)
        $warehouse = Warehouse::with(['store', 'manager', 'products'])->findOrFail($id);
        
        // جلب المنتجات بشكل منفصل لتمريرها للفيو كما هو مصمم
        $products = $warehouse->products;

        return view('warehouses.show', compact('warehouse', 'products'));
    }

    /**
     * 5. واجهة التعديل مع الحماية
     */
   public function edit($id)
{
    // جلب المستودع باستخدام المعرف
    $warehouse = Warehouse::where('warehouse_id', $id)->firstOrFail();

    // الحل: السماح للموظف فقط بدخول هذه الصفحة
    // إذا كان المستخدم "ليس موظفاً" (أي مديراً أو غيره)، امنعه من صفحة التعديل
    if (Auth::user()->role !== 'staff') {
        abort(403, 'عذراً، هذه الصفحة مخصصة للموظفين فقط لتعديل البيانات.');
    }

    $stores = Store::all();
    // جلب المستخدمين الذين دورهم مدير فقط لعرضهم في القائمة المنسدلة
    $managers = User::where('role', 'manager')->get();
    
    return view('warehouses.edit', compact('warehouse', 'stores', 'managers'));
}
    /**
     * 6. تحديث البيانات
     */
  public function update(Request $request, $id)
{
    // 1. إضافة شرط الصلاحية: التعديل مسموح فقط للموظف (Staff)
    if (Auth::user()->role !== 'staff') {
        return back()->with('error', 'عذراً، التعديل متاح فقط للموظفين.');
    }

    $warehouse = Warehouse::findOrFail($id);

    // 2. التحقق من البيانات (مع التأكد من إضافة store_id و manager_id للـ Validation)
    $request->validate([
        'warehouse_name' => 'required|min:3',
        'city'           => 'required',
        'store_id'       => 'nullable|exists:stores,store_id', // nullable كما طلبنا
        'manager_id'     => 'required|exists:users,user_id',
        'brochure'       => 'nullable|file|mimes:pdf,jpg,png|max:2048',
    ]);

    // 3. تجهيز البيانات الأساسية
    $data = $request->only(['warehouse_name', 'city', 'store_id', 'manager_id', 'description']);

    // 4. معالجة البروشور (كودك الأصلي الرائع لحذف الملف القديم)
    if ($request->hasFile('brochure')) {
        // حذف الملف القديم من المجلد إذا كان موجوداً
        if ($warehouse->brochure && file_exists(public_path('uploads/brochures/' . $warehouse->brochure))) {
            unlink(public_path('uploads/brochures/' . $warehouse->brochure));
        }

        $file = $request->file('brochure');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/brochures'), $fileName);
        $data['brochure'] = $fileName;
    }

    // 5. التحديث النهائي
    $warehouse->update($data);

    return redirect()->route('warehouses.index')->with('success', 'Warehouse data updated successfully.');
}

    /**
     * 7. الحذف (للمدير فقط)
     */
public function destroy($id)
{
    // 1. الحذف للمدير فقط
    if (Auth::user()->role !== 'manager') {
        return back()->with('error', 'عذراً، الحذف من صلاحية المدير فقط.');
    }

    $warehouse = Warehouse::findOrFail($id);

    // 2. شرط الحذف المزدوج: التأكد من عدم الارتباط بمنتجات أو متاجر
    if ($warehouse->products()->count() > 0 || $warehouse->store()->count() > 0) {
        return back()->with('error', 'لا يمكن حذف المستودع: تأكد من نقل المنتجات وفك الارتباط بالمتاجر أولاً!');
    }

    // 3. حذف ملف البروشور قبل حذف السجل من القاعدة
    if ($warehouse->brochure && file_exists(public_path('uploads/brochures/' . $warehouse->brochure))) {
        unlink(public_path('uploads/brochures/' . $warehouse->brochure));
    }

    $warehouse->delete();

    return redirect()->route('warehouses.index')->with('success', 'Warehouse removed successfully.');
}
public function manager()
{
    // الربط بين manager_id في جدول المستودعات و user_id في جدول المستخدمين
    return $this->belongsTo(User::class, 'manager_id', 'user_id');
}

}