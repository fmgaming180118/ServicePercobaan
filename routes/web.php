<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AsuransiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DetailPekerjaanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OwnerDashboardController;
use App\Models\DetailPekerjaan;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\DashboardCustomerController;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

// Rute halaman welcome
Route::get('/welcome', function () {
    return view('welcome');
});

// Contoh rute dengan respons langsung
Route::get('/nama', function () {
    return "<h1>Nama Saya Bowo</h1>";
});

// Rute login dan autentikasi
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']); // Rute untuk memproses login
Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); // Rute untuk logout
Route::get('/register', [LoginController::class, 'register']);
Route::post('/register', [LoginController::class, 'registerUser ']);
Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'emailUser '])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [LoginController::class, 'newPassword'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'savePassword'])->middleware('guest')->name('password.update');

// Rute halaman dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/ownerdashboard', [OwnerDashboardController::class, 'index'])->name('ownerdashboard')->middleware('auth');
Route::get('/customerdashboard', [DashboardCustomerController::class, 'showCustomerDashboard'])->middleware('auth')->name('customerdashboard');

    

// Rute CRUD untuk User
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index'); // Menampilkan daftar user
    Route::get('/create', [UserController::class, 'create'])->name('users.create'); // Form tambah user baru
    Route::post('/', [UserController::class, 'store'])->name('users.store'); // Menyimpan user baru
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit'); // Form edit user
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update'); // Memperbarui user
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy'); // Menghapus user
});

// Rute CRUD untuk Kendaraan
Route::prefix('kendaraan')->group(function () {
    Route::get('/', [KendaraanController::class, 'index'])->name('kendaraan.index'); // Menampilkan daftar kendaraan
    Route::get('/create', [KendaraanController::class, 'create'])->name('kendaraan.create'); // Form tambah kendaraan baru
    Route::post('/', [KendaraanController::class, 'store'])->name('kendaraan.store'); // Menyimpan kendaraan baru
    Route::get('/{no_polisi}/edit', [KendaraanController::class, 'edit'])->name('kendaraan.edit'); // Form edit kendaraan
    Route::put('/{no_polisi}', [KendaraanController::class, 'update'])->name('kendaraan.update'); // Memperbarui kendaraan
    Route::delete('/{no_polisi}', [KendaraanController::class, 'destroy'])->name('kendaraan.destroy'); // Menghapus kendaraan
});

// Rute CRUD untuk Asuransi
Route::prefix('asuransi')->group(function () {
    Route::get('/', [AsuransiController::class, 'index'])->name('asuransi.index'); // Menampilkan daftar asuransi
    Route::get('/create', [AsuransiController::class, 'create'])->name('asuransi.create');
    Route::post('/', [AsuransiController::class, 'store'])->name('asuransi.store'); // Menyimpan asuransi baru
    Route::get('/{id_asuransi}/edit', [AsuransiController::class, 'edit'])->name('asuransi.edit'); // Form edit asuransi
    Route::put('/{id_asuransi}', [AsuransiController::class, 'update'])->name('asuransi.update'); // Memperbarui asuransi
    Route::delete('/{id_asuransi}', [AsuransiController::class, 'destroy'])->name('asuransi.destroy'); // Menghapus asuransi
});

Route::prefix('asuransi')->group(function () {
    Route::get('/', [AsuransiController::class, 'index'])->name('asuransi.index'); // Menampilkan daftar asuransi
    Route::get('/create', [AsuransiController::class, 'create'])->name('asuransi.create');
    Route::post('/', [AsuransiController::class, 'store'])->name('asuransi.store'); // Menyimpan asuransi baru
    Route::get('/{id_asuransi}/edit', [AsuransiController::class, 'edit'])->name('asuransi.edit'); // Form edit asuransi
    Route::put('/{id_asuransi}', [AsuransiController::class, 'update'])->name('asuransi.update'); // Memperbarui asuransi
    Route::delete('/{id_asuransi}', [AsuransiController::class, 'destroy'])->name('asuransi.destroy'); // Menghapus asuransi
});
    
