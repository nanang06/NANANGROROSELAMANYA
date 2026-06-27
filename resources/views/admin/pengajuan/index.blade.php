@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Manajemen Pengajuan Surat</h4>
            <p class="text-muted small mb-0">Verifikasi berkas permohonan surat pelayanan masyarakat Kelurahan Pesanggrahan secara berkala.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert" style="background-color: #e6f7ed; color: #198754;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 900px;">
                    <thead class="text-white" style="background-color: #003366;">
                        <tr>
                            <th class="ps-4 py-3" style="width: 150px;">Tanggal</th>
                            <th class="py-3">Nama Warga / NIK</th>
                            <th class="py-3">Jenis Surat</th>
                            <th class="py-3 text-center" style="width: 160px;">Status</th>
                            <th class="py-3 text-center" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $p)
                        <tr>
                            <td class="ps-4 text-secondary small">
                                {{ $p->created_at->format('d/m/Y') }}
                            </td>

                            <td>
                                <span class="fw-bold text-dark d-block" style="font-size: 0.95rem;">
                                    {{ $p->warga->nama_lengkap ?? 'User Belum Isi Profil' }}
                                </span>
                                <small class="text-muted fw-medium" style="font-family: monospace; font-size: 0.85rem;">
                                    {{ $p->nik }}
                                </small>
                            </td>

                            <td class="fw-semibold text-dark">
                                {{ $p->jenisSurat->nama_surat ?? '-' }}
                            </td>

                            <td class="text-center">
                                @if($p->status == 'Pending')
                                    <span class="badge fw-bold px-3 py-2 rounded-pill text-dark" style="background-color: #ffcc00;">
                                        <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                    </span>
                                @elseif($p->status == 'Proses')
                                    <span class="badge bg-info fw-bold px-3 py-2 rounded-pill text-white">
                                        <i class="bi bi-gear-fill me-1"></i> Diproses
                                    </span>
                                @elseif($p->status == 'Selesai')
                                    <span class="badge bg-success fw-bold px-3 py-2 rounded-pill text-white">
                                        <i class="bi bi-check2-circle me-1"></i> Selesai
                                    </span>
                                @else
                                    <span class="badge bg-danger fw-bold px-3 py-2 rounded-pill text-white">
                                        <i class="bi bi-x-circle me-1"></i> Ditolak
                                    </span>
                                @endif
                            </td>

                            <td class="text-center pe-4">
                                <a href="{{ route('admin.pengajuan.detail', $p->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" style="background-color: #003366; border: none; font-size: 0.8rem;">
                                    <i class="bi bi-eye me-1"></i> Periksa Berkas
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center p-5 text-muted bg-white">
                                <i class="bi bi-envelope-open text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                                <h6 class="fw-bold text-secondary mb-1">Belum Ada Pengajuan Masuk</h6>
                                <p class="small text-muted mb-0">Kotak masuk permohonan pelayanan dokumen surat saat ini masih kosong.</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table tbody tr { transition: background-color 0.2s; }
    .table tbody tr:hover { background-color: rgba(0, 51, 102, 0.01) !important; }
</style>
@endsection
