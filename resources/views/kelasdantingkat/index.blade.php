@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Tingkat List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tingkat Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Tingkat List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('tingkat-kelas.create') }}">Create New Tingkat</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Tingkat</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('tingkat-kelas.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="nama_tingkat">Nama Tingkat</label>
                                            <input type="text" name="nama_tingkat" class="form-control" id="nama_tingkat" placeholder="Nama Tingkat" value="{{ request('nama_tingkat') }}">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('tingkat-kelas.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Tingkat</th>
                                            <th>Kelas</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($matapelajaran as $key => $tingkat)
                                            <tr>
                                                <td>{{ ($matapelajaran->currentPage() - 1) * $matapelajaran->perPage() + $key + 1 }}</td>
                                                <td>{{ $tingkat->nama_tingkat }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-start">
                                                        {{-- Cek jika venue memiliki klub dan jadwal --}}
                                                        @if ($tingkat->tingkat_count > 0 && $tingkat->kelas_count > 0)
                                                            {{-- Venue sudah memiliki jadwal dan klub, tampilkan kedua tombol --}}
                                                            <a href="{{ route('tingkat-kelas.create-kelas', $tingkat->tingkat_id) }}"
                                                                class="btn btn-sm btn-primary btn-icon">
                                                                <i class="fas fa-plus"></i> Kelas
                                                            </a>
                                                            <a href="{{ route('tingkat-kelas.show-kelas', $tingkat->tingkat_id) }}"
                                                                class="btn btn-sm btn-info btn-icon ml-2">
                                                                <i class="fas fa-eye"></i> Show
                                                            </a>
                                                        @else
                                                            {{-- Venue belum memiliki klub dan jadwal, tampilkan hanya tombol Jadwal --}}
                                                            <a href="{{ route('tingkat-kelas.create-kelas', $tingkat->tingkat_id) }}"
                                                                class="btn btn-sm btn-primary btn-icon">
                                                                <i class="fas fa-plus"></i> Kelas
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('tingkat-kelas.edit', $tingkat->tingkat_id) }}" class="btn btn-sm btn-info btn-icon"><i class="fas fa-edit"></i> Edit</a>
                                                        <form action="{{ route('tingkat-kelas.destroy', $tingkat->tingkat_id) }}" method="POST" class="ml-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No Data Available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $matapelajaran->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
    <script>
        $(document).ready(function() {
            $('.search').click(function(event) {
                event.stopPropagation();
                $(".show-search").slideToggle("fast");
            });
        });
    </script>
@endpush
