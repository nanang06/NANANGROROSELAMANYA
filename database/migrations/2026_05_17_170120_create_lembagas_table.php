<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lembagas', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('nama_lembaga');
            $blueprint->string('singkatan')->nullable(); // Contoh: PKK, LPM, Karang Taruna
            $blueprint->text('deskripsi');
            $blueprint->string('logo')->nullable(); // Foto logo atau dokumentasi kegiatan
            $blueprint->string('nama_ketua')->nullable();
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lembagas');
    }
};
