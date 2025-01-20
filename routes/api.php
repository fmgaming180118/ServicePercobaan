<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\DetailPekerjaanController;
use App\Http\Controllers\CustomerController;
use App\Models\Customer;
use App\Http\Controllers\DashboardCustomerController;

/*
|--------------------------------------------------------------------------|
| API Routes                                                               |
|--------------------------------------------------------------------------|
*/

Route::post('login', [AuthController::class, 'login']);

// Route untuk mendapatkan data pengguna yang sedang login (hanya dengan auth)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function(){
    Route::middleware('auth:sanctum')->get('/customerdashboard', [DashboardCustomerController::class, 'showCustomerDashboard'])->name('customerdashboard');
});