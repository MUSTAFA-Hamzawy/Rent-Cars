<?php

use App\Http\Controllers\api\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Search Routes (API)
|--------------------------------------------------------------------------
*/

// Searching
Route::get('/search', SearchController::class);
