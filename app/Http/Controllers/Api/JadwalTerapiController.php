<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\JadwalTerapi;

class JadwalTerapiController extends Controller
{
    public function index(Pasien $pasien) {
        return $pasien->jadwalTerapis;
    }

    public function store(Request $request, Pasien $pasien) {
    $data = $request->validate([
        'jenis_terapi' => 'required|string',
        'tanggal_terapi' => 'required|date',
        'sesi' => 'required|in:1,2,3,4,5,6'
    ]);

    // Cek kuota
    $kuota = $pasien->jadwalTerapis()
        ->where('tanggal_terapi', $data['tanggal_terapi'])
        ->where('sesi', $data['sesi'])
        ->count();

    if ($kuota >= 6) {
        return response()->json([
            'message' => 'Sesi ini sudah penuh. Silakan pilih sesi lain.'
        ], 409);
    }

    $jadwal = $pasien->jadwalTerapis()->create($data);

    return response()->json($jadwal, 201);
}

    public function show(Pasien $pasien, JadwalTerapi $jadwal) {
        $this->authorizeJadwal($pasien, $jadwal);
        return $jadwal;
    }

    public function update(Request $request, Pasien $pasien, JadwalTerapi $jadwal) {
        $this->authorizeJadwal($pasien, $jadwal);
        $data = $request->validate([
            'jenis_terapi' => 'sometimes|required|string',
            'tanggal_terapi' => 'sometimes|required|date'
        ]);
        $jadwal->update($data);
        return $jadwal;
    }

    public function destroy(Pasien $pasien, JadwalTerapi $jadwal) {
        $this->authorizeJadwal($pasien, $jadwal);
        $jadwal->delete();
        return response()->json(['message' => 'Jadwal dihapus']);
    }

    protected function authorizeJadwal(Pasien $pasien, JadwalTerapi $jadwal) {
        if ($jadwal->pasien_id !== $pasien->id) {
            abort(404, 'Jadwal tidak ditemukan untuk pasien ini.');
        }
    }
}

