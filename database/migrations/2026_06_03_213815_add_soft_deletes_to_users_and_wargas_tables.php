<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan kolom deleted_at ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Menambahkan kolom deleted_at ke tabel wargas
        Schema::table('wargas', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('wargas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
