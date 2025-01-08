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
}
