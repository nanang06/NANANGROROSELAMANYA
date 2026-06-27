<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warga - SIP PESANGGRAHAN</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; }
        .sidebar { min-height: 100vh; background: #003366; box-shadow: 4px 0 10px rgba(0,0,0,0.1); z-index: 1000; }
        .sidebar-brand { border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .nav-link { color: rgba(255, 255, 255, 0.7) !important; border-radius: 10px; margin-bottom: 8px; padding: 12px 18px; font-weight: 500; transition: all 0.3s ease; }
        .nav-link:hover { color: #ffcc00 !important; background-color: rgba(255, 255, 255, 0.05); transform: translateX(3px); }
        .nav-link.active { background-color: #ffcc00 !important; color: #003366 !important; font-weight: 700; box-shadow: 0 4px 12px rgba(255, 204, 0, 0.2); }
        .main-content { padding: 40px 30px; min-height: 100vh; }
        .card-nik { background-color: rgba(255, 255, 255, 0.08); border: 1px dashed rgba(255, 255, 255, 0.2); border-radius: 12px; color: white; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 p-3 sidebar position-fixed d-flex flex-column">
                <div class="sidebar-brand text-center pt-3 pb-4 mb-4">
                    <i class="bi bi-shield-check text-warning mb-2" style="font-size: 3rem; display: block;"></i>
                    <h5 class="fw-bold text-white mb-1">SIP PESANGGRAHAN</h5>
                    <small class="text-white opacity-50 text-uppercase tracking-wider" style="font-size: 0.75rem; font-weight: 600;">Panel Warga</small>
                </div>

                <div class="card-nik mb-4 p-3 text-center shadow-sm">
                    <small class="text-white opacity-50 d-block mb-1" style="font-size: 0.8rem;">NIK Pengguna</small>
                    <strong class="small text-warning">{{ Auth::user()->nik }}</strong>
                </div>

                <ul class="nav flex-column flex-grow-1">
                    <li class="nav-item">
                        <a href="{{ route('warga.dashboard') }}" class="nav-link d-flex align-items-center {{ Request::is('warga/dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-fill fs-5 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('warga.profil') }}" class="nav-link d-flex align-items-center {{ Request::is('warga/profil*') ? 'active' : '' }}">
                            <i class="bi bi-person-vcard fs-5 me-2"></i> Profil Biodata
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('warga.surat.index') }}" class="nav-link d-flex align-items-center {{ Request::is('warga/ajukan-surat*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-plus fs-5 me-2"></i> Ajukan Surat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('warga.surat.riwayat') }}" class="nav-link d-flex align-items-center {{ Request::is('warga/riwayat-surat*') ? 'active' : '' }}">
                            <i class="bi bi-clock-history fs-5 me-2"></i> Riwayat Pengajuan
                        </a>
                    </li>
                </ul>

                <div class="border-top mt-auto pt-3 pb-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start text-danger d-flex align-items-center m-0 px-3" style="color: #ff6b6b !important;">
                            <i class="bi bi-box-arrow-right fs-5 me-2"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-9 offset-md-3 col-lg-10 offset-lg-2 main-content">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
