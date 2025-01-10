<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals';

    protected $fillable = [
        'guru_id',
        'periode_id',
        'kelas_id',
        'matapelajaran_id',
        'hari',
        'jam_mulai',
        'jam_selesai'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function matapelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'matapelajaran_id');
    }
}
