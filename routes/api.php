<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// , 'middleware' => ['checkRequestIpMiddlware']
Route::group(['prefix' => env('ROUTE_PREFIX')], function(){
    Route::get('/credentials', [App\Http\Controllers\Api\TransactionController::class, 'getAccessToken']) -> name('transaction.access_token');
    Route::get('/registerUrl', [App\Http\Controllers\Api\TransactionController::class, 'registerUrl']) -> name('transaction.register_url');
    Route::post('/confirmation', [App\Http\Controllers\Api\TransactionController::class, 'confirmTransaction']) -> name('transaction.confirmation');
    Route::post('/validation', [App\Http\Controllers\Api\TransactionController::class, 'validateTransaction']) -> name('transaction.validation');
    Route::get('/simulate', [App\Http\Controllers\Api\TransactionController::class, 'simulate']) -> name('transaction.simulate');
});

Route::post('/search', function (Request $request) {
    Log::info($request -> all());
    $query = DB::table('tblproperties');
    $where = [];
    if($request['neighbourhood']){
        array_push($where, ['Neighbourhood', 'like', '%' . $request['neighbourhood'] . '%']);
    }
    if($request['county']){
        array_push($where, ['County', 'like', '%' . $request['county'] . '%']);
    }
    if($request['price']){
        array_push($where, ['Price', '<=', $request['price']]);
    }
    if($request['propertytype']){
        array_push($where, ['PropertyType', $request['propertytype']]);
    }

    $key_words = $request['key_words'] ? $request['key_words'] : null;

    if($key_words){
        
            $query -> where(function($q) use ($key_words) {
                $key_words_exploded = explode(',', $key_words);
                Log::info('key_words_exploded');
                Log::info($key_words_exploded);
                Log::info('key_words_exploded');
                foreach ($key_words_exploded as $key_word) {
                    $q -> orWhere('CompanyName', 'like', '%' . $key_word . '%');
                    $q -> orWhere('AssistingAgent', 'like', '%' . $key_word . '%');
                    $q -> orWhere('PropertyDescription', 'like', '%' . $key_word . '%');
                    $q -> orWhere('PropertyFeatures', 'like', '%' . $key_word . '%');
                    $q -> orWhere('PropertyName', 'like', '%' . $key_word . '%');
                }

            } );
    }


    $response = $query -> where ($where) -> get();


    // Log::info('count');
    // Log::info($where);
    // Log::info($response);
    return response() -> json($response);
    //  response() -> json([
    //     'properties' => $response
    // ]);
});
