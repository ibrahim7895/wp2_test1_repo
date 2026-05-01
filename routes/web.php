<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes - Aurum Time Project
|--------------------------------------------------------------------------
*/

// 1. توجيه الصفحة الرئيسية
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. روابط الزوار (Guest)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// 3. الروابط المحمية (Protected Routes)
Route::middleware(['auth'])->group(function () {

    // تسجيل الخروج
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // لوحة التحكم
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/warehouses/create', [WarehouseController::class, 'create'])->name('warehouses.create');

    // مجموعة إدارة المستودعات (Warehouses)
    Route::prefix('warehouses')->group(function () {
        
        // روابط متاحة للجميع (العرض والتحميل)
        Route::get('/', [WarehouseController::class, 'index'])->name('warehouses.index');
      Route::get('/warehouses/{warehouse_id}', [WarehouseController::class, 'show'])->name('warehouses.show');
        Route::get('/{warehouse_id}/download', [WarehouseController::class, 'downloadBrochure'])->name('warehouses.download');

        // روابط الموظف (الإضافة والتعديل)
     // يجب أن يكون رابط create "فوق" الرابط الذي يحتوي على ID


// أي رابط فيه {warehouse_id} يجب أن يكون "تحت"

        Route::post('/', [WarehouseController::class, 'store'])->name('warehouses.store');
        Route::get('/{warehouse_id}/edit', [WarehouseController::class, 'edit'])->name('warehouses.edit');
        Route::put('/{warehouse_id}', [WarehouseController::class, 'update'])->name('warehouses.update');

        // رابط المدير (الحذف)
        Route::delete('/{warehouse_id}', [WarehouseController::class, 'destroy'])->name('warehouses.destroy');
    });

    // مجموعة إدارة المنتجات (Products)
    Route::resource('products', ProductController::class);

}); // إغلاق مجموعة auth