<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto - SIP CIPULIR</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; scroll-behavior: smooth; display: flex; flex-direction: column; min-height: 100vh; }

        /* Navbar Styling */
        .navbar { background: #003366 !important; padding: 12px 0; border-bottom: 3px solid #ffcc00; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; color: white !important;}
        .nav-link { color: rgba(255,255,255,0.9) !important; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; }
        .nav-link:hover { color: #ffcc00 !important; }
        .dropdown-menu { border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .dropdown-item:hover { background-color: #003366; color: white; }

        /* Header Jumbotron */
        .page-header {
            background: linear-gradient(rgba(0, 51, 102, 0.8), rgba(0, 51, 102, 0.8)),
                        url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            padding: 60px 0;
            color: white;
            text-align: center;
        }

        /* Card Galeri Custom */
        .card-galeri { border: none; border-radius: 12px; overflow: hidden; background: white; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
        .card-galeri:hover { transform: translateY(-5px); box-shadow: 0 12px 20px rgba(0,0,0,0.08); }

        /* Mengunci rasio foto dokumentasi (16:9) agar seragam berjejer rapi */
        .galeri-img-container { width: 100%; height: 220px; overflow: hidden; background-color: #e9ecef; }
        .galeri-img-container img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .card-galeri:hover .galeri-img-container img { transform: scale(1.05); }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg shadow sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ route('publik.home') }}">
                <i class="bi bi-shield-check me-2 text-warning fs-3"></i>
                <span>SIP CIPULIR</span>
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

    <div class="page-header shadow-sm">
        <div class="container">
            <h1 class="display-5 fw-bold mb-2">Galeri Kegiatan</h1>
            <p class="lead mb-0 opacity-75">Dokumentasi lensa aktivitas dan program kerja Pemerintah Kelurahan Cipulir</p>
        </div>
    </div>

    <div class="container py-5 mb-5 flex-grow-1">
        <div class="row g-4">
            @forelse($galeris as $g)
            <div class="col-md-4">
                <div class="card card-galeri h-100 shadow-sm">
                    <div class="galeri-img-container">
                        @if(isset($g->gambar) && $g->gambar)
                            <img src="{{ asset('storage/' . $g->gambar) }}" alt="Dokumentasi">
                        @elseif(isset($g->foto) && $g->foto)
                            <img src="{{ asset('storage/' . $g->foto) }}" alt="Dokumentasi">
                        @else
                            <img src="https://images.unsplash.com/photo-1542038784456-1ea8e935640e?q=80&w=500" alt="Default">
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-2" style="font-size: 1.1rem; line-height: 1.4;">{{ $g->judul ?? $g->nama_kegiatan }}</h5>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-calendar3 me-1"></i>{{ $g->created_at->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="bi bi-images opacity-25" style="font-size: 4rem;"></i>
                <p class="mt-3">Belum ada dokumentasi foto kegiatan yang diunggah.</p>
            </div>
            @endforelse
        </div>
    </div>

    <footer class="py-5 text-white shadow-lg mt-auto" style="background: #001a33;">
        <div class="container text-center small opacity-50">
            <p class="mb-0">&copy; 2026 Pemerintah Kelurahan Cipulir. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
