@extends('layouts.warga')

@section('content')
<div class="container-fluid px-2">
    <div class="mb-4">
        <a href="{{ route('warga.surat.index') }}" class="btn btn-outline-primary btn-sm mb-3 rounded-pill" style="color: #003366; border-color: #003366;">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Pilihan Surat
        </a>
        <h4 class="fw-bold" style="color: #003366;">Form Pengajuan: {{ $jenisSurat->nama_surat }}</h4>
        <p class="text-muted small">Silakan lengkapi berkas di bawah ini untuk mengirim permohonan Anda ke sistem pelayanan.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="mb-4 fw-bold" style="color: #003366;"><i class="bi bi-cloud-upload text-warning me-2"></i>Unggah Berkas Persyaratan</h5>

                    <form action="{{ route('warga.surat.simpan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jenis_surat_id" value="{{ $jenisSurat->id }}">

                        @forelse($syarat as $s)
                        <div class="mb-4 p-3 border rounded-4 bg-light shadow-sm">
                            <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.95rem;">{{ $s->nama_syarat }}</label>
                            <input type="file" name="berkas[{{ $s->id }}]" class="form-control rounded-3 shadow-sm p-2" required>
                            <div class="form-text text-muted mt-1" style="font-size: 0.8rem;">
                                <i class="bi bi-info-circle me-1"></i>Format: **JPG, PNG, atau PDF** (Maksimal ukuran file: 2MB)
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-warning border-0 shadow-sm rounded-4 d-flex align-items-center p-3 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-warning"></i>
                            <div>
                                <strong class="d-block text-dark">Tanpa Berkas Persyaratan</strong>
                                <span class="small text-muted">Tidak ada syarat dokumen khusus untuk jenis surat ini. Anda dapat langsung mengirimkan pengajuan ke admin kelurahan.</span>
                            </div>
                        </div>
                        @endforelse

                        <div class="mt-4 pt-2 text-end">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm py-2.5 rounded-pill fw-bold" style="background-color: #003366; border: none;">
                                <i class="bi bi-send me-2"></i> Kirim Pengajuan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 text-white mb-4 rounded-4 overflow-hidden">
                <div class="p-4" style="background: linear-gradient(135deg, #003366 0%, #002244 100%); border-bottom: 4px solid #ffcc00;">
                    <h6 class="fw-bold mb-1"><i class="bi bi-info-circle-fill text-warning me-2"></i>Informasi Penting</h6>
                    <p class="small mb-0 opacity-75">Panduan unggah dokumen pendukung.</p>
                </div>
                <div class="card-body p-4 bg-white text-dark">
                    <p class="small text-secondary mb-0" style="line-height: 1.6;">
                        Pastikan seluruh dokumen atau berkas yang Anda unggah terlihat secara jelas, tidak buram, teks terbaca, dan merupakan berkas resmi asli yang masih berlaku. Berkas yang tidak jelas berisiko **ditolak** oleh verifikator kelurahan.
                    </p>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-uppercase text-secondary small mb-3 tracking-wider" style="font-weight: 700;">Estimasi Peninjauan</h6>
                    <div class="d-flex align-items-start gap-3">
                        <div class="text-primary fs-3">
                            <i class="bi bi-lightning-charge-fill" style="color: #003366;"></i>
                        </div>
                        <p class="small mb-0 text-dark" style="line-height: 1.6;">
                            Berkas permohonan Anda akan diperiksa secara berkala oleh staf Admin dalam kurun waktu <strong>1-3 hari kerja</strong>. Anda dapat memantau perkembangannya melalui menu **Riwayat Pengajuan**.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
