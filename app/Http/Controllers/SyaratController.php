<?php

namespace App\Http\Controllers;

use App\Models\SyaratJenisSurat;
use App\Models\JenisSurat;
use Illuminate\Http\Request;

class SyaratController extends Controller
{
    // Menampilkan halaman kelola syarat berdasarkan ID Jenis Surat
    public function index($jenis_surat_id)
    {
        $jenisSurat = JenisSurat::findOrFail($jenis_surat_id);
        $syarat = SyaratJenisSurat::where('jenis_surat_id', $jenis_surat_id)->get();

        // Tetap menggunakan lokasi view asli kamu
        return view('admin.jenis_surat.syarat', compact('jenisSurat', 'syarat'));
    }

    // Menyimpan syarat baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_syarat' => 'required|string|max:255'
        ]);

        SyaratJenisSurat::create([
            'jenis_surat_id' => $request->jenis_surat_id,
            'nama_syarat' => $request->nama_syarat
        ]);

        return back()->with('success', 'Syarat berhasil ditambahkan!');
    }

    // Proses simpan perubahan (Edit) berkas syarat
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_syarat' => 'required|string|max:255'
        ]);

        $syarat = SyaratJenisSurat::findOrFail($id);
        $syarat->update([
            'nama_syarat' => $request->nama_syarat
        ]);

        return back()->with('success', 'Nama dokumen persyaratan berhasil diperbarui!');
    }

    // Menghapus syarat
    public function destroy($id)
    {
        SyaratJenisSurat::destroy($id);
        return back()->with('success', 'Syarat berhasil dihapus!');
    }
}
