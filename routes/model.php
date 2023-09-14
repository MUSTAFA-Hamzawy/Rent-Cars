<?php

use App\Http\Controllers\ModelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Model Routes
|--------------------------------------------------------------------------
*/
//


Route::middleware(['auth'])->group(function (){
    Route::delete('model/remove_all', [ModelController::class, 'truncate'])->name('model.truncate');
    Route::resource('model', ModelController::class)
        ->missing(function (){
            $alertPosition = app()->getLocale() == 'en' ? 'top-right' : 'top-start';
            toast(trans('general.page_not_exist'),'error')->position($alertPosition);;
            return to_route('model.index');
        });

});
