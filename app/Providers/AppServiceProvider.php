<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
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
        // Share the active categories with the header, home page and shop —
        // a single database-driven source for the whole site's navigation.
        View::composer(['components.site-header', 'home', 'products.index'], function ($view) {
            $view->with('navCategories', Category::active()->ordered()->get());
        });
    }
}
