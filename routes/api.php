<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// , 'middleware' => ['checkRequestIpMiddlware']
Route::group(['prefix' => env('ROUTE_PREFIX')], function(){
    Route::get('/credentials', [App\Http\Controllers\Api\TransactionController::class, 'getAccessToken']) -> name('transaction.access_token');
    Route::get('/registerUrl', [App\Http\Controllers\Api\TransactionController::class, 'registerUrl']) -> name('transaction.register_url');
    Route::post('/confirmation', [App\Http\Controllers\Api\TransactionController::class, 'confirmTransaction']) -> name('transaction.confirmation');
    Route::post('/validation', [App\Http\Controllers\Api\TransactionController::class, 'validateTransaction']) -> name('transaction.validation');
    Route::get('/simulate', [App\Http\Controllers\Api\TransactionController::class, 'simulate']) -> name('transaction.simulate');
});
