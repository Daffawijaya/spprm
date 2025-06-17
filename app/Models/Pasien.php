<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $fillable = [
        'nama', 'umur', 'jenis_kelamin', 'nik', 'alamat', 'no_telepon',
        'jenis_pasien', 'berlaku_hingga', 'poli_asal', 'riwayat_medis',
    ];

    public function jadwalTerapis()
    {
        return $this->hasMany(JadwalTerapi::class);
    }
}


