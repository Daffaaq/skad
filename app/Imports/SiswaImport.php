<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Konversi serial number Excel ke tanggal (jika tanggal lahir ada)
        if (is_numeric($row['tanggal_lahir_siswa'])) {
            $row['tanggal_lahir_siswa'] = Carbon::instance(Date::excelToDateTimeObject($row['tanggal_lahir_siswa']))->format('Y-m-d');
        }

        // Validasi data (hanya kolom yang required)
        $validator = Validator::make($row, [
            'nama_siswa' => 'required|string|max:255',
            'nama_panggilan_siswa' => 'required|string|max:255',
            'jenis_kelamin_siswa' => 'required|in:Laki-Laki,Perempuan',
            'tanggal_lahir_siswa' => 'required|date',
            'agama_siswa' => 'required|in:Islam,Kristen,Katolik,Budha,Hindu,Khonghucu',
            'alamat_siswa' => 'required|string',
            'tahun_masuk' => 'required|integer|min:1900',
            'no_hp_siswa' => 'required|string|max:15',
            'email_siswa' => 'required|email|unique:siswas,email_siswa|max:255',
            'status_aktif_siswa' => 'required|in:Aktif,Lulus,Dropout',
            'nisn' => 'required|unique:siswas,nisn|string|max:20',
        ]);

        if ($validator->fails()) {
            Log::error('Validasi gagal', ['row' => $row, 'errors' => $validator->errors()]);
            return null; // Abaikan baris jika validasi gagal
        }

        // Buat user baru
        $user = User::create([
            'name' => $row['nama_panggilan_siswa'],
            'email' => $row['email_siswa'],
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Assign role siswa
        $user->assignRole('siswa');

        // Generate NIS
        $nis = $this->generateNIS();

        // Kembalikan model Siswa
        return new Siswa([
            'nama_siswa' => $row['nama_siswa'],
            'nama_panggilan_siswa' => $row['nama_panggilan_siswa'],
            'email_siswa' => $row['email_siswa'],
            'no_hp_siswa' => $row['no_hp_siswa'],
            'nis' => $nis,
            'jenis_kelamin_siswa' => $row['jenis_kelamin_siswa'],
            'tanggal_lahir_siswa' => $row['tanggal_lahir_siswa'],
            'agama_siswa' => $row['agama_siswa'],
            'alamat_siswa' => $row['alamat_siswa'],
            'user_id' => $user->id,
            'tahun_masuk' => $row['tahun_masuk'],
            'status_aktif_siswa' => $row['status_aktif_siswa'],
            'nisn' => $row['nisn'],
        ]);
    }

    private function generateNIS()
    {
        // Dapatkan periode aktif
        $activePeriod = DB::table('periodes')->where('status_periode', 'aktif')->first();

        if (!$activePeriod) {
            throw new \Exception('Periode Belum Aktif.');
        }

        $yearDigits = substr($activePeriod->nama_periode, 2, 2);
        $lastSiswa = Siswa::latest('nis')->first();
        $sequentialNumber = $lastSiswa ? (intval(substr($lastSiswa->nis, 2)) + 1) : 1;
        $formattedSequentialNumber = str_pad($sequentialNumber, 10, '0', STR_PAD_LEFT);

        return $yearDigits . $formattedSequentialNumber;
    }
}
