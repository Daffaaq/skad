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
            $table->string('nip')->nullable();
            $table->enum('jenis_kelamin',['Laki-Laki','Perempuan']);
            $table->enum('status_guru',['PNS', 'Honorer']);
            $table->string('no_hp');
            $table->longText('alamat');
            $table->enum('agama_guru',['Islam', 'Kristen', 'Katolik', 'budha', 'hindu', 'khonghucu']);
            $table->unsignedBigInteger('user_id')->index();
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
