<?php

namespace App\Http\Controllers;

use App\Models\periode;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePeriodeRequest;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user.index')->only('index');
        $this->middleware('permission:user.create')->only('create', 'store');
        $this->middleware('permission:user.edit')->only('edit', 'update');
        $this->middleware('permission:user.destroy')->only('destroy');
    }

    public function getActivePeriode()
    {
        // Mengambil periode dengan status 'aktif'
        $activePeriode = periode::where('status_periode', 'aktif')->first();

        return response()->json($activePeriode);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // mengambil data
        $periodes = DB::table('periodes')
            ->when($request->input('nama_periode'), function ($query, $nama_periode) {
                return $query->where('nama_periode', 'like', '%' . $nama_periode . '%');
            })
            ->select('id', 'nama_periode', 'status_periode', 'periode_kepala_sekolah', 'periode_nip')
            ->paginate(10);
        return view('periode.index', compact('periodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('periode.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePeriodeRequest $request)
    {
        // Mengambil data yang sudah tervalidasi
        $validatedData = $request->validated();

        // Menyimpan data periode baru
        $periode = Periode::create($validatedData);

        return redirect(route('periode.index'))->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(periode $periode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(periode $periode)
    {
        return view('periode.edit')
            ->with('periode', $periode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePeriodeRequest $request, periode $periode)
    {
        // Mengambil data yang sudah tervalidasi
        $validatedData = $request->validated();

        // Update data periode
        $periode->update($validatedData);

        // Redirect kembali ke halaman daftar periode dengan pesan sukses
        return redirect(route('periode.index'))->with('success', 'Data Periode Berhasil Diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(periode $periode)
    {
        // Cek apakah periode yang akan dihapus adalah periode aktif
        if ($periode->status_periode === 'aktif') {
            return redirect()->route('periode.index')->with('error', 'Tidak dapat menghapus periode yang sedang aktif.');
        }
        $periode->delete();
        return redirect()->route('periode.index')->with('success', 'Periode Deleted Successfully');
    }
}
