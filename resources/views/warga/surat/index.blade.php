@extends('layouts.warga')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Pilih Jenis Surat</h4>
            <p class="text-muted small mb-0">Silakan pilih layanan surat resmi yang ingin Anda ajukan secara online.</p>
        </div>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row g-4">
        @forelse($jenisSurat as $surat)
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden card-surat" style="transition: transform 0.3s, box-shadow 0.3s; background: white;">
                    <div style="height: 6px; background: #003366;"></div>

                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-4 d-flex align-items-center justify-content-center text-primary" style="width: 50px; height: 50px; background-color: rgba(0, 51, 102, 0.05);">
                                    <i class="bi bi-file-earmark-text-fill fs-3" style="color: #003366;"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark" style="line-height: 1.4;">{{ $surat->nama_surat }}</h6>
                                    <span class="badge mt-1" style="background-color: rgba(0, 51, 102, 0.1); color: #003366; font-size: 0.7rem; font-weight: 600;">
                                        {{ $surat->kode_surat }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <p class="text-muted small flex-grow-1 mb-4" style="line-height: 1.6;">
                            {{ $surat->keterangan ?? 'Layanan pengajuan dokumen ' . $surat->nama_surat . ' di Kelurahan Cipulir.' }}
                        </p>

                        <div class="mt-auto">
                            <a href="{{ route('warga.surat.detail', $surat->id) }}" class="btn btn-outline-primary w-100 py-2 rounded-pill fw-semibold text-center btn-pilih-surat" style="color: #003366; border-color: #003366; font-size: 0.9rem; transition: 0.3s;">
                                Pilih Surat <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 text-center p-5 bg-white">
                    <i class="bi bi-envelope-open text-muted mb-3" style="font-size: 4rem;"></i>
                    <h5 class="fw-bold text-secondary">Belum Ada Layanan Surat</h5>
                    <p class="text-muted small mb-0">Belum ada layanan surat yang tersedia saat ini.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    .card-surat:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 51, 102, 0.08) !important;
    }
    .card-surat:hover .btn-pilih-surat {
        background-color: #003366 !important;
        color: #ffffff !important;
        border-color: #003366 !important;
    }
</style>
@endsection
