<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $siswa = DB::table('siswas')
            ->when(
                $request->input('nama_guru'),
                function ($query, $nama_guru) {
                    return $query->where('nama_guru', 'like', '%' . $nama_guru . '%');
                }
            )
            ->select('nama_siswa', 'id', 'nis', 'status_aktif_siswa')
            ->paginate(10);
        return view('siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiswaRequest $request)
    {
        DB::beginTransaction(); // Start transaction

        try {
            // Handle the photo upload if provided
            $fotoPath = null;
            if ($request->hasFile('foto_siswa')) {
                $fotoPath = $request->file('foto_siswa')->store('foto_siswa', 'public');
            }

            // Default password for the user
            $defaultPassword = Hash::make('password');

            // Create the user
            $user = User::create([
                'name' => $request['nama_panggilan_siswa'],
                'email' => $request['email_siswa'],
                'password' => $defaultPassword,
                'email_verified_at' => now(),
            ]);

            // Assign 'siswa' role to the user
            $user->assignRole('siswa');
            $nis = $this->generateNIS();  // Call the function to generate NIS
            // Create the siswa record
            siswa::create([
                'nama_siswa' => $request->nama_siswa,
                'nama_panggilan_siswa' => $request->nama_panggilan_siswa,
                'nisn' => $request->nisn,
                'nis' => $nis,
                'jenis_kelamin_siswa' => $request->jenis_kelamin_siswa,
                'tanggal_lahir_siswa' => $request->tanggal_lahir_siswa,
                'agama_siswa' => $request->agama_siswa,
                'foto_siswa' => $fotoPath, // Store the uploaded photo path
                'no_hp_siswa' => $request->no_hp_siswa,
                'alamat_siswa' => $request->alamat_siswa,
                'user_id' => $user->id, // Relate the siswa to the created user
                'tahun_masuk' => $request->tahun_masuk,
                'nama_ayah_siswa' => $request->nama_ayah_siswa,
                'nama_ibu_siswa' => $request->nama_ibu_siswa,
                'no_hp_ibu_siswa' => $request->no_hp_ibu_siswa,
                'no_hp_ayah_siswa' => $request->no_hp_ayah_siswa,
                'pekerjaan_ibu_siswa' => $request->pekerjaan_ibu_siswa,
                'pekerjaan_ayah_siswa' => $request->pekerjaan_ayah_siswa,
                'tanggal_kelulusan' => $request->tanggal_kelulusan,
                'email_siswa' => $request->email_siswa,
                'status_aktif_siswa' => $request->status_aktif_siswa,
            ]);

            DB::commit(); // Commit transaction

            // Redirect with success message
            return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaction on error

            // Handle the error and return the message
            return redirect()->route('siswa.index')->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    private function generateNIS()
    {
        // Get the active period from the periodes table
        $activePeriod = DB::table('periodes')->where('status_periode', 'aktif')->first();
        // dd($activePeriod);

        if (!$activePeriod) {
            throw new \Exception('Periode Belum Aktif.');
        }

        // Extract the last two digits of the period (e.g., 24 from 2024/2025)
        $yearDigits = substr($activePeriod->nama_periode, 2, 2);

        // Get the last sequential NIS number (if any)
        $lastSiswa = siswa::latest('nisn')->first(); // Get the last NIS created

        // Default to 1 if no NIS exists yet
        $sequentialNumber = $lastSiswa ? (intval(substr($lastSiswa->nisn, 2)) + 1) : 1;

        // Format the sequential number to ensure it's 10 digits long
        $formattedSequentialNumber = str_pad($sequentialNumber, 10, '0', STR_PAD_LEFT);

        // Combine the year part with the sequential number
        $nis = $yearDigits . $formattedSequentialNumber;

        return $nis;
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $siswa = siswa::findOrFail($id);
        return view('siswa.show',compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the siswa record and related user
        $siswa = siswa::findOrFail($id);
        $user = $siswa->user;

        // Pass the data to the edit view
        return view('siswa.edit', compact('siswa', 'user'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiswaRequest $request, $id)
    {
        DB::beginTransaction(); // Start transaction

        try {
            // Retrieve the siswa record and related user
            $siswa = siswa::findOrFail($id);
            $user = $siswa->user;

            // Handle the photo upload if provided
            $fotoPath = $siswa->foto_siswa;  // Keep the existing photo path
            if ($request->hasFile('foto_siswa')) {
                // If a new photo is uploaded, store the new one
                $fotoPath = $request->file('foto_siswa')->store('foto_siswa', 'public');
            }

            // Update the user record
            $user->update([
                'name' => $request['nama_panggilan_siswa'],
                'email' => $request['email_siswa'],
            ]);

            // Update the siswa record
            $nis = $this->generateNIS();  // Call the function to generate NIS (if necessary)

            $siswa->update([
                'nama_siswa' => $request->nama_siswa,
                'nama_panggilan_siswa' => $request->nama_panggilan_siswa,
                'nisn' => $request->nisn,
                'nis' => $nis,
                'jenis_kelamin_siswa' => $request->jenis_kelamin_siswa,
                'tanggal_lahir_siswa' => $request->tanggal_lahir_siswa,
                'agama_siswa' => $request->agama_siswa,
                'foto_siswa' => $fotoPath, // Store the uploaded photo path
                'no_hp_siswa' => $request->no_hp_siswa,
                'alamat_siswa' => $request->alamat_siswa,
                'user_id' => $user->id, // Relate the siswa to the updated user
                'tahun_masuk' => $request->tahun_masuk,
                'nama_ayah_siswa' => $request->nama_ayah_siswa,
                'nama_ibu_siswa' => $request->nama_ibu_siswa,
                'no_hp_ibu_siswa' => $request->no_hp_ibu_siswa,
                'no_hp_ayah_siswa' => $request->no_hp_ayah_siswa,
                'pekerjaan_ibu_siswa' => $request->pekerjaan_ibu_siswa,
                'pekerjaan_ayah_siswa' => $request->pekerjaan_ayah_siswa,
                'tanggal_kelulusan' => $request->tanggal_kelulusan,
                'email_siswa' => $request->email_siswa,
                'status_aktif_siswa' => $request->status_aktif_siswa,
            ]);

            DB::commit(); // Commit transaction

            // Redirect with success message
            return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaction on error

            // Handle the error and return the message
            return redirect()->route('siswa.index')->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
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
            $siswa = DB::table('siswas')->where('id', $id)->first();

            if (!$siswa) {
                return redirect()->route('siswa.index')->withErrors(['error' => 'siswa tidak ditemukan.']);
            }

            // Menghapus foto siswa jika ada
            if ($siswa->foto_siswa) {
                Storage::disk('public')->delete($siswa->foto_siswa);
            }

            // Menghapus data siswa
            DB::table('siswas')->where('id', $id)->delete();

            // Menghapus user terkait
            $user = User::find($siswa->user_id);
            if ($user) {
                $user->delete();
            }

            DB::commit(); // Menyimpan perubahan setelah semua operasi berhasil

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback(); // Membatalkan transaksi jika terjadi kesalahan

            // Tangani error
            return redirect()->route('siswa.index')->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
