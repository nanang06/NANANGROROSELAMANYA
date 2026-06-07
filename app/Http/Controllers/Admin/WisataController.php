<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WisataController extends Controller
{
    // Menampilkan daftar wisata di panel admin
    public function index()
    {
        $wisata = Wisata::latest()->get();
        return view('admin.wisata.index', compact('wisata'));
    }

    // Menyimpan data wisata baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jam_operasional' => 'nullable|string|max:100',
            'harga_tiket' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('wisata', 'public');
        }

        Wisata::create($data);

        return redirect()->back()->with('success', 'Destinasi wisata berhasil ditambahkan!');
    }

    // Memperbarui data wisata (Edit)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jam_operasional' => 'nullable|string|max:100',
            'harga_tiket' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $wisata = Wisata::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($wisata->foto) {
                Storage::disk('public')->delete($wisata->foto);
            }
            $data['foto'] = $request->file('foto')->store('wisata', 'public');
        } else {
            $data['foto'] = $wisata->foto;
        }

        $wisata->update($data);

        return redirect()->back()->with('success', 'Data destinasi wisata berhasil diperbarui!');
    }

    // Menghapus data wisata
    public function destroy($id)
    {
        $wisata = Wisata::findOrFail($id);

        if ($wisata->foto) {
            Storage::disk('public')->delete($wisata->foto);
        }

        $wisata->delete();

        return redirect()->back()->with('success', 'Destinasi wisata berhasil dihapus!');
    }
}
