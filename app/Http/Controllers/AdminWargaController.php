<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminWargaController extends Controller
{
    /**
     * Menampilkan daftar seluruh warga terdaftar (Hanya yang ber-role Warga)
     */
    public function index()
    {
        // 🛠️ PERBAIKAN: Hanya mengambil data warga yang akun user-nya memiliki role 'warga'
        $daftarWarga = Warga::whereHas('user', function ($query) {
            $query->where('role', 'warga');
        })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.warga.index', compact('daftarWarga'));
    }

    /**
     * Menghapus data warga beserta akun loginnya menggunakan Database Transaction
     */
    public function destroy($nik)
    {
        $warga = Warga::where('nik', $nik)->firstOrFail();

        // Menggunakan DB Transaction agar jika salah satu gagal hapus, data otomatis di-rollback (aman)
        // Karena User dan Warga sudah pakai SoftDeletes, method delete() di bawah otomatis melakukan Soft Delete
        DB::beginTransaction();
        try {
            // 1. Hapus (Soft Delete) akun login di tabel users terlebih dahulu jika ada
            User::where('nik', $nik)->delete();

            // 2. Hapus (Soft Delete) data biodata di tabel wargas
            $warga->delete();

            DB::commit();
            return redirect()->route('admin.warga.index')->with('success', 'Data warga dan akun akses berhasil dihapus dari sistem.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.warga.index')->with('error', 'Gagal menghapus data warga: ' . $e->getMessage());
        }
    }
}
