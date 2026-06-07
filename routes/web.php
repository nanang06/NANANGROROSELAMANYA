<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\SyaratController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\AdminPengajuanController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminWargaController;
use App\Http\Controllers\AparaturController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

// Import Controller Sisi Admin
use App\Http\Controllers\Admin\LembagaController;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\Admin\WisataController;
// 🛠️ PERBAIKAN: Mengimport GaleriController di baris atas agar dikenali global di dalam file rute
use App\Http\Controllers\Admin\GaleriController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- HALAMAN PUBLIK ---
Route::get('/', [PublicController::class, 'index'])->name('publik.home');
Route::get('/aparatur-kelurahan', [PublicController::class, 'aparatur'])->name('publik.aparatur');
Route::get('/tentang-kelurahan', [PublicController::class, 'tentang'])->name('publik.tentang');
Route::get('/visi-misi', [PublicController::class, 'visiMisi'])->name('publik.visimisi');

// --- RUTE PUBLIK BARU (SUDAH DIPISAH MANDIRI) ---
Route::get('/lembaga-kemasyarakatan', [PublicController::class, 'lembaga'])->name('publik.lembaga');
Route::get('/umkm-warga', [PublicController::class, 'umkm'])->name('publik.umkm');
Route::get('/destinasi-wisata', [PublicController::class, 'wisata'])->name('publik.wisata');

// --- RUTE PUBLIK BERITA ---
Route::get('/berita', [PublicController::class, 'berita'])->name('publik.berita');
Route::get('/berita/{id}', [PublicController::class, 'detailBerita'])->name('publik.berita.detail');

// 🛠️ RUTE PUBLIK BARU: GALERI FOTO
Route::get('/galeri', [PublicController::class, 'galeri'])->name('publik.galeri');


// Fitur Autentikasi (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/proses-login', [AuthController::class, 'prosesLogin']);
    Route::post('/proses-register', [AuthController::class, 'prosesRegister']);
});

