<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LembagaController extends Controller
{
    // Menampilkan daftar lembaga di panel admin
    public function index()
    {
        $lembaga = Lembaga::latest()->get();
        return view('admin.lembaga.index', compact('lembaga'));
    }

    // Menyimpan data lembaga baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'deskripsi' => 'required|string',
            'nama_ketua' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('lembaga', 'public');
        }

        Lembaga::create($data);

        return redirect()->back()->with('success', 'Lembaga Kemasyarakatan berhasil ditambahkan!');
    }

    // Memperbarui data lembaga (Edit)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'deskripsi' => 'required|string',
            'nama_ketua' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $lembaga = Lembaga::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($lembaga->logo) {
                Storage::disk('public')->delete($lembaga->logo);
            }
            $data['logo'] = $request->file('logo')->store('lembaga', 'public');
        } else {
            $data['logo'] = $lembaga->logo;
        }

        $lembaga->update($data);

        return redirect()->back()->with('success', 'Data Lembaga berhasil diperbarui!');
    }

    // Menghapus data lembaga
    public function destroy($id)
    {
        $lembaga = Lembaga::findOrFail($id);

        if ($lembaga->logo) {
            Storage::disk('public')->delete($lembaga->logo);
        }

        $lembaga->delete();

        return redirect()->back()->with('success', 'Lembaga berhasil dihapus!');
    }
}
