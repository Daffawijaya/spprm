<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalTerapi extends Model
{
    protected $fillable = [
        'pasien_id', 'tanggal_terapi', 'sesi', 'jenis_terapi'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public static function sesiWaktu()
    {
        return [
            1 => '07.30-09.00',
            2 => '09.00-10.30',
            3 => '10.30-12.00',
            4 => '13.00-14.30',
            5 => '14.30-16.00',
        ];
    }
}
