<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PasienController;
use App\Http\Controllers\Api\JadwalTerapiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('pasien', PasienController::class);

Route::prefix('pasien/{pasien}')->group(function () {
    Route::get('jadwal', [JadwalTerapiController::class, 'index']);
    Route::post('jadwal', [JadwalTerapiController::class, 'store']);
    Route::get('jadwal/{jadwal}', [JadwalTerapiController::class, 'show']);
    Route::put('jadwal/{jadwal}', [JadwalTerapiController::class, 'update']);
    Route::delete('jadwal/{jadwal}', [JadwalTerapiController::class, 'destroy']);
});