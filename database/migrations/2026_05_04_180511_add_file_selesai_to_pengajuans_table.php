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
        Schema::table('pengajuans', function (Blueprint $table) {
            // Menambah kolom untuk file PDF dari admin dan keterangan revisi jika ditolak
            $table->string('file_selesai')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn('file_selesai');
        });
    }
};
