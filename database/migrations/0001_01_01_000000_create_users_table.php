<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // استخدام اسم الجدول USERS بالخط العريض كما هو مطلوب في مشروعك
        Schema::create('USERS', function (Blueprint $table) {
            $table->id('user_id'); 
            $table->string('full_name'); 
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique()->nullable();
            
            /** * المطلب 5 + 6: الصلاحيات
             * 'manager' -> يملك صلاحية الحذف المشروط (بشرط عدم وجود منتجات أو متاجر مرتبطة)
             * 'staff'   -> يملك صلاحية الإضافة والتعديل والبحث وتحميل البروشور
             */
            $table->string('role')->default('staff'); 
           

            
            /**
             * المطلب 7: تبعية الموظف لمستودع واحد
             * تم جعلها nullable للسماح بإضافة موظف قبل ربطه بمستودع معين
             */
            $table->unsignedBigInteger('warehouse_id')->nullable(); 
            
            $table->rememberToken(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('USERS');
    }
};