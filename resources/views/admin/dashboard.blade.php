@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Dashboard Utama Admin</h4>
            <p class="text-muted small mb-0">Selamat datang kembali! Berikut adalah ringkasan data pelayanan SIP CIPULIR saat ini.</p>
        </div>
        <span class="badge p-2 rounded-pill px-3 shadow-sm text-dark" style="background-color: #ffcc00; font-weight: 600;">
            <i class="bi bi-calendar3 me-1"></i> Hari ini: {{ date('d M Y') }}
        </span>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 overflow-hidden card-stat">
                <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #003366;"></div>
                <div class="d-flex align-items-center justify-content-between ms-2">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Warga Terdaftar</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalWarga }}</h2>
                    </div>
                    <div class="rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: rgba(0, 51, 102, 0.05);">
                        <i class="bi bi-people-fill fs-3" style="color: #003366;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 overflow-hidden card-stat">
                <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #ffcc00;"></div>
                <div class="d-flex align-items-center justify-content-between ms-2">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Menunggu (Pending)</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $suratPending }}</h2>
                    </div>
                    <div class="rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: rgba(255, 204, 0, 0.1);">
                        <i class="bi bi-hourglass-split fs-3" style="color: #cca300;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 overflow-hidden card-stat">
                <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #0dcaf0;"></div>
                <div class="d-flex align-items-center justify-content-between ms-2">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Sedang Diproses</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $suratProses }}</h2>
                    </div>
                    <div class="rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: rgba(13, 202, 240, 0.05);">
                        <i class="bi bi-gear-fill fs-3 text-info"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 overflow-hidden card-stat">
                <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #198754;"></div>
                <div class="d-flex align-items-center justify-content-between ms-2">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Surat Selesai Terbit</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $suratSelesai }}</h2>
                    </div>
                    <div class="rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: rgba(25, 135, 84, 0.05);">
                        <i class="bi bi-check2-circle fs-3 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <h5 class="fw-bold mb-3" style="color: #003366;"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Panduan Operasional Staf</h5>
                <p class="text-secondary small mb-4" style="line-height: 1.6;">
                    Sebagai Admin Kelurahan Cipulir, Anda bertanggung jawab penuh untuk memverifikasi keabsahan dokumen persyaratan yang diunggah oleh warga. Pastikan untuk menolak berkas jika resolusi gambar buram atau tidak terbaca, dan segera unggah dokumen hasil cetak resmi format PDF jika permohonan surat dinyatakan **Selesai**.
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-primary btn-sm rounded-pill px-4" style="background-color: #003366; border: none;">
                        Periksa Surat Masuk ({{ $suratPending }})
                    </a>
                    <a href="{{ route('admin.jenis_surat.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4" style="color: #003366; border-color: #003366;">
                        Master Layanan Surat ({{ $totalJenisSurat }})
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 rounded-4 text-white p-4 h-100 overflow-hidden" style="background: linear-gradient(135deg, #003366 0%, #002244 100%); border-bottom: 4px solid #ffcc00;">
                <h6 class="fw-bold mb-2"><i class="bi bi-info-circle-fill text-warning me-2"></i>Status Integrasi</h6>
                <p class="small opacity-75 mb-0" style="line-height: 1.6; font-size: 0.85rem;">
                    Sistem Pelayanan Digital terhubung penuh dengan tabel data akun warga pengguna. Setiap pengubahan status dokumen ataupun pesan penolakan dari admin akan memicu pembaruan data waktu nyata (real-time) di halaman riwayat warga.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .card-stat {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 51, 102, 0.05) !important;
    }
</style>
@endsection
