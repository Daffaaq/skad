<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreguruRequest;
use App\Http\Requests\UpdateguruRequest;
use App\Models\guru;
use App\Models\User;
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
                'name' => $request['nama_guru'],
                'email' => $request['email_guru'],
                'password' => $defaultPassword,
                'email_verified_at' => now(),
            ]);
            // dd($user);
            // Memberikan peran 'guru' setelah user dibuat
            $user->assignRole('guru');

            // Simpan data guru
            DB::table('gurus')->insert([
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
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit(); // Menyimpan perubahan setelah semua operasi berhasil

            return redirect()->route('guru.index')->with('success', 'Data guru berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback(); // Membatalkan transaksi jika terjadi kesalahan

            // Tangani error
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
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

            // Memperbarui data guru
            DB::table('gurus')->where('id', $id)->update([
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
                'updated_at' => now(),
            ]);

            DB::commit(); // Menyimpan perubahan setelah semua operasi berhasil

            return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback(); // Membatalkan transaksi jika terjadi kesalahan

            // Tangani error
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
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
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

}
