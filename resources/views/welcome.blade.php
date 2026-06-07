<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Informasi Pelayanan - Kelurahan Cipulir</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; scroll-behavior: smooth; }

        /* Navbar Styling */
        .navbar { background: #003366 !important; padding: 12px 0; border-bottom: 3px solid #ffcc00; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .nav-link { color: rgba(255,255,255,0.9) !important; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; }
        .nav-link:hover { color: #ffcc00 !important; }
        .dropdown-menu { border: none; shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .dropdown-item:hover { background-color: #003366; color: white; }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 51, 102, 0.75), rgba(0, 51, 102, 0.75)),
                        url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            height: 80vh;
            display: flex;
            align-items: center;
            color: white;
            text-align: center;
        }
        .hero h1 { font-size: 3.5rem; font-weight: 800; }

        /* Card Custom */
        .card-layanan { border: none; border-radius: 15px; transition: 0.4s; border-bottom: 4px solid transparent; }
        .card-layanan:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); border-bottom: 4px solid #003366; }

        .card-potensi { border: none; border-radius: 20px; overflow: hidden; transition: 0.3s; }
        .card-potensi:hover { transform: scale(1.02); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }

        .section-title { font-weight: 800; color: #003366; position: relative; padding-bottom: 15px; text-align: center; }
        .section-title::after {
            content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 4px; background: #ffcc00;
        }
        .btn-primary-custom { background-color: #003366; border: none; color: white; border-radius: 50px; padding: 10px 25px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('publik.home') }}">
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
                    <li class="nav-item"><a class="nav-link" href="{{ Request::is('/') ? '#layanan' : route('publik.home').'#layanan' }}">Layanan</a></li>

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

    @if(Request::is('lembaga-kemasyarakatan') || Request::is('umkm-warga') || Request::is('destinasi-wisata') || Request::is('aparatur-kelurahan') || Request::is('tentang-kelurahan') || Request::is('visi-misi') || Request::is('berita*') || Request::is('galeri*'))

        <main class="py-2">
            @yield('content')
        </main>

    @else

        <header class="hero">
            <div class="container">
                <h1 class="mb-3 animate__animated animate__fadeIn">Website Resmi <br>Kelurahan Cipulir</h1>
                <p class="mb-4 opacity-75">Melayani Kebutuhan Administrasi Masyarakat Secara Cepat & Digital.</p>
                <a href="#layanan" class="btn btn-warning btn-lg px-5 py-3 fw-bold rounded-pill shadow">Mulai Layanan Surat</a>
            </div>
        </header>

        <section id="sambutan" class="py-5 bg-white">
            <div class="container py-5">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        @if(isset($lurah) && $lurah->foto)
                            <img src="{{ asset('storage/' . $lurah->foto) }}" class="rounded-4 shadow-lg img-fluid" style="max-height: 400px; border: 5px solid #f8f9fa;" alt="Foto Lurah">
                        @else
                            <div class="bg-light rounded-4 p-5 shadow-sm d-inline-block">
                                <i class="bi bi-person-bounding-box text-secondary" style="font-size: 5rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <i class="bi bi-quote fs-1 text-primary opacity-25"></i>
                        <h2 class="fw-bold mb-3" style="color: #003366;">Kata Sambutan</h2>
                        <p class="lead text-muted fst-italic">
                            "Selamat datang di website resmi Kelurahan Cipulir. Kami sangat bangga dapat menyambut Anda di website ini dan berbagi visi kami untuk membuat kelurahan ini menjadi tempat yang lebih baik. Kami akan terus bekerja keras untuk meningkatkan pelayanan publik, transparan, and mudah diakses. Terima kasih atas dukungan Anda."
                        </p>
                        <div class="mt-4">
                            <h5 class="fw-bold mb-0 text-primary">{{ $lurah->nama ?? 'Nama Lurah Belum Diisi' }}</h5>
                            <p class="text-muted">{{ $lurah->jabatan ?? 'Lurah Cipulir' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="alur" class="py-5 bg-light">
            <div class="container text-center py-4">
                <h2 class="section-title mb-5">ALUR PENGAJUAN</h2>
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="p-4 bg-white rounded-circle shadow-sm d-inline-block mb-3"><i class="bi bi-person-lock fs-2 text-primary"></i></div>
                        <h6 class="fw-bold">Login Akun</h6>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 bg-white rounded-circle shadow-sm d-inline-block mb-3"><i class="bi bi-file-earmark-text fs-2 text-primary"></i></div>
                        <h6 class="fw-bold">Pilih Layanan</h6>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 bg-white rounded-circle shadow-sm d-inline-block mb-3"><i class="bi bi-shield-check fs-2 text-primary"></i></div>
                        <h6 class="fw-bold">Verifikasi</h6>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 bg-white rounded-circle shadow-sm d-inline-block mb-3"><i class="bi bi-download fs-2 text-primary"></i></div>
                        <h6 class="fw-bold">Selesai</h6>
                    </div>
                </div>
            </div>
        </section>

        <section id="layanan" class="py-5 bg-white shadow-sm">
            <div class="container py-4">
                <h2 class="section-title mb-5">LAYANAN SURAT DIGITAL</h2>
                <div class="row g-4">
                    @foreach($layanan as $l)
                    <div class="col-md-4">
                        <div class="card card-layanan h-100 shadow-sm p-4">
                            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-envelope-check me-2"></i>{{ $l->nama_surat }}</h5>
                            <p class="small text-muted mb-3">Persyaratan:</p>
                            <ul class="list-unstyled small mb-4">
                                @foreach($l->syarat->take(3) as $s)
                                    <li class="mb-1"><i class="bi bi-check2 text-success me-2"></i>{{ $s->nama_syarat }}</li>
                                @endforeach
                            </ul>
                            @auth
                                <a href="{{ route('warga.surat.detail', $l->id) }}" class="btn btn-primary-custom w-100 text-center">Ajukan Sekarang</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 rounded-pill text-center">Masuk untuk Mengajukan</a>
                            @endauth
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="potensi" class="py-5 bg-light">
            <div class="container py-4">
                <h2 class="section-title mb-5 text-uppercase">UMKM & Pariwisata</h2>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card card-potensi shadow-sm h-100">
                            <img src="https://images.unsplash.com/photo-1555529669-e69e730f162b?q=80&w=500&auto=format&fit=crop" class="card-img-top" style="height: 250px; object-fit: cover;">
                            <div class="card-body p-4 text-center">
                                <h4 class="fw-bold">Pemberdayaan UMKM</h4>
                                <p class="text-muted small">Mendukung pertumbuhan ekonomi lokal melalui digitalisasi produk unggulan masyarakat Cipulir.</p>
                                <a href="{{ route('publik.umkm') }}" class="btn btn-outline-primary px-4 rounded-pill">Lihat Produk Lokal</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-potensi shadow-sm h-100">
                            <img src="https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?q=80&w=500&auto=format&fit=crop" class="card-img-top" style="height: 250px; object-fit: cover;">
                            <div class="card-body p-4 text-center">
                                <h4 class="fw-bold">Pariwisata Cipulir</h4>
                                <p class="text-muted small">Eksplorasi keindahan dan tempat-tempat bersejarah yang menjadi ikon di wilayah Kelurahan Cipulir.</p>
                                <a href="{{ route('publik.wisata') }}" class="btn btn-outline-primary px-4 rounded-pill">Jelajahi Wisata</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita" class="py-5 bg-white">
            <div class="container py-4">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h2 class="section-title mb-0" style="text-align: left;">BERITA TERBARU</h2>
                    <a href="{{ route('publik.berita') }}" class="btn btn-sm btn-outline-primary rounded-pill px-4">Semua Berita</a>
                </div>
                <div class="row g-4">
                    @forelse($berita as $b)
                    <div class="col-md-4">
                        <div class="card card-berita h-100 border-0 shadow-sm bg-light">
                            <div class="card-body">
                                <span class="badge bg-warning text-dark mb-2 small">{{ $b->created_at->format('d/m/Y') }}</span>
                                <h5 class="fw-bold mb-2">{{ $b->judul }}</h5>
                                <p class="text-muted small">{{ Str::limit(strip_tags($b->konten), 100) }}</p>
                                <a href="{{ route('publik.berita.detail', $b->id) }}" class="text-primary fw-bold text-decoration-none small">Baca Selengkapnya...</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-4"><p class="text-muted">Belum ada berita.</p></div>
                    @endforelse
                </div>
            </div>
        </section>

    @endif

    <footer class="py-5 text-white shadow-lg" style="background: #001a33;">
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
