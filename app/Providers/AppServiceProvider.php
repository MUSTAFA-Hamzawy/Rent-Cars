<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('greater_than_start_hour', function ($attribute, $value, $parameters, $validator){
            return strtotime($value) > strtotime($validator->getData()[$parameters[0]]);
        });
        Paginator::useBootstrapFive();
    }
}
