@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Update Tingkat dan Kelas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Tingkat dan Kelas</a></div>
                <div class="breadcrumb-item">Update Tingkat dan Kelas</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Form Update Tingkat dan Kelas</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Update Tingkat: {{ $tingkat->nama_tingkat }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tingkat-kelas.update', $tingkat->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama Tingkat -->
                        <div class="form-group">
                            <label for="nama_tingkat">Nama Tingkat</label>
                            <input type="text" name="nama_tingkat" id="nama_tingkat"
                                class="form-control @error('nama_tingkat') is-invalid @enderror"
                                value="{{ old('nama_tingkat', $tingkat->nama_tingkat) }}" required>
                            @error('nama_tingkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Daftar Kelas -->
                        <div class="form-group">
                            <label for="nama_kelas">Nama Kelas</label>
                            @foreach ($kelas as $kelasItem)
                                <div class="mb-3">
                                    <input type="text" name="nama_kelas[{{ $kelasItem->id }}]"
                                        class="form-control @error('nama_kelas.' . $kelasItem->id) is-invalid @enderror"
                                        value="{{ old('nama_kelas.' . $kelasItem->id, $kelasItem->nama_kelas) }}"
                                        placeholder="Masukkan Nama Kelas">
                                    @error('nama_kelas.' . $kelasItem->id)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>


                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('tingkat-kelas.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
