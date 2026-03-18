<?php

namespace App\Providers;

// In App\Providers\ViewServiceProvider.php

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Seo;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $currentRoute = Route::currentRouteName(); // e.g. 'about', 'contact', etc.
            
            if ($currentRoute) {
                $seo = Seo::where('page_name', $currentRoute)->first();
                $view->with('seo', $seo);
            }
        });
    }
}

