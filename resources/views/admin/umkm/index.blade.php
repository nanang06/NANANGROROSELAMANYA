@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Manajemen UMKM Kelurahan</h4>
            <p class="text-muted small mb-0">Daftar produk, pelaku usaha kreatif, dan toko lokal warga Kelurahan Cipulir.</p>
        </div>
        <button class="btn text-dark fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUmkm" style="background-color: #ffcc00; border: none;">
            <i class="bi bi-plus-lg me-1"></i> Daftarkan UMKM
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
                            <th class="py-3">Nama Usaha / Pemilik</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3">Kontak & Alamat</th>
                            <th class="py-3 text-center" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($umkm as $u)
                        <tr>
                            <td class="ps-4">
                                <div class="rounded border shadow-sm bg-white overflow-hidden" style="width: 60px; height: 60px;">
                                    @if($u->foto)
                                        <img src="{{ asset('storage/' . $u->foto) }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                            <i class="bi bi-shop fs-4"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <span class="fw-bold text-dark d-block" style="font-size: 0.95rem;">{{ $u->nama_usaha }}</span>
                                <small class="text-muted"><i class="bi bi-person me-1"></i>{{ $u->pemilik }}</small>
                            </td>

                            <td>
                                <span class="badge rounded-pill px-3 py-2 bg-light text-primary border fw-bold">
                                    {{ $u->kategori }}
                                </span>
                            </td>

                            <td class="small text-secondary">
                                <span class="d-block text-dark fw-medium"><i class="bi bi-whatsapp text-success me-1"></i>{{ $u->kontak ?? '-' }}</span>
                                <span class="text-truncate d-inline-block" style="max-width: 250px;">{{ $u->alamat ?? '-' }}</span>
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditUmkm{{ $u->id }}" style="font-size: 0.8rem; border-color: #003366; color: #003366;">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <form action="{{ route('admin.umkm.destroy', $u->id) }}" method="POST" class="m-0 d-inline" onsubmit="return confirm('Hapus UMKM ini?')">
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
                                <i class="bi bi-shop text-muted mb-3 d-block" style="font-size: 3.5rem;"></i>
                                <h6 class="fw-bold text-secondary mb-1">Belum Ada Daftar UMKM</h6>
                                <p class="small text-muted mb-0">Silakan klik tombol "Daftarkan UMKM" untuk menambah unit usaha warga.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($umkm as $u)
<div class="modal fade" id="modalEditUmkm{{ $u->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.umkm.update', $u->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Ubah Data Usaha</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Tempat Usaha</label>
                        <input type="text" name="nama_usaha" class="form-control rounded-3 p-2.5" value="{{ $u->nama_usaha }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Pemilik Usaha</label>
                        <input type="text" name="pemilik" class="form-control rounded-3 p-2.5" value="{{ $u->pemilik }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Kategori Bisnis</label>
                        <select name="kategori" class="form-select rounded-3 p-2.5" required>
                            <option value="Kuliner" {{ $u->kategori == 'Kuliner' ? 'selected' : '' }}>Kuliner (Makanan/Minuman)</option>
                            <option value="Kerajinan" {{ $u->kategori == 'Kerajinan' ? 'selected' : '' }}>Kerajinan Tangan</option>
                            <option value="Fashion" {{ $u->kategori == 'Fashion' ? 'selected' : '' }}>Fashion & Pakaian</option>
                            <option value="Jasa" {{ $u->kategori == 'Jasa' ? 'selected' : '' }}>Pelayanan Jasa</option>
                            <option value="Toko Kelontong" {{ $u->kategori == 'Toko Kelontong' ? 'selected' : '' }}>Toko Kelontong / Sembako</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">No. HP / WhatsApp Usaha</label>
                        <input type="text" name="kontak" class="form-control rounded-3 p-2.5" value="{{ $u->kontak }}" placeholder="Contoh: 0812XXXXXXXX">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Ganti Foto Sampul / Menu Produk</label>
                    <input type="file" name="foto" class="form-control rounded-3" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Alamat Lokasi Usaha</label>
                    <input type="text" name="alamat" class="form-control rounded-3 p-2.5" value="{{ $u->alamat }}">
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Deskripsi Singkat Usaha / Produk Andalan</label>
                    <textarea name="deskripsi" class="form-control rounded-3 p-2.5" rows="4" required>{{ $u->deskripsi }}</textarea>
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

<div class="modal fade" id="modalTambahUmkm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.umkm.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-shop me-2"></i>Daftarkan Unit Usaha Warga</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Tempat Usaha</label>
                        <input type="text" name="nama_usaha" class="form-control rounded-3 p-2.5" placeholder="Contoh: Warung Soto Betawi Mak Nyus" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Pemilik Usaha</label>
                        <input type="text" name="pemilik" class="form-control rounded-3 p-2.5" placeholder="Contoh: Bapak Joko Widodo" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Kategori Bisnis</label>
                        <select name="kategori" class="form-select rounded-3 p-2.5" required>
                            <option value="Kuliner">Kuliner (Makanan/Minuman)</option>
                            <option value="Kerajinan">Kerajinan Tangan</option>
                            <option value="Fashion">Fashion & Pakaian</option>
                            <option value="Jasa">Pelayanan Jasa</option>
                            <option value="Toko Kelontong">Toko Kelontong / Sembako</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">No. HP / WhatsApp Usaha</label>
                        <input type="text" name="kontak" class="form-control rounded-3 p-2.5" placeholder="Contoh: 0812XXXXXXXX">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Foto Sampul / Menu Produk</label>
                    <input type="file" name="foto" class="form-control rounded-3" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Alamat Lokasi Usaha</label>
                    <input type="text" name="alamat" class="form-control rounded-3 p-2.5" placeholder="Contoh: Jl. Panjang No. 12, RT 02/03">
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Deskripsi Singkat Usaha / Produk Andalan</label>
                    <textarea name="deskripsi" class="form-control rounded-3 p-2.5" rows="4" placeholder="Tuliskan jenis produk yang dijual, keunggulan, atau jam buka toko..." required></textarea>
                </div>
            </div>
            <div class="modal-footer border-top-0 bg-light rounded-bottom-4 py-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 btn-sm fw-medium" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn text-white rounded-pill px-4 btn-sm fw-bold shadow-sm" style="background-color: #003366; border: none;">Daftarkan Usaha</button>
            </div>
        </form>
    </div>
</div>

<style>
    .table tbody tr { transition: background-color 0.2s; }
    .table tbody tr:hover { background-color: rgba(0, 51, 102, 0.01) !important; }
</style>
@endsection
