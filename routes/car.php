<?php

use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Car Routes
|--------------------------------------------------------------------------
*/
//


Route::middleware(['auth'])->group(function (){
    Route::delete('car/remove_all', [CarController::class, 'truncate'])->name('car.truncate');
    Route::resource('car', CarController::class)
       ->missing(function (){
           $alertPosition = app()->getLocale() == 'en' ? 'top-right' : 'top-start';
           toast(trans('general.page_not_exist'),'error')->position($alertPosition);;
           return to_route('car.index');
       });

});
