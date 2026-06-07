<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail; // 🛠️ Menggunakan Facade Mail Laravel
use App\Mail\NotifikasiSuratSelesai; // 🛠️ Memanggil Class Mailable kita

class AdminPengajuanController extends Controller
{
    // Menampilkan semua pengajuan yang masuk ke Admin
    public function index()
    {
        // 🛠️ PENYESUAIAN: Query kembali bersih dan cepat karena data yatim-piatu dari warga yang dihapus sudah otomatis hilang
        $pengajuan = Pengajuan::with(['jenisSurat', 'warga'])
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

    // Process Verifikasi: Update Status, Tambah Keterangan, atau Upload Surat Jadi
    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::with('warga')->findOrFail($id);

        // 🛡️ PROTEKSI SISTEM: Jika status lama sudah 'Selesai', kunci mati data!
        if ($pengajuan->status == 'Selesai') {
            return back()->with('error', 'Gagal! Dokumen yang sudah berstatus Selesai telah dikunci dan tidak dapat diubah kembali.');
        }

        // Validasi input data dari form verifikasi admin
        // 🛠️ PERBAIKAN: Jika status Selesai, file PDF WAJIB diunggah (required_if)
        $request->validate([
            'status' => 'required|in:Pending,Proses,Selesai,Ditolak',
            'file_selesai' => 'required_if:status,Selesai|mimes:pdf|max:2048', // Validasi PDF maks 2MB wajib jika Selesai
            'keterangan_admin' => 'nullable|string'
        ], [
            // Pesan error custom agar admin paham kesalahannya
            'file_selesai.required_if' => 'File surat PDF wajib diunggah jika status diubah menjadi Selesai!',
            'file_selesai.mimes' => 'File yang diunggah harus berformat PDF.',
            'file_selesai.max' => 'Ukuran file PDF maksimal adalah 2MB.'
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

        // 🛠️ JURUS OTOMATISASI EMAIL NOTIFIKASI
        // Jika status sukses diubah ke 'Selesai' dan warga memiliki alamat email yang valid
        if ($request->status == 'Selesai' && isset($pengajuan->warga->email) && $pengajuan->warga->email !== '-') {
            try {
                Mail::to($pengajuan->warga->email)->send(new NotifikasiSuratSelesai($pengajuan));
            } catch (\Exception $e) {
                // Proteksi sistem: Jika konfigurasi SMTP mail di .env salah/belum lengkap, proses web tidak akan macet/blank error
            }
        }

        return back()->with('success', 'Status pengajuan berhasil diperbarui!');
    }
}
