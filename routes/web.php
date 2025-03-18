<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\DataPenggunaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanRekamMedisController;

// Saat akses utama, langsung redirect ke halaman login admin
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Route untuk login & register admin, dengan middleware untuk mencegah akses jika sudah login
Route::middleware(['guest:admin'])->group(function () {
    Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

    Route::get('/admin/register', [AdminController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/admin/register', [AdminController::class, 'register']);
});

// Middleware untuk admin (bidan) yang sudah login
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    // Logout tetap bisa diakses tanpa middleware `guest`
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');






    // Data Pengguna
    Route::resource('data-pengguna', DataPenggunaController::class);
    // Manajemen User
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::resource('users', UserController::class);


    // data pasien
    Route::get('/data-pasien', [UserController::class, 'index'])->name('data-pasien.index');
    // Route::get('/rekam-medis/{id}/pdf', [RekamMedisController::class, 'generatePDF'])->name('rekam-medis.pdf');




    // Manajemen Rekam Medis
    Route::prefix('rekam-medis')->name('rekam-medis.')->group(function () {
        Route::get('/', [RekamMedisController::class, 'index'])->name('index');
        Route::get('/create', [RekamMedisController::class, 'create'])->name('create');
        Route::post('/', [RekamMedisController::class, 'store'])->name('store');
        Route::get('/{id}', [RekamMedisController::class, 'show'])->name('show');
        Route::get('{id}/edit', [RekamMedisController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RekamMedisController::class, 'update'])->name('update');
        Route::delete('/{id}', [RekamMedisController::class, 'destroy'])->name('destroy');
    });
});




























// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\AdminAuthController;
// use App\Http\Controllers\AdminController;
// use App\Http\Controllers\RekamMedisController;
// use App\Http\Controllers\DataPenggunaController;
// use App\Http\Controllers\UserController;

// // Saat akses utama, langsung redirect ke halaman login admin
// Route::get('/', function () {
//     return redirect()->route('admin.login');
// });

// // Route untuk login admin
// Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
// Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
// Route::post('/admin/register', [AdminAuthController::class, 'register']);

// Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
// Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// // Middleware untuk admin (bidan)
// Route::middleware(['auth:admin'])->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard')->middleware('auth:admin');
//     Route::get('/data-pengguna', [DataPenggunaController::class, 'index'])->name('data-pengguna.index');


//     Route::post('/users/store', [UserController::class, 'store'])->name('users.store');


//     Route::get('/rekam-medis', [RekamMedisController::class, 'index'])->name('rekam-medis.index');
//     Route::get('/rekam-medis/{id}', [RekamMedisController::class, 'show'])->name('rekam-medis.show');
//     Route::get('/rekam-medis/create', [RekamMedisController::class, 'create'])->name('rekam-medis.create');
//     Route::post('/rekam-medis', [RekamMedisController::class, 'store'])->name('rekam-medis.store');
//     Route::get('/rekam-medis/{id}/edit', [RekamMedisController::class, 'edit'])->name('rekam-medis.edit');
//     Route::put('/rekam-medis/{id}', [RekamMedisController::class, 'update'])->name('rekam-medis.update');
//     Route::delete('/rekam-medis/{id}', [RekamMedisController::class, 'destroy'])->name('rekam-medis.destroy');


//     // Route::get('/rekam-medis', [RekamMedisController::class, 'index'])->name('rekam-medis.index');
//     // Route::get('/rekam-medis/create', [RekamMedisController::class, 'create'])->name('rekam-medis.create');
//     // Route::post('/rekam-medis', [RekamMedisController::class, 'store'])->name('rekam-medis.store');
// });
