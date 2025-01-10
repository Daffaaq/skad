@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Form Tambah Siswa ke Kelas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Siswa Kelas</a></div>
                <div class="breadcrumb-item">Tambah Siswa</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Data Siswa ke Kelas</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Siswa ke Kelas</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa-kelas.store') }}" method="POST">
                        @csrf
                        <!-- Multi-Select untuk Siswa -->
                        <div class="form-group">
                            <label for="siswa_id">Pilih Siswa <span class="text-danger">*</span></label>
                            <select name="siswa_id[]" class="form-control select2" multiple>
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option>
                                @endforeach
                            </select>
                            @error('siswa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Single-Select untuk Kelas -->
                        <div class="form-group">
                            <label for="kelas_id">Pilih Kelas <span class="text-danger">*</span></label>
                            <select class="form-control @error('kelas_id') is-invalid @enderror" id="kelas_id"
                                name="kelas_id">
                                <option value="" disabled selected>Pilih Kelas</option>
                                @foreach ($tingkat as $t)
                                    <optgroup label="{{ $t->nama_tingkat }}">
                                        @foreach ($t->kelas as $k)
                                            <option value="{{ $k->id }}"
                                                {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-right mt-3">
                            <button class="btn btn-primary">Simpan</button>
                            <a class="btn btn-secondary" href="{{ route('siswa-kelas.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('customScript')
    <script src="/assets/js/select2.min.js"></script>
@endpush

@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
