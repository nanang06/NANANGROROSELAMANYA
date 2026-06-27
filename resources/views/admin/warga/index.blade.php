@extends('layouts.admin')

@section('content')
<div class="container-fluid px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #003366;">Manajemen Data Warga</h4>
            <p class="text-muted small mb-0">Berikut adalah daftar seluruh masyarakat Kelurahan Pesanggrahan yang memiliki akun di sistem SIP PESANGGRAHAN.</p>
        </div>
    </div>

    {{-- Alert Error jika transaksi database gagal --}}
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 900px;">
                    <thead class="text-white" style="background-color: #003366;">
                        <tr>
                            <th class="ps-4 py-3" style="width: 180px;">NIK</th>
                            <th class="py-3">Nama Lengkap</th>
                            <th class="py-3" style="width: 130px;">RT / RW</th>
                            <th class="py-3">Alamat Domisili</th>
                            <th class="py-3 text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarWarga as $w)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary style-code" style="font-size: 0.9rem;">
                                    {{ $w->nik }}
                                </td>

                                <td>
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">{{ $w->nama_lengkap }}</h6>
                                    <small class="text-muted" style="font-size: 0.8rem;">
                                        {{ $w->jenis_kelamin == '-' ? 'Belum isi profil' : $w->jenis_kelamin }}
                                    </small>
                                </td>

                                <td class="small text-dark">
                                    <span class="d-block fw-semibold">RT {{ $w->rt }} / RW {{ $w->rw }}</span>
                                    <small class="text-muted">{{ $w->kewarganegaraan }}</small>
                                </td>

                                <td class="text-secondary small" style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $w->alamat_lengkap ?? '-' }}
                                </td>

                                <td class="text-center pe-4">
                                    <form action="{{ route('admin.warga.destroy', $w->nik) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini? Menghapus biodata juga akan menghapus akun login yang bersangkutan secara permanen.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                                            <i class="bi bi-trash3-fill"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-5 text-muted bg-white rounded-bottom-4">
                                    <i class="bi bi-people text-muted mb-3 d-block" style="font-size: 3.5rem;"></i>
                                    <h6 class="fw-bold text-secondary mb-1">Belum Ada Warga Terdaftar</h6>
                                    <p class="small text-muted mb-0">Sistem belum mendeteksi adanya data masyarakat di dalam database.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table tbody tr {
        transition: background-color 0.2s;
    }
    .table tbody tr:hover {
        background-color: rgba(0, 51, 102, 0.01) !important;
    }
    .style-code {
        font-family: monospace;
    }
</style>
@endsection
