<?php

use App\Http\Controllers\api\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Order Routes (API)
|--------------------------------------------------------------------------
*/

// Order
Route::prefix('order')->middleware('jwt.verify')
    ->controller(OrderController::class)
    ->group(function (){
        Route::post('/create', 'store');
        Route::post('/cancel/{order}', 'cancel')->missing(function (){
            return response(['msg' => 'Invalid ID'], 404);
        });
        Route::get('/user_orders', 'userOrders');
        Route::get('/{order}', 'show')->missing(function (){
            return response(['msg' => 'Invalid ID'], 404);
        });
    });
