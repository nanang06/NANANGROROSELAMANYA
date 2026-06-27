<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - SIP PESANGGRAHAN</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; scroll-behavior: smooth; display: flex; flex-direction: column; min-height: 100vh; }

        /* Navbar Styling (Sama persis seperti template acuan) */
        .navbar { background: #003366 !important; padding: 12px 0; border-bottom: 3px solid #ffcc00; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; color: white !important;}
        .nav-link { color: rgba(255,255,255,0.9) !important; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; }
        .nav-link:hover { color: #ffcc00 !important; }
        .dropdown-menu { border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .dropdown-item:hover { background-color: #003366; color: white; }

        /* Header Gambar Spesifik (Sama seperti halaman Aparatur) */
        .page-header {
            background: linear-gradient(rgba(0, 51, 102, 0.8), rgba(0, 51, 102, 0.8)),
                        url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            padding: 60px 0;
            color: white;
            text-align: center;
        }

        .search-bar { max-width: 500px; margin: 0 auto; position: relative; }
        .search-bar input { padding: 12px 20px 12px 45px; border-radius: 30px; border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .search-bar i { position: absolute; left: 18px; top: 14px; color: #6c757d; z-index: 10; }

        .card-berita { border: none; border-radius: 12px; overflow: hidden; background: white; transition: 0.3s; }
        .card-berita:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="bg-light">

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

    <div class="page-header shadow-sm">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">Berita Kelurahan</h1>
            <p class="lead mb-4 opacity-75">Informasi terkini dan pengumuman resmi seputar wilayah Kelurahan Pesanggrahan</p>

            <form action="{{ route('publik.berita') }}" method="GET" class="search-bar">
                <i class="bi bi-search"></i>
                <input type="text" name="search" class="form-control" placeholder="Cari judul berita..." value="{{ $search ?? '' }}">
            </form>
        </div>
    </div>

    <div class="container py-5 mb-5 flex-grow-1">

        @if(isset($search) && $search != '')
            <div class="mb-4 bg-white p-3 rounded-3 shadow-sm d-flex justify-content-between align-items-center">
                <span class="text-secondary mb-0">Menampilkan hasil pencarian untuk: <strong class="text-dark">"{{ $search }}"</strong></span>
                <a href="{{ route('publik.berita') }}" class="btn btn-sm btn-secondary rounded-pill px-3">Reset</a>
            </div>
        @endif

        <div class="row g-4 justify-content-center">
            @forelse($beritas as $b)
            <div class="col-md-4">
                <a href="{{ route('publik.berita.detail', $b->id) }}" class="text-decoration-none text-dark">
                    <div class="card card-berita h-100 shadow-sm">
                        <div style="height: 200px; background-color: #e9ecef;">
                            @if($b->gambar)
                                <img src="{{ asset('storage/' . $b->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                            @elseif($b->foto)
                                <img src="{{ asset('storage/' . $b->foto) }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <img src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=500" class="w-100 h-100" style="object-fit: cover;">
                            @endif
                        </div>
                        <div class="card-body p-4">
                            <span class="badge bg-light text-primary border mb-2 small">Berita Kelurahan</span>
                            <h5 class="fw-bold mb-2 text-dark truncate-2" style="line-height: 1.4; font-size: 1.1rem;">{{ $b->judul }}</h5>

                            <p class="text-muted small mb-0">
                                <i class="bi bi-calendar3 me-1"></i>{{ $b->created_at->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="bi bi-newspaper opacity-25" style="font-size: 4rem;"></i>
                <p class="mt-3">Maaf, berita tidak ditemukan atau belum ada data terbaru.</p>
            </div>
            @endforelse
        </div>
    </div>

    <footer class="py-5 text-white shadow-lg mt-auto" style="background: #001a33;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <h4 class="fw-bold text-warning mb-3">SIP Pesanggrahan</h4>
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
