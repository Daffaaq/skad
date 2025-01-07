<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\StoreTingkatKelasRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class kelasdantingkatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $matapelajaran = DB::table('tingkats')
            ->when($request->input('nama_tingkat'), function ($query, $nama_tingkat) {
                return $query->where('tingkats.nama_tingkat', 'like', '%' . $nama_tingkat . '%');
            })
            ->select(
                'tingkats.id as tingkat_id',
                'tingkats.nama_tingkat',
                DB::raw('COUNT(tingkats.id) as tingkat_count'),
                DB::raw('COUNT(kelas.id) as kelas_count')
            ) // Tentukan kolom dengan tabelnya
            ->leftJoin('kelas', 'tingkats.id', '=', 'kelas.tingkat_id')
            ->groupBy('tingkats.id', 'tingkats.nama_tingkat')
            ->paginate(10);
        // dd($matapelajaran);
        return view('kelasdantingkat.index', compact('matapelajaran'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kelasdantingkat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTingkatKelasRequest $request)
    {
        // Masukkan data tingkat dan dapatkan ID-nya
        $tingkatId = DB::table('tingkats')->insertGetId([
            'nama_tingkat' => $request->input('nama_tingkat'),
            'created_at' => now(), // Tambahkan timestamp jika menggunakan
            'updated_at' => now(),
        ]);

        // Masukkan data ke tabel kelas
        foreach ($request->input('nama_kelas') as $kelas) {
            DB::table('kelas')->insert([
                'tingkat_id' => $tingkatId,
                'nama_kelas' => $kelas,
            ]);
        }

        return redirect()->route('tingkat-kelas.index')->with('success', 'Tingkat created successfully.');
    }

    public function indexTambahKelas($tingkatId){
        $tingkat = DB::table('tingkats')->where('id', $tingkatId)->first();
        $kelas = DB::table('kelas')->where('tingkat_id', $tingkatId)->get();
        return view('kelasdantingkat.tambahkelas', compact('tingkat', 'kelas'));
    }

    public function tambahkelas(StoreKelasRequest $request, $tingkatId)
    {
        // Periksa apakah tingkat dengan ID tersebut ada
        $tingkat = DB::table('tingkats')->where('id', $tingkatId)->first();
        if (!$tingkat) {
            return redirect()->route('tingkat-kelas.index')->with('error', 'Tingkat tidak ditemukan.');
        }

        // Tambahkan data kelas baru
        foreach ($request->input('nama_kelas') as $kelas) {
            DB::table('kelas')->insert([
                'tingkat_id' => $tingkatId,
                'nama_kelas' => $kelas,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('tingkat-kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function showkelas($tingkatId){
        $tingkat = DB::table('tingkats')->where('id', $tingkatId)->first();
        $kelas = DB::table('kelas')->where('tingkat_id', $tingkatId)->get();
        return view('kelasdantingkat.showkelas', compact('tingkat', 'kelas'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}