<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Modifikasi Tabel Users sesuai rancangan kita
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique(); // Mengganti email menjadi NIK
            $table->string('password');
            $table->enum('role', ['admin', 'warga'])->default('warga'); // Menambahkan role
            $table->rememberToken(); // Biarkan ini untuk fitur "Remember Me" saat login
            $table->timestamps();
        });

        // 2. Biarkan tabel bawaan Laravel ini (Jangan dihapus)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 3. Biarkan tabel bawaan Laravel ini (Jangan dihapus)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
