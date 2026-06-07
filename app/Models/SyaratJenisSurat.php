<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratJenisSurat extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_surat_id', 'nama_syarat'];

    // Relasi balik ke Jenis Surat
    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }
}
