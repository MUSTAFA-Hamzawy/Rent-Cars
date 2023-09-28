<?php

use App\Http\Controllers\api\BrandController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Brand Routes (API)
|--------------------------------------------------------------------------
*/

// Brand
Route::apiResource('brand', BrandController::class)->only(['show', 'index'])
    ->missing(function (){
       return response(['msg' => 'Invalid ID'], 404);
    });