// Rute untuk Karyawan
Route::prefix('karyawan')->group(function () {
    Route::get('/', [KaryawanController::class, 'index'])->name('karyawan.index'); // Menampilkan daftar asuransi
    Route::get('/create', [KaryawanController::class, 'create'])->name('karyawan.create'); // Form tambah asuransi baru
    Route::post('/', [KaryawanController::class, 'store'])->name('karyawan.store'); // Menyimpan asuransi baru
    Route::get('/{id_karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit'); // Form edit asuransi
    Route::put('/{id_karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update'); // Memperbarui asuransi
    Route::delete('/{id_karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy'); // Menghapus asuransi
});

Route::prefix('customer')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customer.index'); // Menampilkan daftar asuransi
    Route::get('/create', [CustomerController::class, 'create'])->name('customer.create'); // Form tambah asuransi baru
    Route::post('/', [CustomerController::class, 'store'])->name('customer.store'); // Menyimpan asuransi baru
    Route::get('/{id_customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit'); // Form edit asuransi
    Route::put('/{id_customer}', [CustomerController::class, 'update'])->name('customer.update'); // Memperbarui asuransi
    Route::delete('/{id_customer}', [CustomerController::class, 'destroy'])->name('customer.destroy'); // Menghapus asuransi
});

Route::prefix('pekerjaan')->group(function () {
    Route::get('/', [PekerjaanController::class, 'index'])->name('pekerjaan.index'); // Menampilkan daftar asuransi
    Route::get('/create', [PekerjaanController::class, 'create'])->name('pekerjaan.create'); // Form tambah asuransi baru
    Route::post('/', [PekerjaanController::class, 'store'])->name('pekerjaan.store'); // Menyimpan asuransi baru
    Route::get('/{id_pekerjaan}/edit', [PekerjaanController::class, 'edit'])->name('pekerjaan.edit'); // Form edit asuransi
    Route::put('/{id_pekerjaan}', [PekerjaanController::class, 'update'])->name('pekerjaan.update'); // Memperbarui asuransi
    Route::delete('/{id_pekerjaan}', [PekerjaanController::class, 'destroy'])->name('pekerjaan.destroy'); // Menghapus asuransi
});

Route::prefix('service')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('service.index'); // Menampilkan daftar asuransi
    Route::get('/create', [ServiceController::class, 'create'])->name('service.create'); // Form tambah asuransi baru
    Route::post('/', [ServiceController::class, 'store'])->name('service.store'); // Menyimpan asuransi baru
    Route::get('/{id_service}/edit', [ServiceController::class, 'edit'])->name('service.edit'); // Form edit asuransi
    Route::put('/{id_service}', [ServiceController::class, 'update'])->name('service.update'); // Memperbarui asuransi
    Route::delete('/{id_service}', [ServiceController::class, 'destroy'])->name('service.destroy'); // Menghapus asuransi
});

Route::prefix('detailpekerjaan')->group(function () {
    // Menampilkan daftar detail pekerjaan berdasarkan id_service
    Route::get('/{id_service}', [DetailPekerjaanController::class, 'index'])->name('detailpekerjaan.index'); // Menampilkan daftar detail pekerjaan

    // Menyimpan detail pekerjaan baru
    Route::post('/', [DetailPekerjaanController::class, 'store'])->name('detailpekerjaan.store'); // Menyimpan detail pekerjaan baru

    // Menampilkan form untuk mengedit detail pekerjaan berdasarkan id_service dan id_pekerjaan
    Route::get('/{id_service}/edit/{id_pekerjaan}', [DetailPekerjaanController::class, 'edit'])->name('detailpekerjaan.edit'); // Form edit detail pekerjaan

    // Memperbarui detail pekerjaan berdasarkan id_service dan id_pekerjaan
    Route::put('/{id_service}/{id_pekerjaan}', [DetailPekerjaanController::class, 'update'])->name('detailpekerjaan.update'); // Memperbarui detail pekerjaan

    // Menghapus detail pekerjaan berdasarkan id_service dan id_pekerjaan
    Route::delete('/{id_service}/{id_pekerjaan}', [DetailPekerjaanController::class, 'destroy'])->name('detailpekerjaan.destroy'); // Menghapus detail pekerjaan
});



// Rute Default (mengarah ke login jika belum login)
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

// Rute setelah login
Route::get('/home', [UserController::class, 'index'])->name('home')->middleware('auth');
