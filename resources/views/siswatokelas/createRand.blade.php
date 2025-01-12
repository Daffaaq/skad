@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Form Acak Siswa ke Kelas</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Siswa Kelas</a></div>
                <div class="breadcrumb-item">Acak Siswa</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Acak Data Siswa ke Kelas</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Form Acak Siswa ke Kelas</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa-kelas.autoAssign') }}" method="POST">
                        @csrf
                        <!-- Multi-Select untuk Siswa -->
                        <div class="form-group">
                            <label for="siswa[]">Pilih Siswa <span class="text-danger">*</span></label>
                            <select name="siswa[]" class="form-control select2" multiple>
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option>
                                @endforeach
                            </select>
                            @error('siswa')
                                {{ $message }}
                            @enderror
                        </div>

                        <!-- Single-Select untuk Tingkat -->
                        <div class="form-group">
                            <label for="tingkat">Pilih Tingkat</label>
                            <select name="tingkat_id" id="tingkat" class="form-control">
                                <option value="">Pilih Tingkat</option>
                                @foreach ($tingkat as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_tingkat }}</option>
                                @endforeach
                            </select>
                            @error('tingkat_id')
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
