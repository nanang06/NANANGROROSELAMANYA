<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    // Menampilkan semua berita
    public function index()
    {
        $berita = Berita::latest()->get();
        return view('admin.berita.index', compact('berita'));
    }

    // Menyimpan berita baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048' // Diwajibkan saat tambah baru
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . time(), // Tambah time biar slug selalu unik
            'konten' => $request->konten,
            'gambar' => $path
        ]);

        return back()->with('success', 'Berita berhasil diterbitkan!');
    }

    // Memperbarui data berita (Edit)
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Opsional saat edit
        ]);

        $berita = Berita::findOrFail($id);

        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . $berita->id, // Mengikuti judul baru
            'konten' => $request->konten,
        ];

        // Jika admin mengunggah gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage jika ada
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }

            // Simpan gambar yang baru
            $path = $request->file('gambar')->store('berita', 'public');
            $data['gambar'] = $path;
        }

        $berita->update($data);

        return back()->with('success', 'Berita berhasil diperbarui!');
    }

    // Menghapus berita beserta gambarnya
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();
        return back()->with('success', 'Berita berhasil dihapus!');
    }
}
