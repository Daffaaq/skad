<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nama_siswa',
        'nis',
        'jenis_kelamin_siswa',
        'tanggal_lahir_siswa',
        'agama_siswa',
        'foto_siswa',
        'no_hp_siswa',
        'alamat_siswa',
        'user_id',
        'tahun_masuk',
        'nama_ayah_siswa',
        'nama_ibu_siswa',
        'no_hp_ibu_siswa',
        'no_hp_ayah_siswa',
        'pekerjaan_orang_tua',
        'tanggal_kelulusan',
        'email_siswa',
        'status_aktif_siswa',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
