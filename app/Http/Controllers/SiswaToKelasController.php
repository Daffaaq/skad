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
        $data = DB::table('siswatokelas')
            ->when($request->input('nama_siswa'), function ($query, $nama_siswa) {
                return $query->where('siswas.nama_siswa', 'like', '%' . $nama_siswa . '%');
            })
            ->join('siswas', 'siswatokelas.siswa_id', '=', 'siswas.id')
            ->join('kelas', 'siswatokelas.kelas_id', '=', 'kelas.id')
            ->join('tingkats', 'kelas.tingkat_id', '=', 'tingkats.id') // Tambahkan join ke tingkats
            ->join('periodes', 'siswatokelas.periode_id', '=', 'periodes.id')
            ->select(
                'siswatokelas.id',
                'siswas.nama_siswa as siswa_nama',
                'kelas.nama_kelas as kelas_nama',
                'tingkats.nama_tingkat as tingkat_nama', // Alias untuk tingkat
                'periodes.nama_periode as periode_nama'
            )
            ->paginate(10);

        return view('siswatokelas.index', compact('data'));
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
    public function edit(string $id)
    {
        $activePeriod = DB::table('periodes')->where('status_periode', 'aktif')->first();
        if (!$activePeriod) {
            return redirect()->route('siswa-kelas.index')->with('error', 'Periode ajaran aktif tidak ditemukan.');
        }
        $data = Siswatokelas::findOrFail($id);
        $siswa = Siswa::all();
        $kelas = Kelas::all();

        return view('siswatokelas.edit', compact('data', 'siswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiswaKelasRequest $request, string $id)
    {
        $activePeriod = DB::table('periodes')->where('status_periode', 'aktif')->first();
        if (!$activePeriod) {
            return redirect()->route('siswa-kelas.index')->with('error', 'Periode ajaran aktif tidak ditemukan.');
        }
        $data = Siswatokelas::findOrFail($id);
        $data->update([
            'siswa_id' => $request->siswa_id,
            'kelas_id' => $request->kelas_id,
            'periode_id' => $activePeriod->id,
        ]);

        return redirect()->route('siswatokelas.index')->with('success', 'Data siswa di kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
