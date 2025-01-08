<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateguruRequest extends FormRequest
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
            'nip' => 'nullable|string|max:255',
            'jenis_kelamin_guru' => 'required|in:Laki-Laki,Perempuan',
            'status_guru' => 'required|in:PNS,Honorer',
            'no_hp_guru' => 'required|string|max:255',
            'alamat_guru' => 'required|string|max:255',
            'tanggal_lahir_guru' => 'nullable|date',
            'agama_guru' => 'required|in:Islam,Kristen,Katolik,budha,hindu,khonghucu',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'tanggal_bergabung' => 'nullable|date',
            'email_guru' => 'required|string|email|max:255|' . Rule::unique('gurus')->ignore($this->route('guru')),
            'foto_guru' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_aktif_guru' => 'required|in:Aktif,Pensiun',
        ];
    }
}
