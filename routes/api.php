<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\DataPenggunaController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkriningKehamilanController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('bidan')->group(function () {
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout']);

    Route::get('skrining', [SkriningKehamilanController::class, 'semua']);

    Route::get('rekam-medis', [RekamMedisController::class, 'getAllRekamMedis']);   // Lihat semua rekam medis
    Route::get('data-pasien', [UserController::class, 'getByPasien']);
    Route::get('data-pengguna', [DataPenggunaController::class, 'getUsers']);
    Route::get('/{id}', [AdminAuthController::class, 'getAdminById']);
    Route::put('/{id}', [AdminAuthController::class, 'updateProfile']);

    Route::middleware(['auth:sanctum', 'user.type:bidan'])->group(function () {
        //
    });
});



Route::prefix('user')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout']);

    // Route::get('rekam-medis', [RekamMedisController::class, 'getByUserRekamMedis']);
    Route::middleware(['auth:sanctum'])->group(function () {

        Route::get('rekam-medis', [RekamMedisController::class, 'getByUserRekamMedis']);  // Pasien melihat rekam medisnya
        Route::get('/{id}', [UserAuthController::class, 'getPasienById']);
        Route::put('/{id}', [UserAuthController::class, 'updateProfile']);

        Route::post('/skrining', [SkriningKehamilanController::class, 'store']);
        Route::get('/skrining/{user_id}', [SkriningKehamilanController::class, 'riwayat']);



        // Route::get('/skrining/result', [SkriningKehamilanController::class, 'result']);
    });
});
