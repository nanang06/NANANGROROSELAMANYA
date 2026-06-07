@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Pariwisata & Spot Ikonik</h4>
            <p class="text-muted small mb-0">Kelola informasi objek wisata, taman kota, atau destinasi publik di Kelurahan Cipulir.</p>
        </div>
        <button class="btn text-dark fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahWisata" style="background-color: #ffcc00; border: none;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Wisata
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
                            <th class="py-3">Nama Destinasi</th>
                            <th class="py-3">Lokasi / Alamat</th>
                            <th class="py-3">Jam Buka & Tiket</th>
                            <th class="py-3 text-center" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wisata as $w)
                        <tr>
                            <td class="ps-4">
                                <div class="rounded border shadow-sm bg-white overflow-hidden" style="width: 60px; height: 60px;">
                                    @if($w->foto)
                                        <img src="{{ asset('storage/' . $w->foto) }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                            <i class="bi bi-geo-alt fs-4"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <span class="fw-bold text-dark d-block" style="font-size: 0.95rem;">{{ $w->nama_wisata }}</span>
                            </td>

                            <td class="small text-secondary">
                                <span class="text-truncate d-inline-block" style="max-width: 250px;"><i class="bi bi-map me-1"></i>{{ $w->lokasi }}</span>
                            </td>

                            <td class="small text-secondary">
                                <span class="d-block text-dark fw-medium"><i class="bi bi-clock me-1 text-primary"></i>{{ $w->jam_operasional ?? '24 Jam' }}</span>
                                <span class="badge bg-light text-dark border"><i class="bi bi-ticket-perforated me-1 text-success"></i>{{ $w->harga_tiket ?? 'Gratis' }}</span>
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditWisata{{ $w->id }}" style="font-size: 0.8rem; border-color: #003366; color: #003366;">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <form action="{{ route('admin.wisata.destroy', $w->id) }}" method="POST" class="m-0 d-inline" onsubmit="return confirm('Hapus destinasi wisata ini?')">
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
                                <i class="bi bi-geo-alt text-muted mb-3 d-block" style="font-size: 3.5rem;"></i>
                                <h6 class="fw-bold text-secondary mb-1">Belum Ada Data Objek Wisata</h6>
                                <p class="small text-muted mb-0">Silakan klik tombol "Tambah Wisata" untuk mengisi data pariwisata wilayah.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($wisata as $w)
<div class="modal fade" id="modalEditWisata{{ $w->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.wisata.update', $w->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Ubah Data Objek Wisata</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Nama Objek / Spot Wisata</label>
                    <input type="text" name="nama_wisata" class="form-control rounded-3 p-2.5" value="{{ $w->nama_wisata }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Jam Operasional</label>
                        <input type="text" name="jam_operasional" class="form-control rounded-3 p-2.5" value="{{ $w->jam_operasional }}" placeholder="Contoh: 08:00 - 17:00 WIB">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Harga Tiket Masuk</label>
                        <input type="text" name="harga_tiket" class="form-control rounded-3 p-2.5" value="{{ $w->harga_tiket }}" placeholder="Contoh: Rp 5.000 / Gratis">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Ganti Foto Sampul Lokasi</label>
                    <input type="file" name="foto" class="form-control rounded-3" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Alamat / Koordinat Lokasi</label>
                    <input type="text" name="lokasi" class="form-control rounded-3 p-2.5" value="{{ $w->lokasi }}" required>
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Deskripsi & Daya Tarik Wisata</label>
                    <textarea name="deskripsi" class="form-control rounded-3 p-2.5" rows="4" required>{{ $w->deskripsi }}</textarea>
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

<div class="modal fade" id="modalTambahWisata" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.wisata.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-geo-alt me-2"></i>Daftarkan Destinasi Wisata Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Nama Objek / Spot Wisata</label>
                    <input type="text" name="nama_wisata" class="form-control rounded-3 p-2.5" placeholder="Contoh: Taman Hijau Cipulir / Kampung Main" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Jam Operasional</label>
                        <input type="text" name="jam_operasional" class="form-control rounded-3 p-2.5" placeholder="Contoh: 06:00 - 18:00 WIB">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Harga Tiket Masuk</label>
                        <input type="text" name="harga_tiket" class="form-control rounded-3 p-2.5" placeholder="Contoh: Rp 10.000 / Gratis">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Foto Sampul Lokasi</label>
                    <input type="file" name="foto" class="form-control rounded-3" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Alamat Lengkap / Lokasi Objek</label>
                    <input type="text" name="lokasi" class="form-control rounded-3 p-2.5" placeholder="Contoh: Jl. Cipulir Indah No. 4, RT 05/01" required>
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Deskripsi & Daya Tarik Wisata</label>
                    <textarea name="deskripsi" class="form-control rounded-3 p-2.5" rows="4" placeholder="Tuliskan daya tarik utama, fasilitas, sejarah ringkas spot wisata ini..." required></textarea>
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
