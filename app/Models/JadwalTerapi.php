<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalTerapi extends Model
{
   protected $fillable = ['pasien_id', 'jenis_terapi', 'tanggal_terapi'];

   public function pasien()
{
    return $this->belongsTo(Pasien::class);
}

}
