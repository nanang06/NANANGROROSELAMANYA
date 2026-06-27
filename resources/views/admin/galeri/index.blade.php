@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Galeri & Dokumentasi Kegiatan</h4>
            <p class="text-muted small mb-0">Kelola dokumentasi foto resmi dari berbagai lini aktivitas dan program kerja Kelurahan Pesanggrahan.</p>
        </div>
        <button class="btn text-dark fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah" style="background-color: #ffcc00; border: none;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Foto
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
                            <th class="ps-4 py-3" style="width: 100px;">Foto</th>
                            <th class="py-3">Nama / Judul Kegiatan</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3 text-center" style="width: 220px;">Tanggal Upload</th>
                            <th class="py-3 text-center" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($galeris as $g)
                        <tr>
                            <td class="ps-4">
                                <div class="rounded border shadow-sm bg-white overflow-hidden" style="width: 70px; height: 50px;">
                                    <img src="{{ asset('storage/' . $g->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                                </div>
                            </td>

                            <td>
                                <span class="fw-bold text-dark d-block" style="font-size: 0.95rem;">{{ $g->judul }}</span>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border"><i class="bi bi-tag-fill me-1 text-primary"></i>Dokumentasi Resmi</span>
                            </td>

                            <td class="text-center text-secondary small">
                                <span class="d-block text-dark fw-medium"><i class="bi bi-calendar3 me-1 text-primary"></i>{{ $g->created_at->translatedFormat('d M Y') }}</span>
                                <span class="text-muted" style="font-size: 0.78rem;">{{ $g->created_at->format('H:i') }} WIB</span>
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $g->id }}" style="font-size: 0.8rem; border-color: #003366; color: #003366;">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST" class="m-0 d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto dokumentasi ini?')">
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
                                <i class="bi bi-images text-muted mb-3 d-block" style="font-size: 3.5rem;"></i>
                                <h6 class="fw-bold text-secondary mb-1">Belum Ada Koleksi Foto Galeri</h6>
                                <p class="small text-muted mb-0">Silakan klik tombol "Tambah Foto" di atas untuk mengisi arsip dokumentasi wilayah.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($galeris as $g)
<div class="modal fade" id="modalEdit{{ $g->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.galeri.update', $g->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Ubah Data Foto Dokumentasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Nama / Judul Kegiatan</label>
                    <input type="text" name="judul" class="form-control rounded-3 p-2.5" value="{{ $g->judul }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Ganti Foto Kegiatan (Opsional)</label>
                    <input type="file" name="gambar" class="form-control rounded-3" accept="image/*">
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary d-block mb-2">Preview Foto Saat Ini</label>
                    <div class="rounded border bg-light overflow-hidden shadow-sm" style="width: 100%; height: 200px;">
                        <img src="{{ asset('storage/' . $g->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                    </div>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-images me-2"></i>Upload Dokumentasi Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Nama / Judul Kegiatan</label>
                    <input type="text" name="judul" class="form-control rounded-3 p-2.5" placeholder="Contoh: Rapat Koordinasi TP PKK Tingkat Kelurahan" required>
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Pilih File Foto Kegiatan</label>
                    <input type="file" name="gambar" class="form-control rounded-3" accept="image/*" required>
                    <small class="form-text text-muted mt-1 d-block">Format resmi: JPG, JPEG, PNG. Maksimal ukuran file: 2MB.</small>
                </div>
            </div>
            <div class="modal-footer border-top-0 bg-light rounded-bottom-4 py-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 btn-sm fw-medium" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn text-white rounded-pill px-4 btn-sm fw-bold shadow-sm" style="background-color: #003366; border: none;">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<style>
    .table tbody tr { transition: background-color 0.2s; }
    .table tbody tr:hover { background-color: rgba(0, 51, 102, 0.01) !important; }
</style>
@endsection
