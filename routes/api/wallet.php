<?php

use App\Http\Controllers\API\Wallet\WalletController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'jwt.verify',
    ],
], function () {
    Route::post('/wallet-connect', [WalletController::class, 'connectWallet']);
    Route::get('/claim', [WalletController::class, 'claim']);
});

Route::get('/public-claim', [WalletController::class, 'publicClaim']);
Route::get('/check-claim', [WalletController::class, 'checkClaim']);
Route::post('/wallet-login', [WalletController::class, 'loginWallet']);