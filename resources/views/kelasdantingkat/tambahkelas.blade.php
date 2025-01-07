@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Kelas untuk Tingkat: {{ $tingkat->nama_tingkat }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Tingkat dan Kelas</a></div>
                <div class="breadcrumb-item">Tambah Kelas</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Daftar Kelas</h2>

            <!-- Daftar Kelas -->
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Kelas untuk Tingkat: {{ $tingkat->nama_tingkat }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kelas as $key => $kelasItem)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $kelasItem->nama_kelas }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Belum ada kelas yang terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Form Tambah Kelas -->
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Kelas Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tingkat-kelas.create-kelas-store', $tingkat->id) }}" method="POST">
                        @csrf
                        <div id="kelas-wrapper">
                            <div class="input-group mb-3">
                                <input type="text" name="nama_kelas[]" class="form-control" placeholder="Masukkan Nama Kelas">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-add-kelas" type="button">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success">Tambah Kelas</button>
                            <a href="{{ route('tingkat-kelas.index') }}" class="btn btn-secondary">Kembali</a>
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
