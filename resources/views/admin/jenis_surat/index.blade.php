@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Kelola Jenis Surat</h4>
            <p class="text-muted small mb-0">Kelola master layanan kategori surat menyurat untuk warga Kelurahan Pesanggrahan.</p>
        </div>
        <button class="btn text-dark fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah" style="background-color: #ffcc00; border: none;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Jenis Surat
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert" style="background-color: #e6f7ed; color: #198754;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Gagal menyimpan perubahan:</strong>
            <ul class="mb-0 mt-1 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-white" style="background-color: #003366;">
                        <tr>
                            <th class="ps-4 py-3" style="width: 120px;">Kode</th>
                            <th class="py-3">Nama Surat</th>
                            <th class="py-3">Keterangan</th>
                            <th class="py-3 text-center" style="width: 280px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($surat as $s)
                        <tr>
                            <td class="ps-4">
                                <span class="badge fw-bold px-3 py-2 rounded-pill text-dark" style="background-color: rgba(255, 204, 0, 0.2); border: 1px solid #ffcc00;">
                                    {{ $s->kode_surat }}
                                </span>
                            </td>

                            <td class="fw-bold text-dark" style="font-size: 0.95rem;">
                                {{ $s->nama_surat }}
                            </td>

                            <td class="text-secondary small">
                                {{ $s->keterangan ?? '-' }}
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.syarat.index', $s->id) }}" class="btn btn-sm btn-warning rounded-pill px-3 fw-bold text-dark d-inline-flex align-items-center gap-1" style="background-color: #ffcc00; border: none; font-size: 0.8rem;">
                                        <i class="bi bi-list-check fs-6"></i> Syarat
                                    </a>

                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $s->id }}" style="font-size: 0.8rem; border-color: #003366; color: #003366;">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <form action="{{ route('admin.jenis_surat.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus jenis surat ini? Semua syarat terkait juga akan terhapus.')" class="m-0 d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                                            <i class="bi bi-trash3-fill"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @if($surat->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center p-5 text-muted bg-white">
                                <i class="bi bi-file-earmark-text text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                                <h6 class="fw-bold text-secondary mb-1">Belum Ada Kategori Surat</h6>
                                <p class="small text-muted mb-0">Silakan klik tombol "Tambah Jenis Surat" di kanan atas untuk mengisi data baru.</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($surat as $s)
<div class="modal fade" id="modalEdit{{ $s->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.jenis_surat.update', $s->id) }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Ubah Kategori Surat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Kode Surat (Singkatan)</label>
                    <input type="text" name="kode_surat" class="form-control rounded-3 p-2.5" value="{{ $s->kode_surat }}" required maxlength="10" style="text-transform: uppercase;">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Nama Kategori Surat</label>
                    <input type="text" name="nama_surat" class="form-control rounded-3 p-2.5" value="{{ $s->nama_surat }}" required>
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Keterangan / Deskripsi (Opsional)</label>
                    <textarea name="keterangan" class="form-control rounded-3 p-2.5" rows="3">{{ $s->keterangan }}</textarea>
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

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.jenis_surat.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Kategori Surat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Kode Surat (Singkatan)</label>
                    <input type="text" name="kode_surat" class="form-control rounded-3 p-2.5" placeholder="Contoh: SKD" required maxlength="10" style="text-transform: uppercase;">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Nama Kategori Surat</label>
                    <input type="text" name="nama_surat" class="form-control rounded-3 p-2.5" placeholder="Contoh: Surat Keterangan Domisili" required>
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Keterangan / Deskripsi (Opsional)</label>
                    <textarea name="keterangan" class="form-control rounded-3 p-2.5" rows="3" placeholder="Penjelasan singkat mengenai fungsi atau peruntukan surat ini..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-top-0 bg-light rounded-bottom-4 py-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 btn-sm fw-medium" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn text-white rounded-pill px-4 btn-sm fw-bold shadow-sm" style="background-color: #003366; border: none;">Simpan Layanan</button>
            </div>
        </form>
    </div>
</div>

<style>
    .table tbody tr { transition: background-color 0.2s; }
    .table tbody tr:hover { background-color: rgba(0, 51, 102, 0.01) !important; }
</style>
@endsection
