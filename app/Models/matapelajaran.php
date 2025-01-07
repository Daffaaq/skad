<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matapelajaran extends Model
{
    use HasFactory;

    // Menentukan nama tabel (jika tidak mengikuti konvensi plural)
    protected $table = 'matapelajarans';

    // Menentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'nama_matapelajaran',
        'kode_matapelajaran',
    ];
}
