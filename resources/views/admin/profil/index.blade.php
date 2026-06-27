@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Edit Profil Kelurahan</h4>
            <p class="text-muted small mb-0">Perbarui narasi sejarah, visi misi, dan informasi publik Kelurahan Pesanggrahan melalui text editor resmi.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert" style="background-color: #e6f7ed; color: #198754;">
            <i class="bi bi-check-circle-fill me-2"></i> <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.profil.update') }}" method="POST">
        @csrf
        <div class="row g-4">

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4">
                    <h5 class="fw-bold mb-3" style="color: #003366;">
                        <i class="bi bi-info-circle-fill text-warning me-2"></i>Tentang Kelurahan (Sejarah)
                    </h5>
                    <hr class="opacity-10 mb-3">
                    <div class="mb-0">
                        <textarea name="sejarah" id="editor1">{{ $sejarah->value ?? '' }}</textarea>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                    <h5 class="fw-bold mb-3" style="color: #003366;">
                        <i class="bi bi-flag-fill text-warning me-2"></i>Visi & Misi Instansi
                    </h5>
                    <hr class="opacity-10 mb-3">
                    <div class="mb-0">
                        <textarea name="visi_misi" id="editor2">{{ $visi_misi->value ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center text-white sticky-top" style="background-color: #003366; top: 20px; z-index: 10;">
                    <i class="bi bi-cloud-check text-warning mb-2 d-block" style="font-size: 2.5rem;"></i>
                    <h6 class="fw-bold mb-1 text-white">Konfirmasi Perubahan</h6>
                    <p class="small opacity-75 mb-4" style="line-height: 1.5;">Pastikan seluruh format teks sejarah serta poin visi misi yang Anda ubah di editor sudah tertata rapi sebelum dipublikasikan.</p>

                    <button type="submit" class="btn fw-bold w-100 rounded-pill py-2.5 shadow-sm text-dark transition-button" style="background-color: #ffcc00; border: none;">
                        <i class="bi bi-save-fill me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    // Inisialisasi CKEditor 4 agar textarea otomatis berubah menjadi rich text editor
    CKEDITOR.replace('editor1', {
        height: 250,
        removeButtons: 'About'
    });
    CKEDITOR.replace('editor2', {
        height: 250,
        removeButtons: 'About'
    });
</script>

<style>
    /* Efek hover lembut pada tombol simpan utama */
    .transition-button { transition: background-color 0.2s ease, transform 0.1s ease; }
    .transition-button:hover { background-color: #e6b800 !important; transform: scale(1.02); }
</style>
@endsection
