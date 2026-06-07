@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Manajemen Berita Kelurahan</h4>
            <p class="text-muted small mb-0">Kelola publikasi berita, artikel kegiatan, dan informasi penting untuk warga Cipulir.</p>
        </div>
        <button class="btn text-dark fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalBerita" style="background-color: #ffcc00; border: none;">
            <i class="bi bi-plus-lg me-1"></i> Tulis Berita
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert" style="background-color: #e6f7ed; color: #198754;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @foreach($berita as $b)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 d-flex flex-column justify-content-between overflow-hidden transition-card">
                <div>
                    <div class="position-relative bg-light border-bottom d-flex align-items-center justify-content-center overflow-hidden" style="height: 200px;">
                        @if($b->gambar)
                            <img src="{{ asset('storage/' . $b->gambar) }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-image text-secondary mb-2" style="font-size: 3rem;"></i>
                                <span class="d-block small">Tidak ada gambar</span>
                            </div>
                        @endif
                        <span class="position-absolute bottom-0 start-0 m-3 badge bg-dark bg-opacity-75 rounded-pill px-3 py-2 small">
                            {{ $b->created_at->format('d/m/Y') }}
                        </span>
                    </div>

                    <div class="p-4">
                        <h5 class="fw-bold text-dark mb-2 text-line-clamp-2" style="font-size: 1.1rem; line-height: 1.4;">
                            {{ $b->judul }}
                        </h5>
                        <p class="text-secondary small mb-0 text-line-clamp-3">
                            {{ Str::limit(strip_tags($b->konten), 100) }}
                        </p>
                    </div>
                </div>

                <div class="p-4 pt-0 border-top-0">
                    <hr class="opacity-10 mt-0 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted"><i class="bi bi-person me-1"></i>Admin</small>

                        <div class="d-flex gap-2 w-100 justify-content-end">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditBerita{{ $b->id }}" style="font-size: 0.8rem; border-color: #003366; color: #003366;">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>

                            <form action="{{ route('admin.berita.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Hapus berita?')" class="m-0 d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                                    <i class="bi bi-trash3-fill"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @if($berita->isEmpty())
        <div class="col-12 text-center p-5 text-muted bg-white rounded-4 shadow-sm">
            <i class="bi bi-newspaper text-muted mb-3 d-block" style="font-size: 3.5rem;"></i>
            <h6 class="fw-bold text-secondary mb-1">Belum Ada Berita yang Diterbitkan</h6>
            <p class="small text-muted mb-0">Klik tombol "Tulis Berita" di kanan atas untuk membagikan info kegiatan kelurahan.</p>
        </div>
        @endif
    </div>
</div>

@foreach($berita as $b)
<div class="modal fade" id="modalEditBerita{{ $b->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.berita.update', $b->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Ubah Data Berita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Judul Berita</label>
                    <input type="text" name="judul" class="form-control rounded-3 p-2.5" value="{{ $b->judul }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Ganti Gambar Cover (Opsional)</label>
                    <input type="file" name="gambar" class="form-control rounded-3" accept="image/*">
                    <small class="text-muted small mt-1 d-block">Biarkan kosong jika tidak ingin mengubah gambar utama saat ini.</small>
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Isi Berita</label>
                    <textarea name="konten" class="form-control rounded-3 p-2.5" rows="8" required>{{ $b->konten }}</textarea>
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

<div class="modal fade" id="modalBerita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header text-white rounded-top-4 py-3" style="background-color: #003366;">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Buat Berita Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Judul Berita</label>
                    <input type="text" name="judul" class="form-control rounded-3 p-2.5" placeholder="Masukkan judul pengumuman/berita..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Gambar Cover</label>
                    <input type="file" name="gambar" class="form-control rounded-3" accept="image/*" required>
                    <small class="text-muted small mt-1 d-block">Unggah berkas foto berformat JPG, JPEG, atau PNG.</small>
                </div>
                <div class="mb-0">
                    <label class="form-label small fw-semibold text-secondary">Isi Berita</label>
                    <textarea name="konten" class="form-control rounded-3 p-2.5" rows="8" placeholder="Tuliskan detail informasi berita secara lengkap..." required></textarea>
                </div>
            </div>
            <div class="modal-footer border-top-0 bg-light rounded-bottom-4 py-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 btn-sm fw-medium" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn text-white rounded-pill px-4 btn-sm fw-bold shadow-sm" style="background-color: #003366; border: none;">Terbitkan</button>
            </div>
        </form>
    </div>
</div>

<style>
    .text-line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .text-line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .transition-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .transition-card:hover { transform: translateY(-4px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
</style>
@endsection
