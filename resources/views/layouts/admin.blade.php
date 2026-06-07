<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SIP CIPULIR</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; overflow-x: hidden; }

        /* 🛠️ STRUKTUR AMAN UNTUK MODAL (Tetap dipertahankan) */
        .sidebar { width: 280px; height: 100vh; background: #003366; box-shadow: 4px 0 10px rgba(0,0,0,0.1); z-index: 1000; position: fixed; left: 0; top: 0; overflow-y: auto; }
        .main-content { margin-left: 280px; width: calc(100% - 280px); padding: 40px 30px; min-height: 100vh; transition: all 0.3s ease; }
        .sidebar::-webkit-scrollbar { width: 0px; display: none; }

        /* 🎨 GAYA VISUAL DARI PANEL WARGA */
        .sidebar-brand { border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .card-nik { background-color: rgba(255, 255, 255, 0.08); border: 1px dashed rgba(255, 255, 255, 0.2); border-radius: 12px; color: white; margin: 0 15px; }

        .nav-link { color: rgba(255, 255, 255, 0.7) !important; border-radius: 10px; margin-bottom: 8px; padding: 12px 18px; font-weight: 500; transition: all 0.3s ease; margin: 0 10px; }
        .nav-link:hover { color: #ffcc00 !important; background-color: rgba(255, 255, 255, 0.05); transform: translateX(3px); }
        .nav-link.active { background-color: #ffcc00 !important; color: #003366 !important; font-weight: 700; box-shadow: 0 4px 12px rgba(255, 204, 0, 0.2); }

        /* Teks Pembagi Menu (Karena menu admin sangat banyak, tetap butuh pembagi agar rapi) */
        .menu-heading { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: rgba(255, 255, 255, 0.35); margin-top: 15px; margin-bottom: 8px; padding-left: 25px; }
    </style>
</head>
<body>
    <div class="d-flex">

        <div class="py-3 sidebar d-flex flex-column">

            <div class="sidebar-brand text-center pt-2 pb-4 mb-4">
                <i class="bi bi-shield-check text-warning mb-2" style="font-size: 3rem; display: block;"></i>
                <h5 class="fw-bold text-white mb-1">SIP CIPULIR</h5>
                <small class="text-white opacity-50 text-uppercase tracking-wider" style="font-size: 0.75rem; font-weight: 600;">Panel Admin</small>
            </div>

            <div class="card-nik mb-4 p-3 text-center shadow-sm">
                <small class="text-white opacity-50 d-block mb-1" style="font-size: 0.8rem;">Nama Admin</small>
                <strong class="small text-warning">{{ Auth::user()->name ?? 'Admin' }}</strong>
            </div>

            <ul class="nav flex-column flex-grow-1 px-2">
                <div class="menu-heading">Utama</div>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill fs-5 me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.warga.index') }}" class="nav-link d-flex align-items-center {{ Request::is('admin/warga*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill fs-5 me-2"></i> Kelola Warga
                    </a>
                </li>

                <div class="menu-heading">Pelayanan Surat</div>
                <li class="nav-item">
                    <a href="{{ route('admin.jenis_surat.index') }}" class="nav-link d-flex align-items-center {{ Request::is('admin/jenis-surat*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text fs-5 me-2"></i> Master Surat
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.pengajuan.index') }}" class="nav-link d-flex align-items-center {{ Request::is('admin/pengajuan*') ? 'active' : '' }}">
                        <i class="bi bi-envelope-fill fs-5 me-2"></i> Pengajuan
                    </a>
                </li>

                <div class="menu-heading">Publikasi & Profil</div>
                <li class="nav-item">
                    <a href="{{ route('admin.berita.index') }}" class="nav-link d-flex align-items-center {{ Request::is('admin/berita*') ? 'active' : '' }}">
                        <i class="bi bi-newspaper fs-5 me-2"></i> Berita Wilayah
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.galeri.index') }}" class="nav-link d-flex align-items-center {{ Request::is('admin/galeri*') ? 'active' : '' }}">
                        <i class="bi bi-images fs-5 me-2"></i> Galeri Kegiatan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.aparatur.index') }}" class="nav-link d-flex align-items-center {{ Request::is('admin/aparatur*') ? 'active' : '' }}">
                        <i class="bi bi-person-workspace fs-5 me-2"></i> Staf Aparatur
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.profil.index') }}" class="nav-link d-flex align-items-center {{ Request::is('admin/profil-kelurahan*') ? 'active' : '' }}">
                        <i class="bi bi-info-circle-fill fs-5 me-2"></i> Profil Instansi
                    </a>
                </li>

                <div class="menu-heading">Potensi Wilayah</div>
                <li class="nav-item">
                    <a href="{{ route('admin.lembaga.index') }}" class="nav-link d-flex align-items-center {{ Request::is('admin/lembaga*') ? 'active' : '' }}">
                        <i class="bi bi-building-fill fs-5 me-2"></i> Data Lembaga
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.umkm.index') }}" class="nav-link d-flex align-items-center {{ Request::is('admin/umkm*') ? 'active' : '' }}">
                        <i class="bi bi-shop fs-5 me-2"></i> UMKM Warga
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.wisata.index') }}" class="nav-link d-flex align-items-center {{ Request::is('admin/wisata*') ? 'active' : '' }}">
                        <i class="bi bi-geo-alt-fill fs-5 me-2"></i> Wisata
                    </a>
                </li>
            </ul>

            <div class="border-top mt-auto pt-3 pb-2 px-2">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start text-danger d-flex align-items-center m-0" style="color: #ff6b6b !important;">
                        <i class="bi bi-box-arrow-right fs-5 me-2"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <div class="main-content">
            @yield('content')
        </div>
    </div>

    @yield('modals')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
