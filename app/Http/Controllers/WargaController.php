<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\JenisSurat;
use App\Models\SyaratJenisSurat;
use App\Models\Pengajuan;
use App\Models\BerkasPengajuan;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    /**
     * Membantu pengecekan kelengkapan data biodata warga
     */
    private function cekKelengkapanProfil()
    {
        $warga = Warga::where('nik', Auth::user()->nik)->first();
        if (!$warga) return false;

        // Cukup cek kolom teks utama. Jika tempat lahir atau alamat masih berisi '-', berarti profil BELUM LENGKAP
        return !empty($warga->tempat_lahir) && $warga->tempat_lahir !== '-' &&
            !empty($warga->tanggal_lahir) &&
            !empty($warga->jenis_kelamin) &&
            !empty($warga->rt) && $warga->rt !== '-' &&
            !empty($warga->rw) && $warga->rw !== '-' &&
            !empty($warga->alamat_lengkap) && $warga->alamat_lengkap !== '-';
    }

    /**
     * Halaman Utama Dashboard (Informasi Singkat / Statistik)
     */
    public function dashboard()
    {
        // Menggunakan salah satu nilai ENUM resmi ('Laki-laki') agar database tidak menolak saat pendaftaran pertama
        $warga = Warga::firstOrCreate(
            ['nik' => Auth::user()->nik],
            [
                'nama_lengkap'    => Auth::user()->name ?? 'Warga Baru',
                'tempat_lahir'    => '-',
                'tanggal_lahir'   => date('Y-m-d'),
                'jenis_kelamin'   => 'Laki-laki',
                'agama'           => '-',
                'rt'              => '-',
                'rw'              => '-',
                'pekerjaan'       => '-',
                'kewarganegaraan' => 'WNI',
                'alamat_lengkap'  => '-'
            ]
        );

        $isLengkap = $this->cekKelengkapanProfil();

        $totalPengajuan = Pengajuan::where('nik', Auth::user()->nik)->count();
        $totalPending = Pengajuan::where('nik', Auth::user()->nik)->where('status', 'Pending')->count();
        $totalSelesai = Pengajuan::where('nik', Auth::user()->nik)->where('status', 'Selesai')->count();

        return view('warga.dashboard', compact('warga', 'isLengkap', 'totalPengajuan', 'totalPending', 'totalSelesai'));
    }

    /**
     * Halaman Khusus Kelengkapan Biodata
     */
    public function profil()
    {
        // Penerapan aman yang sama di halaman profil biodata
        $warga = Warga::firstOrCreate(
            ['nik' => Auth::user()->nik],
            [
                'nama_lengkap'    => Auth::user()->name ?? 'Warga Baru',
                'tempat_lahir'    => '-',
                'tanggal_lahir'   => date('Y-m-d'),
                'jenis_kelamin'   => 'Laki-laki',
                'agama'           => '-',
                'rt'              => '-',
                'rw'              => '-',
                'pekerjaan'       => '-',
                'kewarganegaraan' => 'WNI',
                'alamat_lengkap'  => '-'
            ]
        );

        $isLengkap = $this->cekKelengkapanProfil();

        return view('warga.profil', compact('warga', 'isLengkap'));
    }

    public function pilihSurat()
    {
        if (!$this->cekKelengkapanProfil()) {
            return redirect()->route('warga.profil')->with('error', 'Silakan lengkapi profil biodata Anda terlebih dahulu.');
        }
        $jenisSurat = JenisSurat::all();
        return view('warga.surat.index', compact('jenisSurat'));
    }

    public function detailSurat($id)
    {
        if (!$this->cekKelengkapanProfil()) {
            return redirect()->route('warga.profil')->with('error', 'Silakan lengkapi profil biodata Anda terlebih dahulu.');
        }
        $jenisSurat = JenisSurat::findOrFail($id);
        $syarat = SyaratJenisSurat::where('jenis_surat_id', $id)->get();
        return view('warga.surat.detail', compact('jenisSurat', 'syarat'));
    }

    public function simpanPengajuan(Request $request)
    {
        if (!$this->cekKelengkapanProfil()) {
            return redirect()->route('warga.profil')->with('error', 'Data profil belum lengkap.');
        }

        $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'berkas.*' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $pengajuan = Pengajuan::create([
            'nik' => Auth::user()->nik,
            'jenis_surat_id' => $request->jenis_surat_id,
            'status' => 'Pending',
        ]);

        if ($request->hasFile('berkas')) {
            foreach ($request->file('berkas') as $syarat_id => $file) {
                $dataSyarat = SyaratJenisSurat::find($syarat_id);
                if ($dataSyarat) {
                    $cleanSyaratName = str_replace(' ', '_', $dataSyarat->nama_syarat);
                    $namaFile = Auth::user()->nik . '_' . time() . '_' . $cleanSyaratName . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('pengajuan', $namaFile, 'public');

                    BerkasPengajuan::create([
                        'pengajuan_id' => $pengajuan->id,
                        'nama_berkas' => $dataSyarat->nama_syarat,
                        'path_file' => $path,
                    ]);
                }
            }
        }

        return redirect()->route('warga.surat.riwayat')->with('success', 'Pengajuan surat berhasil dikirim!');
    }

    public function riwayatPengajuan()
    {
        $riwayat = Pengajuan::with('jenisSurat')
            ->where('nik', Auth::user()->nik)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('warga.surat.riwayat', compact('riwayat'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama_lengkap'    => 'required|string|max:255',
            'tempat_lahir'    => 'required|string',
            'tanggal_lahir'   => 'required|date',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'agama'           => 'required|string',
            'rt'              => 'required|string|max:5',
            'rw'              => 'required|string|max:5',
            'pekerjaan'       => 'nullable|string',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'alamat_lengkap'  => 'required|string',
        ]);

        Warga::updateOrCreate(
            ['nik' => Auth::user()->nik],
            $request->except(['_token'])
        );

        return redirect()->route('warga.profil')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
