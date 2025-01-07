<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tingkat extends Model
{
    use HasFactory;

    protected $table = 'tingkats';

    protected $fillable = [
        'nama_tingkat',
    ];

    public function kelas()
    {
        return $this->hasMany(kelas::class);
    }
}
