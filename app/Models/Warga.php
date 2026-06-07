<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 🛠️ 1. Panggil class SoftDeletes

class Warga extends Model
{
    use HasFactory, SoftDeletes; // 🛠️ 2. Aktifkan SoftDeletes di sini

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'kewarganegaraan',
        'pekerjaan',
        'alamat_lengkap',
        'rt',
        'rw'
    ];

    /**
     * Relasi balik ke tabel User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }
}
