<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /**
         * 1. حساب عدد الساعات (Products Count)
         * المدير (Manager): يرى إجمالي الساعات في كل النظام.
         * الموظف (Staff): يرى فقط عدد الساعات في مستودعه المرتبط.
         */
        try {
            if ($user->role == 'manager') {
                // استخدام الـ Procedure لجلب العدد الإجمالي (المطلب التقني)
                $result = DB::select('CALL GetProductCount()');
                $productCount = $result[0]->total ?? 0;
            } else {
                // الموظف يرى إحصائية مستودعه فقط
                $productCount = Product::where('warehouse_id', $user->warehouse_id)->count();
            }
        } catch (\Exception $e) {
            // خطة احتياطية في حال فشل الـ Procedure
            $productCount = ($user->role == 'manager') 
                ? DB::table('PRODUCT')->count() 
                : DB::table('PRODUCT')->where('warehouse_id', $user->warehouse_id)->count();
        }

        /**
         * 2. حساب عدد المستودعات والمنتجات الأخيرة
         */
        if ($user->role == 'manager') {
            // المدير يرى كل شيء
            $warehouseCount = Warehouse::count();
            $recentProducts = Product::with('warehouse')
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();
        } else {
            // الموظف يرى بيانات مستودعه فقط
            $warehouseCount = $user->warehouse_id ? 1 : 0;
            $recentProducts = Product::where('warehouse_id', $user->warehouse_id)
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();
        }

        // إرسال البيانات للواجهة باللغة الإنجليزية (المطلب 1)
        return view('dashboard', compact('productCount', 'warehouseCount', 'recentProducts'));
    }
}