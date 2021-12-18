<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\AdminUserResponseMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share auth user with all views ... Using closure based composers...
        View::composer('*', function ($view) {
            $view->with('user', auth()->user());
        });

        // Call Cache service provider as singelton
        $this->app->singleton(AdminUserResponseMiddleware::class);
    }
}
