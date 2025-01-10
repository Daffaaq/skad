<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class periode extends Model
{
    use HasFactory;


    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'periodes';

    // Tentukan kolom yang dapat diisi mass-assignable
    protected $fillable = [
        'nama_periode',
        'status_periode',
        'periode_kepala_sekolah',
        'periode_nip',
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}
