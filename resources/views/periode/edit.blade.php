@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Edit Periode</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Periode</a></div>
                <div class="breadcrumb-item">Edit Periode</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Data Periode</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Edit Data Periode</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('periode.update', $periode->id) }}" method="post">
                        @csrf
                        @method('PUT') <!-- Menandakan bahwa ini adalah permintaan PUT untuk update data -->
                        
                        <div class="form-group">
                            <label for="nama_periode">Nama Periode</label>
                            <input type="text" class="form-control @error('nama_periode') is-invalid @enderror" id="nama_periode"
                                name="nama_periode" placeholder="Masukkan Nama Periode" value="{{ old('nama_periode', $periode->nama_periode) }}">
                            @error('nama_periode')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status_periode">Status Periode</label>
                            <select class="form-control @error('status_periode') is-invalid @enderror" id="status_periode" name="status_periode">
                                <option value="aktif" {{ old('status_periode', $periode->status_periode) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonAktif" {{ old('status_periode', $periode->status_periode) == 'nonAktif' ? 'selected' : '' }}>Non Aktif</option>
                            </select>
                            @error('status_periode')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="periode_kepala_sekolah">Kepala Sekolah</label>
                            <input type="text" class="form-control @error('periode_kepala_sekolah') is-invalid @enderror" id="periode_kepala_sekolah"
                                name="periode_kepala_sekolah" placeholder="Masukkan Nama Kepala Sekolah" value="{{ old('periode_kepala_sekolah', $periode->periode_kepala_sekolah) }}">
                            @error('periode_kepala_sekolah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="periode_nip">NIP Kepala Sekolah</label>
                            <input type="text" class="form-control @error('periode_nip') is-invalid @enderror" id="periode_nip"
                                name="periode_nip" placeholder="Masukkan NIP Kepala Sekolah" value="{{ old('periode_nip', $periode->periode_nip) }}">
                            @error('periode_nip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Update</button>
                    <a class="btn btn-secondary" href="{{ route('periode.index') }}">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
