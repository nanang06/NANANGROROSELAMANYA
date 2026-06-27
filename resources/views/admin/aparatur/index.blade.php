@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Manajemen Aparatur Kelurahan</h4>
            <p class="text-muted small mb-0">Kelola susunan pejabat dan staf struktur organisasi pelayanan Kelurahan Pesanggrahan.</p>
        </div>
        <button class="btn text-dark fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahModal" style="background-color: #ffcc00; border: none;">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Aparatur
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
            <div class="d-flex align-items-start">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>
                    <strong>Gagal Menyimpan Data:</strong>
                    <ul class="mb-0 mt-1 small ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-white" style="background-color: #003366;">
                        <tr>
                            <th class="ps-4 py-3 text-center" style="width: 80px;">Urutan</th>
                            <th class="py-3" style="width: 100px;">Foto</th>
                            <th class="py-3">Nama Lengkap</th>
                            <th class="py-3">Jabatan Resmi</th>
                            <th class="py-3 text-center" style="width: 220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aparaturs as $a)
                        <tr>
                            <td class="ps-4 text-center text-secondary fw-bold" style="font-size: 0.95rem;">
                                {{ $a->urutan }}
                            </td>

                            <td>
                                <div class="rounded-circle overflow-hidden border shadow-sm bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    @if($a->foto)
                                        <img src="{{ asset('storage/' . $a->foto) }}" alt="{{ $a->nama }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <i class="bi bi-person-fill text-secondary fs-4"></i>
                                    @endif
                                </div>
                            </td>

                            <td class="fw-bold text-dark" style="font-size: 0.95rem;">
                                {{ $a->nama }}
                            </td>

                            <td>
                                <span class="badge fw-semibold px-3 py-2 rounded-pill text-dark" style="background-color: rgba(0, 51, 102, 0.08); color: #003366 !important;">
                                    {{ $a->jabatan }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditAparatur{{ $a->id }}" style="font-size: 0.8rem; border-color: #003366; color: #003366;">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <form action="{{ route('admin.aparatur.destroy', $a->id) }}" method="POST" class="m-0 d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                                <i class="bi bi-people text-muted mb-3 d-block" style="font-size: 3.5rem;"></i>
                                <h6 class="fw-bold text-secondary mb-1">Belum Ada Data Aparatur</h6>
                                <p class="small text-muted mb-0">Silakan klik tombol "Tambah Aparatur" untuk mengisi struktur organisasi.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($aparaturs as $a)
<div class="modal fade" id="modalEditAparatur{{ $a->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.aparatur.update', $a->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Ubah Data Aparatur</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Nama Lengkap & Gelar</label>
                    <input type="text" name="nama" class="form-control rounded-3 p-2.5" value="{{ $a->nama }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control rounded-3 p-2.5" value="{{ $a->jabatan }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Ganti Foto Profil <small class="text-muted">(Opsional, Max 2MB)</small></label>
                    <input type="file" name="foto" class="form-control rounded-3" accept="image/*">
                    @if($a->foto)
                        <div class="form-text text-success small mt-1"><i class="bi bi-image"></i> Sudah ada foto terunggah.</div>
                    @endif
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Nomor Urut Tampil</label>
                    <input type="number" name="urutan" class="form-control rounded-3 p-2.5" value="{{ $a->urutan }}" required min="1">
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

<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.aparatur.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold" id="tambahModalLabel"><i class="bi bi-person-plus-fill me-2"></i>Tambah Aparatur Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control rounded-3 p-2.5" required placeholder="Contoh: Budi Santoso, S.E.">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control rounded-3 p-2.5" required placeholder="Contoh: Lurah Pesanggrahan">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Foto <small class="text-muted">(Opsional, Max 2MB)</small></label>
                    <input type="file" name="foto" class="form-control rounded-3" accept="image/*">
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Nomor Urut Tampil</label>
                    <input type="number" name="urutan" class="form-control rounded-3 p-2.5" value="1" required min="1">
                    <small class="text-muted d-block mt-1">Gunakan angka 1 untuk Lurah agar tampil paling atas.</small>
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
