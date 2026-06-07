<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Pengajuan;
use App\Models\JenisSurat;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan Halaman Utama / Dashboard Admin beserta Statistiknya
     */
    public function index()
    {
        // 1. Hitung total warga yang aktif terdaftar di sistem
        // Laravel secara otomatis hanya menghitung warga yang belum dihapus (deleted_at IS NULL)
        $totalWarga = Warga::count();

        // 2. Hitung statistik pengajuan surat berdasarkan statusnya
        // 🛠️ PERBAIKAN: Ditambahkan filter whereHas agar hanya menghitung surat dari warga yang MASIH AKTIF
        $suratPending = Pengajuan::whereHas('warga', function ($query) {
            $query->whereNull('wargas.deleted_at');
        })->where('status', 'Pending')->count();

        $suratProses  = Pengajuan::whereHas('warga', function ($query) {
            $query->whereNull('wargas.deleted_at');
        })->where('status', 'Proses')->count();

        $suratSelesai = Pengajuan::whereHas('warga', function ($query) {
            $query->whereNull('wargas.deleted_at');
        })->where('status', 'Selesai')->count();

        // 3. Hitung total jenis layanan surat yang tersedia
        $totalJenisSurat = JenisSurat::count();

        // Kirim semua data statistik ke view admin
        return view('admin.dashboard', compact(
            'totalWarga',
            'suratPending',
            'suratProses',
            'suratSelesai',
            'totalJenisSurat'
        ));
    }
}
