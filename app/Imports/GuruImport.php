<?php

namespace App\Imports;

use App\Http\Requests\ImportGuruRequest;
use App\Models\Guru;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    /**
     * Menerima setiap baris dari Excel dan menyimpannya ke database.
     */
    public function model(array $row)
    {
        // Konversi serial number Excel ke tanggal
        if (is_numeric($row['tanggal_bergabung'])) {
            $row['tanggal_bergabung'] = \Carbon\Carbon::instance(Date::excelToDateTimeObject($row['tanggal_bergabung']))->format('Y-m-d');
        }
        
        // Ambil aturan validasi dari FormRequest
        $rules = (new ImportGuruRequest())->rules();

        // Validasi data
        $validator = Validator::make($row, $rules);

        if ($validator->fails()) {
            Log::error('Validasi gagal', ['row' => $row, 'errors' => $validator->errors()]);
            Log::info('Nilai tanggal bergabung:', ['tanggal_bergabung' => $row['tanggal_bergabung']]);
            return null; // Abaikan baris jika validasi gagal
        }

        // Buat user baru
        $user = User::create([
            'name' => $row['nama_pendek_guru'], // Nama pendek guru
            'email' => $row['email_guru'], // Email guru
            'password' => Hash::make('password'), // Password default
            'email_verified_at' => now(),
        ]);

        // Assign role guru
        $user->assignRole('guru');

        // Buat kode guru unik
        $kodeGuru = $this->generateKodeGuru($row['nama_guru']);

        // Buat nomor SK
        $nomorSK = $this->generateNoSK($row['tanggal_bergabung'] ?? now());

        // Kembalikan data Guru
        return new Guru([
            'nama_guru' => $row['nama_guru'], // Nama lengkap
            'nama_pendek_guru' => $row['nama_pendek_guru'], // Nama pendek
            'email_guru' => $row['email_guru'], // Email
            'no_hp_guru' => $row['no_hp_guru'], // Nomor HP
            'jenis_kelamin_guru' => $row['jenis_kelamin_guru'], // Jenis kelamin
            'status_guru' => $row['status_guru'], // Status pekerjaan
            'status_perkawinan_guru' => $row['status_perkawinan_guru'], // Status perkawinan
            'agama_guru' => $row['agama_guru'], // Agama
            'status_aktif_guru' => $row['status_aktif_guru'], // Status aktif
            'kode_guru' => $kodeGuru, // Kode unik guru
            'nomor_sk' => $nomorSK, // Nomor SK
            'user_id' => $user->id, // ID User yang baru dibuat
            'alamat_guru' => $row['alamat_guru'], // Alamat
        ]);
    }

    /**
     * Generate kode guru unik berdasarkan nama.
     */
    private function generateKodeGuru($namaGuru)
    {
        if (!$namaGuru) {
            return null; // Jika nama guru kosong, kode guru juga null
        }

        $existingCodes = DB::table('gurus')->pluck('kode_guru')->toArray();
        $parts = explode(' ', $namaGuru);
        $initials = array_map(function ($part) {
            return strtoupper(substr($part, 0, 1));
        }, array_slice($parts, 0, 3));
        $kodeGuru = implode('', $initials);
        $kodeGuru = substr($kodeGuru, 0, 3);

        $additionalIndex = 0;
        $lastPart = end($parts);
        while (in_array($kodeGuru, $existingCodes)) {
            if (isset($lastPart[$additionalIndex])) {
                $kodeGuru = substr($kodeGuru, 0, 2) . strtoupper($lastPart[$additionalIndex]);
                $additionalIndex++;
            } else {
                $kodeGuru .= (string)($additionalIndex % 10);
                $additionalIndex++;
            }
            if (strlen($kodeGuru) > 4) {
                break;
            }
        }

        return $kodeGuru;
    }

    /**
     * Generate nomor SK berdasarkan tanggal bergabung.
     */
    private function generateNoSK($tanggalBergabung)
    {
        if (is_null($tanggalBergabung)) {
            return null;
        }

        $date = \Carbon\Carbon::parse($tanggalBergabung);
        $bulanRomawi = $this->convertMonthToRoman($date->month);
        $tahun = $date->year;
        $bagianTetap = 'SMP1/HUMAS';
        $jumlahSK = DB::table('gurus')
            ->whereYear('tanggal_bergabung', $tahun)
            ->whereMonth('tanggal_bergabung', $date->month)
            ->count();
        $nomorUrut = str_pad($jumlahSK + 1, 3, '0', STR_PAD_LEFT);
        $nomorSK = "{$nomorUrut}/SK/BUP/{$bagianTetap}/{$bulanRomawi}/{$tahun}";

        return $nomorSK;
    }

    /**
     * Mengonversi bulan angka ke Romawi.
     */
    private function convertMonthToRoman($month)
    {
        $romawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];

        return $romawi[$month] ?? 'I';
    }
}
