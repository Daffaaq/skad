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
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_guru');
            $table->string('nip')->nullable()->unique();
            $table->enum('jenis_kelamin_guru',['Laki-Laki','Perempuan']);
            $table->enum('status_guru',['PNS', 'Honorer']);
            $table->string('no_hp_guru');
            $table->longText('alamat_guru');
            $table->date('tanggal_lahir_guru')->nullable(); // Nullable jika tidak ingin wajib diisi
            $table->enum('agama_guru',['Islam', 'Kristen', 'Katolik', 'budha', 'hindu', 'khonghucu']);
            $table->string('foto_guru')->nullable(); // Menyimpan path foto guru
            $table->date('tanggal_bergabung')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('email_guru')->unique(); // Menyimpan email yang unik
            $table->enum('status_aktif_guru', ['Aktif', 'Pensiun'])->default('Aktif');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
