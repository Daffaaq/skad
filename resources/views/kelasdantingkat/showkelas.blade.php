@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>List Kelas untuk Tingkat: {{ $tingkat->nama_tingkat }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Tingkat dan Kelas</a></div>
                <div class="breadcrumb-item">List Kelas</div>
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
                    <div class="text-right">
                        <a href="{{ route('tingkat-kelas.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
@endpush