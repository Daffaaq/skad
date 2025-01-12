@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Kelas Siswa</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Kelas untuk Siswa</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Edit Kelas Siswa</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa-kelas.update', $siswatokelas->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Untuk update -->

                        <div class="form-group">
                            <label for="siswa_id">Siswa</label>
                            <select class="form-control" @if ($readonlySiswa) readonly @endif>
                                <option value="{{ $siswatokelas->siswa_id }}" selected>
                                    {{ $siswatokelas->siswa->nama_siswa }}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="kelas_id">Pilih Kelas <span class="text-danger">*</span></label>
                            <select class="form-control @error('kelas_id') is-invalid @enderror" id="kelas_id"
                                name="kelas_id">
                                <option value="" disabled selected>Pilih Kelas</option>
                                @foreach ($tingkat as $t)
                                    <optgroup label="{{ $t->nama_tingkat }}">
                                        @foreach ($t->kelas as $k)
                                            <option value="{{ $k->id }}"
                                                @if ($siswatokelas->kelas_id == $k->id) selected @endif>
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
                            <button class="btn btn-primary">Update</button>
                            <a class="btn btn-secondary" href="{{ route('siswa-kelas.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
