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
}
