<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\LaporanController;

Route::resource('wilayah', \App\Http\Controllers\WilayahController::class);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Role: Admin
Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
});
// Role: Pendaftaran
Route::middleware(['auth', 'role:pendaftaran'])->group(function () {
    Route::get('/pendaftaran', function () {
        return view('pendaftaran.dashboard');
    });
});
// Role: Dokter
Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('/dokter', function () {
        return view('dokter.dashboard');
    });
});
// Role: Kasir
Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir', function () {
        return view('kasir.dashboard');
    });
});

Route::get('login', function () {
    return view('auth.login');
})->name('home');



Route::get('/', function () {
    return view('dashboard');
});

Route::get('/wilayah', function () {
    return view('wilayah');
});

Route::get('/user', function () {
    return view('user');
});

Route::get('/pegawai', function () {
    return view('pegawai');
});
Route::get('/tindakan', function () {
    return view('tindakan');
});
Route::get('/obat', function () {
    return view('obat');
});

Route::get('/admin/laporan', function () {
    return view('admin.laporan');
})->name('admin.laporan');

Route::get('/apetugas/pendaftaran', function () {
    return view('apetugas.pendaftaran');
})->name('pendaftaran');

Route::get('/dokter/tindakan', function () {
    return view('dokter.transaksi_tindakan');
})->name('dokter.tindakan');

Route::get('/kasir/pembayaran', function () {
    return view('kasir.pembayaran');
})->name('kasir.pembayaran');

Route::get('/laporan/generatePDF', [LaporanController::class, 'generatePDF'])->name('laporan.generatePDF');


Route::post('/wilayah', [WilayahController::class, 'store'])->name('wilayah.store');

// Route::get('/', function () {
//     return view('welcome');
// });
