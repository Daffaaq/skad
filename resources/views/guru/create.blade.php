@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Form Tambah Guru</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Guru</a></div>
                <div class="breadcrumb-item">Tambah Guru</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Data Guru</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Data Guru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('guru.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex flex-wrap">
                            <!-- Bagian Kiri -->
                            <div class="flex-fill pr-3" style="flex: 1;">
                                <div class="form-group">
                                    <label for="nama_guru">Nama Guru <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_guru') is-invalid @enderror"
                                        id="nama_guru" name="nama_guru" placeholder="Masukkan Nama Guru"
                                        value="{{ old('nama_guru') }}">
                                    @error('nama_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama_pendek_guru">Nama Pendek Guru <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('nama_pendek_guru') is-invalid @enderror"
                                        id="nama_pendek_guru" name="nama_pendek_guru" placeholder="Masukkan Nama Guru"
                                        value="{{ old('nama_pendek_guru') }}">
                                    @error('nama_pendek_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                        id="nip" name="nip" placeholder="Masukkan NIP"
                                        value="{{ old('nip') }}">
                                    @error('nip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin_guru">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-control @error('jenis_kelamin_guru') is-invalid @enderror"
                                        id="jenis_kelamin_guru" name="jenis_kelamin_guru">
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki"
                                            {{ old('jenis_kelamin_guru') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki
                                        </option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin_guru') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                    @error('jenis_kelamin_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status_guru">Status Guru <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status_guru') is-invalid @enderror" id="status_guru"
                                        name="status_guru">
                                        <option value="" disabled selected>Pilih Status Guru</option>
                                        <option value="PNS" {{ old('status_guru') == 'PNS' ? 'selected' : '' }}>PNS
                                        </option>
                                        <option value="Honorer" {{ old('status_guru') == 'Honorer' ? 'selected' : '' }}>
                                            Honorer</option>
                                    </select>
                                    @error('status_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="no_hp_guru">No. HP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('no_hp_guru') is-invalid @enderror"
                                        id="no_hp_guru" name="no_hp_guru" placeholder="Masukkan No. HP"
                                        value="{{ old('no_hp_guru') }}">
                                    @error('no_hp_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                                    <input type="text"
                                        class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                                        id="pendidikan_terakhir" name="pendidikan_terakhir"
                                        placeholder="Masukkan Pendidikan Terakhir"
                                        value="{{ old('pendidikan_terakhir') }}">
                                    @error('pendidikan_terakhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                 <div class="form-group">
                                    <label for="tanggal_lahir_guru">Tanggal Lahir</span></label>
                                    <input type="date" class="form-control @error('tanggal_lahir_guru') is-invalid @enderror"
                                        id="tanggal_lahir_guru" name="tanggal_lahir_guru" placeholder="Masukkan Tanggal Lahir"
                                        value="{{ old('tanggal_lahir_guru') }}">
                                    @error('tanggal_lahir_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bagian Kanan -->
                            <div class="flex-fill pl-3" style="flex: 1;">
                                <div class="form-group">
                                    <label for="alamat_guru">Alamat <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('alamat_guru') is-invalid @enderror" id="alamat_guru" name="alamat_guru"
                                        rows="3" placeholder="Masukkan Alamat">{{ old('alamat_guru') }}</textarea>
                                    @error('alamat_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="agama_guru">Agama <span class="text-danger">*</span></label>
                                    <select class="form-control @error('agama_guru') is-invalid @enderror" id="agama_guru"
                                        name="agama_guru">
                                        <option value="" disabled selected>Pilih Agama</option>
                                        <option value="Islam" {{ old('agama_guru') == 'Islam' ? 'selected' : '' }}>Islam
                                        </option>
                                        <option value="Kristen" {{ old('agama_guru') == 'Kristen' ? 'selected' : '' }}>
                                            Kristen</option>
                                        <option value="Katolik" {{ old('agama_guru') == 'Katolik' ? 'selected' : '' }}>
                                            Katolik</option>
                                        <option value="Budha" {{ old('agama_guru') == 'Budha' ? 'selected' : '' }}>Budha
                                        </option>
                                        <option value="Hindu" {{ old('agama_guru') == 'Hindu' ? 'selected' : '' }}>Hindu
                                        </option>
                                        <option value="Khonghucu"
                                            {{ old('agama_guru') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                    </select>
                                    @error('agama_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status_perkawinan_guru">Status Perkawinan <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('status_perkawinan_guru') is-invalid @enderror"
                                        id="status_perkawinan_guru" name="status_perkawinan_guru">
                                        <option value="" disabled selected>Pilih Status Perkawinan</option>
                                        <option value="Belum Menikah"
                                            {{ old('status_perkawinan_guru') == 'Belum Menikah' ? 'selected' : '' }}>Belum
                                            Menikah</option>
                                        <option value="Menikah"
                                            {{ old('status_perkawinan_guru') == 'Menikah' ? 'selected' : '' }}>Menikah
                                        </option>
                                        <option value="Duda"
                                            {{ old('status_perkawinan_guru') == 'Duda' ? 'selected' : '' }}>Duda</option>
                                        <option value="Janda"
                                            {{ old('status_perkawinan_guru') == 'Janda' ? 'selected' : '' }}>Janda</option>
                                    </select>
                                    @error('status_perkawinan_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email_guru">Email <span class="text-danger">*</label>
                                    <input type="email" class="form-control @error('email_guru') is-invalid @enderror"
                                        id="email_guru" name="email_guru" placeholder="Masukkan Email"
                                        value="{{ old('email_guru') }}">
                                    @error('email_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="foto_guru">Foto</label>
                                    <input type="file" class="form-control @error('foto_guru') is-invalid @enderror"
                                        id="foto_guru" name="foto_guru">
                                    @error('foto_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status_aktif_guru">Status Aktif <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status_aktif_guru') is-invalid @enderror"
                                        id="status_aktif_guru" name="status_aktif_guru">
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="Aktif"
                                            {{ old('status_aktif_guru') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Pensiun"
                                            {{ old('status_aktif_guru') == 'Pensiun' ? 'selected' : '' }}>Pensiun</option>
                                    </select>
                                    @error('status_aktif_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_bergabung">Tanggal Bergabung</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_bergabung') is-invalid @enderror"
                                        id="tanggal_bergabung" name="tanggal_bergabung"
                                        value="{{ old('tanggal_bergabung') }}">
                                    @error('tanggal_bergabung')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jabatan_guru">Jabatan Guru (Opsional)</label>
                                    <select class="form-control @error('jabatan_guru') is-invalid @enderror"
                                        id="jabatan_guru" name="jabatan_guru">
                                        <option value="" disabled selected>Pilih Jabatan</option>
                                        <option value="Kepala Sekolah"
                                            {{ old('jabatan_guru') == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah
                                        </option>
                                        <option value="Wakil Kepala Sekolah"
                                            {{ old('jabatan_guru') == 'Wakil Kepala Sekolah' ? 'selected' : '' }}>Wakil
                                            Kepala Sekolah</option>
                                        <option value="Waka Akademik"
                                            {{ old('jabatan_guru') == 'Waka Akademik' ? 'selected' : '' }}>Waka Akademik
                                        </option>
                                        <option value="Waka Kesiswaan"
                                            {{ old('jabatan_guru') == 'Waka Kesiswaan' ? 'selected' : '' }}>Waka Kesiswaan
                                        </option>
                                        <option value="Waka SarPras"
                                            {{ old('jabatan_guru') == 'Waka SarPras' ? 'selected' : '' }}>Waka SarPras
                                        </option>
                                        <option value="Waka Humas"
                                            {{ old('jabatan_guru') == 'Waka Humas' ? 'selected' : '' }}>Waka Humas</option>
                                    </select>
                                    @error('jabatan_guru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="text-right mt-3">
                            <button class="btn btn-primary">Simpan</button>
                            <a class="btn btn-secondary" href="{{ route('guru.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
