<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    // Menampilkan daftar surat
    public function index()
    {
        // Menggunakan orderBy agar data yang baru ditambahkan/diubah muncul paling atas
        $surat = JenisSurat::orderBy('created_at', 'desc')->get();
        return view('admin.jenis_surat.index', compact('surat'));
    }

    // Proses simpan surat baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_surat' => 'required|unique:jenis_surats,kode_surat|max:10',
            'nama_surat' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        JenisSurat::create([
            'kode_surat' => strtoupper($request->kode_surat), // Otomatis simpan huruf besar
            'nama_surat' => $request->nama_surat,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.jenis_surat.index')->with('success', 'Jenis surat berhasil ditambahkan!');
    }

    // Proses simpan perubahan (Edit) jenis surat
    public function update(Request $request, $id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        $request->validate([
            // ignore($id) mencegah error unique jika admin tidak mengubah kode suratnya saat mengedit
            'kode_surat' => 'required|max:10|unique:jenis_surats,kode_surat,' . $id,
            'nama_surat' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $jenisSurat->update([
            'kode_surat' => strtoupper($request->kode_surat),
            'nama_surat' => $request->nama_surat,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.jenis_surat.index')->with('success', 'Kategori layanan surat berhasil diperbarui.');
    }

    // Proses hapus surat
    public function destroy($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        $jenisSurat->delete();

        return redirect()->route('admin.jenis_surat.index')->with('success', 'Jenis surat berhasil dihapus!');
    }
}