// Fitur Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// --- HALAMAN PRIVATE (Wajib Login) ---
Route::middleware('auth')->group(function () {

    // --- GROUP UNTUK ADMIN ---
    Route::prefix('admin')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // --- MANAJEMEN DATA WARGA ---
        Route::get('/warga', [AdminWargaController::class, 'index'])->name('admin.warga.index');
        Route::delete('/warga/{nik}', [AdminWargaController::class, 'destroy'])->name('admin.warga.destroy');

        // CRUD Jenis Surat
        Route::get('/jenis-surat', [JenisSuratController::class, 'index'])->name('admin.jenis_surat.index');
        Route::post('/jenis-surat', [JenisSuratController::class, 'store'])->name('admin.jenis_surat.store');
        Route::put('/jenis-surat/{id}', [JenisSuratController::class, 'update'])->name('admin.jenis_surat.update');
        Route::delete('/jenis-surat/{id}', [JenisSuratController::class, 'destroy'])->name('admin.jenis_surat.destroy');

        // Kelola Syarat per Jenis Surat
        Route::get('/jenis-surat/{id}/syarat', [SyaratController::class, 'index'])->name('admin.syarat.index');
        Route::post('/syarat', [SyaratController::class, 'store'])->name('admin.syarat.store');
        Route::put('/syarat/{id}', [SyaratController::class, 'update'])->name('admin.syarat.update');
        Route::delete('/syarat/{id}', [SyaratController::class, 'destroy'])->name('admin.syarat.destroy');

        // Manajemen Berita
        Route::get('/berita', [BeritaController::class, 'index'])->name('admin.berita.index');
        Route::post('/berita', [BeritaController::class, 'store'])->name('admin.berita.store');
        Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('admin.berita.update');
        Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('admin.berita.destroy');

        // --- CRUD APARATUR KELURAHAN ---
        Route::get('/aparatur', [AparaturController::class, 'index'])->name('admin.aparatur.index');
        Route::post('/aparatur', [AparaturController::class, 'store'])->name('admin.aparatur.store');
        Route::put('/aparatur/{id}', [AparaturController::class, 'update'])->name('admin.aparatur.update');
        Route::delete('/aparatur/{id}', [AparaturController::class, 'destroy'])->name('admin.aparatur.destroy');

        // --- MANAJEMEN PROFIL KELURAHAN (SEJARAH, VISI & MISI) ---
        Route::get('/profil-kelurahan', [AdminProfileController::class, 'index'])->name('admin.profil.index');
        Route::post('/profil-kelurahan', [AdminProfileController::class, 'update'])->name('admin.profil.update');

        // --- MANAJEMEN PENGAJUAN ---
        Route::get('/pengajuan', [AdminPengajuanController::class, 'index'])->name('admin.pengajuan.index');
        Route::get('/pengajuan/{id}', [AdminPengajuanController::class, 'show'])->name('admin.pengajuan.detail');
        Route::post('/pengajuan/{id}/update', [AdminPengajuanController::class, 'update'])->name('admin.pengajuan.update');

        // --- FITUR BARU: CRUD LEMBAGA KEMASYARAKATAN ---
        Route::get('/lembaga', [LembagaController::class, 'index'])->name('admin.lembaga.index');
        Route::post('/lembaga', [LembagaController::class, 'store'])->name('admin.lembaga.store');
        Route::put('/lembaga/{id}', [LembagaController::class, 'update'])->name('admin.lembaga.update');
        Route::delete('/lembaga/{id}', [LembagaController::class, 'destroy'])->name('admin.lembaga.destroy');

        // --- FITUR BARU: CRUD UMKM KELURAHAN ---
        Route::get('/umkm', [UmkmController::class, 'index'])->name('admin.umkm.index');
        Route::post('/umkm', [UmkmController::class, 'store'])->name('admin.umkm.store');
        Route::put('/umkm/{id}', [UmkmController::class, 'update'])->name('admin.umkm.update');
        Route::delete('/umkm/{id}', [UmkmController::class, 'destroy'])->name('admin.umkm.destroy');

        // --- FITUR BARU: CRUD PARIWISATA WILAYAH ---
        Route::get('/wisata', [WisataController::class, 'index'])->name('admin.wisata.index');
        Route::post('/wisata', [WisataController::class, 'store'])->name('admin.wisata.store');
        Route::put('/wisata/{id}', [WisataController::class, 'update'])->name('admin.wisata.update');
        Route::delete('/wisata/{id}', [WisataController::class, 'destroy'])->name('admin.wisata.destroy');

        // 🛠️ RUTE CRUD MANAJEMEN GALERI FOTO ADMIN (SUDAH DISEDERHANAKAN)
        Route::get('/galeri', [GaleriController::class, 'index'])->name('admin.galeri.index');
        Route::post('/galeri', [GaleriController::class, 'store'])->name('admin.galeri.store');
        Route::put('/galeri/{id}', [GaleriController::class, 'update'])->name('admin.galeri.update');
        Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('admin.galeri.destroy');
    });

    // --- GROUP UNTUK WARGA ---
    Route::prefix('warga')->group(function () {
        Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('warga.dashboard');
        Route::get('/profil', [WargaController::class, 'profil'])->name('warga.profil');
        Route::post('/profil/update', [WargaController::class, 'updateProfil'])->name('warga.profil.update');
        Route::get('/ajukan-surat', [WargaController::class, 'pilihSurat'])->name('warga.surat.index');
        Route::get('/ajukan-surat/{id}', [WargaController::class, 'detailSurat'])->name('warga.surat.detail');
        Route::post('/ajukan-surat/simpan', [WargaController::class, 'simpanPengajuan'])->name('warga.surat.simpan');
        Route::get('/riwayat-surat', [WargaController::class, 'riwayatPengajuan'])->name('warga.surat.riwayat');
    });
});
