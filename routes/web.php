<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;

Route::post('/', function () {
    return response() -> json([
        'properties' => DB::table('tblproperties') -> count()
    ]);
});


