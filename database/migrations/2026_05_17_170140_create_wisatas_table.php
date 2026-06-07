<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wisatas', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('nama_wisata');
            $blueprint->string('lokasi');
            $blueprint->text('deskripsi');
            $blueprint->string('jam_operasional')->nullable(); // Contoh: 08.00 - 17.00 WIB
            $blueprint->string('harga_tiket')->nullable(); // Contoh: Gratis atau Rp 10.000
            $blueprint->string('foto')->nullable();
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wisatas');
    }
};
