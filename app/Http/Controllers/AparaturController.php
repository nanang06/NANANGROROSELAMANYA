<?php

namespace App\Http\Controllers;

use App\Models\Aparatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AparaturController extends Controller
{
    // Menampilkan daftar aparatur di halaman Admin
    public function index()
    {
        $aparaturs = Aparatur::orderBy('urutan', 'asc')->get();
        return view('admin.aparatur.index', compact('aparaturs'));
    }

    // Memproses form tambah aparatur
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
            'urutan' => 'required|integer|min:1|unique:aparaturs,urutan' // Validasi nomor urut harus unik
        ], [
            // Custom pesan error bahasa Indonesia agar mudah dipahami admin
            'urutan.unique' => 'Nomor urut tampil tersebut sudah digunakan oleh aparatur lain. Silakan gunakan nomor urut berikutnya.',
            'urutan.min' => 'Nomor urut minimal dimulai dari angka 1.'
        ]);

        $data = $request->all();

        // Cek jika ada file foto yang diupload
        if ($request->hasFile('foto')) {
            // Simpan foto ke folder storage/app/public/aparatur
            $data['foto'] = $request->file('foto')->store('aparatur', 'public');
        }

        Aparatur::create($data);

        return redirect()->back()->with('success', 'Data Aparatur berhasil ditambahkan.');
    }

    // Memproses perubahan data aparatur (Edit)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
            // Validasi unik kecuali untuk data milik aparatur ini sendiri yang sedang di-edit
            'urutan' => 'required|integer|min:1|unique:aparaturs,urutan,' . $id
        ], [
            'urutan.unique' => 'Nomor urut tampil tersebut sudah digunakan oleh aparatur lain. Silakan gunakan nomor urut berikutnya.',
            'urutan.min' => 'Nomor urut minimal dimulai dari angka 1.'
        ]);

        $aparatur = Aparatur::findOrFail($id);
        $data = $request->all();

        // Cek jika ada file foto baru yang diupload
        if ($request->hasFile('foto')) {
            // Hapus file foto lama dari storage jika ada
            if ($aparatur->foto) {
                Storage::disk('public')->delete($aparatur->foto);
            }

            // Simpan foto baru ke folder storage/app/public/aparatur
            $data['foto'] = $request->file('foto')->store('aparatur', 'public');
        } else {
            // Tetap gunakan foto lama jika tidak ada file baru yang diunggah
            $data['foto'] = $aparatur->foto;
        }

        $aparatur->update($data);

        return redirect()->back()->with('success', 'Data Aparatur berhasil diperbarui.');
    }

    // Menghapus data aparatur beserta fotonya
    public function destroy($id)
    {
        $aparatur = Aparatur::findOrFail($id);

        // Hapus file foto dari storage jika ada
        if ($aparatur->foto) {
            Storage::disk('public')->delete($aparatur->foto);
        }

        $aparatur->delete();

        return redirect()->back()->with('success', 'Data Aparatur berhasil dihapus.');
    }
}
