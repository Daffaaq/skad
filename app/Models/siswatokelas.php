<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswatokelas extends Model
{
    use HasFactory;

    protected $table = 'siswatokelas';

    protected $fillable = [
        'siswa_id',
        'periode_id',
        'kelas_id'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
