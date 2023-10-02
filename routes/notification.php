<?php

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/read_notification/{notification}', function(DatabaseNotification $notification){
        $notification->markAsRead();
        return to_route('order.index');
    })->name('read-order-notification');

    Route::get('/read_all_notifications', function(){
        Auth::user()->unreadNotifications->markAsRead();
    })->name('read-all-notification');

    Route::post('/all_notifications', function (){
        return response([
            'notifications' => Auth::user()->notifications,
            'unreadNotificationsCount' => count(Auth::user()->unreadNotifications)
        ]);
    })->name('get-user-notifications');
});
