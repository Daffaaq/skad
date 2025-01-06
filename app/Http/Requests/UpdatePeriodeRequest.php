<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeriodeRequest extends FormRequest
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
            'nama_periode' => 'required|string|max:255',
            'status_periode' => 'required|in:aktif,nonAktif',
            'periode_kepala_sekolah' => 'required|string|max:255',
            'periode_nip' => 'required|string|max:255',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->status_periode === 'aktif') {
                // Cek jika ada periode aktif yang sudah ada
                $existingActivePeriode = \App\Models\periode::where('status_periode', 'aktif')->first();

                if ($existingActivePeriode) {
                    // Jika ada periode aktif yang sudah ada, kirimkan error
                    $validator->errors()->add('status_periode', 'Hanya boleh ada satu periode aktif.');
                }
            }
        });
    }
}
