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
        'nik' => ['required', 'digits:16', 'unique:pasiens,nik'],
        'alamat' => 'required',
        'no_telepon' => 'required|regex:/^08[0-9]{8,11}$/|unique:pasiens,no_telepon',
        'jenis_pasien' => 'required|in:BPJS,Mandiri',
        'berlaku_hingga' => 'nullable|date',
        'poli_asal' => 'required',
        'riwayat_medis' => 'nullable'
    ], [
        'nik.required' => 'NIK wajib diisi.',
        'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
        'nik.unique' => 'NIK ini sudah terdaftar.',
        'nama.required' => 'Nama wajib diisi.',
        'umur.required' => 'Umur wajib diisi.',
        'umur.integer' => 'Umur harus berupa angka.',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        'jenis_kelamin.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
        'alamat.required' => 'Alamat wajib diisi.',
        'no_telepon.required' => 'Nomor telepon wajib diisi.',
        'jenis_pasien.required' => 'Jenis pasien wajib dipilih.',
        'jenis_pasien.in' => 'Jenis pasien harus BPJS atau Mandiri.',
        'poli_asal.required' => 'Poli asal wajib diisi.',
        'berlaku_hingga.date' => 'Format tanggal tidak valid.',
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
        'riwayat_medis' => 'nullable'
    ], [
        'nik.required' => 'NIK wajib diisi.',
        'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
        'nik.unique' => 'NIK ini sudah terdaftar untuk pasien lain.',
        // tambahkan pesan lainnya seperti di store()
    ]);

    $pasien->update($validated);
    return $pasien;
}


    public function destroy($id) {
        Pasien::destroy($id);
        return response()->json(['message' => 'Pasien dihapus']);
    }
}
