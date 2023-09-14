<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Category Routes
|--------------------------------------------------------------------------
*/
//


Route::middleware(['auth'])->group(function (){
    Route::delete('category/remove_all', [CategoryController::class, 'truncate'])->name('category.truncate');
    Route::resource('category', CategoryController::class)
        ->missing(function (){
            $alertPosition = app()->getLocale() == 'en' ? 'top-right' : 'top-start';
            toast(trans('general.page_not_exist'),'error')->position($alertPosition);;
            return to_route('category.index');
        });

});
