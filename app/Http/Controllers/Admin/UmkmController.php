<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    // Menampilkan daftar UMKM di panel admin
    public function index()
    {
        $umkm = Umkm::latest()->get();
        return view('admin.umkm.index', compact('umkm'));
    }

    // Menyimpan data UMKM baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'kontak' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        Umkm::create($data);

        return redirect()->back()->with('success', 'Data UMKM berhasil didaftarkan!');
    }

    // Memperbarui data UMKM (Edit)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'kontak' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $umkm = Umkm::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($umkm->foto) {
                Storage::disk('public')->delete($umkm->foto);
            }
            $data['foto'] = $request->file('foto')->store('umkm', 'public');
        } else {
            $data['foto'] = $umkm->foto;
        }

        $umkm->update($data);

        return redirect()->back()->with('success', 'Data UMKM berhasil diperbarui!');
    }

    // Menghapus data UMKM
    public function destroy($id)
    {
        $umkm = Umkm::findOrFail($id);

        if ($umkm->foto) {
            Storage::disk('public')->delete($umkm->foto);
        }

        $umkm->delete();

        return redirect()->back()->with('success', 'Data UMKM berhasil dihapus!');
    }
}
