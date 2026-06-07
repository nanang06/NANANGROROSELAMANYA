@extends('layouts.warga')

@section('content')
<div class="container-fluid px-2">
    <div class="card border-0 shadow-sm rounded-4 mb-4 text-white overflow-hidden" style="background: linear-gradient(135deg, #003366 0%, #004080 100%);">
        <div class="card-body p-4 p-md-5">
            <h2 class="fw-bold mb-2">Selamat Datang Kembali, {{ $warga->nama_lengkap ?? Auth::user()->name }}!</h2>
            <p class="mb-0 opacity-75 lead fs-6">Pantau status pengajuan dokumen administrasi kelurahan Anda dengan mudah dalam satu dashboard.</p>
        </div>
    </div>

    @if(!$isLengkap)
        <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill fs-3 text-warning me-3"></i>
            <div>
                <h6 class="fw-bold mb-1 text-dark">Lengkapi Profil Biodata Anda</h6>
                <p class="small text-muted mb-0">Anda belum bisa melakukan pengajuan surat baru karena biodata belum lengkap. Silakan menuju menu <a href="{{ route('warga.profil') }}" class="fw-bold text-primary text-decoration-none">Profil Biodata</a> untuk melengkapinya.</p>
            </div>
        </div>
    @endif

    <h5 class="fw-bold mb-3" style="color: #003366;">Ringkasan Aktivitas Layanan</h5>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Total Pengajuan</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalPengajuan }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="bi bi-envelope-paper fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Sedang Diproses (Pending)</span>
                        <h2 class="fw-bold mb-0 text-warning">{{ $totalPending }}</h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-4 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="bi bi-hourglass-split fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">Surat Selesai</span>
                        <h2 class="fw-bold mb-0 text-success">{{ $totalSelesai }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-4 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="bi bi-check2-circle fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
