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
        Schema::create('siswatokelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id')->index(); // Siswa dapat memiliki beberapa entri
            $table->unsignedBigInteger('periode_id')->index(); // Periode ajaran
            $table->unsignedBigInteger('kelas_id')->index(); // Kelas saat ini
            $table->timestamps();

            // Relasi foreign key
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');

            // Kombinasi unik siswa + periode
            $table->unique(['siswa_id', 'periode_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswatokelas');
    }
};
