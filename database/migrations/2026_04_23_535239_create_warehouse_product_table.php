<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('WAREHOUSE_PRODUCT', function (Blueprint $table) {
            $table->id();
            
            /**
             * المطلب 3: البحث والفلاتر
             * هذا الجدول هو المحرك الأساسي لعرض "الكميات" في الـ GridView 
             * التي سيشاهدها الموظف والمدير باللغة الإنجليزية (LTR)
             */
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('product_id');
            
            // الكمية المتوفرة في هذا المستودع تحديداً
            $table->integer('quantity')->default(0);
            
            /**
             * الربط البرمجي (Foreign Keys):
             * تم الإبقاء على أسماء الجداول WAREHOUSE و PRODUCT بالخط العريض
             */
            $table->foreign('warehouse_id')
                  ->references('warehouse_id')
                  ->on('WAREHOUSE')
                  ->onDelete('cascade');

            $table->foreign('product_id')
                  ->references('product_id')
                  ->on('PRODUCT')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('WAREHOUSE_PRODUCT');
    }
};