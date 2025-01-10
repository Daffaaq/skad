<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreguruRequest;
use App\Http\Requests\StoreImportGuruRequest;
use App\Http\Requests\UpdateguruRequest;
use App\Models\guru;
use App\Models\User;
use App\Imports\GuruImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $guru = DB::table('gurus')
            ->when($request->input('nama_guru'), function ($query, $nama_guru) {
                return $query->where('nama_guru', 'like', '%' . $nama_guru . '%');
            })
            ->select('nama_guru', 'status_guru', 'nip', 'id')
            ->paginate(10);
        return view('guru.index', compact('guru'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreguruRequest $request)
    {
        DB::beginTransaction(); // Memulai transaksi

        try {
            // Mengunggah foto jika tersedia
            $fotoPath = null;
            if ($request->hasFile('foto_guru')) {
                $fotoPath = $request->file('foto_guru')->store('foto_guru', 'public');
            }

            $defaultPassword = Hash::make('password');
            // Membuat user
            $user = User::create([
                'name' => $request['nama_pendek_guru'],
                'email' => $request['email_guru'],
                'password' => $defaultPassword,
                'email_verified_at' => now(),
            ]);
            // dd($user);
            // Memberikan peran 'guru' setelah user dibuat
            $user->assignRole('guru');
            $nomorSK = $this->generateNoSK($request->tanggal_bergabung);
            $kodeGuru = $this->generateKodeGuru($request->nama_guru);
            // Simpan data guru
            DB::table('gurus')->insert([
                'nama_pendek_guru' => $request->nama_pendek_guru,
                'nomor_sk' => $nomorSK ?? null,
                'nama_guru' => $request->nama_guru,
                'nip' => $request->nip ?? null,
                'jenis_kelamin_guru' => $request->jenis_kelamin_guru,
                'status_guru' => $request->status_guru,
                'no_hp_guru' => $request->no_hp_guru,
                'alamat_guru' => $request->alamat_guru,
                'tanggal_lahir_guru' => $request->tanggal_lahir_guru ?? null,
                'agama_guru' => $request->agama_guru,
                'pendidikan_terakhir' => $request->pendidikan_terakhir ?? null,
                'tanggal_bergabung' => $request->tanggal_bergabung ?? null,
                'email_guru' => $request->email_guru ?? null,
                'foto_guru' => $fotoPath,
                'status_aktif_guru' => $request->status_aktif_guru,
                'status_perkawinan_guru' => $request->status_perkawinan_guru,
                'jabatan_guru' => $request->jabatan_guru,
                'kode_guru' => $kodeGuru,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit(); // Menyimpan perubahan setelah semua operasi berhasil

            return redirect()->route('guru.index')->with('success', 'Data guru berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback(); // Membatalkan transaksi jika terjadi kesalahan

            // Tangani error
            return redirect()->route('guru.index')->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    private function generateKodeGuru($namaGuru)
    {
        if (!$namaGuru) {
            return null; // Jika nama guru kosong, kode guru juga null
        }

        // Ambil semua kode guru yang sudah ada di database
        $existingCodes = DB::table('gurus')->pluck('kode_guru')->toArray();

        // Pisahkan nama berdasarkan spasi
        $parts = explode(' ', $namaGuru);

        // Ambil huruf pertama dari setiap kata (maksimal 3 kata pertama)
        $initials = array_map(function ($part) {
            return strtoupper(substr($part, 0, 1));
        }, array_slice($parts, 0, 3));

        // Gabungkan menjadi string awal (maksimal 3 huruf)
        $kodeGuru = implode('', $initials);

        // Pastikan panjang kode maksimal 3 huruf
        $kodeGuru = substr($kodeGuru, 0, 3);

        // Cek apakah kode sudah ada di daftar existingCodes
        $additionalIndex = 0;
        $lastPart = end($parts); // Ambil nama terakhir
        while (in_array($kodeGuru, $existingCodes)) {
            if (isset($lastPart[$additionalIndex])) {
                // Tambahkan huruf berikutnya dari nama belakang
                $kodeGuru = substr($kodeGuru, 0, 2) . strtoupper($lastPart[$additionalIndex]);
                $additionalIndex++;
            } else {
                // Jika semua huruf belakang habis, tambahkan huruf dari nama depan atau angka
                if ($additionalIndex < strlen($namaGuru)) {
                    $kodeGuru .= strtoupper(substr($namaGuru, $additionalIndex % strlen($namaGuru), 1));
                } else {
                    $kodeGuru .= (string)($additionalIndex % 10); // Tambahkan angka jika semua sudah habis
                }
                $additionalIndex++;
            }

            // Batasi maksimal panjang kode menjadi 4 huruf jika semua kemungkinan gagal
            if (strlen($kodeGuru) > 4) {
                break;
            }
        }
        // dd($existingCodes, $kodeGuru);
        // Kembalikan kode unik
        return $kodeGuru;
    }

    private function generateNoSK($tanggalBergabung)
    {
        if (is_null($tanggalBergabung)) {
            return null;
        }

        // Mengonversi tanggal bergabung ke Carbon instance
        $date = \Carbon\Carbon::parse($tanggalBergabung);

        // Mendapatkan bulan dalam angka Romawi
        $bulanRomawi = $this->convertMonthToRoman($date->month);

        // Mendapatkan tahun
        $tahun = $date->year;

        // Mendapatkan bagian tetap dari SK
        $bagianTetap = 'SMP1/HUMAS';

        // Mendapatkan jumlah SK yang sudah ada untuk bulan dan tahun tersebut
        $jumlahSK = DB::table('gurus')
            ->whereYear('tanggal_bergabung', $tahun)
            ->whereMonth('tanggal_bergabung', $date->month)
            ->count();

        // Menambahkan 1 ke jumlah SK untuk mendapatkan nomor urut berikutnya
        $nomorUrut = str_pad($jumlahSK + 1, 3, '0', STR_PAD_LEFT);

        // Menyusun nomor SK
        $nomorSK = "{$nomorUrut}/SK/BUP/{$bagianTetap}/{$bulanRomawi}/{$tahun}";

        return $nomorSK;
    }

    /**
     * Mengonversi bulan angka ke Romawi.
     *
     * @param int $month
     * @return string
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


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mengambil data guru berdasarkan ID
        $guru = DB::table('gurus')->where('id', $id)->first();

        if (!$guru) {
            return redirect()->route('guru.index')->withErrors(['error' => 'Guru tidak ditemukan.']);
        }

        // Menampilkan halaman show dengan data guru
        return view('guru.show', compact('guru'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Mengambil data guru berdasarkan ID
        $guru = DB::table('gurus')->where('id', $id)->first();

        if (!$guru) {
            return redirect()->route('guru.index')->withErrors(['error' => 'Guru tidak ditemukan.']);
        }

        // Menampilkan halaman edit dengan data guru
        return view('guru.edit', compact('guru'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateguruRequest $request, $id)
    {
        DB::beginTransaction(); // Memulai transaksi

        try {
            // Mengambil data guru berdasarkan ID
            $guru = DB::table('gurus')->where('id', $id)->first();

            if (!$guru) {
                return redirect()->route('guru.index')->withErrors(['error' => 'Guru tidak ditemukan.']);
            }

            // Mengambil data pengguna yang terkait dengan guru
            $user = User::find($guru->user_id);

            // Memperbarui data pengguna (user)
            if ($user) {
                // Jika password baru diinputkan, hash dan update password
                $password = $request->password ? Hash::make($request->password) : $user->password;

                $user->update([
                    'name' => $request->nama_guru,
                    'email' => $request->email_guru,
                    'password' => $password,
                    'email_verified_at' => now(),
                ]);
            }

            // Mengunggah foto jika ada perubahan foto
            $fotoPath = $guru->foto_guru;
            if ($request->hasFile('foto_guru')) {
                // Menghapus foto lama jika ada
                if ($fotoPath) {
                    Storage::disk('public')->delete($fotoPath);
                }

                // Menyimpan foto baru
                $fotoPath = $request->file('foto_guru')->store('foto_guru', 'public');
            }

            $nomorSK = $this->generateNoSK($request->tanggal_bergabung);
            $kodeGuru = $this->generateKodeGuru($request->nama_guru);

            // Memperbarui data guru
            DB::table('gurus')->where('id', $id)->update([
                'nama_pendek_guru' => $request->nama_pendek_guru,
                'nomor_sk' => $nomorSK ?? null,
                'nama_guru' => $request->nama_guru,
                'nip' => $request->nip ?? null,
                'jenis_kelamin_guru' => $request->jenis_kelamin_guru,
                'status_guru' => $request->status_guru,
                'no_hp_guru' => $request->no_hp_guru,
                'alamat_guru' => $request->alamat_guru,
                'tanggal_lahir_guru' => $request->tanggal_lahir_guru ?? null,
                'agama_guru' => $request->agama_guru,
                'pendidikan_terakhir' => $request->pendidikan_terakhir ?? null,
                'tanggal_bergabung' => $request->tanggal_bergabung ?? null,
                'email_guru' => $request->email_guru ?? null,
                'foto_guru' => $fotoPath,
                'status_aktif_guru' => $request->status_aktif_guru,
                'status_perkawinan_guru' => $request->status_perkawinan_guru,
                'jabatan_guru' => $request->jabatan_guru,
                'kode_guru' => $kodeGuru,
                'updated_at' => now(),
            ]);

            DB::commit(); // Menyimpan perubahan setelah semua operasi berhasil

            return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback(); // Membatalkan transaksi jika terjadi kesalahan

            // Tangani error
            return redirect()->route('guru.index')->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction(); // Memulai transaksi

        try {
            // Mengambil data guru berdasarkan ID
            $guru = DB::table('gurus')->where('id', $id)->first();

            if (!$guru) {
                return redirect()->route('guru.index')->withErrors(['error' => 'Guru tidak ditemukan.']);
            }

            // Menghapus foto guru jika ada
            if ($guru->foto_guru) {
                Storage::disk('public')->delete($guru->foto_guru);
            }

            // Menghapus data guru
            DB::table('gurus')->where('id', $id)->delete();

            // Menghapus user terkait
            $user = User::find($guru->user_id);
            if ($user) {
                $user->delete();
            }

            DB::commit(); // Menyimpan perubahan setelah semua operasi berhasil

            return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback(); // Membatalkan transaksi jika terjadi kesalahan

            // Tangani error
            return redirect()->route('guru.index')->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // public function import(StoreImportGuruRequest $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         // Mengimpor data
    //         Excel::import(new GuruImport, $request->file('file'));

    //         // Simpan perubahan ke database
    //         DB::commit();
    //         // return json
    //         return response()->json(['success' => 'Data berhasil diimpor!']);
    //         // return redirect()->route('guru.index')->with('success', 'Data berhasil diimpor!');
    //     } catch (\Exception $e) {
    //         // Batalkan transaksi jika ada kesalahan
    //         DB::rollback();

    //         return redirect()->route('guru.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'import_file' => 'required|mimes:xlsx,xls,csv|max:10240', // memvalidasi file yang diunggah
        ]);

        if ($request->hasFile('import_file')) {
            $file = $request->file('import_file');
            // Memproses file dan menyimpan data guru
            Excel::import(new GuruImport, $file); // Pastikan Anda sudah mengimpor kelas Excel dan sudah di-setup
            return redirect()->route('guru.index')->with('success', 'Data guru berhasil diimpor.');
        }

        return redirect()->route('guru.index')->with('error', 'File gagal diimpor.');
    }


}
