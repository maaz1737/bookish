<?php

namespace App\Providers;
use App\Http\Controllers\Storefront\CartController;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);
        View::composer('*', function ($view) {
            $view->with('globalCategories', Category::all()); // active status filter lagana chahein to scope use karlein  
        });

        View::composer('*', function ($view) {
            $view->with('cart', app(CartController::class)->cart(request()));
        });
    }
}
