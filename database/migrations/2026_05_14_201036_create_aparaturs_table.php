<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aparaturs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('foto')->nullable(); // Boleh kosong jika belum ada foto
            $table->integer('urutan')->default(0); // Berguna agar Lurah selalu tampil di urutan 1
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aparaturs');
    }
};
