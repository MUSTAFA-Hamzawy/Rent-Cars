<?php

use App\Http\Controllers\api\BranchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Branch Routes (API)
|--------------------------------------------------------------------------
*/

// Branch
Route::apiResource('branch', BranchController::class)->only(['show', 'index'])
    ->missing(function (){
        return response(['msg' => 'Invalid ID'], 404);
    });
