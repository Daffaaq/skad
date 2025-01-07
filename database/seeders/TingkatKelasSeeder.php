<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TingkatKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambahkan data tingkat
        $tingkats = [
            ['nama_tingkat' => 'Kelas VII'],
            ['nama_tingkat' => 'Kelas VIII'],
            ['nama_tingkat' => 'Kelas IX'],
        ];

        DB::table('tingkats')->insert($tingkats);

        // Data kelas (A, B, C, D untuk setiap tingkat)
        $kelas = [];

        // Loop untuk setiap tingkat dan kelas A, B, C, D
        foreach (range(1, 3) as $tingkatId) {
            $kelas_array = array_map(function ($letter) use ($tingkatId) {
                return [
                    'nama_kelas' => $letter, // A, B, C, D
                    'tingkat_id' => $tingkatId // ID tingkatnya (1 = VII, 2 = VIII, 3 = IX)
                ];
            }, ['A', 'B', 'C', 'D', 'E']); // A, B, C, D untuk setiap tingkat

            // Menambahkan kelas ke dalam array
            $kelas = array_merge($kelas, $kelas_array);
        }

        // Menyisipkan semua data kelas ke database
        DB::table('kelas')->insert($kelas);
    }
}
