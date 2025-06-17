<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jadwal_terapis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->string('jenis_terapi');
            $table->date('tanggal_terapi');
            $table->unsignedTinyInteger('sesi'); // 1 - 5
            $table->timestamps();

            $table->unique(['tanggal_terapi', 'sesi', 'pasien_id']); // pasien tidak boleh duplikat sesi
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_terapis');
    }
};
