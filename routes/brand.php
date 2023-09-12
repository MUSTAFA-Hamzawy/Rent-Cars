<?php

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

/*
|--------------------------------------------------------------------------
| Brand Routes
|--------------------------------------------------------------------------
*/
//


Route::middleware(['auth'])->group(function (){
    Route::delete('brand/remove_all', [BrandController::class, 'truncate'])->name('brand.truncate');
    Route::resource('brand', BrandController::class)
       ->missing(function (){
           $alertPosition = app()->getLocale() == 'en' ? 'top-right' : 'top-start';
           toast(trans('general.page_not_exist'),'error')->position($alertPosition);;
           return to_route('brand.index');
       });

});
