<?php

namespace App\Http\Controllers\Admin; // Tetap mempertahankan namespace khusus admin milikmu

use App\Http\Controllers\Controller;
use App\Models\Profile; // Menggunakan model Profile sesuai struktur aslimu
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Menampilkan halaman form edit profil kelurahan
    public function index()
    {
        // Mengambil data baris tunggal berdasarkan key masing-masing di tabel profiles
        $sejarah = Profile::where('key', 'sejarah')->first();
        $visi_misi = Profile::where('key', 'visi_misi')->first();

        return view('admin.profil.index', compact('sejarah', 'visi_misi'));
    }

    // Memproses update data menggunakan metode Key-Value (Setting Table)
    public function update(Request $request)
    {
        // Validasi input data teks dari rich text editor (CKEditor)
        $request->validate([
            'sejarah' => 'required',
            'visi_misi' => 'required',
        ]);

        // Menyimpan data Sejarah: Update jika key sudah ada, Buat baru jika belum ada
        Profile::updateOrCreate(
            ['key' => 'sejarah'],
            ['value' => $request->sejarah]
        );

        // Menyimpan data Visi Misi: Update jika key sudah ada, Buat baru jika belum ada
        Profile::updateOrCreate(
            ['key' => 'visi_misi'],
            ['value' => $request->visi_misi]
        );

        // Mengembalikan ke halaman form dengan membawa session status sukses
        return redirect()->back()->with('success', 'Profil Kelurahan berhasil diperbarui.');
    }
}
