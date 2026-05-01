<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('WAREHOUSE', function (Blueprint $table) {
            // 1. المعرف الأساسي
            $table->id('warehouse_id'); 
            
            // 1. المطلب: لغة إنجليزية LTR
            $table->string('warehouse_name');
            $table->string('city');
            
            /**
             * المطلب 1: ملف البروشور (إدخال وتعديل من قبل الموظف)
             * جعلناه nullable للسماح بإنشاء المستودع ثم رفع الملف لاحقاً
             */
            $table->string('brochure')->nullable(); 

            /**
             * المطلب 2: حقل السعر (Operational Cost/Price)
             * تغيير النوع لـ Decimal لقبول الفواصل وبدون "عداد" في الواجهة
             */
            $table->decimal('price', 10, 2)->nullable();

            /**
             * المطلب 4: ربط المستودع بمتجر (اختياري Nullable)
             * يسمح بربط أكثر من مستودع بنفس المتجر (لا يوجد Unique)
             */
            $table->unsignedBigInteger('store_id')->nullable(); 

            /**
             * المطلب 5: تخصيص مدير للمستودع (من جدول USERS برتبة manager)
             */
            $table->unsignedBigInteger('manager_id')->nullable(); 

            /**
             * المطلب 6: تخصيص موظف للمستودع (من جدول USERS برتبة staff)
             */
            $table->unsignedBigInteger('staff_id')->nullable();

            $table->timestamps();

            // --- العلاقات البرمجية (Foreign Keys) ---

            // ربط المدير (الحذف مشروط بموافقة النظام)
            $table->foreign('manager_id')->references('user_id')->on('USERS')->onDelete('set null');
            
            // ربط الموظف المسؤول
            $table->foreign('staff_id')->references('user_id')->on('USERS')->onDelete('set null');

            /**
             * ربط المتجر (شرط الحذف المشروط للمدير):
             * استخدمنا restrict لمنع حذف المتجر إذا كان مرتبطاً بمستودعات
             */
            $table->foreign('store_id')->references('store_id')->on('STORES')->onDelete('restrict');
        });

        /**
         * المطلب 7: تبعية الموظف لمستودع واحد (الربط العكسي)
         */
        Schema::table('USERS', function (Blueprint $table) {
            $table->foreign('warehouse_id')->references('warehouse_id')->on('WAREHOUSE')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('USERS', function (Blueprint $table) {
            $table->dropForeign(['warehouse_id']);
        });
        Schema::dropIfExists('WAREHOUSE');
    }
};