<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Categories;

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
        // Share categories with all views for navigation menu
        View::composer('front.layouts.header', function ($view) {
            $view->with('navCategories', Categories::where('status', 1)->orderBy('id', 'asc')->get());
        });
    }
}
