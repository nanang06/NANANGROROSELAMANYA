<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    // Tampilkan halaman index daftar galeri di admin
    public function index()
    {
        $galeris = Galeri::orderBy('created_at', 'desc')->get();
        return view('admin.galeri.index', compact('galeris'));
    }

    // Simpan data galeri baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Batas 2MB
        ]);

        // Proses upload gambar ke storage/app/public/galeri
        $path = $request->file('gambar')->store('galeri', 'public');

        // 🛠️ SEKARANG AMAN: Karena properti $fillable sudah kita daftarkan di Model Galeri
        Galeri::create([
            'judul' => $request->judul,
            'gambar' => $path,
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Foto dokumentasi berhasil ditambahkan!');
    }

    // Perbarui data galeri (Judul / Foto)
    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = ['judul' => $request->judul];

        // Jika admin mengganti foto baru, hapus foto lama dan simpan yang baru
        if ($request->hasFile('gambar')) {
            if ($galeri->gambar) {
                Storage::disk('public')->delete($galeri->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Data galeri berhasil diperbarui!');
    }

    // Hapus permanen data galeri beserta filenya
    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->gambar) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Foto dokumentasi berhasil dihapus!');
    }
}
