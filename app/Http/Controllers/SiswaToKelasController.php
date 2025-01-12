<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiswaKelasRequest;
use App\Http\Requests\UpdateSiswaKelasRequest;
use App\Models\kelas;
use App\Models\periode;
use App\Models\siswa;
use App\Models\siswatokelas;
use App\Models\tingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaToKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query utama untuk mengambil data siswa, kelas, tingkat, dan periode
        $data = DB::table('siswatokelas')
            ->join('siswas', 'siswatokelas.siswa_id', '=', 'siswas.id')
            ->join('kelas', 'siswatokelas.kelas_id', '=', 'kelas.id')
            ->join('tingkats', 'kelas.tingkat_id', '=', 'tingkats.id')
            ->join('periodes', 'siswatokelas.periode_id', '=', 'periodes.id')
            ->select(
                'siswatokelas.id',
                'siswas.nama_siswa as siswa_nama',
                'kelas.nama_kelas as kelas_nama',
                'tingkats.nama_tingkat as tingkat_nama',
                'periodes.nama_periode as periode_nama',
            )
            // Filter berdasarkan nama siswa jika ada input
            ->when($request->input('nama_siswa'), function ($query, $nama_siswa) {
                return $query->where('siswas.nama_siswa', 'like', '%' . $nama_siswa . '%');
            })
            // Filter berdasarkan tingkat jika checkbox "filter_by_tingkat" diaktifkan
            ->when($request->input('tingkat_id'), function ($query, $tingkat_id) {
                return $query->where('kelas.tingkat_id', $tingkat_id);
            })
            ->when($request->input('tingkat_id') && $request->input('kelas_id'), function ($query) use ($request) {
                return $query->where('kelas.tingkat_id', $request->input('tingkat_id'))
                    ->where('siswatokelas.kelas_id', $request->input('kelas_id'));
            })

            ->paginate(10);

        // Ambil data tingkat untuk dropdown filter
        $tingkats = Tingkat::all();


        return view('siswatokelas.index', compact('data', 'tingkats'));
    }

    // SiswaToKelasController.php

    public function getKelasByTingkat($tingkat_id)
    {
        // Ambil kelas berdasarkan tingkat_id
        $kelas = Kelas::where('tingkat_id', $tingkat_id)->get();

        // Mengembalikan data kelas dalam format JSON
        return response()->json($kelas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activePeriod = DB::table('periodes')->where('status_periode', 'aktif')->first();
        if (!$activePeriod) {
            return redirect()->route('siswa-kelas.index')->with('error', 'Periode ajaran aktif tidak ditemukan.');
        }

        // Ambil semua siswa yang belum memiliki kelas pada periode aktif
        $siswa = siswa::whereDoesntHave('siswatokelas', function ($query) use ($activePeriod) {
            $query->where('periode_id', $activePeriod->id);
        })->get();
        $tingkat = tingkat::with('kelas')->get(); // Ambil tingkat beserta kelasnya

        return view('siswatokelas.create', compact('siswa', 'tingkat'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiswaKelasRequest $request)
    {
        $activePeriod = DB::table('periodes')->where('status_periode', 'aktif')->first();
        if (!$activePeriod) {
            return redirect()->route('siswa-kelas.index')->with('error', 'Periode ajaran aktif tidak ditemukan.');
        }
        // Loop untuk menyimpan setiap siswa ke kelas
        foreach ($request->siswa_id as $siswa_id) {
            Siswatokelas::create([
                'siswa_id' => $siswa_id,
                'kelas_id' => $request->kelas_id,
                'periode_id' => $activePeriod->id,
            ]);
        }

        return redirect()->route('siswa-kelas.index')->with('success', 'Siswa berhasil ditambahkan ke kelas.');
    }

    public function createRandomKelas()
    {
        $activePeriod = DB::table('periodes')->where('status_periode', 'aktif')->first();

        if (!$activePeriod) {
            return redirect()->route('siswa-kelas.index')->with('error', 'Periode ajaran aktif tidak ditemukan.');
        }

        // Mengambil daftar siswa
        $siswa = DB::table('siswas')->select('id', 'nama_siswa')->get();

        // Mengambil tingkat kelas beserta kelas-kelasnya
        $tingkat = Tingkat::with('kelas')->get();  // Asumsi ada relasi 'kelas' dalam model Tingkat

        return view('siswatokelas.createRand', compact('siswa', 'tingkat'));
    }

    public function randomAssign(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'siswa' => 'required|array|min:1', // Pastikan siswa yang dipilih ada dan lebih dari 0
            'siswa.*' => 'exists:siswas,id', // Pastikan setiap siswa_id yang dipilih ada di database
            'tingkat_id' => 'required|exists:tingkats,id', // Pastikan tingkat yang dipilih ada di database
        ]);
        $activePeriod = DB::table('periodes')->where('status_periode', 'aktif')->first();

        if (!$activePeriod) {
            return redirect()->route('siswa-kelas.index')->with('error', 'Periode ajaran aktif tidak ditemukan.');
        }

        $siswaIds = $request->input('siswa'); // Siswa yang dipilih
        $tingkatId = $request->input('tingkat_id'); // Tingkat yang dipilih

        // Cek apakah ada siswa dan tingkat yang dipilih
        if (empty($siswaIds) || empty($tingkatId)) {
            return redirect()->back()->with('error', 'Siswa atau tingkat tidak dipilih.');
        }

        // Ambil kelas-kelas yang sesuai dengan tingkat yang dipilih
        $kelas = DB::table('kelas')
            ->where('tingkat_id', $tingkatId)
            ->get(); // Ambil kelas yang sesuai dengan tingkat
        $kelasIds = $kelas->pluck('id')->toArray(); // Ambil ID kelas

        // Cek apakah ada kelas yang terkait dengan tingkat yang dipilih
        if (empty($kelasIds)) {
            return redirect()->back()->with('error', 'Tidak ada kelas yang tersedia untuk tingkat ini.');
        }

        // Acak siswa dan kelas
        $siswaIds = collect($siswaIds)->shuffle(); // Acak siswa
        $kelas = $kelas->shuffle(); // Acak kelas

        $kelasCount = count($kelasIds);
        $siswaCount = count($siswaIds);

        // Tentukan distribusi siswa ke kelas
        $kelasPerSiswa = ceil($siswaCount / $kelasCount);

        $currentKelasIndex = 0;

        // Proses mengalokasikan siswa ke kelas
        foreach ($siswaIds as $index => $siswaId) {
            $kelasId = $kelas[$currentKelasIndex]->id; // Ambil kelas yang teracak

            // Gunakan upsert untuk memasukkan atau mengupdate data siswa ke kelas
            DB::table('siswatokelas')->upsert(
                [
                    'siswa_id' => $siswaId,
                    'kelas_id' => $kelasId,
                    'periode_id' => $activePeriod->id
                ],
                ['siswa_id', 'periode_id'], // Kunci unik yang digunakan untuk cek keberadaan data
                ['kelas_id'] // Update hanya kolom kelas jika sudah ada
            );

            // Pindah ke kelas berikutnya jika kelas sudah penuh
            if (($index + 1) % $kelasPerSiswa == 0) {
                $currentKelasIndex++;
            }

            // Jika sudah mengalokasikan siswa ke semua kelas, stop
            if ($currentKelasIndex >= $kelasCount) {
                break;
            }
        }

        return redirect()->route('siswa-kelas.index')->with('success', 'Siswa berhasil diacak ke kelas.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $activePeriod = DB::table('periodes')->where('status_periode', 'aktif')->first();

        if (!$activePeriod) {
            return redirect()->route('siswa-kelas.index')->with('error', 'Periode ajaran aktif tidak ditemukan.');
        }

        // Ambil data siswa dan kelas yang akan diedit
        $siswatokelas = Siswatokelas::where('id', $id)->first();

        if (!$siswatokelas) {
            return redirect()->route('siswa-kelas.index')->with('error', 'Data tidak ditemukan.');
        }

        // Tentukan kondisi readonly (misalnya berdasarkan periode aktif atau status lainnya)
        $readonlySiswa = true;  // Misalnya, siswa tidak bisa diubah kelasnya di periode ini

        $tingkat = tingkat::with('kelas')->get();

        return view('siswatokelas.edit', compact('siswatokelas', 'tingkat', 'readonlySiswa'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiswaKelasRequest $request, $id)
    {
        $activePeriod = DB::table('periodes')->where('status_periode', 'aktif')->first();

        if (!$activePeriod) {
            return redirect()->route('siswa-kelas.index')->with('error', 'Periode ajaran aktif tidak ditemukan.');
        }

        // Ambil data siswa dan kelas yang akan diupdate
        $siswatokelas = Siswatokelas::findOrFail($id);

        // Update kelas_id tanpa mengubah siswa_id atau periode_id
        $siswatokelas->update([
            'kelas_id' => $request->kelas_id,  // Perbarui kelas_id yang baru
        ]);

        return redirect()->route('siswa-kelas.index')->with('success', 'Kelas siswa berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
