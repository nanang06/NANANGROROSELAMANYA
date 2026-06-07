<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pariwisata - SIP CIPULIR</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; scroll-behavior: smooth; display: flex; flex-direction: column; min-height: 100vh; }

        /* Navbar Styling (Sama seperti template acuan) */
        .navbar { background: #003366 !important; padding: 12px 0; border-bottom: 3px solid #ffcc00; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; color: white !important;}
        .nav-link { color: rgba(255,255,255,0.9) !important; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; }
        .nav-link:hover { color: #ffcc00 !important; }
        .dropdown-menu { border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .dropdown-item:hover { background-color: #003366; color: white; }

        /* Header Gambar Spesifik */
        .page-header {
            background: linear-gradient(rgba(0, 51, 102, 0.8), rgba(0, 51, 102, 0.8)),
                        url('https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            color: white;
            text-align: center;
        }
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
            <h1 class="display-5 fw-bold mb-3">Pariwisata & Spot Menarik</h1>
            <p class="lead mb-0 opacity-75">Jelajahi keindahan ruang publik, sejarah lokal, dan destinasi ikonik di Cipulir</p>
        </div>
    </div>

    <div class="container py-5 mb-5 flex-grow-1">
        <div class="row g-4 justify-content-center">
            @forelse($wisatas as $w)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
                    <div style="height: 200px; background: #e9ecef; position: relative;">
                        @if($w->foto)
                            <img src="{{ asset('storage/' . $w->foto) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $w->nama_wisata }}">
                        @else
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <i class="bi bi-geo-alt text-secondary opacity-50" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-primary mb-2">{{ $w->nama_wisata }}</h5>
                        <p class="small text-muted mb-3"><i class="bi bi-map me-1"></i>{{ $w->lokasi }}</p>
                        <p class="small text-secondary mb-4" style="text-align: justify;">{{ $w->deskripsi }}</p>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top small text-muted">
                            <span><i class="bi bi-clock text-primary me-1"></i>{{ $w->jam_operasional ?? '24 Jam' }}</span>
                            <span class="badge bg-light text-dark border"><i class="bi bi-ticket-perforated text-success me-1"></i>{{ $w->harga_tiket ?? 'Gratis' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-geo-alt text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Data destinasi wisata belum ditambahkan oleh Admin.</p>
            </div>
            @endforelse
        </div>
    </div>

    <footer class="py-5 text-white shadow-lg mt-auto" style="background: #001a33;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <h4 class="fw-bold text-warning mb-3">SIP CIPULIR</h4>
                    <p class="opacity-75">Sistem Informasi Pelayanan Kelurahan Cipulir adalah inovasi untuk mewujudkan pelayanan publik yang modern dan transparan.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6 class="fw-bold mb-2">Alamat Kantor</h6>
                    <p class="small opacity-50">Jl. Ciledug Raya, Cipulir, Kec. Kby. Lama, Kota Jakarta Selatan, DKI Jakarta</p>
                    <div class="fs-4 d-flex gap-3 justify-content-md-end text-warning">
                        <i class="bi bi-facebook"></i><i class="bi bi-instagram"></i><i class="bi bi-youtube"></i>
                    </div>
                </div>
            </div>
            <hr class="my-4 opacity-25">
            <p class="text-center small opacity-50 mb-0">&copy; 2026 Pemerintah Kelurahan Cipulir. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
