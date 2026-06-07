<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SIP CIPULIR</title>

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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px 0;
        }
        .login-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
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

    <div class="login-card shadow-lg">
        <div class="login-header pb-2">
            <i class="bi bi-person-vcard text-warning mb-2" style="font-size: 3.5rem;"></i>
            <h3 class="fw-bold mb-1" style="color: #003366;">Daftar Akun</h3>
            <p class="text-muted small">Buat akun untuk mulai mengajukan surat digital</p>
        </div>

        <div class="login-body">

            {{-- Menampilkan Error Validasi Laravel --}}
            @if ($errors->any())
                <div class="alert alert-danger p-2 small rounded-3 mb-3" id="errorAlert">
                    <ul class="mb-0 px-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Menampilkan Error Session Biasa --}}
            @if(session('error'))
                <div class="alert alert-danger p-2 text-center small rounded-3 mb-3" id="sessionAlert">
                    <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
                </div>
            @endif

            <form action="/proses-register" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted mb-1">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-person text-muted"></i></span>
                        <input type="text" name="name" class="form-control border-start-0 ps-0" required placeholder="Sesuai KTP Anda" autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted mb-1">Nomor Induk Kependudukan (NIK)</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-person-vcard text-muted"></i></span>
                        <input type="text" name="nik" class="form-control border-start-0 ps-0" required placeholder="Masukkan 16 digit NIK KTP Anda">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small text-muted mb-1">Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0"><i class="bi bi-shield-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control border-start-0 ps-0" required placeholder="Minimal 8 karakter">
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100 shadow-sm mt-2">Daftar Sekarang</button>
            </form>

            <div class="text-center mt-4">
                <p class="small text-muted mb-0">Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #003366;">Masuk di sini</a>
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
            // Ambil semua input di dalam form
            const inputs = document.querySelectorAll('.form-control');
            // Ambil semua elemen alert
            const alerts = document.querySelectorAll('.alert');

            // Tambahkan event listener untuk setiap input
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    // Jika user mulai mengetik, sembunyikan semua alert secara perlahan
                    alerts.forEach(alert => {
                        alert.style.opacity = '0';
                        setTimeout(() => {
                            alert.style.display = 'none';
                        }, 400); // Tunggu 0.4 detik sesuai durasi transisi CSS
                    });
                });
            });
        });
    </script>
</body>
</html>
