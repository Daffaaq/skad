@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Form Tambah Mata Pelajaran</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Mata Pelajaran</a></div>
                <div class="breadcrumb-item">Tambah Mata Pelajaran</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Data Mata Pelajaran</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Tambah Data Mata Pelajaran</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('mata-pelajaran.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama_matapelajaran">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control @error('nama_matapelajaran') is-invalid @enderror" id="nama_matapelajaran"
                                name="nama_matapelajaran" placeholder="Masukkan Nama Mata Pelajaran" value="{{ old('nama_matapelajaran') }}">
                            @error('nama_matapelajaran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kode_matapelajaran">Kode Mata Pelajaran</label>
                            <input type="text" class="form-control @error('kode_matapelajaran') is-invalid @enderror" id="kode_matapelajaran"
                                name="kode_matapelajaran" placeholder="Masukkan Kode Mata Pelajaran" value="{{ old('kode_matapelajaran') }}">
                            @error('kode_matapelajaran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Simpan</button>
                    <a class="btn btn-secondary" href="{{ route('mata-pelajaran.index') }}">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
