<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\DataPenggunaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanRekamMedisController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SkriningKehamilanController;

// Saat akses utama, langsung redirect ke halaman login admin
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Route untuk login & register admin
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
    Route::resource('admin', AdminController::class);

    // Data Pengguna
    Route::resource('data-pengguna', DataPenggunaController::class);

    // Manajemen User
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::resource('users', UserController::class);

    // data pasien
    Route::get('/data-pasien', [UserController::class, 'index'])->name('data-pasien.index');
    Route::get('/rekam-medis/{id}/pdf', [RekamMedisController::class, 'generatePDF'])->name('rekam-medis.pdf');
    Route::get('/laporan/bulanan', [LaporanController::class, 'laporanBulanan'])->name('laporan.bulanan');

    // Route::get('/admin/profile', [AdminController::class, 'showProfile'])->name('admin.profile.profile');
    Route::get('/admin/profile', [AdminController::class, 'show'])->name('admin.profile.show');
    Route::get('/admin/profile/edit', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    Route::post('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/skrining', [SkriningKehamilanController::class, 'index'])->name('admin.skrining.index');
    Route::get('/skrining/{id}', [SkriningKehamilanController::class, 'show'])->name('admin.skrining.show');
    Route::get('/admin/skrining/riwayat/{user_id}', [SkriningKehamilanController::class, 'riwayatAdmin'])->name('admin.skrining.riwayat');


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
