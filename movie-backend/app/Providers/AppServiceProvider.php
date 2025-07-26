<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as AuthServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     */
    public const HOME = '/home';

    public function boot(): void
    {
        $this->routes(function () {
           
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

       
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
