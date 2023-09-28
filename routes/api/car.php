<?php

use App\Http\Controllers\api\CarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Car Routes (API)
|--------------------------------------------------------------------------
*/

// Car
Route::apiResource('car', CarController::class)->only(['show', 'index'])
    ->missing(function (){
        return response(['msg' => 'Invalid ID'], 404);
    });
