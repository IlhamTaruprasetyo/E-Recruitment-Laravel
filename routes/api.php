<?php

use App\Http\Controllers\Api\JobApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider / Application within a group which
| is assigned the "api" middleware group.
|
*/

Route::prefix('v1')->group(function () {
    // Endpoints lowongan pekerjaan untuk Next.js & Nuxt.js
    Route::get('/jobs', [JobApiController::class, 'index']);
    Route::get('/jobs/{id}', [JobApiController::class, 'show']);
    Route::get('/departments', [JobApiController::class, 'departments']);
});

// Alias tanpa prefix v1 untuk fleksibilitas klien
Route::get('/jobs', [JobApiController::class, 'index']);
Route::get('/jobs/{id}', [JobApiController::class, 'show']);
