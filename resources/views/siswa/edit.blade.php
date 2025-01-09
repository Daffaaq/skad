@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Form Edit Siswa</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Siswa</a></div>
                <div class="breadcrumb-item">Edit Siswa</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Data Siswa</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Data Siswa</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.update', $siswa->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="d-flex flex-wrap">
                            <!-- Bagian Kiri -->
                            <div class="flex-fill pr-3" style="flex: 1;">
                                <div class="form-group">
                                    <label for="nama_siswa">Nama Siswa <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror"
                                        id="nama_siswa" name="nama_siswa" placeholder="Masukkan Nama Siswa"
                                        value="{{ old('nama_siswa', $siswa->nama_siswa) }}">
                                    @error('nama_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama_panggilan_siswa">Nama Panggilan Siswa <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('nama_panggilan_siswa') is-invalid @enderror"
                                        id="nama_panggilan_siswa" name="nama_panggilan_siswa"
                                        placeholder="Masukkan Nama Panggilan" value="{{ old('nama_panggilan_siswa' , $siswa->nama_panggilan_siswa) }}">
                                    @error('nama_panggilan_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nisn">NISN</label>
                                    <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                        id="nisn" name="nisn" placeholder="Masukkan NISN"
                                        value="{{ old('nisn', $siswa->nisn) }}">
                                    @error('nisn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin_siswa">Jenis Kelamin <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('jenis_kelamin_siswa') is-invalid @enderror"
                                        id="jenis_kelamin_siswa" name="jenis_kelamin_siswa">
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki"
                                            {{ old('jenis_kelamin_siswa', $siswa->jenis_kelamin_siswa) == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki
                                        </option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin_siswa', $siswa->jenis_kelamin_siswa) == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                    @error('jenis_kelamin_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir_siswa">Tanggal Lahir</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_lahir_siswa') is-invalid @enderror"
                                        id="tanggal_lahir_siswa" name="tanggal_lahir_siswa"
                                        placeholder="Masukkan Tanggal Lahir" value="{{ old('tanggal_lahir_siswa', $siswa->tanggal_lahir_siswa) }}">
                                    @error('tanggal_lahir_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="agama_siswa">Agama <span class="text-danger">*</span></label>
                                    <select class="form-control @error('agama_siswa') is-invalid @enderror" id="agama_siswa"
                                        name="agama_siswa">
                                        <option value="" disabled selected>Pilih Agama</option>
                                        <option value="Islam" {{ old('agama_siswa',$siswa->agama_siswa) == 'Islam' ? 'selected' : '' }}>Islam
                                        </option>
                                        <option value="Kristen" {{ old('agama_siswa',$siswa->agama_siswa) == 'Kristen' ? 'selected' : '' }}>
                                            Kristen</option>
                                        <option value="Katolik" {{ old('agama_siswa',$siswa->agama_siswa) == 'Katolik' ? 'selected' : '' }}>
                                            Katolik</option>
                                        <option value="Budha" {{ old('agama_siswa',$siswa->agama_siswa) == 'Budha' ? 'selected' : '' }}>Budha
                                        </option>
                                        <option value="Hindu" {{ old('agama_siswa',$siswa->agama_siswa) == 'Hindu' ? 'selected' : '' }}>Hindu
                                        </option>
                                        <option value="Khonghucu"
                                            {{ old('agama_siswa',$siswa->agama_siswa) == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                    </select>
                                    @error('agama_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="no_hp_siswa">No HP Siswa <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('no_hp_siswa') is-invalid @enderror"
                                        id="no_hp_siswa" name="no_hp_siswa" placeholder="Masukkan No HP Siswa"
                                        value="{{ old('no_hp_siswa', $siswa->no_hp_siswa) }}">
                                    @error('no_hp_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Tambahan Nama Ayah -->
                                <div class="form-group">
                                    <label for="nama_ayah_siswa">Nama Ayah <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('nama_ayah_siswa') is-invalid @enderror"
                                        id="nama_ayah_siswa" name="nama_ayah_siswa" placeholder="Masukkan Nama Ayah"
                                        value="{{ old('nama_ayah_siswa', $siswa->nama_ayah_siswa) }}">
                                    @error('nama_ayah_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tambahan No HP Ayah -->
                                <div class="form-group">
                                    <label for="no_hp_ayah_siswa">No HP Ayah <span class="text-danger">*</span></label>
                                    <input type="number"
                                        class="form-control @error('no_hp_ayah_siswa') is-invalid @enderror"
                                        id="no_hp_ayah_siswa" name="no_hp_ayah_siswa" placeholder="Masukkan No HP Ayah"
                                        value="{{ old('no_hp_ayah_siswa', $siswa->no_hp_ayah_siswa) }}">
                                    @error('no_hp_ayah_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tambahan Pekerjaan Ayah -->
                                <div class="form-group">
                                    <label for="pekerjaan_ayah_siswa">Pekerjaan Ayah <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('pekerjaan_ayah_siswa') is-invalid @enderror"
                                        id="pekerjaan_ayah_siswa" name="pekerjaan_ayah_siswa"
                                        placeholder="Masukkan Pekerjaan Ayah" value="{{ old('pekerjaan_ayah_siswa', $siswa->pekerjaan_ayah_siswa) }}">
                                    @error('pekerjaan_ayah_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bagian Kanan -->
                            <div class="flex-fill pl-3" style="flex: 1;">
                                <div class="form-group">
                                    <label for="alamat_siswa">Alamat <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('alamat_siswa') is-invalid @enderror" id="alamat_siswa" name="alamat_siswa"
                                        rows="3" placeholder="Masukkan Alamat">{{ old('alamat_siswa', $siswa->alamat_siswa) }}</textarea>
                                    @error('alamat_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="foto_siswa">Foto Siswa</label>
                                    <input type="file" class="form-control @error('foto_siswa') is-invalid @enderror"
                                        id="foto_siswa" name="foto_siswa">
                                    @error('foto_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email_siswa">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email_siswa') is-invalid @enderror"
                                        id="email_siswa" name="email_siswa" placeholder="Masukkan Email"
                                        value="{{ old('email_siswa', $siswa->email_siswa) }}">
                                    @error('email_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status_aktif_siswa">Status Aktif <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('status_aktif_siswa') is-invalid @enderror"
                                        id="status_aktif_siswa" name="status_aktif_siswa">
                                        <option value="" disabled selected>Pilih Status Aktif</option>
                                        <option value="Aktif"
                                            {{ old('status_aktif_siswa', $siswa->status_aktif_siswa) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Lulus"
                                            {{ old('status_aktif_siswa', $siswa->status_aktif_siswa) == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                        <option value="Dropout"
                                            {{ old('status_aktif_siswa', $siswa->status_aktif_siswa) == 'Dropout' ? 'selected' : '' }}>Dropout</option>
                                    </select>
                                    @error('status_aktif_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Tambahan Tahun Masuk -->
                                <div class="form-group">
                                    <label for="tahun_masuk">Tahun Masuk <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('tahun_masuk') is-invalid @enderror"
                                        id="tahun_masuk" name="tahun_masuk" placeholder="Masukkan Tahun Masuk"
                                        value="{{ old('tahun_masuk', $siswa->tahun_masuk) }}">
                                    @error('tahun_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tambahan Tanggal Kelulusan -->
                                <div class="form-group">
                                    <label for="tanggal_kelulusan">Tanggal Kelulusan</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_kelulusan') is-invalid @enderror"
                                        id="tanggal_kelulusan" name="tanggal_kelulusan"
                                        placeholder="Masukkan Tanggal Kelulusan" value="{{ old('tanggal_kelulusan', $siswa->tanggal_kelulusan) }}">
                                    @error('tanggal_kelulusan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tambahan Nama Ibu -->
                                <div class="form-group">
                                    <label for="nama_ibu_siswa">Nama Ibu <span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('nama_ibu_siswa') is-invalid @enderror"
                                        id="nama_ibu_siswa" name="nama_ibu_siswa" placeholder="Masukkan Nama Ibu"
                                        value="{{ old('nama_ibu_siswa', $siswa->nama_ibu_siswa) }}">
                                    @error('nama_ibu_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tambahan No HP Ibu -->
                                <div class="form-group">
                                    <label for="no_hp_ibu_siswa">No HP Ibu <span class="text-danger">*</span></label>
                                    <input type="number"
                                        class="form-control @error('no_hp_ibu_siswa') is-invalid @enderror"
                                        id="no_hp_ibu_siswa" name="no_hp_ibu_siswa" placeholder="Masukkan No HP Ibu"
                                        value="{{ old('no_hp_ibu_siswa', $siswa->no_hp_ibu_siswa) }}">
                                    @error('no_hp_ibu_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tambahan Pekerjaan Ibu -->
                                <div class="form-group">
                                    <label for="pekerjaan_ibu_siswa">Pekerjaan Ibu <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('pekerjaan_ibu_siswa') is-invalid @enderror"
                                        id="pekerjaan_ibu_siswa" name="pekerjaan_ibu_siswa"
                                        placeholder="Masukkan Pekerjaan Ibu" value="{{ old('pekerjaan_ibu_siswa', $siswa->pekerjaan_ibu_siswa) }}">
                                    @error('pekerjaan_ibu_siswa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                            <a class="btn btn-secondary" href="{{ route('siswa.index') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
