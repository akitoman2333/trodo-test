<?php

use App\API\V1\Controllers\JwtAuthController;
use Illuminate\Support\Facades\Route;
use \App\API\V1\Controllers\CurrenciesController;

Route::group(['prefix' => 'v1'], function () {
    /** Auth */
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [JwtAuthController::class, 'register']);
        Route::post('login', [JwtAuthController::class, 'login']);
        Route::get('user', [JwtAuthController::class, 'user']);
        Route::post('logout', [JwtAuthController::class, 'logout']);
        Route::post('refresh', [JwtAuthController::class, 'refresh']);
    });

    Route::group(['prefix' => 'currencies', 'middleware' => ['auth:api']], function() {
        /* Display the history of a specific currency */
        Route::get('/{fromCurrency}/{toCurrency}', [CurrenciesController::class, 'show']);
    });

});
