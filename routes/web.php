<?php

use App\Http\Controllers\AdminController;
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

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/pajakter/{id}', [AdminController::class, 'pajak']);
    Route::get('/admin/pajakter/{id}/editptkp/{ptkp_id}', [AdminController::class, 'editPtkp']);
    Route::post('/admin/pajakter/{id}/editptkp/{ptkp_id}', [AdminController::class, 'updatePtkp']);
    Route::get('/admin/bpjs/{id}', [AdminController::class, 'bpjs']);
    Route::get('/admin/tariktpp/{id}/{bulan}/{tahun}/{skpd_id}', [AdminController::class, 'tariktpp']);

    Route::get('/admin/pajakter/{id}/exportpajak/{skpd_id}', [PajakController::class, 'exportPajakSKPD']);
    Route::get('/admin/pajakter/{id}/exportbpjs/{skpd_id}', [PajakController::class, 'exportBpjsSKPD']);
});
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
    Route::get('/superadmin/pajakter/{id}/pppk-pajak', [PajakController::class, 'showPppkPajak']);
    Route::get('/superadmin/pajakter/{id}/pppk-bpjs', [PajakController::class, 'showPppkBpjs']);
    Route::get('/superadmin/pajakter/pppk/{id}/reset', [PajakController::class, 'resetPPPK']);
    Route::post('/superadmin/pajakter/pppk/{id}', [PajakController::class, 'uploadGajiPPPK']);
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

    Route::post('/superadmin/pajakter/{id}/skpd/{skpd_id}/guru', [PajakController::class, 'uploadTPPGuru']);

    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/guru', [PajakController::class, 'showPajakGuru']);
    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/guru/reset', [PajakController::class, 'resetPajakGuru']);
    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/guru/bpjs', [PajakController::class, 'showBpjsGuru']);

    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/gurusd', [PajakController::class, 'showPajakGuruSD']);
    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/gurusd/reset', [PajakController::class, 'resetPajakGuruSD']);
    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/gurusd/bpjs', [PajakController::class, 'showBpjsGuruSD']);

    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/gurusmp', [PajakController::class, 'showPajakGuruSMP']);
    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/gurusmp/reset', [PajakController::class, 'resetPajakGuruSMP']);
    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/gurusmp/bpjs', [PajakController::class, 'showBpjsGuruSMP']);

    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/guruteknis', [PajakController::class, 'showPajakGuruTeknis']);
    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/guruteknis/reset', [PajakController::class, 'resetPajakGuruTeknis']);
    Route::get('/superadmin/pajakter/{id}/skpd/{skpd_id}/guruteknis/bpjs', [PajakController::class, 'showBpjsGuruTeknis']);


    Route::get('/superadmin/pajakter/{id}/exportpajakpppk', [PajakController::class, 'exportPajakPPPK']);
    Route::get('/superadmin/pajakter/{id}/exportbpjspppk', [PajakController::class, 'exportBpjsPPPK']);

    Route::get('/superadmin/pajakter/{id}/exportpajak/{skpd_id}', [PajakController::class, 'exportPajakSKPD']);
    Route::get('/superadmin/pajakter/{id}/exportbpjs/{skpd_id}', [PajakController::class, 'exportBpjsSKPD']);

    Route::get('/superadmin/pajakter/{id}/exportpajak/{skpd_id}/sheet/{nosheet}', [PajakController::class, 'exportPajakSheet']);
    Route::get('/superadmin/pajakter/{id}/exportbpjs/{skpd_id}/sheet/{nosheet}', [PajakController::class, 'exportBpjsSheet']);
});


Route::get('/logout', function () {
    Auth::logout();
    Session::flash('success', 'Anda Telah Logout');
    return redirect('/');
});
