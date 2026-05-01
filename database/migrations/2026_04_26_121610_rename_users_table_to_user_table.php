<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('users', 'user');
    }

    public function down(): void
    {
        Schema::rename('user', 'users');
    }
};