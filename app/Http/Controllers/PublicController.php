<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\JenisSurat;
use App\Models\Aparatur;
use App\Models\Profile;

// Import 3 Model Baru agar bisa diakses di halaman publik warga
use App\Models\Lembaga;
use App\Models\Umkm;
use App\Models\Wisata;

// 🛠️ Hubungkan Model Galeri (Sesuaikan jika nama model admin kamu berbeda, misal: GaleriFoto/Foto)
use App\Models\Galeri;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // Ambil data berita terbaru (terbatas 3 untuk landing page beranda)
        $berita = Berita::orderBy('created_at', 'desc')->take(3)->get();

        // Ambil data layanan surat
        $layanan = JenisSurat::with('syarat')->get();

        // Ambil data Lurah (Aparatur dengan urutan terkecil/pertama)
        $lurah = Aparatur::orderBy('urutan', 'asc')->first();

        return view('welcome', compact('berita', 'layanan', 'lurah'));
    }

    public function aparatur()
    {
        // Ambil semua daftar aparatur
        $aparaturs = Aparatur::orderBy('urutan', 'asc')->get();
        return view('publik.aparatur', compact('aparaturs'));
    }

    public function tentang()
    {
        // Hanya mengambil data sejarah
        $sejarah = Profile::where('key', 'sejarah')->first();
        return view('publik.tentang', compact('sejarah'));
    }

    public function visiMisi()
    {
        // Hanya mengambil data visi & misi
        $visi_misi = Profile::where('key', 'visi_misi')->first();
        return view('publik.visimisi', compact('visi_misi'));
    }

    // --- METHOD BARU: MENAMPILKAN HALAMAN LEMBAGA KEMASYARAKATAN ---
    public function lembaga()
    {
        // Mengambil semua data lembaga masyarakat untuk ditampilkan ke warga
        $lembagas = Lembaga::all();
        return view('publik.lembaga', compact('lembagas'));
    }

    // Menampilkan halaman khusus UMKM Warga
    public function umkm()
    {
        $umkms = Umkm::latest()->get();
        return view('publik.umkm', compact('umkms'));
    }

    // Menampilkan halaman khusus Pariwisata
    public function wisata()
    {
        $wisatas = Wisata::latest()->get();
        return view('publik.wisata', compact('wisatas'));
    }

    // --- METHOD BARU: MENAMPILKAN GRID HALAMAN SEMUA DAFTAR BERITA + FITUR CARI ---
    public function berita(Request $request)
    {
        // Tangkap kata kunci dari form pencarian di halaman blade
        $search = $request->input('search');

        // Logika kondisional: Jika ada kata kunci, filter judul berita yang mirip
        if ($search) {
            $beritas = Berita::where('judul', 'like', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Jika kosong, muat semua berita dari yang terbaru seperti biasa
            $beritas = Berita::orderBy('created_at', 'desc')->get();
        }

        // Lempar variabel beritas dan search agar bisa dipertahankan di kolom input text
        return view('publik.berita', compact('beritas', 'search'));
    }

    // --- METHOD BARU: MENAMPILKAN DETAIL ISI BERITA UTUH ---
    public function detailBerita($id)
    {
        // Cari data berita berdasarkan ID, jika tidak ketemu langsung gagalkan dengan error 404 (Not Found)
        $berita = Berita::findOrFail($id);

        return view('publik.berita_detail', compact('berita'));
    }

    // --- 🛠️ METHOD BARU: MENAMPILKAN GRID HALAMAN KATALOG GALERI FOTO ---
    public function galeri()
    {
        // Ambil semua data galeri foto kegiatan dari yang paling baru diupload
        $galeris = Galeri::orderBy('created_at', 'desc')->get();

        return view('publik.galeri', compact('galeris'));
    }
}
