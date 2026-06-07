<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\User;
use App\Models\Pengajuan;
use App\Models\BerkasPengajuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminWargaController extends Controller
{
    public function index()
    {
        $daftarWarga = Warga::whereHas('user', function ($query) {
            $query->where('role', 'warga');
        })->orderBy('created_at', 'desc')->get();

        return view('admin.warga.index', compact('daftarWarga'));
    }

    /**
     * Menghapus data warga, akun, dan SELURUH riwayat suratnya secara permanen
     */
    public function destroy($nik)
    {
        $warga = Warga::where('nik', $nik)->firstOrFail();

        DB::beginTransaction();
        try {
            // 1. Cari semua pengajuan milik warga ini
            $pengajuans = Pengajuan::where('nik', $nik)->get();

            foreach ($pengajuans as $p) {
                // Hapus file surat selesai (PDF dari Admin) jika ada di storage
                if ($p->file_selesai) {
                    Storage::disk('public')->delete($p->file_selesai);
                }

                // Hapus semua berkas persyaratan (KTP, KK, dll yang diupload warga)
                $berkas = BerkasPengajuan::where('pengajuan_id', $p->id)->get();
                foreach ($berkas as $b) {
                    if ($b->file_path) {
                        Storage::disk('public')->delete($b->file_path);
                    }
                    $b->delete(); // Hapus record berkas dari database
                }

                $p->delete(); // Hapus record pengajuan dari database
            }

            // 2. Hapus akun login
            User::where('nik', $nik)->delete();

            // 3. Hapus data biodata warga
            $warga->delete();

            DB::commit();
            return redirect()->route('admin.warga.index')->with('success', 'Data warga beserta seluruh riwayat suratnya berhasil dihapus permanen.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.warga.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
