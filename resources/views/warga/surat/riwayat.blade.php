@extends('layouts.warga')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Riwayat Pengajuan Surat</h4>
            <p class="text-muted small mb-0">Pantau perkembangan berkas permohonan Anda dan unduh surat jika telah selesai diterbitkan.</p>
        </div>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 950px;">
                    <thead class="text-white" style="background-color: #003366;">
                        <tr>
                            <th class="ps-4 py-3" style="width: 170px;">Tanggal Pengajuan</th>
                            <th class="py-3">Jenis Surat</th>
                            <th class="py-3 text-center" style="width: 140px;">Status</th>
                            <th class="py-3" style="width: 250px;">Keterangan</th>
                            <th class="py-3 text-center pe-4" style="width: 150px;">Unduh Surat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $r)
                            <tr>
                                <td class="ps-4 text-secondary small">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $r->created_at->translatedFormat('d M Y') }}
                                </td>

                                <td>
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">
                                        {{ $r->jenisSurat->nama_surat ?? 'Surat Tidak Diketahui' }}
                                    </h6>
                                    @if(isset($r->jenisSurat->kode_surat))
                                        <small class="text-muted style-code" style="font-size: 0.75rem;">{{ $r->jenisSurat->kode_surat }}</small>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if($r->status == 'Pending')
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fw-bold" style="border: 1px solid rgba(255,193,7,0.3); font-size: 0.8rem;">
                                            <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                        </span>
                                    @elseif($r->status == 'Proses')
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fw-bold" style="border: 1px solid rgba(13,110,253,0.3); font-size: 0.8rem;">
                                            <i class="bi bi-gear-fill spin-icon me-1"></i> Diproses
                                        </span>
                                    @elseif($r->status == 'Selesai')
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-bold" style="border: 1px solid rgba(40,167,69,0.3); font-size: 0.8rem;">
                                            <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-bold" style="border: 1px solid rgba(220,53,69,0.3); font-size: 0.8rem;">
                                            <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="text-muted small italic-text lh-sm d-block">
                                        {{ $r->keterangan_admin ? '"' . $r->keterangan_admin . '"' : '-' }}
                                    </span>
                                </td>

                                <td class="text-center pe-4">
                                    @if($r->status == 'Selesai' && $r->file_selesai)
                                        <a href="{{ asset('storage/' . $r->file_selesai) }}" download class="btn btn-warning btn-sm px-3 rounded-pill fw-bold text-dark shadow-sm d-inline-flex align-items-center gap-1 border-0" style="background-color: #ffcc00;">
                                            <i class="bi bi-download"></i> Unduh
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-5 text-muted bg-white rounded-bottom-4">
                                    <i class="bi bi-clock-history text-muted mb-3 d-block" style="font-size: 3.5rem;"></i>
                                    <h6 class="fw-bold text-secondary mb-1">Belum Ada Riwayat</h6>
                                    <p class="small text-muted mb-0">Belum ada riwayat pengajuan berkas dari akun Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table tbody tr {
        transition: background-color 0.2s;
    }
    .table tbody tr:hover {
        background-color: rgba(0, 51, 102, 0.01) !important;
    }
    .style-code {
        font-family: monospace;
    }
    .italic-text {
        font-style: italic;
    }
    /* Animasi putar pelan untuk ikon status proses agar interaktif */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .spin-icon {
        display: inline-block;
        animation: spin 4s linear infinite;
    }
    .lh-sm {
        line-height: 1.3 !important;
    }
</style>
@endsection
