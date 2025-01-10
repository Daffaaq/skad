<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa');
            $table->string('nama_panggilan_siswa');
            $table->string('nis')->unique();  // Nomor Induk Siswa (unik)
            $table->string('nisn')->unique();  // Nomor Induk Siswa (unik)
            $table->enum('jenis_kelamin_siswa', ['Laki-Laki', 'Perempuan']);
            $table->date('tanggal_lahir_siswa');
            $table->enum('agama_siswa', ['Islam', 'Kristen', 'Katolik', 'Budha', 'Hindu', 'Khonghucu']);
            $table->string('foto_siswa')->nullable(); // Menyimpan path foto siswa
            $table->string('no_hp_siswa')->nullable();
            $table->string('alamat_siswa');
            $table->unsignedBigInteger('user_id')->index();
            $table->year('tahun_masuk')->nullable();
            $table->string('nama_ayah_siswa')->nullable();
            $table->string('nama_ibu_siswa')->nullable();
            $table->string('no_hp_ibu_siswa')->nullable();
            $table->string('no_hp_ayah_siswa')->nullable();
            $table->string('pekerjaan_ibu_siswa')->nullable();
            $table->string('pekerjaan_ayah_siswa')->nullable();
            $table->date('tanggal_kelulusan')->nullable();
            $table->string('email_siswa')->nullable()->unique(); // Menyimpan email yang unik
            $table->enum('status_aktif_siswa', ['Aktif', 'Lulus', 'Dropout'])->default('Aktif');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
