<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // استخدام اسم الجدول STORES ليتوافق مع الإدخال اليدوي وقواعد بياناتك
        Schema::create('STORES', function (Blueprint $table) {
            $table->id('store_id');
            $table->string('store_name'); // Store Name (English)
            $table->string('location');   // City (Required for later filtering)
            
            /**
             * المطلب 2: السعر (Price)
             * نوع Decimal(10,2) لاستيعاب الفواصل بدقة
             * سيتم التعامل معه في الواجهات لاحقاً كإدخال نصي لضمان عدم ظهور العداد
             */
            $table->decimal('price', 10, 2)->default(0.00);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('STORES');
    }
};