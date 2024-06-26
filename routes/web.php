<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\SysteamUsers\SysUserController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// authentication
Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
Route::post('/auth/login-auth', [AuthController::class, 'login']);
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/forgot-password', [AuthController::class, 'forgotPassword'])->name('reset-password');

Route::group([
    'middleware' => ['auth']
], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // User / Addresses
    Route::get('/users', [UserController::class, 'getAllUsers'])->name('users');
    Route::get('/show-timeline/{id}', [UserController::class, 'showTimeline'])->name('showTimeline');
    Route::post('/process-multiple-rewards', [UserController::class, 'processMultipleRewards'])->name('processMultipleRewards');
    Route::post('/export-data', [UserController::class, 'exportData'])->name('exportData');

    Route::post('/import-data', [UserController::class , 'importData'])->name('importData');

    // Token Holders
    Route::get('/token-holders', [DashboardController::class, 'getAllTokenHolders'])->name('token-holders');
    Route::post('/process-rewards', [DashboardController::class, 'processRewards'])->name('processRewards');
    Route::post('/create-token-holder', [DashboardController::class, 'createTokenHolder'])->name('create-token-holder');
    Route::post('/holder-status-change', [DashboardController::class, 'holderStatusChange'])->name('holderStatusChange');
    Route::post('/import-token', [DashboardController::class , 'importTokenHolders'])->name('importHolders');

});
