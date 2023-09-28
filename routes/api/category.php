<?php

use App\Http\Controllers\api\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Category Routes (API)
|--------------------------------------------------------------------------
*/

// Category
Route::apiResource('category', CategoryController::class)->only(['show', 'index'])
    ->missing(function (){
        return response(['msg' => 'Invalid ID'], 404);
    });
