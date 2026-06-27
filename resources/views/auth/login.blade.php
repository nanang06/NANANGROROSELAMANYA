<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIP PESANGGRAHAN</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(0, 51, 102, 0.8), rgba(0, 51, 102, 0.8)),
                        url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            text-align: center;
            padding: 40px 30px 20px;
        }
        .login-body {
            padding: 0 30px 40px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #003366;
            box-shadow: 0 0 0 0.25rem rgba(0, 51, 102, 0.1);
        }
        .input-group-text {
            background: transparent;
            border-radius: 10px 0 0 10px;
        }
        .btn-login {
            background-color: #003366;
            color: white;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #002244;
            color: #ffcc00;
            transform: translateY(-2px);
        }
        .back-link {
            position: absolute;
            top: 25px;
            left: 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }
        .back-link:hover {
            color: #ffcc00;
        }
        /* Tambahan transisi agar alert hilangnya halus */
        .alert {
            transition: opacity 0.4s ease-out;
        }
    </style>
</head>
<body>

    <a href="{{ route('publik.home') }}" class="back-link d-none d-md-block">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
    </a>

    <div class="login-card">
        <div class="login-header">
            <i class="bi bi-shield-check text-warning mb-2" style="font-size: 3.5rem;"></i>
            <h3 class="fw-bold mb-1" style="color: #003366;">SIP PESANGGRAHAN</h3>
            <p class="text-muted small">Sistem Informasi Pelayanan</p>
        </div>

        <div class="login-body">

            {{-- Menampilkan Error Validasi Laravel --}}
            @if ($errors->any())
                <div class="alert alert-danger p-2 small rounded-3 mb-3">
                    <ul class="mb-0 px-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Alert jika ada pesan error dari controller --}}
            @if(session('error'))
                <div class="alert alert-danger p-2 text-center small rounded-3 mb-3">
                    <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Alert jika ada pesan sukses --}}
            @if(session('success'))
                <div class="alert alert-success p-2 text-center small rounded-3 mb-3">
                    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif

            <form action="/proses-login" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted mb-1">NIK / Username Admin</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-person-badge text-muted"></i></span>
                        <input type="text" name="nik" class="form-control border-start-0 ps-0" required placeholder="Masukkan NIK atau Username" autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-semibold small text-muted mb-0">Password</label>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control border-start-0 ps-0" required placeholder="Masukkan password Anda">
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100 shadow-sm">Masuk Sekarang</button>
            </form>

            <div class="text-center mt-4">
                <p class="small text-muted mb-0">Belum punya akun?
                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #003366;">Daftar Warga</a>
                </p>
            </div>

            <div class="text-center mt-3 d-block d-md-none">
                <a href="{{ route('publik.home') }}" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');
            const alerts = document.querySelectorAll('.alert');

            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    alerts.forEach(alert => {
                        alert.style.opacity = '0';
                        setTimeout(() => {
                            alert.style.display = 'none';
                        }, 400);
                    });
                });
            });
        });
    </script>
</body>
</html>
