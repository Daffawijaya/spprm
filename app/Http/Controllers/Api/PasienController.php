<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;

class PasienController extends Controller
{
    public function index() {
        return Pasien::all();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama' => 'required|string',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'nik' => 'required|unique:pasiens',
            'alamat' => 'required',
            'no_telepon' => 'required',
            'jenis_pasien' => 'required|in:BPJS,Mandiri',
            'berlaku_hingga' => 'nullable|date',
            'poli_asal' => 'required',
            'riwayat_medis' => 'nullable'
        ]);

        return Pasien::create($validated);
    }

    public function show($id) 
    {
    $pasien = Pasien::with('jadwalTerapis')->findOrFail($id);
    return response()->json($pasien);
}

    public function update(Request $request, $id) {
        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->all());
        return $pasien;
    }

    public function destroy($id) {
        Pasien::destroy($id);
        return response()->json(['message' => 'Pasien dihapus']);
    }
}
