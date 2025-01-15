@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Kelas Siswa</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Kelas Siswa Management</h2>

            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Kelas Siswa List</h4>
                            <div class="card-header-action">
                                <a class="btn btn-icon icon-left btn-primary"
                                    href="{{ route('siswa-kelas.create') }}">Tambah
                                    Siswa ke Kelas</a>
                                <a class="btn btn-info btn-primary active search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search Student</a>
                                <a class="btn btn-info btn-primary active filter">
                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                    Filter</a>
                                <a href="{{ route('siswa-kelas.random') }}" class="btn btn-icon icon-left btn-primary">
                                    <i class="fas fa-random"></i> Acak Siswa
                                </a>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="show-filter mb-3" style="display:none">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="filter_by_tingkat"
                                        name="filter_by_tingkat" {{ request('filter_by_tingkat') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="filter_by_tingkat">
                                        Filter berdasarkan Tingkat
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="filter_by_tingkat_dan_kelas"
                                        name="filter_by_tingkat_dan_kelas"
                                        {{ request('filter_by_tingkat_dan_kelas') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="filter_by_tingkat_dan_kelas">
                                        Filter berdasarkan Tingkat dan Kelas
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="filter_by_periode"
                                        name="filter_by_periode" {{ request('filter_by_periode') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="filter_by_periode">
                                        Filter berdasarkan Periode
                                    </label>
                                </div>
                            </div>
                            <div class="show-filter mb-3" style="display:none">
                                <form method="GET" action="{{ route('siswa-kelas.index') }}">
                                    <div class="form-row">
                                        <!-- Filter by Tingkat -->
                                        <div class="form-group">
                                            <label for="tingkat_id">Tingkat</label>
                                            <select name="tingkat_id" id="tingkat_id" class="form-control">
                                                <option value="">Pilih Tingkat</option>
                                                @foreach ($tingkats as $tingkat)
                                                    <option value="{{ $tingkat->id }}"
                                                        {{ request('tingkat_id') == $tingkat->id ? 'selected' : '' }}>
                                                        {{ $tingkat->nama_tingkat }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filter by Kelas -->
                                        <div class="form-group col-md-6" id="kelas_field"
                                            style="{{ request('tingkat_id') ? '' : 'display:none;' }}">
                                            <label for="kelas_id">Kelas</label>
                                            <select class="form-control" id="kelas_id" name="kelas_id">
                                                <option value="" disabled selected>Pilih Kelas</option>
                                                <!-- Kelas akan diisi lewat AJAX -->
                                            </select>
                                        </div>

                                        <!-- Filter by Periode -->
                                        <!-- Form Filter by Periode -->
                                        <div class="form-group" id="periode_field">
                                            <label for="periode_id">Periode</label>
                                            <select name="periode_id" id="periode_id" class="form-control">
                                                <option value="">Pilih Periode</option>
                                                @foreach ($periodes as $periode)
                                                    <option value="{{ $periode->id }}"
                                                        {{ request('periode_id') == $periode->id ? 'selected' : '' }}>
                                                        {{ $periode->nama_periode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button class="btn btn-primary" type="submit">Filter</button>
                                        <a class="btn btn-secondary" href="{{ route('siswa-kelas.index') }}">Reset</a>
                                    </div>
                                </form>

                            </div>

                            <div class="show-search mb-3" style="display: none">
                                <form id="search" method="GET" action="{{ route('siswa-kelas.index') }}">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="nama_siswa">Nama Siswa</label>
                                            <input type="text" name="nama_siswa" class="form-control" id="nama_siswa"
                                                placeholder="Nama Siswa">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                        <a class="btn btn-secondary" href="{{ route('siswa-kelas.index') }}">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Siswa</th>
                                            <th>Tingkat</th>
                                            <th>Kelas</th>
                                            <th>Periode</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $key => $item)
                                            <tr>
                                                <td>{{ $data->firstItem() + $key }}</td>
                                                <td>{{ $item->siswa_nama }}</td> <!-- Gunakan alias 'siswa_nama' -->
                                                <td>{{ $item->tingkat_nama }}</td>
                                                <td>{{ $item->kelas_nama }}</td> <!-- Gunakan alias 'kelas_nama' -->
                                                <td>{{ $item->periode_nama }}</td> <!-- Gunakan alias 'periode_nama' -->
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ route('siswa-kelas.edit', $item->id) }}"
                                                            class="btn btn-sm btn-info btn-icon mr-2"><i
                                                                class="fas fa-edit"></i> Edit</a>
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
                                    {{ $data->links() }}
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
        document.getElementById('tingkat_id').addEventListener('change', function() {
            console.log('Script is running');
            var tingkatId = this.value;
            console.log(tingkatId);
            var kelasField = document.getElementById('kelas_field');

            if (tingkatId) {
                // Mengirimkan AJAX request untuk mendapatkan kelas berdasarkan tingkat_id
                fetch(`/akademik-management/kelas-by-tingkat/${tingkatId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Menyembunyikan kelas field jika tidak ada kelas
                        if (data.length > 0) {
                            kelasField.style.display = 'block';
                            var kelasSelect = document.getElementById('kelas_id');
                            kelasSelect.innerHTML = '<option value="" disabled selected>Pilih Kelas</option>';
                            data.forEach(function(kelas) {
                                var option = document.createElement('option');
                                option.value = kelas.id;
                                option.textContent = kelas.nama_kelas;
                                kelasSelect.appendChild(option);
                            });
                        } else {
                            kelasField.style.display = 'none';
                        }
                    })
                    .catch(error => console.log(error));
            } else {
                kelasField.style.display = 'none';
            }
        });

        // Memastikan kelas ditampilkan jika tingkat_id sudah dipilih
        document.addEventListener('DOMContentLoaded', function() {
            var tingkatId = document.getElementById('tingkat_id').value;
            if (tingkatId) {
                document.getElementById('kelas_field').style.display = 'block';
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Ketika tombol Filter diklik, toggle filter
            $(document).on('click', '.search', function(event) {
                event.stopPropagation();
                $(".show-search").slideToggle("fast");
                $(".show-filter").hide();
            });

            $(document).on('click', '.filter', function(event) {
                event.stopPropagation();
                $(".show-filter").slideToggle("fast");
                $(".show-search").hide();
            });

            // Elemen-elemen filter
            const $filterByTingkat = $('#filter_by_tingkat');
            const $filterByTingkatDanKelas = $('#filter_by_tingkat_dan_kelas');
            const $filterByPeriode = $('#filter_by_periode');
            const $tingkatField = $('#tingkat_id').closest('.form-group');
            const $kelasField = $('#kelas_field');
            const $periodeField = $('#periode_field');
            const $periodeId = $('#periode_id');

            // Fungsi untuk menampilkan atau menyembunyikan dropdown berdasarkan checkbox
            function toggleDropdown() {
                if ($filterByTingkat.is(':checked')) {
                    $tingkatField.show();
                    $kelasField.hide();
                    $periodeField.hide();
                } else if ($filterByTingkatDanKelas.is(':checked')) {
                    $tingkatField.show();
                    $kelasField.show();
                    $periodeField.hide();
                } else if ($filterByPeriode.is(':checked')) {
                    $tingkatField.hide();
                    $kelasField.hide();
                    $periodeField.show();
                } else {
                    $tingkatField.hide();
                    $kelasField.hide();
                    $periodeField.hide();
                }
            }

            // Logika untuk memilih hanya satu checkbox
            $filterByTingkat.on('change', function() {
                if ($(this).is(':checked')) {
                    $filterByTingkatDanKelas.prop('checked', false);
                    $filterByPeriode.prop('checked', false);
                }
                toggleDropdown();
            });

            $filterByTingkatDanKelas.on('change', function() {
                if ($(this).is(':checked')) {
                    $filterByTingkat.prop('checked', false);
                    $filterByPeriode.prop('checked', false);
                }
                toggleDropdown();
            });

            $filterByPeriode.on('change', function() {
                if ($(this).is(':checked')) {
                    $filterByTingkat.prop('checked', false);
                    $filterByTingkatDanKelas.prop('checked', false);
                }
                toggleDropdown();
            });

            // Jalankan fungsi untuk mengatur dropdown berdasarkan status awal checkbox
            toggleDropdown();
        });
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="{{ route('siswa-kelas.index') }}"]');

            form.addEventListener('submit', function(event) {
                // Prevent form submission to manipulate URL parameters first
                event.preventDefault();

                // Get all form elements
                const tingkatField = document.querySelector('#tingkat_id');
                const kelasField = document.querySelector('#kelas_id');
                const periodeField = document.querySelector('#periode_id');

                // Initialize query parameters
                let params = new URLSearchParams();

                // Determine which checkbox is checked
                const filterByTingkat = document.querySelector('#filter_by_tingkat').checked;
                const filterByTingkatDanKelas = document.querySelector('#filter_by_tingkat_dan_kelas')
                    .checked;
                const filterByPeriode = document.querySelector('#filter_by_periode').checked;

                // Add relevant parameters based on active filter
                if (filterByTingkat) {
                    if (tingkatField.value) {
                        params.append('tingkat_id', tingkatField.value);
                    }
                } else if (filterByTingkatDanKelas) {
                    if (tingkatField.value) {
                        params.append('tingkat_id', tingkatField.value);
                    }
                    if (kelasField.value) {
                        params.append('kelas_id', kelasField.value);
                    }
                } else if (filterByPeriode) {
                    if (periodeField.value) {
                        params.append('periode_id', periodeField.value);
                    }
                }

                // Redirect to the filtered URL
                const baseUrl = '{{ route('siswa-kelas.index') }}';
                window.location.href = `${baseUrl}?${params.toString()}`;
            });
        });
    </script>
@endpush
