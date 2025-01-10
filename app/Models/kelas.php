<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat_id',
    ];

    public function tingkat()
    {
        return $this->belongsTo(tingkat::class, 'tingkat_id');
    }

    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'siswatokelas', 'kelas_id', 'siswa_id')
        ->withPivot('periode_id')
        ->withTimestamps();
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}
