<?php

use App\Http\Controllers\BranchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Branch Routes
|--------------------------------------------------------------------------
*/
//


Route::middleware(['auth'])->group(function (){
    Route::delete('branch/remove_all', [BranchController::class, 'truncate'])->name('branch.truncate');
    Route::resource('branch', BranchController::class)
        ->missing(function (){
            $alertPosition = app()->getLocale() == 'en' ? 'top-right' : 'top-start';
            toast(trans('general.page_not_exist'),'error')->position($alertPosition);;
            return to_route('branch.index');
        });

});
