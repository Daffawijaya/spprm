<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\JadwalTerapi;

class DashboardController extends Controller
{
    public function summary()
    {
        $totalPasien = Pasien::count();
        $totalJadwal = JadwalTerapi::count();

        return response()->json([
            'total_pasien' => $totalPasien,
            'total_jadwal' => $totalJadwal,
        ]);
    }
}
