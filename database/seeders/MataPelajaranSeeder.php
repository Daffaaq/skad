<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data mata pelajaran dengan kode singkat
        $mataPelajaran = [
            ['nama_matapelajaran' => 'Matematika', 'kode_matapelajaran' => 'MAT'],
            ['nama_matapelajaran' => 'Bahasa Indonesia', 'kode_matapelajaran' => 'BINDO'],
            ['nama_matapelajaran' => 'Bahasa Inggris', 'kode_matapelajaran' => 'BING'],
            ['nama_matapelajaran' => 'Ilmu Pengetahuan Alam (IPA)', 'kode_matapelajaran' => 'IPA'],
            ['nama_matapelajaran' => 'Ilmu Pengetahuan Sosial (IPS)', 'kode_matapelajaran' => 'IPS'],
            ['nama_matapelajaran' => 'Pendidikan Agama Islam', 'kode_matapelajaran' => 'PAI'],
            ['nama_matapelajaran' => 'Pendidikan Agama Kristen', 'kode_matapelajaran' => 'PAK'],
            ['nama_matapelajaran' => 'Pendidikan Agama Katolik', 'kode_matapelajaran' => 'PAKOL'],
            ['nama_matapelajaran' => 'Pendidikan Agama Buddha', 'kode_matapelajaran' => 'PABUD'],
            ['nama_matapelajaran' => 'Pendidikan Agama Hindu', 'kode_matapelajaran' => 'PAHIN'],
            ['nama_matapelajaran' => 'Pendidikan Agama Khonghucu', 'kode_matapelajaran' => 'PAKH'],
            ['nama_matapelajaran' => 'Pendidikan Kewarganegaraan (PKN)', 'kode_matapelajaran' => 'PKN'],
            ['nama_matapelajaran' => 'Seni Budaya', 'kode_matapelajaran' => 'SBD'],
            ['nama_matapelajaran' => 'Pendidikan Jasmani dan Kesehatan', 'kode_matapelajaran' => 'PJOK'],
            ['nama_matapelajaran' => 'Teknologi Informasi dan Komunikasi (TIK)', 'kode_matapelajaran' => 'TIK'],
            ['nama_matapelajaran' => 'Prakarya dan Kewirausahaan', 'kode_matapelajaran' => 'PKW'],
            ['nama_matapelajaran' => 'Bahasa Jawa', 'kode_matapelajaran' => 'Baja'],
        ];

        // Insert data into the table
        DB::table('matapelajarans')->insert($mataPelajaran);
    }
}
