<?php

use App\Http\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Payment Method Routes
|--------------------------------------------------------------------------
*/
//


Route::middleware(['auth'])->group(function (){
    Route::delete('payment_method/remove_all', [PaymentMethodController::class, 'truncate'])->name('payment_method.truncate');
    Route::resource('payment_method', PaymentMethodController::class)
        ->missing(function (){
            $alertPosition = app()->getLocale() == 'en' ? 'top-right' : 'top-start';
            toast(trans('general.page_not_exist'),'error')->position($alertPosition);;
            return to_route('payment_method.index');
        });

});
