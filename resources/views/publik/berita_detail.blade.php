<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }} - SIP PESANGGRAHAN</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ffffff; display: flex; flex-direction: column; min-height: 100vh; }

        /* Navbar Styling (Sama persis seperti halaman publik lainnya) */
        .navbar { background: #003366 !important; padding: 12px 0; border-bottom: 3px solid #ffcc00; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; color: white !important;}
        .nav-link { color: rgba(255,255,255,0.9) !important; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; }
        .nav-link:hover { color: #ffcc00 !important; }
        .dropdown-menu { border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .dropdown-item:hover { background-color: #003366; color: white; }

        /* Kategori Badge Kecil Atas */
        .badge-kategori {
            background-color: #e6f0fa;
            color: #0056b3;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 4px;
            display: inline-block;
        }

        /* Tipografi Judul & Meta Detail Berita sesuai Referensi */
        .berita-title {
            color: #1a1a1a;
            font-weight: 700;
            font-size: 2.2rem;
            line-height: 1.3;
            letter-spacing: -0.5px;
        }
        .berita-meta {
            font-size: 0.85rem;
            color: #8c8c8c;
            font-style: italic;
        }

        /* 🛠️ PERBAIKAN CSS AREA GAMBAR UTAMA BERITA */
        .berita-image-wrapper {
            width: 100%;
            display: flex;
            justify-content: center; /* Membuat wadah foto otomatis berada di posisi tengah */
            margin-bottom: 24px;
        }
        .berita-image-wrapper img {
            width: 100%;
            max-width: 500px; /* 🛠️ MEMBATASI LEBAR: Agar foto tidak raksasa/terlalu besar di layar */
            height: auto; /* Mengikuti tinggi asli foto secara proporsional agar tidak gepeng */
            border-radius: 4px;
            object-fit: contain; /* Memastikan foto asli tampil utuh tanpa terpotong */
        }

        /* Area Teks Isi Berita */
        .berita-body {
            font-size: 1.05rem;
            line-height: 1.85;
            color: #2b2b2b;
            text-align: justify;
            white-space: pre-line;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg shadow sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ route('publik.home') }}">
                <i class="bi bi-shield-check me-2 text-warning fs-3"></i>
                <span>SIP PESANGGRAHAN</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('publik.home') }}">Beranda</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Profil</a>
                        <ul class="dropdown-menu shadow">
                            <li><a class="dropdown-item" href="{{ route('publik.tentang') }}">Tentang Kelurahan</a></li>
                            <li><a class="dropdown-item" href="{{ route('publik.visimisi') }}">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="{{ route('publik.aparatur') }}">Aparatur Kelurahan</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('publik.lembaga') }}">Lembaga</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Publikasi</a>
                        <ul class="dropdown-menu shadow">
                            <li><a class="dropdown-item" href="{{ route('publik.berita') }}">Berita</a></li>
                            <li><a class="dropdown-item" href="{{ route('publik.galeri') }}">Galeri Foto</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('publik.home') }}#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('publik.umkm') }}">UMKM</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('publik.wisata') }}">Pariwisata</a></li>
                </ul>
                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ Auth::user()->role == 'Admin' ? route('admin.dashboard') : route('warga.dashboard') }}" class="btn btn-warning fw-bold px-4 rounded-pill shadow-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light px-4 rounded-pill">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-warning fw-bold px-4 text-dark rounded-pill">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-5 my-2 flex-grow-1" style="max-width: 820px;">

        <div class="mb-2">
            <span class="badge-kategori">Berita Kelurahan</span>
        </div>

        <h1 class="berita-title mb-2">{{ $berita->judul }}</h1>

        <div class="berita-meta mb-4">
            Dipublikasi pada tanggal {{ $berita->created_at->translatedFormat('d F Y') }}
        </div>

        @if($berita->gambar)
            <div class="berita-image-wrapper mb-4 shadow-sm">
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Foto Utama Berita">
            </div>
        @elseif($berita->foto)
            <div class="berita-image-wrapper mb-4 shadow-sm">
                <img src="{{ asset('storage/' . $berita->foto) }}" alt="Foto Utama Berita">
            </div>
        @endif

        <div class="berita-body mt-4">
            {!! $berita->konten !!}
        </div>

        <div class="mt-5 pt-4 border-top">
            <a href="{{ route('publik.berita') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-4 fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Berita
            </a>
        </div>
    </main>

    <footer class="py-5 text-white shadow-lg mt-auto" style="background: #001a33;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <h4 class="fw-bold text-warning mb-3">SIP PESANGGRAHAN</h4>
                    <p class="opacity-75">Sistem Informasi Pelayanan Kelurahan Pesanggrahan adalah inovasi untuk mewujudkan pelayanan publik yang modern dan transparan.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6 class="fw-bold mb-2">Alamat Kantor</h6>
                    <p class="small opacity-50">Jl. Pesanggrahan Indah No.2 5, RT.5/RW.3, Pesanggrahan, Kec. Pesanggrahan, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12320</p>
                    <div class="fs-4 d-flex gap-3 justify-content-md-end text-warning">
                        <i class="bi bi-facebook"></i><i class="bi bi-instagram"></i><i class="bi bi-youtube"></i>
                    </div>
                </div>
            </div>
            <hr class="my-4 opacity-25">
            <p class="text-center small opacity-50 mb-0">&copy; 2026 Pemerintah Kelurahan Pesanggrahan. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
