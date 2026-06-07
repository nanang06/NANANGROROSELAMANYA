<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Storage;

class AdminPengajuanController extends Controller
{
    // Menampilkan semua pengajuan yang masuk ke Admin
    public function index()
    {
        // 🛠️ PERBAIKAN: Hanya mengambil pengajuan dari warga yang akunnya MASIH AKTIF (tidak di-soft delete)
        $pengajuan = Pengajuan::whereHas('warga', function ($query) {
            $query->whereNull('wargas.deleted_at');
        })
            ->with(['jenisSurat', 'warga'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    // Menampilkan detail pengajuan dan berkas syarat dari warga
    public function show($id)
    {
        $pengajuan = Pengajuan::with(['jenisSurat', 'berkas', 'warga'])->findOrFail($id);
        return view('admin.pengajuan.detail', compact('pengajuan'));
    }

    // Proses Verifikasi: Update Status, Tambah Keterangan, atau Upload Surat Jadi
    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        // 🛡️ PROTEKSI SISTEM: Jika status lama sudah 'Selesai', kunci mati data!
        if ($pengajuan->status == 'Selesai') {
            return back()->with('error', 'Gagal! Dokumen yang sudah berstatus Selesai telah dikunci dan tidak dapat diubah kembali.');
        }

        // Validasi input data dari form verifikasi admin
        $request->validate([
            'status' => 'required|in:Pending,Proses,Selesai,Ditolak',
            'file_selesai' => 'nullable|mimes:pdf|max:2048', // Validasi PDF maks 2MB
            'keterangan_admin' => 'nullable|string'
        ]);

        $data = [
            'status' => $request->status,
            'keterangan_admin' => $request->keterangan_admin,
        ];

        // Jika Admin mengunggah file surat yang sudah jadi
        if ($request->hasFile('file_selesai')) {
            // Hapus file lama jika ada (untuk mencegah penumpukan sampah file di storage)
            if ($pengajuan->file_selesai) {
                Storage::disk('public')->delete($pengajuan->file_selesai);
            }

            // Penamaan file dibuat rapi terstruktur berdasarkan NIK pemohon
            $namaFile = 'SURAT_' . $pengajuan->nik . '_' . time() . '.pdf';
            $path = $request->file('file_selesai')->storeAs('surat_selesai', $namaFile, 'public');
            $data['file_selesai'] = $path;
        }

        $pengajuan->update($data);

        return back()->with('success', 'Status pengajuan berhasil diperbarui!');
    }
}
