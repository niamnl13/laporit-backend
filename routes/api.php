<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public
Route::post('/login', [AuthController::class, 'login']);

// Semua role yang sudah login
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // User biasa — buat & lihat laporan sendiri
    Route::middleware('role:user')->group(function () {
        Route::post('/reports', [ReportController::class, 'store']);
        Route::get('/reports/my', [ReportController::class, 'myReports']);
    });

    // Operator IT — lihat semua laporan & update status
    Route::middleware('role:operator,admin')->group(function () {
        Route::get('/reports', [ReportController::class, 'index']);
        Route::patch('/reports/{report}/status', [ReportController::class, 'updateStatus']);
    });

    // Admin only — manajemen user
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [ReportController::class, 'allUsers']);
    });

    // Logout untuk semua role
    Route::post('/logout', [AuthController::class, 'logout']);
});