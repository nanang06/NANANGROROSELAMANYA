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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->string('nik'); // NIK warga yang mengajukan
            $table->foreignId('jenis_surat_id')->constrained('jenis_surats'); // ID surat yang dipilih
            $table->enum('status', ['Pending', 'Proses', 'Selesai', 'Ditolak'])->default('Pending');
            $table->text('keterangan_admin')->nullable(); // Alasan jika ditolak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
