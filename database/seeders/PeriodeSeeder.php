<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('periodes')->insert([
            [
                'nama_periode' => '2024/2025',
                'status_periode' => 'nonAktif',
                'periode_kepala_sekolah' => 'Dr. Ahmad Fauzi',
                'periode_nip' => '198405112010011002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_periode' => '2023/2024',
                'status_periode' => 'nonAktif',
                'periode_kepala_sekolah' => 'Siti Nurhayati, M.Pd',
                'periode_nip' => '197504112009042001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_periode' => '2022/2023',
                'status_periode' => 'nonAktif',
                'periode_kepala_sekolah' => 'Budi Santoso',
                'periode_nip' => '197112131998021001',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
