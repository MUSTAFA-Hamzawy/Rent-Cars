<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Order Routes
|--------------------------------------------------------------------------
*/
//
Route::middleware(['auth'])->group(function (){
    Route::delete('order/remove_all', [OrderController::class, 'truncate'])->name('order.truncate');
    Route::resource('order', OrderController::class)
        ->only(['index', 'edit', 'update', 'destroy'])
        ->missing(function (){
            $alertPosition = app()->getLocale() == 'en' ? 'top-right' : 'top-start';
            toast(trans('general.page_not_exist'),'error')->position($alertPosition);;
            return to_route('order.index');
        });
});
