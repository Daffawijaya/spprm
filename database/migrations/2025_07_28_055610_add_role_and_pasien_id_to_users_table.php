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
        Schema::table('users', function (Blueprint $table) {
            // Jangan tambahkan kolom 'role' karena sudah ada
            if (!Schema::hasColumn('users', 'pasien_id')) {
                $table->foreignId('pasien_id')->nullable()->constrained('pasiens')->onDelete('cascade');
            }
        });
    }


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['pasien_id']);
            $table->dropColumn('pasien_id');
            $table->dropColumn('role');
        });
    }
};
