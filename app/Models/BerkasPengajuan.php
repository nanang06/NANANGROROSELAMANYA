<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasPengajuan extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     * Ini memungkinkan penyimpanan data pengajuan_id, nama_berkas, dan path_file.
     */
    protected $fillable = [
        'pengajuan_id',
        'nama_berkas',
        'path_file',
    ];

    /**
     * Relasi ke model Pengajuan
     * Setiap berkas dimiliki oleh satu data pengajuan
     */
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id');
    }
}
