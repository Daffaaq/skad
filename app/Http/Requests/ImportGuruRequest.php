<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportGuruRequest extends FormRequest
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
            'nama_guru' => 'required|string|max:255',
            'nama_pendek_guru' => 'required|string|max:255',
            'email_guru' => 'required|email|unique:users,email',
            'no_hp_guru' => 'required|string|max:15',
            'jenis_kelamin_guru' => 'required|in:Laki-Laki,Perempuan',
            'status_guru' => 'required|in:PNS,Honorer',
            'status_perkawinan_guru' => 'required|in:Belum Menikah,Menikah,Duda,Janda',
            'agama_guru' => 'required|in:Islam,Kristen,Katolik,Budha,Hindu,Khonghucu',
            'status_aktif_guru' => 'required|in:Aktif,Pensiun',
            'tanggal_bergabung' => 'required|date',
            'alamat_guru' => 'required|string|max:255',
        ];
    }
}
