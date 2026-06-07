<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('nama_usaha');
            $blueprint->string('pemilik');
            $blueprint->string('kategori'); // Contoh: Kuliner, Kerajinan, Jasa
            $blueprint->text('deskripsi');
            $blueprint->string('kontak')->nullable(); // No HP / WhatsApp pelaku usaha
            $blueprint->text('alamat')->nullable();
            $blueprint->string('foto')->nullable();
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
