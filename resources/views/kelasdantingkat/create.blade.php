@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Form Tambah Tingkat dan Kelas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Tingkat dan Kelas</a></div>
                <div class="breadcrumb-item">Tambah Tingkat dan Kelas</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Data Tingkat dan Kelas</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data Tingkat dan Kelas</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tingkat-kelas.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama_tingkat">Nama Tingkat</label>
                            <input type="text" class="form-control @error('nama_tingkat') is-invalid @enderror"
                                id="nama_tingkat" name="nama_tingkat" placeholder="Masukkan Nama Tingkat"
                                value="{{ old('nama_tingkat') }}">
                            @error('nama_tingkat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama Kelas</label>
                            <div id="kelas-wrapper">
                                <div class="input-group mb-3">
                                    <input type="text" name="nama_kelas[]"
                                        class="form-control @error('nama_kelas.*') is-invalid @enderror"
                                        placeholder="Masukkan Nama Kelas">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary btn-add-kelas" type="button">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    @error('nama_kelas.*')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary">Simpan</button>
                            <a class="btn btn-secondary" href="{{ route('tingkat-kelas.index') }}">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
    <script>
        $(document).ready(function() {
            // Tambah inputan kelas
            $(document).on('click', '.btn-add-kelas', function() {
                const kelasInput = `
                    <div class="input-group mb-3">
                        <input type="text" name="nama_kelas[]" class="form-control" placeholder="Masukkan Nama Kelas">
                        <div class="input-group-append">
                            <button class="btn btn-danger btn-remove-kelas" type="button">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>`;
                $('#kelas-wrapper').append(kelasInput);
            });

            // Hapus inputan kelas
            $(document).on('click', '.btn-remove-kelas', function() {
                $(this).closest('.input-group').remove();
            });
        });
    </script>
@endpush
