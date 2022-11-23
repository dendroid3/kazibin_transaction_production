<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => env('ROUTE_PREFIX'), 'middleware' => ['checkRequestIpMiddlware']], function(){
    Route::get('/confirmation', [App\Http\Controllers\Api\TransactionController::class, 'confirmTransaction']) -> name('transaction.confirmation');
});
