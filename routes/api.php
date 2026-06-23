<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SettingController;


// Public
Route::post('/login', [AuthController::class, 'login']);

// Semua role yang sudah login
Route::middleware('auth:sanctum')->group(function () {

    // Mendapatkan data user yang sedang login
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // Update profil user yang sedang login
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // Change password untuk user yang sedang login
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // User biasa — buat & lihat laporan sendiri
    Route::middleware('role:user')->group(function () {
        Route::post('/reports', [ReportController::class, 'store']);
        Route::get('/reports/my', [ReportController::class, 'myReports']);
    });

    // Operator IT — lihat semua laporan & update status
    Route::middleware('role:operator,admin')->group(function () {
        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/reports/my-tasks', [ReportController::class, 'myTasks']); // Laporan yang ditugaskan ke operator
        Route::patch('/reports/{report}/status', [ReportController::class, 'updateStatus']);
    });

    // Admin only — manajemen user
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::patch('/users/{user}/status', [UserController::class, 'toggleStatus']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });

    // Notifikasi untuk semua role
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll']);
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'read']);

    // Kategori untuk semua role (tapi hanya admin yang bisa CRUD)
    Route::get('/kategoris', [KategoriController::class, 'index']);
    Route::middleware('role:admin')->group(function () {
        Route::post('/kategoris', [KategoriController::class, 'store']);
        Route::put('/kategoris/{kategori}', [KategoriController::class, 'update']);
        Route::delete('/kategoris/{kategori}', [KategoriController::class, 'destroy']);
    });

    // Settings
    Route::get('/settings', [SettingController::class, 'index']);
    Route::middleware('role:admin')->group(function () {
        // ... yang sudah ada ...
        Route::put('/settings', [SettingController::class, 'update']);
    });
    // Logout untuk semua role
    Route::post('/logout', [AuthController::class, 'logout']);
});