<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes (API)
|--------------------------------------------------------------------------
*/

// User
Route::prefix('user')->controller(AuthController::class)
    ->group(function (){
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout','logout');
        Route::post('/refresh', 'refresh');
        Route::get('/profile', 'me');
    });
