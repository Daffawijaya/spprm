<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\JadwalTerapi;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);

        $query = Pasien::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%")
                    ->orWhere('no_telepon', 'like', "%$search%")
                    ->orWhere('alamat', 'like', "%$search%")
                    ->orWhere('poli_asal', 'like', "%$search%")
                    ->orWhere('jenis_pasien', 'like', "%$search%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'nik' => ['required', 'digits:16', 'unique:pasiens,nik'],
            'alamat' => 'required',
            'no_telepon' => 'required|regex:/^08[0-9]{8,11}$/|unique:pasiens,no_telepon',
            'jenis_pasien' => 'required|in:BPJS,Mandiri',
            'berlaku_hingga' => 'nullable|date',
            'poli_asal' => 'required',
            'riwayat_medis' => 'nullable',
        ], [
            // Pesan error kustom
        ]);

        // Simpan data pasien
        $pasien = Pasien::create($validated);

        $email = $pasien->nik . '@pasien.app'; // atau ganti sesuai kebutuhan
        $defaultPassword = env('DEFAULT_USER_PASSWORD', 'default123');

        // Cek apakah user dengan email ini sudah ada
        if (User::where('email', $email)->exists()) {
            return response()->json([
                'message' => 'Akun pasien sudah ada.',
            ], 409);
        }

        // Buat akun login pasien
        $user = User::create([
            'name' => $pasien->nama,
            'email' => $email,
            'password' => Hash::make($defaultPassword),
            'role' => User::ROLE_PASIEN,
            'pasien_id' => $pasien->id,
        ]);

        return response()->json([
            'message' => 'Pasien dan akun login berhasil ditambahkan.',
            'data' => $pasien,
            'login' => [
                'email' => $user->email,
                'password' => $defaultPassword,
            ],
        ], 201);
    }

    public function show($id)
    {
        $pasien = Pasien::with('jadwalTerapis')->findOrFail($id);
        return response()->json([
            'message' => 'Detail pasien ditemukan.',
            'data' => $pasien
        ]);
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'nik' => ['required', 'digits:16', 'unique:pasiens,nik,' . $id],
            'alamat' => 'required',
            'no_telepon' => 'required|regex:/^08[0-9]{8,11}$/|unique:pasiens,no_telepon,' . $id,
            'jenis_pasien' => 'required|in:BPJS,Mandiri',
            'berlaku_hingga' => 'nullable|date',
            'poli_asal' => 'required',
            'riwayat_medis' => 'nullable',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar untuk pasien lain.',
        ]);

        $pasien->update($validated);

        return response()->json([
            'message' => 'Pasien berhasil diperbarui.',
            'data' => $pasien
        ]);
    }

    public function destroy($id)
    {
        Pasien::destroy($id);
        return response()->json([
            'message' => 'Pasien berhasil dihapus.'
        ]);
    }

    public function byTanggalSesi(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $sesi = $request->input('sesi');

        if (!$tanggal || !$sesi) {
            return response()->json([
                'message' => 'Tanggal dan sesi wajib diisi.'
            ], 400);
        }

        $pasienList = Pasien::whereHas('jadwalTerapis', function ($query) use ($tanggal, $sesi) {
            $query->where('tanggal_terapi', $tanggal)
                ->where('sesi', $sesi);
        })
            ->with(['jadwalTerapis' => function ($query) use ($tanggal, $sesi) {
                $query->where('tanggal_terapi', $tanggal)
                    ->where('sesi', $sesi);
            }])
            ->get();

        $waktu = JadwalTerapi::sesiWaktu()[$sesi] ?? '-';

        return response()->json([
            'message' => 'Data pasien berdasarkan sesi berhasil diambil.',
            'data' => [
                'jadwal' => [
                    'hari' => Carbon::parse($tanggal)->isoFormat('dddd'),
                    'tanggal' => $tanggal,
                    'waktu' => $waktu,
                    'jenis_terapi' => optional($pasienList->first()?->jadwalTerapis->first())->jenis_terapi ?? '-',
                ],
                'pasien' => $pasienList->map(function ($pasien) {
                    return [
                        'id' => $pasien->id,
                        'nama' => $pasien->nama,
                        'umur' => $pasien->umur,
                        'poli_asal' => $pasien->poli_asal,
                        'jenis_pasien' => $pasien->jenis_pasien,
                    ];
                }),
            ]
        ]);
    }
}
