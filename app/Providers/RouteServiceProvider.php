<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api/api.php'))
                ->group(base_path('routes/api/user.php'))
                ->group(base_path('routes/api/brand.php'))
                ->group(base_path('routes/api/branch.php'))
                ->group(base_path('routes/api/category.php'))
                ->group(base_path('routes/api/car.php'))
                ->group(base_path('routes/api/search.php'))
                ->group(base_path('routes/api/order.php'));

            Route::middleware('web')
                ->prefix(LaravelLocalization::setLocale())
                ->group(base_path('routes/web.php'))
                ->group(base_path('routes/brand.php'))
                ->group(base_path('routes/category.php'))
                ->group(base_path('routes/model.php'))
                ->group(base_path('routes/payment_method.php'))
                ->group(base_path('routes/branch.php'))
                ->group(base_path('routes/car.php'))
                ->group(base_path('routes/order.php'));

        });
    }
}
