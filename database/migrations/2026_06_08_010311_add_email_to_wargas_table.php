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
        Schema::table('wargas', function (Blueprint $table) {
            // 🛠️ Menambahkan kolom email setelah kolom nama_lengkap
            // Diberi nullable() agar data warga lama yang belum punya email tidak error
            $table->string('email')->nullable()->after('nama_lengkap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            // 🛠️ Menghapus kolom email jika fitur rollback (undo) dijalankan
            $table->dropColumn('email');
        });
    }
};
