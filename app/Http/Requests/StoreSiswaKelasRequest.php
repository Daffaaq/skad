<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaKelasRequest extends FormRequest
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
            'siswa_id' => 'required|array|min:1', // Harus array dan minimal pilih 1 siswa
            'siswa_id.*' => 'exists:siswas,id', // Setiap elemen array harus valid
            'kelas_id' => 'required|exists:kelas,id',
        ];
    }
}
