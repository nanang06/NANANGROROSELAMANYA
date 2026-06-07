@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Lembaga Kemasyarakatan</h4>
            <p class="text-muted small mb-0">Kelola daftar organisasi kemitraan dan lembaga masyarakat resmi di Kelurahan Cipulir.</p>
        </div>
        <button class="btn text-dark fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahLembaga" style="background-color: #ffcc00; border: none;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Lembaga
        </button>
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
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-white" style="background-color: #003366;">
                        <tr>
                            <th class="ps-4 py-3" style="width: 80px;">Logo</th>
                            <th class="py-3">Nama Lembaga (Singkatan)</th>
                            <th class="py-3">Nama Ketua</th>
                            <th class="py-3">Deskripsi/Tugas Fungsi</th>
                            <th class="py-3 text-center" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lembaga as $l)
                        <tr>
                            <td class="ps-4">
                                <div class="rounded border shadow-sm bg-white d-flex align-items-center justify-content-center overflow-hidden" style="width: 50px; height: 50px;">
                                    @if($l->logo)
                                        <img src="{{ asset('storage/' . $l->logo) }}" class="w-100 h-100" style="object-fit: contain;">
                                    @else
                                        <i class="bi bi-building text-secondary fs-4"></i>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <span class="fw-bold text-dark d-block" style="font-size: 0.95rem;">{{ $l->nama_lembaga }}</span>
                                @if($l->singkatan)
                                    <small class="badge bg-light text-primary border fw-bold text-uppercase" style="font-size: 0.75rem;">{{ $l->singkatan }}</small>
                                @endif
                            </td>

                            <td class="text-dark fw-medium small">
                                {{ $l->nama_ketua ?? '-' }}
                            </td>

                            <td class="text-secondary small text-truncate" style="max-width: 250px;">
                                {{ strip_tags($l->deskripsi) }}
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditLembaga{{ $l->id }}" style="font-size: 0.8rem; border-color: #003366; color: #003366;">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <form action="{{ route('admin.lembaga.destroy', $l->id) }}" method="POST" class="m-0 d-inline" onsubmit="return confirm('Hapus lembaga ini?')">
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
                            <td colspan="5" class="text-center p-5 text-muted bg-white">
                                <i class="bi bi-building text-muted mb-3 d-block" style="font-size: 3.5rem;"></i>
                                <h6 class="fw-bold text-secondary mb-1">Belum Ada Data Lembaga</h6>
                                <p class="small text-muted mb-0">Silakan klik tombol "Tambah Lembaga" untuk mengisi data.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($lembaga as $l)
<div class="modal fade" id="modalEditLembaga{{ $l->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.lembaga.update', $l->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Ubah Data Lembaga</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Lengkap Lembaga</label>
                        <input type="text" name="nama_lembaga" class="form-control rounded-3 p-2.5" value="{{ $l->nama_lembaga }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Singkatan/Akronim</label>
                        <input type="text" name="singkatan" class="form-control rounded-3 p-2.5" value="{{ $l->singkatan }}" placeholder="Contoh: PKK">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Nama Ketua Organisasi</label>
                    <input type="text" name="nama_ketua" class="form-control rounded-3 p-2.5" value="{{ $l->nama_ketua }}">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Ganti Logo / Foto Kegiatan</label>
                    <input type="file" name="logo" class="form-control rounded-3" accept="image/*">
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Deskripsi & Pokok Tugas Fungsi</label>
                    <textarea name="deskripsi" class="form-control rounded-3 p-2.5" rows="5" required>{{ $l->deskripsi }}</textarea>
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

<div class="modal fade" id="modalTambahLembaga" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.lembaga.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Daftarkan Lembaga Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Lengkap Lembaga</label>
                        <input type="text" name="nama_lembaga" class="form-control rounded-3 p-2.5" placeholder="Contoh: Pemberdayaan Kesejahteraan Keluarga" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Singkatan/Akronim</label>
                        <input type="text" name="singkatan" class="form-control rounded-3 p-2.5" placeholder="Contoh: PKK">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Nama Ketua Organisasi</label>
                    <input type="text" name="nama_ketua" class="form-control rounded-3 p-2.5" placeholder="Contoh: Ibu Siti Aminah">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Logo / Lambang Resmi</label>
                    <input type="file" name="logo" class="form-control rounded-3" accept="image/*">
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Deskripsi & Pokok Tugas Fungsi</label>
                    <textarea name="deskripsi" class="form-control rounded-3 p-2.5" rows="5" placeholder="Tuliskan peran, visi, atau deskripsi ringkas mengenai lembaga ini..." required></textarea>
                </div>
            </div>
            <div class="modal-footer border-top-0 bg-light rounded-bottom-4 py-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 btn-sm fw-medium" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn text-white rounded-pill px-4 btn-sm fw-bold shadow-sm" style="background-color: #003366; border: none;">Simpan Lembaga</button>
            </div>
        </form>
    </div>
</div>

<style>
    .table tbody tr { transition: background-color 0.2s; }
    .table tbody tr:hover { background-color: rgba(0, 51, 102, 0.01) !important; }
</style>
@endsection
