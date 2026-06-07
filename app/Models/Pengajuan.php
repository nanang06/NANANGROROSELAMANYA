<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'nik',
        'jenis_surat_id',
        'status',
        'file_selesai',
        'keterangan_admin',
    ];

    /**
     * Relasi ke model Warga
     * Satu pengajuan dimiliki oleh satu warga berdasarkan NIK
     */
    public function warga()
    {
        // 🛠️ PERBAIKAN: Menambahkan withTrashed() agar riwayat surat tetap aman dibaca
        // meskipun data Warga terkait sudah di-Soft Delete oleh Admin.
        return $this->belongsTo(Warga::class, 'nik', 'nik')->withTrashed();
    }

    /**
     * Relasi ke model JenisSurat
     * Satu pengajuan merujuk pada satu jenis surat
     */
    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    /**
     * Relasi ke model BerkasPengajuan
     * Satu pengajuan bisa memiliki banyak berkas persyaratan
     */
    public function berkas()
    {
        return $this->hasMany(BerkasPengajuan::class, 'pengajuan_id');
    }
}
