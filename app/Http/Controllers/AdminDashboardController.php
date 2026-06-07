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
        // 1. Hitung total warga yang terdaftar di sistem
        // Hanya menghitung warga yang akun user-nya memiliki role 'warga' (Akun Admin tidak ikut dihitung)
        $totalWarga = Warga::whereHas('user', function ($query) {
            $query->where('role', 'warga');
        })->count();

        // 2. Hitung statistik pengajuan surat berdasarkan statusnya
        // Query kembali bersih dan super cepat karena riwayat dari warga yang dihapus sudah ikut musnah bersih
        $suratPending = Pengajuan::where('status', 'Pending')->count();
        $suratProses  = Pengajuan::where('status', 'Proses')->count();
        $suratSelesai = Pengajuan::where('status', 'Selesai')->count();

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
