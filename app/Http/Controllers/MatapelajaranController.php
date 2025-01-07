<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMataPelajaranRequest;
use App\Http\Requests\UpdateMataPelajaranRequest;
use App\Models\matapelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MatapelajaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:mata-pelajaran.index')->only('index');
        $this->middleware('permission:mata-pelajaran.create')->only('create', 'store');
        $this->middleware('permission:mata-pelajaran.edit')->only('edit', 'update');
        $this->middleware('permission:mata-pelajaran.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // mengambil data
        $matapelajaran = DB::table('matapelajarans')
            ->when($request->input('nama_matapelajaran'), function ($query, $nama_matapelajaran) {
                return $query->where('nama_matapelajaran', 'like', '%' . $nama_matapelajaran . '%');
            })
            ->select('id', 'nama_matapelajaran', 'kode_matapelajaran')
            ->paginate(10);
        return view('mapel.index', compact('matapelajaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mapel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMataPelajaranRequest $request)
    {
        // Simpan data ke dalam database
        matapelajaran::create($request->validated());

        // Redirect atau respon setelah menyimpan
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(matapelajaran $matapelajaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(matapelajaran $matapelajaran)
    // {
    //     dd($matapelajaran);
    //     return view('mapel.edit', compact('matapelajaran'));
    // }

    public function edit($id)
    {
        $matapelajaran = matapelajaran::findOrFail($id); // Cari berdasarkan ID
        // dd($matapelajaran); // Debug untuk memastikan data ditemukan
        return view('mapel.edit', compact('matapelajaran'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMataPelajaranRequest $request, $id)
    {
        // Validasi data dari request
        $validatedData = $request->validated();

        // Cari data berdasarkan ID
        $matapelajaran = matapelajaran::findOrFail($id);

        // Update data
        $matapelajaran->update($validatedData);

        // Redirect ke index dengan pesan sukses
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $matapelajaran = matapelajaran::findOrFail($id);

        // Hapus data
        $matapelajaran->delete();

        // Redirect ke index dengan pesan sukses
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus!');
    }

}
