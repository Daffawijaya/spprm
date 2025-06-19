<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PasienController;
use App\Http\Controllers\Api\JadwalTerapiController;

Route::apiResource('pasien', PasienController::class);

Route::get('pasien/{pasien}/jadwal', [JadwalTerapiController::class, 'index']);
Route::post('pasien/{pasien}/jadwal', [JadwalTerapiController::class, 'store']);
Route::get('pasien/{pasien}/jadwal/{jadwal}', [JadwalTerapiController::class, 'show']);
Route::put('pasien/{pasien}/jadwal/{jadwal}', [JadwalTerapiController::class, 'update']);
Route::delete('pasien/{pasien}/jadwal/{jadwal}', [JadwalTerapiController::class, 'destroy']);

// Endpoint tambahan
Route::get('status/bulan', [JadwalTerapiController::class, 'statusBulan']);
Route::get('status/tanggal', [JadwalTerapiController::class, 'statusTanggal']);