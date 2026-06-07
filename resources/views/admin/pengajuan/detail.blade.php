@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Pemeriksaan Berkas Permohon</h4>
            <p class="text-muted small mb-0">Periksa kecocokan berkas asli warga secara teliti sebelum memberikan status legalitas.</p>
        </div>
        <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-1" style="border-color: #003366; color: #003366;">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert" style="background-color: #e6f7ed; color: #198754;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>
                    <strong>Tindakan Ditolak:</strong> {{ session('error') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <div class="p-4 text-white d-flex align-items-center gap-3" style="background-color: #003366;">
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center text-primary" style="width: 45px; height: 45px; background: rgba(255,255,255,0.15) !important;">
                        <i class="bi bi-person-badge text-warning fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-white" style="font-size: 1.05rem;">{{ $pengajuan->warga->nama_lengkap }}</h6>
                        <small class="opacity-75" style="font-family: monospace; font-size: 0.85rem; letter-spacing: 0.5px;">NIK: {{ $pengajuan->nik }}</small>
                    </div>
                </div>

                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color: #003366;"><i class="bi bi-files text-warning me-2"></i>Dokumen Lampiran Warga:</h6>
                    <div class="row g-3">
                        @forelse($pengajuan->berkas as $b)
                        <div class="col-md-6">
                            <div class="border border-light-subtle rounded-4 p-3 bg-light h-100 d-flex flex-column justify-content-between shadow-sm">
                                <label class="fw-bold text-dark small mb-2 d-block text-truncate"><i class="bi bi-file-earmark-text me-1 text-secondary"></i>{{ $b->nama_berkas }}</label>

                                <div class="text-center bg-white rounded-3 p-2 border d-flex align-items-center justify-content-center overflow-hidden mb-3" style="height: 180px;">
                                    @php $ext = pathinfo($b->path_file, PATHINFO_EXTENSION); @endphp

                                    @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                        <img src="{{ asset('storage/' . $b->path_file) }}" class="img-fluid rounded" style="max-height: 160px; object-fit: contain;">
                                    @else
                                        <div class="py-2">
                                            <i class="bi bi-file-earmark-pdf-fill text-danger" style="font-size: 3.5rem;"></i>
                                            <span class="d-block text-muted small fw-bold mt-1">Dokumen PDF</span>
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ asset('storage/' . $b->path_file) }}" target="_blank" class="btn btn-sm btn-light w-100 rounded-pill fw-bold text-secondary border shadow-sm" style="font-size: 0.75rem;">
                                    <i class="bi bi-fullscreen me-1"></i> Lihat Ukuran Penuh
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-4 text-muted small">
                            <i class="bi bi-info-circle me-1"></i> Tidak ada lampiran berkas fisik yang dikirimkan.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <h5 class="fw-bold mb-1" style="color: #003366;"><i class="bi bi-check2-square text-warning me-2"></i>Verifikasi Layanan</h5>

                @if($pengajuan->status == 'Selesai')
                    <p class="text-muted small mb-3">Dokumen telah diarsip secara permanen.</p>
                    <hr class="opacity-10 mb-4">

                    <div class="text-center p-4 rounded-4" style="background-color: #e6f7ed; color: #198754;">
                        <i class="bi bi-lock-fill text-success mb-2 d-block" style="font-size: 3rem;"></i>
                        <h6 class="fw-bold text-dark mb-1">Pengajuan Telah Selesai</h6>
                        <p class="small text-secondary mb-3" style="line-height: 1.5;">Status permohonan berkas ini sudah sah dan dikunci secara permanen oleh sistem.</p>

                        @if($pengajuan->file_selesai)
                            <a href="{{ asset('storage/' . $pengajuan->file_selesai) }}" target="_blank" class="btn btn-success btn-sm rounded-pill px-3 fw-bold shadow-sm w-100 py-2">
                                <i class="bi bi-file-earmark-pdf-fill"></i> Lihat Hasil Surat (PDF)
                            </a>
                        @endif
                    </div>
                @else
                    <p class="text-muted small mb-3">Tentukan status akhir keabsahan permohonan warga.</p>
                    <hr class="opacity-10 mb-4">

                    <form action="{{ route('admin.pengajuan.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Ubah Status Dokumen</label>
                            <select name="status" class="form-select rounded-3 p-2.5 fw-semibold text-dark">
                                <option value="Pending" {{ $pengajuan->status == 'Pending' ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                                <option value="Proses" {{ $pengajuan->status == 'Proses' ? 'selected' : '' }}>⚙️ Dalam Proses Cetak</option>
                                <option value="Selesai" {{ $pengajuan->status == 'Selesai' ? 'selected' : '' }}>✅ Selesai (Kirim Surat)</option>
                                <option value="Ditolak" {{ $pengajuan->status == 'Ditolak' ? 'selected' : '' }}>❌ Tolak Pengajuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Keterangan / Catatan Admin</label>
                            <textarea name="keterangan_admin" class="form-control rounded-3 p-2.5 small" rows="3" placeholder="Contoh: Berkas foto buram, harap upload lembar kartu keluarga kembali...">{{ $pengajuan->keterangan_admin }}</textarea>
                        </div>

                        <div class="mb-4 p-3 rounded-4 bg-light border border-dashed text-center">
                            <label class="form-label small fw-bold text-dark d-block mb-1"><i class="bi bi-cloud-arrow-up-fill me-1 text-primary"></i>Unggah Hasil Surat Resmi</label>
                            <small class="text-muted d-block mb-2" style="font-size: 0.75rem;">Format dokumen wajib berupa berkas .PDF</small>

                            <input type="file" name="file_selesai" class="form-control form-control-sm rounded-3 shadow-sm bg-white" accept=".pdf">

                            @if($pengajuan->file_selesai)
                                <div class="mt-2 text-success small fw-bold d-flex align-items-center justify-content-center gap-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-check-circle-fill"></i> Arsip Surat PDF Siap Diunduh Warga
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold p-2.5 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #003366; border: none;">
                            <i class="bi bi-arrow-right-circle-fill"></i> Simpan Keputusan
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .table tbody tr { transition: background-color 0.2s; }
    .table tbody tr:hover { background-color: rgba(0, 51, 102, 0.01) !important; }
</style>
@endsection
