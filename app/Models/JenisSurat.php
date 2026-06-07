<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;

    protected $fillable = ['kode_surat', 'nama_surat', 'keterangan'];

    // Relasi: 1 Jenis Surat punya banyak Syarat
    public function syarat()
    {
        return $this->hasMany(SyaratJenisSurat::class);
    }
}
