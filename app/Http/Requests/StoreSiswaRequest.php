<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_siswa' => 'required|string|max:255',
            'nama_panggilan_siswa' => 'required|string|max:255',
            'nisn' => 'required|unique:siswas,nisn|string|max:20',
            'jenis_kelamin_siswa' => 'required|in:Laki-Laki,Perempuan',
            'tanggal_lahir_siswa' => 'required|date',
            'agama_siswa' => 'required|in:Islam,Kristen,Katolik,budha,hindu,khonghucu',
            'foto_siswa' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_hp_siswa' => 'nullable|string|max:15',
            'alamat_siswa' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'tahun_masuk' => 'required|integer|min:1900',
            'nama_ayah_siswa' => 'nullable|string|max:255',
            'nama_ibu_siswa' => 'nullable|string|max:255',
            'no_hp_ibu_siswa' => 'nullable|string|max:15',
            'no_hp_ayah_siswa' => 'nullable|string|max:15',
            'pekerjaan_ibu_siswa' => 'nullable|string|max:100',
            'pekerjaan_ayah_siswa' => 'nullable|string|max:100',
            'tanggal_kelulusan' => 'nullable|date',
            'email_siswa' => 'required|email|unique:siswas,email_siswa|max:255',
            'status_aktif_siswa' => 'required|in:Aktif,Lulus,Dropout',
        ];
    }
}
