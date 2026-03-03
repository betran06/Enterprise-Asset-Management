<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\Penyusutan\PenyusutanController;
use App\Http\Controllers\Penyusutan\PenyusutanSettingController;
use App\Http\Controllers\Penyusutan\PenyusutanDisposalController;
use App\Http\Controllers\Opname\OpnameController;
use App\Http\Controllers\Opname\OpnameDetailController;
use App\Http\Controllers\Pelaporan\TambahPelaporanController;
use App\Http\Controllers\Pelaporan\PelaporanMasukController;
use App\Http\Controllers\Pelaporan\CekPelaporanController;
use App\Http\Controllers\Pelaporan\PelaporanSelesaiController;
use App\Http\Controllers\AuditTrailController;


// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::group(['middleware'  => 'CheckRole:admin,staf,manager'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/home', [DashboardController::class, 'index'])->name('home');
        Route::resource('/kategori', KategoriController::class);
        Route::resource('/lokasi', LokasiController::class);
        Route::resource('/aset', AsetController::class);
        Route::put('/aset/{aset}/pengguna', [AsetController::class, 'updatePengguna'])->name('aset.updatePengguna');
        Route::get('/aset/export/pdf', [AsetController::class, 'exportPdf'])->name('aset.export.pdf');
        Route::get('/aset/export/laporan-keseluruhan', [AsetController::class, 'exportLaporanKeseluruhan'])->name('aset.export.keseluruhan');
        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
        Route::get('/aset/export/excel', [AsetController::class, 'exportExcel'])->name('aset.export.excel');

        //--cek-pelaporan--//
        Route::get('/cek-pelaporan', [CekPelaporanController::class, 'index'])->name('cek-pelaporan.index');
        Route::get('/cek-pelaporan/detail/{pelaporan}', [CekPelaporanController::class, 'detail']);
        Route::post('/cek-pelaporan/detail/{pelaporan}', [CekPelaporanController::class, 'store']);
        
        //--penyusutsan--//
        Route::get('/penyusutan', [PenyusutanController::class, 'index'])->name('penyusutan.index');
        Route::get('/penyusutan/{aset}', [PenyusutanController::class, 'show'])->name('penyusutan.show');
        Route::get('/penyusutan/{aset}/export-pdf', [PenyusutanController::class, 'cetakPdf'])->name('penyusutan.export-pdf');
        Route::post('/penyusutan/{aset}/susutkan', [PenyusutanController::class, 'susutkan'])->name('penyusutan.susutkan');
        
        
        //--opname--//
        Route::get('/opname/get-aset-by-qr', [OpnameDetailController::class, 'getAsetData'])->name('opname.getAsetData');
        Route::get('/opname', [OpnameController::class, 'index'])->name('opname.index');
        Route::get('/create-opname', [OpnameController::class, 'create'])->name('opname.create');
        Route::post('/opname', [OpnameController::class, 'store'])->name('opname.store');
        Route::get('/opname/{opname}', [OpnameController::class, 'show'])->name('opname.show');
        Route::put('/opname/{opname}/final', [OpnameController::class, 'final'])->name('opname.final');
        Route::get('/opname/{opname}/pdf', [OpnameController::class, 'pdf'])->name('opname.pdf');

        //--input aset opname--//
        Route::get('/opname/{opname}/input', [OpnameDetailController::class, 'create'])->name('opname.input');
        Route::post('/opname/{opname}/input', [OpnameDetailController::class, 'store'])->name('opname.input.store');
        Route::delete('/opname/{opname}/detail/{detail}', [OpnameDetailController::class, 'destroy'])->name('opname.detail.destroy');
        Route::put('/opname/{opname}/final',[OpnameDetailController::class, 'final'])->name('opname.final');

    });

    Route::group(['middleware'  => 'CheckRole:admin,staf'], function () {
        //--tambah pelaporan--//
        Route::get('/tambah-pelaporan', [TambahPelaporanController::class, 'index'])->name('tambah-pelaporan.index');
        Route::get('/get-data-aset', [TambahPelaporanController::class, 'getDataAset']);
        Route::post('/tambah-pelaporan', [TambahPelaporanController::class, 'store'])->name('tambah-pelaporan.store');
    });

    Route::group(['middleware'  => 'CheckRole:admin,manager'], function () {
        //--pelaporan masuk--//
        Route::get('/pelaporan-masuk', [PelaporanMasukController::class, 'index'])->name('pelaporan-masuk.index');
        Route::get('/pelaporan-masuk/detail/{id}', [PelaporanMasukController::class, 'detail']);
        Route::put('/pelaporan-masuk/detail/{id}/perbaiki', [PelaporanMasukController::class, 'perbaiki']);
        Route::put('/pelaporan-masuk/detail/{id}/selesai', [PelaporanMasukController::class, 'selesai']);

        //--pelaporan selesai--//
        Route::get('/pelaporan-selesai', [PelaporanSelesaiController::class, 'index'])->name('pelaporan-selesai.index');
        Route::get('/pelaporan-selesai/cetak-laporan/{id}', [PelaporanSelesaiController::class, 'cetakLaporan']);

        //--karyawan--//
        Route::get('/karyawan/create', [KaryawanController::class, 'create']);
        Route::post('/karyawan', [KaryawanController::class, 'store']);
        Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit']);
        Route::put('/karyawan/{id}', [KaryawanController::class, 'update']);
        Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy']);
        
        //--setting penyusutsan--//
        Route::get('/setting-penyusutan', [PenyusutanSettingController::class, 'index'])->name('setting.index');
        Route::get('/setting-penyusutan/create', [PenyusutanSettingController::class, 'create'])->name('setting.create');
        Route::post('/setting-penyusutan', [PenyusutanSettingController::class, 'store'])->name('setting.store');
        Route::get('/setting/{aset}/edit', [PenyusutanSettingController::class, 'edit'])->name('setting.edit');
        Route::put('/setting/{aset}', [PenyusutanSettingController::class, 'update'])->name('setting.update');

        //--disposal--//
        Route::get('/penyusutan/{aset}/disposal', [PenyusutanDisposalController::class, 'create'])->name('penyusutan.dispose.form');
        Route::put('/penyusutan/{aset}/disposal', [PenyusutanDisposalController::class, 'store'])->name('penyusutan.dispose.store');
        
    });


    Route::middleware(['auth', 'CheckRole:admin'])->group(function () {
        //--control user--//
        Route::resource('/users', UserController::class);
        Route::get('/user/status', [UserStatusController::class, 'index'])->name('users.status');

        //--audit--//
        Route::get('/audit', [AuditTrailController::class, 'index'])->name('audit.index');
        Route::get('/audit/{auditLog}', [AuditTrailController::class, 'show'])->name('audit.show');
    });


});