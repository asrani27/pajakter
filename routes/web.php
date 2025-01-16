<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\COAController;
use App\Http\Controllers\DPDController;
use App\Http\Controllers\DPKController;
use App\Http\Controllers\DPWController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\RFKController;
use App\Http\Controllers\SkpdController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/progress', function () {
        Session::flash('warning', 'Belum terintegrasi dengan TPP');
        return redirect()->back();
    });
    Route::get('/superadmin', [HomeController::class, 'superadmin']);

    Route::get('/superadmin/user', [UserController::class, 'index']);
    Route::get('/superadmin/user/create', [UserController::class, 'create']);
    Route::post('/superadmin/user/create', [UserController::class, 'store']);
    Route::get('/superadmin/user/edit/{id}', [UserController::class, 'edit']);
    Route::post('/superadmin/user/edit/{id}', [UserController::class, 'update']);
    Route::get('/superadmin/user/delete/{id}', [UserController::class, 'delete']);

    Route::get('/superadmin/skpd', [SkpdController::class, 'index']);
    Route::post('/superadmin/pajakter/gajitpp/{id}', [PajakController::class, 'uploadGajiTPP']);
    Route::post('/superadmin/pajakter/gajibpjs/{id}', [PajakController::class, 'uploadGajiBPJS']);
    Route::get('/superadmin/tariktpp/{id}/{bulan}/{tahun}/{skpd_id}', [PajakController::class, 'tariktpp']);
    Route::get('/superadmin/pajakter', [PajakController::class, 'index']);
    Route::get('/superadmin/pajakter/create-bulan-tahun', [PajakController::class, 'createBulanTahun']);
    Route::post('/superadmin/pajakter/create-bulan-tahun', [PajakController::class, 'storeBulanTahun']);
    Route::get('/superadmin/pajakter/delete-bulan-tahun/{id}', [PajakController::class, 'deleteBulanTahun']);
    Route::get('/superadmin/pajakter/{id}/skpd', [PajakController::class, 'showSkpd']);
    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/reset', [PajakController::class, 'resetPajak']);
    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}', [PajakController::class, 'showPajak']);
    Route::post('/superadmin/pajakter/{id}/skpd/{skpd_id}/importpegawai', [PajakController::class, 'importPegawai']);
    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/bpjs', [PajakController::class, 'showBPJS']);
});

Route::middleware(['auth', 'dpw'])->group(function () {
    Route::get('/dpw', [DPWController::class, 'index']);
});

Route::middleware(['auth', 'dpd'])->group(function () {
    Route::get('/dpd', [DPDController::class, 'index']);
    Route::get('/dpd/rfk', [RFKController::class, 'index']);
    Route::get('/dpd/rfk/create', [RFKController::class, 'create']);
    Route::post('/dpd/rfk/create', [RFKController::class, 'store']);
    Route::get('/dpd/rfk/edit/{id}', [RFKController::class, 'edit']);
    Route::post('/dpd/rfk/edit/{id}', [RFKController::class, 'update']);
    Route::get('/dpd/rfk/delete/{id}', [RFKController::class, 'delete']);
    Route::get('/dpd/rfk/detail/{id}/akun', [RFKController::class, 'akun']);

    Route::get('/dpd/rfk/detail/{id}/okk', [RFKController::class, 'okk']);
    Route::post('/dpd/rfk/detail/{id}/okk', [RFKController::class, 'okkStore']);
    Route::get('/dpd/rfk/detail/{id}/okk/edit/{okk_id}', [RFKController::class, 'okkEdit']);
    Route::post('/dpd/rfk/detail/{id}/okk/edit/{okk_id}', [RFKController::class, 'okkUpdate']);
    Route::get('/dpd/rfk/detail/{id}/okk/delete/{okk_id}', [RFKController::class, 'okkDelete']);
    Route::get('/dpd/rfk/detail/{id}/okk/sub/{okk_id}', [RFKController::class, 'okkSub']);
    Route::post('/dpd/rfk/detail/{id}/okk/sub/{okk_id}', [RFKController::class, 'okkSubStore']);
    Route::get('/dpd/rfk/detail/{id}/okk/sub/{okk_id}/delete/{sub_id}', [RFKController::class, 'okkSubDelete']);
    Route::get('/dpd/rfk/detail/{id}/okk/sub/{okk_id}/edit/{sub_id}', [RFKController::class, 'okkSubEdit']);
    Route::post('/dpd/rfk/detail/{id}/okk/sub/{okk_id}/edit/{sub_id}', [RFKController::class, 'okkSubUpdate']);

    Route::get('/dpd/rfk/detail/{id}/hp', [RFKController::class, 'hp']);
    Route::post('/dpd/rfk/detail/{id}/hp', [RFKController::class, 'hpStore']);
    Route::get('/dpd/rfk/detail/{id}/hp/edit/{hp_id}', [RFKController::class, 'hpEdit']);
    Route::post('/dpd/rfk/detail/{id}/hp/edit/{hp_id}', [RFKController::class, 'hpUpdate']);
    Route::get('/dpd/rfk/detail/{id}/hp/delete/{hp_id}', [RFKController::class, 'hpDelete']);
    Route::get('/dpd/rfk/detail/{id}/hp/sub/{hp_id}', [RFKController::class, 'hpSub']);
    Route::post('/dpd/rfk/detail/{id}/hp/sub/{hp_id}', [RFKController::class, 'hpSubStore']);
    Route::get('/dpd/rfk/detail/{id}/hp/sub/{hp_id}/delete/{sub_id}', [RFKController::class, 'hpSubDelete']);
    Route::get('/dpd/rfk/detail/{id}/hp/sub/{hp_id}/edit/{sub_id}', [RFKController::class, 'hpSubEdit']);
    Route::post('/dpd/rfk/detail/{id}/hp/sub/{hp_id}/edit/{sub_id}', [RFKController::class, 'hpSubUpdate']);


    Route::get('/dpd/rfk/detail/{id}/pp', [RFKController::class, 'pp']);
    Route::get('/dpd/rfk/detail/{id}/kdln', [RFKController::class, 'kdln']);
    Route::get('/dpd/rfk/detail/{id}/diklat', [RFKController::class, 'diklat']);
    Route::get('/dpd/rfk/detail/{id}/penelitian', [RFKController::class, 'penelitian']);
    Route::get('/dpd/rfk/detail/{id}/sisinfokom', [RFKController::class, 'sisinfokom']);
    Route::get('/dpd/rfk/detail/{id}/pelayanan', [RFKController::class, 'pelayanan']);
    Route::get('/dpd/rfk/detail/{id}/kesejahteraan', [RFKController::class, 'kesejahteraan']);
});

Route::middleware(['auth', 'dpk'])->group(function () {
    Route::get('/dpk', [DPKController::class, 'index']);
});


Route::get('/logout', function () {
    Auth::logout();
    Session::flash('success', 'Anda Telah Logout');
    return redirect('/');
});
