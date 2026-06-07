<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = ['nik', 'jenis_surat_id', 'status', 'file_selesai', 'keterangan_admin'];

    public function warga()
    {
        // 🛠️ withTrashed() dihapus agar kembali normal
        return $this->belongsTo(Warga::class, 'nik', 'nik');
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public function berkas()
    {
        return $this->hasMany(BerkasPengajuan::class, 'pengajuan_id');
    }
}
