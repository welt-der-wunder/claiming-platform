<?php

use App\Http\Controllers\API\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'jwt.verify',
    ],
    'prefix' => 'admin',
], function () {

    Route::post('/import-token-holders', [AdminController::class , 'importTokenHolders']);

});
