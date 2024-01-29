<?php

use App\Http\Controllers\C_Anggota;
use App\Http\Controllers\C_Auth;
use App\Http\Controllers\C_Dashboard;
use App\Http\Controllers\C_Form;
use App\Http\Controllers\C_Games;
use App\Http\Controllers\C_Kehadiran;
use App\Http\Controllers\C_Pengurus;
use App\Http\Controllers\C_Pertemuan;
use App\Http\Controllers\C_PJ;
use App\Http\Controllers\C_Prodi;
use App\Http\Controllers\C_TA;
use App\Http\Controllers\C_User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('login')->controller(C_Dashboard::class)->group(function () {
    Route::get('/', 'index')->name('dashboard');
    Route::get('/totalAnggota', 'totalAnggota')->name('totalAnggota');
    Route::get('/presentase', 'presentKehadiran')->name('presentKehadiran');
    Route::get('/presentasePertemuan', 'presentPertemuan')->name('presentasePertemuan');
    Route::get('/AnggotaPerTahun', 'AnggotaPerTahun')->name('AnggotaPerTahun');
});

Route::controller(C_Auth::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(C_Form::class)->group(function () {
    Route::get('/pendaftaran', 'pendaftaran')->name('pendaftaran');
    Route::post('/submitForm', 'submitForm')->name('submitForm');
    Route::get('/presensi   ', 'presensi')->name('presensi ');
    Route::post('/submitPresensi', 'submitPresensi')->name('submitPresensi');
});

Route::middleware('login')->controller(C_Games::class)->group(function () {
    Route::get('/games', 'index')->name('games');
    Route::get('/games/create', 'create')->name('createGames');
    Route::post('/games/create', 'saveGames')->name('createGames');
    Route::get('/games/update/{id}', 'update')->name('updateGames');
    Route::post('/games/update/{id}', 'updateGames')->name('updateGames');
    Route::get('/games/delete/{id}', 'delete')->name('deleteGames');
});

Route::middleware('login')->controller(C_TA::class)->group(function () {
    Route::get('/TA', 'index')->name('TA');
    Route::get('/TA/create', 'create')->name('createTA');
    Route::post('/TA/create', 'saveTA')->name('createTA');
    Route::get('/TA/update/{id}', 'update')->name('updateTA');
    Route::post('/TA/update/{id}', 'updateTA')->name('updateTA');
    Route::get('/TA/delete/{id}', 'delete')->name('deleteTA');
});

Route::middleware('login')->controller(C_Prodi::class)->group(function () {
    Route::get('/prodi', 'index')->name('prodi');
    Route::get('/prodi/create', 'create')->name('createProdi');
    Route::post('/prodi/create', 'saveProdi')->name('createProdi');
    Route::get('/prodi/update/{id}', 'update')->name('updateProdi');
    Route::post('/prodi/update/{id}', 'updateProdi')->name('updateProdi');
    Route::get('/prodi/delete/{id}', 'delete')->name('deleteProdi');
});

Route::middleware('login')->controller(C_PJ::class)->group(function () {
    Route::get('/PJ', 'index')->name('PJ');
    Route::get('/PJ/create', 'create')->name('createPJ');
    Route::post('/PJ/create', 'savePJ')->name('createPJ');
    Route::get('/PJ/update/{id}', 'update')->name('updatePJ');
    Route::post('/PJ/update/{id}', 'updatePJ')->name('updatePJ');
    Route::get('/PJ/delete/{id}', 'delete')->name('deletePJ');
    Route::get('/PJ/detail/{id}', 'detail')->name('detailPJ');
});

Route::middleware('login')->controller(C_Pengurus::class)->group(function () {
    Route::get('/pengurus', 'index')->name('Pengurus');
    Route::get('/pengurus/create', 'create')->name('createPengurus');
    Route::post('/pengurus/create', 'savePengurus')->name('createPengurus');
    Route::get('/pengurus/update/{id}', 'update')->name('updatePengurus');
    Route::post('/pengurus/update/{id}', 'updatePengurus')->name('updatePengurus');
    Route::get('/pengurus/delete/{id}', 'delete')->name('deletePengurus');
    Route::get('/pengurus/detail/{id}', 'detail')->name('detailPengurus');
});
Route::middleware('login')->controller(C_User::class)->group(function () {
    Route::get('/user', 'index')->name('User');
    Route::get('/user/create', 'create')->name('createUser');
    Route::post('/user/create', 'saveUser')->name('createUser');
    Route::get('/user/update/{id}', 'update')->name('updateUser');
    Route::post('/user/update/{id}', 'updateUser')->name('updateUser');
    Route::get('/user/updatePass/{id}', 'changePass')->name('changePass');
    Route::post('/user/updatePass/{id}', 'updatePass')->name('updatePass');
    Route::get('/user/delete/{id}', 'delete')->name('deleteUser');
    Route::get('/user/detail/{id}', 'detail')->name('detailUser');
});
Route::middleware('login')->controller(C_Anggota::class)->group(function () {
    Route::get('/anggota', 'index')->name('Anggota');
    Route::get('/anggota/create', 'create')->name('createAnggota');
    Route::post('/anggota/create', 'saveAnggota')->name('createAnggota');
    Route::get('/anggota/update/{id}', 'update')->name('updateAnggota');
    Route::post('/anggota/update/{id}', 'updateAnggota')->name('updateAnggota');
    Route::get('/anggota/delete/{id}', 'delete')->name('deleteAnggota');
    Route::get('/anggota/detail/{id}', 'detail')->name('detailAnggota');
    Route::post('/anggota/import', 'import')->name('importAnggota');
});
Route::middleware('login')->controller(C_Pertemuan::class)->group(function () {
    Route::get('/pertemuan', 'index')->name('Pertemuan');
    Route::get('/pertemuan/create', 'create')->name('createPertemuan');
    Route::post('/pertemuan/create', 'savePertemuan')->name('createPertemuan');
    Route::get('/pertemuan/update/{id}', 'update')->name('updatePertemuan');
    Route::post('/pertemuan/update/{id}', 'updatePertemuan')->name('updatePertemuan');
    Route::get('/pertemuan/delete/{id}', 'delete')->name('deletePertemuan');
    Route::get('/pertemuan/detail/{id}', 'detail')->name('detailPertemuan');
});
Route::middleware('login')->controller(C_Kehadiran::class)->group(function () {
    Route::get('/kehadiran', 'index')->name('Kehadiran');
    Route::get('/kehadiran/create', 'create')->name('createKehadiran');
    Route::post('/kehadiran/create', 'saveKehadiran')->name('createKehadiran');
    Route::get('/pertemuan/{pertemuan}/update/{anggota}', 'update')->name('updateKehadiran');
    Route::post('/pertemuan/{pertemuan}/update/{anggota}', 'updateKehadiran')->name('updateKehadiran');
    Route::get('/kehadiran/{pertemuan}/verif/{anggota}', 'verifikasi')->name('verifikasi');
    Route::get('/pertemuan/{pertemuan}/delete/{anggota}', 'delete')->name('deleteKehadiran');
    // Route::get('/kehadiran/export', 'eksportKehadiran')->name('Export');
    Route::get('/kehadiran/export/{ta}/{pertemuan}/{games}', 'eksportKehadiran')->name('Export');
});
