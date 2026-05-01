<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // استخدام اسم الجدول PRODUCT بالخط العريض
        Schema::create('PRODUCT', function (Blueprint $table) {
            $table->id('product_id'); 
            $table->string('product_name'); // لغة إنجليزية (المطلب 1)

            /**
             * المطلب 2: حقل السعر (Price)
             * نوع Decimal(10,2) يسمح بالفواصل البرمجية بدقة
             * سيتم التعامل معه في الواجهة كحقل نصي لإزالة "العداد"
             */
            $table->decimal('price', 10, 2);

            $table->text('description')->nullable();
            
            /**
             * ملف الصورة أو المرفقات الخاصة بالمنتج
             */
            $table->string('upload_file')->nullable(); 
            
            /**
             * المطلب 4: التبعية للمستودع
             * الربط مع جدول WAREHOUSE
             */
            $table->unsignedBigInteger('warehouse_id'); 
            
            /**
             * قيد الحذف (Restrict):
             * يحقق شرط "الحذف المشروط للمدير" 
             * حيث يمنع حذف المستودع نهائياً إذا كانت هناك منتجات مرتبطة به
             */
            $table->foreign('warehouse_id')
                  ->references('warehouse_id') 
                  ->on('WAREHOUSE')           
                  ->onDelete('restrict');      

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('PRODUCT');
    }
};