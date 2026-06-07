<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    // 🛠️ PERBAIKAN: Daftarkan kolom judul dan gambar agar diizinkan menyimpan data
    protected $fillable = [
        'judul',
        'gambar',
    ];
}
