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
    $data = $pasien->jadwalTerapis->map(function ($jadwal) {
        return array_merge(
            $jadwal->toArray(),
            ['waktu' => JadwalTerapi::sesiWaktu()[$jadwal->sesi] ?? null]
        );
    });

    return response()->json($data);
}

    public function store(Request $request, $pasien)
    {
        $request->validate([
            'jenis_terapi' => 'required|string',
            'tanggal_terapi' => 'required|date',
            'sesi' => 'required|in:1,2,3,4,5',
        ]);

        // Maksimal 5 pasien per sesi
        $kuota = JadwalTerapi::where('tanggal_terapi', $request->tanggal_terapi)
            ->where('sesi', $request->sesi)
            ->count();

        if ($kuota >= 5) {
            return response()->json(['error' => 'Sesi ini sudah penuh. Maksimal 5 pasien.'], 422);
        }

        // Tidak boleh ada 2 pasien dengan jenis terapi yang sama di sesi dan tanggal yang sama
        $jenisTerapiSudahAda = JadwalTerapi::where('tanggal_terapi', $request->tanggal_terapi)
            ->where('sesi', $request->sesi)
            ->where('jenis_terapi', $request->jenis_terapi)
            ->exists();

        if ($jenisTerapiSudahAda) {
            return response()->json(['error' => 'Jenis terapi ini sudah digunakan di sesi ini. Harus berbeda setiap pasien.'], 422);
        }

        // Pasien tidak boleh daftar 2 kali di sesi yang sama
        $pasienSudahAda = JadwalTerapi::where('tanggal_terapi', $request->tanggal_terapi)
            ->where('sesi', $request->sesi)
            ->where('pasien_id', $pasien)
            ->exists();

        if ($pasienSudahAda) {
            return response()->json(['error' => 'Pasien sudah memiliki jadwal di sesi ini.'], 422);
        }

        // Simpan data jika valid
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

    public function statusBulan(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2020',
            'bulan' => 'required|integer|min:1|max:12',
            'jenis_terapi' => 'required|string'
        ]);

        $tahun = $request->input('tahun');
        $bulan = str_pad($request->input('bulan'), 2, '0', STR_PAD_LEFT);
        $jenisTerapiInput = strtolower($request->input('jenis_terapi'));

        $tanggalAwal = "{$tahun}-{$bulan}-01";
        $tanggalAkhir = date("Y-m-t", strtotime($tanggalAwal));

        $jadwals = JadwalTerapi::whereBetween('tanggal_terapi', [$tanggalAwal, $tanggalAkhir])
            ->get()
            ->groupBy('tanggal_terapi');

        $statusPerTanggal = [];

        foreach (
            new \DatePeriod(
                new \DateTime($tanggalAwal),
                new \DateInterval('P1D'),
                (new \DateTime($tanggalAkhir))->modify('+1 day')
            ) as $date
        ) {
            $tanggal = $date->format('Y-m-d');
            $jadwalTanggalIni = $jadwals[$tanggal] ?? collect();

            $jumlahSesiPenuh = 0;
            $jumlahSesiTerapiSama = 0;

            foreach (range(1, 5) as $sesi) {
                $sesiData = $jadwalTanggalIni->where('sesi', $sesi);

                $jumlah = $sesiData->count();
                $jenisTerapis = $sesiData->pluck('jenis_terapi')->map(fn($val) => strtolower($val))->unique();

                if ($jumlah >= 5) {
                    $jumlahSesiPenuh++;
                }

                if ($jenisTerapis->contains($jenisTerapiInput)) {
                    $jumlahSesiTerapiSama++;
                }
            }

            // Jika semua sesi penuh atau semua sesi sudah pakai jenis terapi tsb
            $status = ($jumlahSesiPenuh >= 5 || $jumlahSesiTerapiSama >= 5) ? 'penuh' : 'tersedia';

            $statusPerTanggal[] = [
                'tanggal' => $tanggal,
                'status' => $status,
            ];
        }

        return response()->json($statusPerTanggal);
    }


    public function statusTanggal(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_terapi' => 'required|string'
        ]);

        $tanggal = $request->input('tanggal');
        $jenisTerapiInput = $request->input('jenis_terapi');
        $response = [];

        foreach (range(1, 5) as $sesi) {
            $jadwal = JadwalTerapi::where('tanggal_terapi', $tanggal)
                ->where('sesi', $sesi)
                ->get();

            $jumlah = $jadwal->count();
            $jenisTerapis = $jadwal->pluck('jenis_terapi')->unique();

            // FIX: case-insensitive comparison
            $jenisSudahAda = $jenisTerapis
                ->map(fn($val) => strtolower($val))
                ->contains(strtolower($jenisTerapiInput));

            if ($jadwal->isEmpty()) {
                $status = 'tersedia';
            } elseif ($jenisSudahAda) {
                $status = 'penuh';
            } else {
                $status = ($jumlah < 5) ? 'tersedia' : 'penuh';
            }

            $response[] = [
                'sesi' => $sesi,
                'kuota' => "{$jumlah}/5",
                'status' => $status
            ];
        }

        return response()->json([
            'tanggal' => $tanggal,
            'sesi' => $response
        ]);
    }
}
