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
//Route::middleware([])->resource('brand', BrandController::class)
//    ->except('update');

Route::middleware([])->group(function (){
   Route::resource('brand', BrandController::class)
       ->missing(function (){
           toast('Failed, this brand does not exist.','error')->position('top-start');;
           return to_route('brand.index');
       });
});
