@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Guru: {{ $guru->nama_guru }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Guru</a></div>
                <div class="breadcrumb-item">Detail Guru</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Informasi Lengkap Guru</h2>
            <p class="section-lead">Berikut adalah data lengkap dari guru.</p>
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <!-- Detail Guru -->
            <div class="card">
                <div class="card-header position-relative">
                    <h4><i class="fas fa-user-tie"></i> Data Guru</h4>
                    <div class="foto-guru">
                        @if ($guru->foto_guru)
                            <img src="{{ asset('storage/' . $guru->foto_guru) }}" alt="Foto Guru" class="img-thumbnail">
                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <!-- Kolom Kiri -->
                        <div class="col-lg-6 col-md-12 mb-3">
                            <div class="d-flex flex-column">
                                <strong>Nama Lengkap:</strong>
                                <span>{{ $guru->nama_guru }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Nama Pendek:</strong>
                                <span>{{ $guru->nama_pendek_guru }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>NIP:</strong>
                                <span>{{ $guru->nip ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Jenis Kelamin:</strong>
                                <span>{{ $guru->jenis_kelamin_guru }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Status Guru:</strong>
                                <span>{{ $guru->status_guru }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Status Perkawinan:</strong>
                                <span>{{ $guru->status_perkawinan_guru }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Jabatan:</strong>
                                <span>{{ $guru->jabatan_guru ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column">
                                <strong>No HP:</strong>
                                <span>{{ $guru->no_hp_guru }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Email:</strong>
                                <span>{{ $guru->email_guru }}</span>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-lg-6 col-md-12 mb-3">
                            <div class="d-flex flex-column mt-3">
                                <strong>Alamat:</strong>
                                <span>{{ $guru->alamat_guru }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Tanggal Lahir:</strong>
                                <span>{{ $guru->tanggal_lahir_guru ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Tanggal Bergabung:</strong>
                                <span>{{ $guru->tanggal_bergabung ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Agama:</strong>
                                <span>{{ $guru->agama_guru }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Pendidikan Terakhir:</strong>
                                <span>{{ $guru->pendidikan_terakhir ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Kode Guru:</strong>
                                <span>{{ $guru->kode_guru ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Nomor SK:</strong>
                                <span>{{ $guru->nomor_sk ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Status Aktif:</strong>
                                <span class="badge badge-{{ $guru->status_aktif_guru == 'Aktif' ? 'success' : 'danger' }}">
                                    {{ ucfirst($guru->status_aktif_guru) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('guru.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
@endpush
@push('customStyle')
    <style>
        .foto-guru {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 90px; /* Menyesuaikan ukuran pas foto 3x4 */
            height: 120px;
        }

        .foto-guru img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Pastikan foto pas di dalam */
            border: 2px solid #ddd;
            border-radius: 5px; /* Opsional untuk estetika */
        }
    </style>
@endpush

