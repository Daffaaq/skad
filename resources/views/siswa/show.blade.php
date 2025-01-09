@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Siswa: {{ $siswa->nama_siswa }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Siswa</a></div>
                <div class="breadcrumb-item">Detail Siswa</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Informasi Lengkap Siswa</h2>
            <p class="section-lead">Berikut adalah data lengkap dari siswa.</p>
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <!-- Detail Siswa -->
            <div class="card">
                <div class="card-header position-relative">
                    <h4><i class="fas fa-user"></i> Data Siswa</h4>
                    <div class="foto-siswa">
                        @if ($siswa->foto_siswa)
                            <img src="{{ asset('storage/' . $siswa->foto_siswa) }}" alt="Foto Siswa" class="img-thumbnail">
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
                                <span>{{ $siswa->nama_siswa }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Nama Panggilan:</strong>
                                <span>{{ $siswa->nama_panggilan_siswa }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>NIS:</strong>
                                <span>{{ $siswa->nis ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>NISN:</strong>
                                <span>{{ $siswa->nisn ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Jenis Kelamin:</strong>
                                <span>{{ $siswa->jenis_kelamin_siswa }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>No HP:</strong>
                                <span>{{ $siswa->no_hp_siswa }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Email:</strong>
                                <span>{{ $siswa->email_siswa }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Alamat:</strong>
                                <span>{{ $siswa->alamat_siswa }}</span>
                            </div>
                             <div class="d-flex flex-column mt-3">
                                <strong>Tanggal Kelulusan:</strong>
                                <span>{{ $siswa->tanggal_kelulusan ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-lg-6 col-md-12 mb-3">
                            <div class="d-flex flex-column mt-3">
                                <strong>Agama:</strong>
                                <span>{{ $siswa->agama_siswa }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Tanggal Lahir:</strong>
                                <span>{{ $siswa->tanggal_lahir_siswa ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Tahun Masuk:</strong>
                                <span>{{ $siswa->tahun_masuk }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Nama Ayah:</strong>
                                <span>{{ $siswa->nama_ayah_siswa ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>No HP Ayah:</strong>
                                <span>{{ $siswa->no_hp_ayah_siswa ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Pekerjaan Ayah:</strong>
                                <span>{{ $siswa->pekerjaan_ayah_siswa ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Nama Ibu:</strong>
                                <span>{{ $siswa->nama_ibu_siswa ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>No HP Ibu:</strong>
                                <span>{{ $siswa->no_hp_ibu_siswa ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Pekerjaan Ibu:</strong>
                                <span>{{ $siswa->pekerjaan_ibu_siswa ?? '-' }}</span>
                            </div>
                            <div class="d-flex flex-column mt-3">
                                <strong>Status Aktif:</strong>
                                <span class="badge badge-{{ $siswa->status_aktif_siswa == 'Aktif' ? 'success' : 'danger' }}">
                                    {{ ucfirst($siswa->status_aktif_siswa) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('customStyle')
    <style>
        .foto-siswa {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 90px; /* Ukuran pas foto */
            height: 120px;
        }

        .foto-siswa img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
    </style>
@endpush
