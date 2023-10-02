<?php

use App\Http\Controllers\StatsController;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home_page');
})->name('home');

Route::fallback(function(){
    return view('not_found_page');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [StatsController::class, '__invoke'])->name('dashboard');

    // mark-notification-as-read
    Route::get('/read_notification/{notification}', function(DatabaseNotification $notification){
        $notification->markAsRead();
        return to_route('order.index');
    })->name('read-order-notification');

    Route::get('/read_all_notifications', function(){
        Auth::user()->unreadNotifications->markAsRead();
    })->name('read-all-notification');

    Route::post('/all_notifications', function (){
        return response(Auth::user()->notifications);
    })->name('get-user-notifications');
});
