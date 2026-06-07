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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul'); // Judul berita
            $table->string('slug')->unique(); // Untuk URL yang rapi (misal: berita-kelurahan-cipulir)
            $table->text('konten'); // Isi berita yang panjang
            $table->string('gambar')->nullable(); // Nama file gambar (boleh kosong jika tidak ada foto)
            $table->timestamps(); // Created_at & Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
