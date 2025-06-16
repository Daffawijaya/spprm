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
    Schema::create('pasiens', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->integer('umur');
        $table->enum('jenis_kelamin', ['L', 'P']);
        $table->string('nik', 16)->unique();
        $table->text('alamat');
        $table->string('no_telepon')->unique();;
        $table->enum('jenis_pasien', ['BPJS', 'Mandiri']);
        $table->date('berlaku_hingga')->nullable();
        $table->string('poli_asal');
        $table->text('riwayat_medis')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
