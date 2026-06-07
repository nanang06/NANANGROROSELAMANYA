<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory; // 🛠️ SoftDeletes dihapus

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'email',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }
}
