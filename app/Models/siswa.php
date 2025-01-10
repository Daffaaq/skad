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
        'nama_panggilan_siswa',
        'nis',
        'nisn',
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
        'pekerjaan_ibu_siswa',
        'pekerjaan_ayah_siswa',
        'tanggal_kelulusan',
        'email_siswa',
        'status_aktif_siswa',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'siswatokelas', 'siswa_id', 'kelas_id')
            ->withPivot('periode_id')
            ->withTimestamps();
    }

    public function jadwals()
    {
        return $this->hasManyThrough(Jadwal::class, SiswaToKelas::class, 'siswa_id', 'kelas_id', 'id', 'kelas_id');
    }

    public function siswatokelas()
    {
        return $this->hasMany(Siswatokelas::class, 'siswa_id');
    }
}
