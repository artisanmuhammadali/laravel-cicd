<?php

namespace App\Providers;

use App\Models\Announcement;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

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
        view()->composer('*', function ($view) {
            $view->with(
                [
                    'setting'=> Setting::pluck('value', 'key')->toArray() , 
                    'auth'=> auth()->user(),
                    'avgJson'=>[],
                    'announcements'=>Announcement::active()->get(),
                ]
            );
        });
        Blade::if('routeis', function ($expression) {
            return fnmatch($expression, Route::currentRouteName());
        });
        Paginator::useBootstrap();
    }
}
