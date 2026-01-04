<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\Penyusutan\PenyusutanController;
use App\Http\Controllers\Penyusutan\PenyusutanSettingController;
use App\Http\Controllers\Pelaporan\TambahPelaporanController;
use App\Http\Controllers\Pelaporan\PelaporanMasukController;
use App\Http\Controllers\Pelaporan\CekPelaporanController;
use App\Http\Controllers\Pelaporan\PelaporanSelesaiController;


// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::group(['middleware'  => 'CheckRole:admin,staf,manager'], function () {
    // Route::group(['middleware'], function () {
        Route::get('/', [HomeController::class, 'index']);
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::resource('/kategori', KategoriController::class);
        Route::resource('/lokasi', LokasiController::class);
        Route::resource('/aset', AsetController::class);
        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
        Route::put('/aset/{aset}/pengguna', [AsetController::class, 'updatePengguna'])->name('aset.updatePengguna');
        Route::get('/penyusutan', [PenyusutanController::class, 'index'])->name('penyusutan.index');
        Route::get('/penyusutan/{aset}', [PenyusutanController::class, 'show'])->name('penyusutan.show');
        Route::post('/penyusutan/{aset}/susutkan', [PenyusutanController::class, 'susutkan'])->name('penyusutan.susutkan');


    });

    Route::group(['middleware'  => 'CheckRole:admin,staf'], function () {
        Route::get('/tambah-pelaporan', [TambahPelaporanController::class, 'index'])->name('tambah-pelaporan.index');
        Route::get('/get-data-aset', [TambahPelaporanController::class, 'getDataAset']);
        Route::post('/tambah-pelaporan', [TambahPelaporanController::class, 'store'])->name('tambah-pelaporan.store');
    });

    Route::group(['middleware'  => 'CheckRole:admin,manager'], function () {
        Route::get('/pelaporan-masuk', [PelaporanMasukController::class, 'index'])->name('pelaporan-masuk.index');
        Route::get('/pelaporan-masuk/detail/{id}', [PelaporanMasukController::class, 'detail']);
        Route::put('/pelaporan-masuk/detail/{id}/perbaiki', [PelaporanMasukController::class, 'perbaiki']);
        Route::put('/pelaporan-masuk/detail/{id}/selesai', [PelaporanMasukController::class, 'selesai']);
        Route::get('/cek-pelaporan', [CekPelaporanController::class, 'index'])->name('cek-pelaporan.index');
        Route::get('/cek-pelaporan/detail/{pelaporan}', [CekPelaporanController::class, 'detail']);
        Route::post('/cek-pelaporan/detail/{pelaporan}', [CekPelaporanController::class, 'store']);
        Route::get('/pelaporan-selesai', [PelaporanSelesaiController::class, 'index'])->name('pelaporan-selesai.index');
        Route::get('/pelaporan-selesai/cetak-laporan/{id}', [PelaporanSelesaiController::class, 'cetakLaporan']);

        Route::get('/karyawan/create', [KaryawanController::class, 'create']);
        Route::post('/karyawan', [KaryawanController::class, 'store']);
        Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit']);
        Route::put('/karyawan/{id}', [KaryawanController::class, 'update']);
        Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy']);

        Route::get('/setting-penyusutan', [PenyusutanSettingController::class, 'index'])->name('setting.index');
        Route::get('/setting-penyusutan/create', [PenyusutanSettingController::class, 'create'])->name('setting.create');
        Route::post('/setting-penyusutan', [PenyusutanSettingController::class, 'store'])->name('setting.store');
        Route::get('/setting-penyusutan/{setting}/edit', [PenyusutanSettingController::class, 'edit'])->name('setting.edit');
        Route::put('/setting-penyusutan/{setting}', [PenyusutanSettingController::class, 'update'])->name('setting.update');
        
    });


    Route::middleware(['auth', 'CheckRole:admin'])->group(function () {
        Route::resource('/users', UserController::class);
        Route::get('/user/status', [UserStatusController::class, 'index'])->name('users.status');
    });


});