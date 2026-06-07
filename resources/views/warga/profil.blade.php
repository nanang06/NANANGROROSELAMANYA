@extends('layouts.warga')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Kelengkapan Biodata</h4>
            <p class="text-muted small mb-0">Pastikan informasi di bawah ini sesuai dengan KTP atau Kartu Keluarga Anda.</p>
        </div>
        <span class="badge {{ $isLengkap ? 'bg-success' : 'bg-danger' }} p-2 rounded-pill px-3 shadow-sm">
            <i class="bi {{ $isLengkap ? 'bi-shield-fill-check' : 'bi-shield-fill-exclamation' }} me-1"></i>
            {{ $isLengkap ? 'Profil Lengkap' : 'Belum Lengkap' }}
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-warning border-0 shadow-sm rounded-4 p-3 mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('warga.profil.update') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control rounded-3" value="{{ $warga->nama_lengkap ?? Auth::user()->name }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control rounded-3" value="{{ $warga->tempat_lahir ?? '' }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control rounded-3" value="{{ $warga->tanggal_lahir ?? '' }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select rounded-3" required>
                            <option value="Laki-laki" {{ ($warga->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ ($warga->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Agama</label>
                        <input type="text" name="agama" class="form-control rounded-3" value="{{ $warga->agama ?? '' }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-semibold text-secondary">RT</label>
                        <input type="text" name="rt" class="form-control rounded-3" value="{{ $warga->rt ?? '' }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-semibold text-secondary">RW</label>
                        <input type="text" name="rw" class="form-control rounded-3" value="{{ $warga->rw ?? '' }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Kewarganegaraan</label>
                        <select name="kewarganegaraan" class="form-select rounded-3" required>
                            <option value="WNI" {{ ($warga->kewarganegaraan ?? '') == 'WNI' ? 'selected' : '' }}>WNI</option>
                            <option value="WNA" {{ ($warga->kewarganegaraan ?? '') == 'WNA' ? 'selected' : '' }}>WNA</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label small fw-semibold text-secondary">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control rounded-3" value="{{ $warga->pekerjaan ?? '' }}" placeholder="Contoh: Karyawan Swasta">
                    </div>

                    <div class="col-md-12 mb-4">
                        <label class="form-label small fw-semibold text-secondary">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" class="form-control rounded-3" rows="3" required>{{ $warga->alamat_lengkap ?? '' }}</textarea>
                    </div>
                </div>
                <div class="border-top pt-3 text-end">
                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-semibold shadow-sm" style="background-color: #003366; border: none;">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
