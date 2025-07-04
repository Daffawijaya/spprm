<?php

use App\Http\Controllers\Api\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PasienController;
use App\Http\Controllers\Api\JadwalTerapiController;

use App\Http\Controllers\Api\AuthController;

Route::group(['prefix'=>'auth'], function(){
  Route::post('login', [AuthController::class,'login']);
  Route::post('logout', [AuthController::class,'logout'])->middleware('auth:api');
  Route::post('refresh', [AuthController::class,'refresh'])->middleware('auth:api');
  Route::get('me', [AuthController::class,'me'])->middleware('auth:api');
});


Route::get('/dashboard-summary', [DashboardController::class, 'summary']);

Route::get('pasien/by-jadwal', [PasienController::class, 'byTanggalSesi']);

Route::apiResource('pasien', PasienController::class);

Route::get('pasien/{pasien}/jadwal', [JadwalTerapiController::class, 'index']);
Route::post('pasien/{pasien}/jadwal', [JadwalTerapiController::class, 'store']);
Route::get('pasien/{pasien}/jadwal/{jadwal}', [JadwalTerapiController::class, 'show']);
Route::put('pasien/{pasien}/jadwal/{jadwal}', [JadwalTerapiController::class, 'update']);
Route::delete('pasien/{pasien}/jadwal/{jadwal}', [JadwalTerapiController::class, 'destroy']);

// Endpoint tambahan
Route::get('status/bulan', [JadwalTerapiController::class, 'statusBulan']);
Route::get('status/tanggal', [JadwalTerapiController::class, 'statusTanggal']);

