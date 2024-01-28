<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Broadcast::routes(['middleware' => ['auth']]);

Route::group([
    'prefix' => 'auth',
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::group([
        'middleware' => [
            'jwt.verify',
        ],
    ], function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::post('/refresh', [AuthController::class, 'refresh'])
        ->name('refresh');
});
