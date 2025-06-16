<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\JadwalTerapi;

class JadwalTerapiController extends Controller
{
    public function index(Pasien $pasien)
    {
        return $pasien->jadwalTerapis;
    }

    public function store(Request $request, $pasien)
    {
        $request->validate([
            'jenis_terapi' => 'required|string',
            'tanggal_terapi' => 'required|date',
            'sesi' => 'required|in:1,2,3,4,5,6',
        ]);

        // Validasi dan logika tetap sama
        $kuota = JadwalTerapi::where('tanggal_terapi', $request->tanggal_terapi)
            ->where('sesi', $request->sesi)
            ->count();

        if ($kuota >= 5) {
            return response()->json(['error' => 'Sesi ini sudah penuh. Maksimal 5 pasien.'], 422);
        }

        $terapiSudahAda = JadwalTerapi::where('tanggal_terapi', $request->tanggal_terapi)
            ->where('sesi', $request->sesi)
            ->where('jenis_terapi', $request->jenis_terapi)
            ->exists();

        if ($terapiSudahAda) {
            return response()->json(['error' => 'Jenis terapi ini sudah digunakan di sesi ini.'], 422);
        }

        $pasienSudahAda = JadwalTerapi::where('tanggal_terapi', $request->tanggal_terapi)
            ->where('sesi', $request->sesi)
            ->where('pasien_id', $pasien)
            ->exists();

        if ($pasienSudahAda) {
            return response()->json(['error' => 'Pasien sudah memiliki jadwal di sesi ini.'], 422);
        }

        $jadwal = JadwalTerapi::create([
            'pasien_id' => $pasien,
            'jenis_terapi' => $request->jenis_terapi,
            'tanggal_terapi' => $request->tanggal_terapi,
            'sesi' => $request->sesi,
        ]);

        return response()->json(['message' => 'Jadwal berhasil dibuat', 'data' => $jadwal]);
    }


    public function show(Pasien $pasien, JadwalTerapi $jadwal)
    {
        $this->authorizeJadwal($pasien, $jadwal);
        return $jadwal;
    }

    public function update(Request $request, Pasien $pasien, JadwalTerapi $jadwal)
    {
        $this->authorizeJadwal($pasien, $jadwal);
        $data = $request->validate([
            'jenis_terapi' => 'sometimes|required|string',
            'tanggal_terapi' => 'sometimes|required|date'
        ]);
        $jadwal->update($data);
        return $jadwal;
    }

    public function destroy(Pasien $pasien, JadwalTerapi $jadwal)
    {
        $this->authorizeJadwal($pasien, $jadwal);
        $jadwal->delete();
        return response()->json(['message' => 'Jadwal dihapus']);
    }

    protected function authorizeJadwal(Pasien $pasien, JadwalTerapi $jadwal)
    {
        if ($jadwal->pasien_id !== $pasien->id) {
            abort(404, 'Jadwal tidak ditemukan untuk pasien ini.');
        }
    }
}
