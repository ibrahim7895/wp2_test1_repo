<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('PERSONAL_INFORMATION', function (Blueprint $table) {
            $table->id('personal_id');

            $table->string('firstName');
            $table->string('lastName');

            $table->string('father');
            $table->string('mother')->nullable();

            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();

            $table->string('national_number')->unique();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();

            $table->decimal('salary', 10, 2)->nullable();

            $table->string('image')->nullable();

            // العلاقات
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('employee_status_id')->nullable();

            // العلاقات الخارجية
            $table->foreign('department_id')
                ->references('department_id')
                ->on('DEPARTMENT')
                ->nullOnDelete();

            $table->foreign('role_id')
                ->references('role_id')
                ->on('ROLE')
                ->nullOnDelete();

            $table->foreign('employee_status_id')
                ->references('employee_status_id')
                ->on('EMPLOYEE_STATUS')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_information');
    }
};
