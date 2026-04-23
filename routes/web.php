<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HRController;

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// ================= HR =================

// Dashboard
Route::get('/hr/dashboard', [HRController::class, 'dashboard'])
    ->name('hr.dashboard');

// Add Employee (form)
Route::get('/hr/add-employee', [HRController::class, 'create'])
    ->name('hr.create');

// Store Employee
Route::post('/hr/add-employee', [HRController::class, 'store'])
    ->name('hr.store');


// ================= AUTH =================

// Login page
Route::get('/login', function () {
    return view('login');
})->name('login.page');
// Login process
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::get('/test-db', [HRController::class, 'testDB']);

Route::get('/hr/employees', [HRController::class, 'index'])->name('hr.employees');
Route::delete('/employee/{id}', [HRController::class, 'delete'])->name('hr.delete');

Route::get('/employee/{id}/edit', [HRController::class, 'edit'])->name('hr.edit');
Route::put('/employee/{id}', [HRController::class, 'update'])->name('hr.update');



Route::prefix('hr')->group(function () {

    Route::get('/departments', [App\Http\Controllers\DepartmentController::class, 'index'])->name('departments.index');

    Route::get('/departments/create', [App\Http\Controllers\DepartmentController::class, 'create'])->name('departments.create');

    Route::post('/departments/store', [App\Http\Controllers\DepartmentController::class, 'store'])->name('departments.store');

    Route::get('/departments/edit/{id}', [App\Http\Controllers\DepartmentController::class, 'edit'])->name('departments.edit');

    Route::post('/departments/update/{id}', [App\Http\Controllers\DepartmentController::class, 'update'])->name('departments.update');

    Route::delete('/departments/delete/{id}', [App\Http\Controllers\DepartmentController::class, 'delete'])->name('departments.delete');
});


Route::post('/hr/change-status/{id}', [App\Http\Controllers\HRController::class, 'changeStatus'])
    ->name('hr.changeStatus');

Route::get('/hr/status', [App\Http\Controllers\HRController::class, 'statusPage'])
->name('hr.statusPage');

Route::get('/hr/employee/{id}', [HRController::class, 'show'])->name('hr.show');