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
    Schema::create('jadwal_terapis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pasien_id')->constrained()->onDelete('cascade');
        $table->string('jenis_terapi');
        $table->date('tanggal_terapi');
        $table->enum('sesi', ['1', '2', '3', '4', '5']);
        $table->timestamps();
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
