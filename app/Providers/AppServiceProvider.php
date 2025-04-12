<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

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
        //
        Schema::defaultStringLength(191);

        //share the theme and background classes with all views
        // This will set the theme and background classes based on the cookie value
        View::composer('*', function ($view) {
            $theme = request()->cookie('theme', 'light');
            $bgClass = $theme === 'dark' ? 'bg-dark' : 'bg-light';
            $textClass = $theme === 'dark' ? 'text-light' : 'text-dark';
            $borderClass = $theme === 'dark' ? 'border-light' : 'border-dark';
            $view->with(compact('theme', 'bgClass', 'textClass', 'borderClass'));
        });
    }
}
