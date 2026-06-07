@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Kelola Syarat Dokumen</h4>
            <p class="text-muted small mb-0">
                Mengatur berkas persyaratan wajib untuk: <strong class="text-dark">{{ $jenisSurat->nama_surat }} ({{ $jenisSurat->kode_surat }})</strong>
            </p>
        </div>
        <a href="{{ route('admin.jenis_surat.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-1" style="border-color: #003366; color: #003366;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert" style="background-color: #e6f7ed; color: #198754;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <h5 class="fw-bold mb-3" style="color: #003366;">
                    <i class="bi bi-plus-circle-fill text-warning me-2"></i>Tambah Syarat
                </h5>
                <hr class="opacity-10 mb-4">

                <form action="{{ route('admin.syarat.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="jenis_surat_id" value="{{ $jenisSurat->id }}">

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-secondary">Nama Dokumen Persyaratan</label>
                        <input type="text" name="nama_syarat" class="form-control rounded-3 p-2.5" placeholder="Contoh: Foto Kartu Keluarga (KK)" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold p-2.5 d-flex align-items-center justify-content-center gap-2" style="background-color: #003366; border: none;">
                        <i class="bi bi-plus-lg"></i> Simpan Syarat
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="text-white" style="background-color: #003366;">
                            <tr>
                                <th class="ps-4 py-3" style="width: 70px;">No</th>
                                <th class="py-3">Nama Berkas Persyaratan Wajib</th>
                                <th class="py-3 text-center" style="width: 200px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($syarat as $index => $s)
                            <tr>
                                <td class="ps-4 text-secondary small fw-medium">{{ $index + 1 }}</td>

                                <td class="fw-bold text-dark" style="font-size: 0.95rem;">
                                    {{ $s->nama_syarat }}
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditSyarat{{ $s->id }}" style="font-size: 0.8rem; border-color: #003366; color: #003366;">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <form action="{{ route('admin.syarat.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus syarat ini? Warga tidak perlu lagi mengunggah dokumen ini.')" class="m-0 d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                                                <i class="bi bi-trash3-fill"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center p-5 text-muted bg-white">
                                    <i class="bi bi-folder-x text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                                    <h6 class="fw-bold text-secondary mb-1">Belum Ada Syarat Dokumen</h6>
                                    <p class="small text-muted mb-0">Silakan gunakan formulir di sisi kiri untuk mendaftarkan syarat wajib berkas.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($syarat as $s)
<div class="modal fade" id="modalEditSyarat{{ $s->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.syarat.update', $s->id) }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Ubah Dokumen Syarat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Nama Dokumen Persyaratan</label>
                    <input type="text" name="nama_syarat" class="form-control rounded-3 p-2.5" value="{{ $s->nama_syarat }}" required>
                </div>
            </div>
            <div class="modal-footer border-top-0 bg-light rounded-bottom-4 py-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 btn-sm fw-medium" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn text-white rounded-pill px-4 btn-sm fw-bold shadow-sm" style="background-color: #003366; border: none;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<style>
    .table tbody tr { transition: background-color 0.2s; }
    .table tbody tr:hover { background-color: rgba(0, 51, 102, 0.01) !important; }
</style>
@endsection
