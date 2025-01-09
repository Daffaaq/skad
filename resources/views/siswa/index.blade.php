@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Student List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Student Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Student List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary" href="{{ route('siswa.create') }}">Create New Student</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Student</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('siswa.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="nama_siswa">Nama Siswa</label>
                                            <input type="text" name="nama_guru" class="form-control" id="nama_siswa" placeholder="Nama Siswa">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('siswa.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Siswa</th>
                                            <th>Status</th>
                                            <th>NIS</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($siswa as $key => $item)
                                            <tr>
                                                <td>{{ ($siswa->currentPage() - 1) * $siswa->perPage() + $key + 1 }}</td>
                                                <td>{{ $item->nama_siswa }}</td>
                                                <td>{{ $item->status_aktif_siswa }}</td>
                                                <td>{{ $item->nis ?? '-' }}</td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('siswa.edit', $item->id) }}" class="btn btn-sm btn-info btn-icon mr-2"><i class="fas fa-edit"></i> Edit</a>
                                                        <a href="{{ route('siswa.show', $item->id) }}" class="btn btn-sm btn-warning btn-icon"><i class="fas fa-eye"></i> Show</a>
                                                        <form action="{{ route('siswa.destroy', $item->id) }}" method="POST" class="ml-2">
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
                                                <td colspan="5" class="text-center">No data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{ $siswa->withQueryString()->links() }}
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
