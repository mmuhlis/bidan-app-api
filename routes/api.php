<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\DataPenggunaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('bidan')->group(function () {
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout']);

    Route::get('rekam-medis', [RekamMedisController::class, 'getAllRekamMedis']);   // Lihat semua rekam medis
    Route::get('data-pasien', [UserController::class, 'getByPasien']);
    Route::get('data-pengguna', [DataPenggunaController::class, 'getUsers']);

    Route::middleware(['auth:sanctum', 'user.type:bidan'])->group(function () {
        //Route::get('profile', [AdminController::class, 'ProfileAdmin']);

        // Route::get('profile', [AdminController::class, 'Profile']);

        //Route::get('rekam-medis', [RekamMedisController::class, 'getAllRekamMedis']);
        // Route::get('rekam-medis', [RekamMedisController::class, 'getAllRekamMedis']);   // Lihat semua rekam medis

        // Route::get('users/list', [AdminController::class, 'listUsers']);
        // Route::post('logout', [AdminController::class, 'logout']);
        // Route::put('update/profile', [AdminController::class, 'updateProfile']);
        // Route::get('users/search', [AdminController::class, 'searchUsers']);
        // Route::get('users/{id}', [AdminController::class, 'getUser']);
        // Route::put('users/{id}', [AdminController::class, 'updateUser']);
        // Route::delete('users/{id}', [AdminController::class, 'deleteUser']);


        // ✨ Fitur Rekam Medis untuk Bidan/Admin ✨
        // Route::post('rekam-medis', [RekamMedisController::class, 'store']);  // Buat rekam medis
        // Route::get('rekam-medis', [RekamMedisController::class, 'index']);   // Lihat semua rekam medis
        // Route::put('rekam-medis/{id}', [RekamMedisController::class, 'update']);
        // Route::delete('rekam-medis/{id}', [RekamMedisController::class, 'destroy']);
    });
});



Route::prefix('user')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [UserAuthController::class, 'logout']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('rekam-medis', [RekamMedisController::class, 'getByUser']);  // Pasien melihat rekam medisnya
        // Route::get('data-pasien', [UserController::class, 'getByPasien']);
        // Route::get('data-pengguna', [DataPenggunaController::class, 'getUsers']);
        // Route::post('logout', [UserController::class, 'logout']);
        // Route::get('profile', [UserController::class, 'profile']);
        // Route::put('profile/update', [UserController::class, 'updateProfile']);

        // ✨ Fitur Rekam Medis untuk Pasien ✨
        // Route::get('rekam-medis', [RekamMedisController::class, 'getByUser']);  // Pasien melihat rekam medisnya
    });
});














// Route::prefix('bidan')->group(function () {
//     Route::post('/register', [AdminController::class, 'register']);
//     Route::post('/login', [AdminController::class, 'login']);

//     Route::middleware(['auth:sanctum', 'user.type:bidan'])->group(function () {
//         Route::get('users/list', [AdminController::class, 'listUsers']);
//         Route::post('logout', [AdminController::class, 'logout']);
//         Route::get('profile', [AdminController::class, 'profile']);
//         Route::put('update/profile', [AdminController::class, 'updateProfile']);
//         Route::get('users/search', [AdminController::class, 'searchUsers']);
//         Route::get('users/{id}', [AdminController::class, 'getUser']);
//         Route::put('users/{id}', [AdminController::class, 'updateUser']);
//         Route::delete('users/{id}', [AdminController::class, 'deleteUser']);


//         // ✨ Fitur Rekam Medis untuk Bidan/Admin ✨
//         Route::post('rekam-medis', [RekamMedisController::class, 'store']);  // Buat rekam medis
//         Route::get('rekam-medis', [RekamMedisController::class, 'index']);   // Lihat semua rekam medis
//         Route::put('rekam-medis/{id}', [RekamMedisController::class, 'update']);
//         Route::delete('rekam-medis/{id}', [RekamMedisController::class, 'destroy']);
//     });
// });

// Route::prefix('user')->group(function () {
//     Route::post('/register', [UserController::class, 'register']);
//     Route::post('/login', [UserController::class, 'login']);

//     Route::middleware(['auth:sanctum', 'user.type:user'])->group(function () {
//         Route::post('logout', [UserController::class, 'logout']);
//         Route::get('profile', [UserController::class, 'profile']);
//         Route::put('profile/update', [UserController::class, 'updateProfile']);

//         // ✨ Fitur Rekam Medis untuk Pasien ✨
//         Route::get('rekam-medis', [RekamMedisController::class, 'getByUser']);  // Pasien melihat rekam medisnya
//     });
// });
