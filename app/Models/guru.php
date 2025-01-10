<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';

    protected $fillable = [
        'nama_guru',
        'nama_pendek_guru',
        'nomor_sk',
        'status_perkawinan_guru',
        'kode_guru',
        'jabatan_guru',
        'nip',
        'jenis_kelamin_guru',
        'status_guru',
        'no_hp_guru',
        'alamat_guru',
        'tanggal_lahir_guru',
        'agama_guru',
        'foto_guru',
        'tanggal_bergabung',
        'pendidikan_terakhir',
        'user_id',
        'email_guru',
        'status_aktif_guru',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'guru_id');
    }

    public function siswas()
    {
        return $this->hasManyThrough(Siswa::class, Jadwal::class, 'guru_id', 'kelas_id', 'id', 'kelas_id');
    }
}
