<?php

namespace App\Providers;
use App\Http\Controllers\Storefront\CartController;
use App\Services\HeaderService;
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

            try {
                // Session may not be available (e.g. during exception rendering on live)
                $request = request();
                if (!$request->hasSession() || !$request->session()->isStarted()) {
                    $view->with('carts', ['items' => [], 'total' => 0]);
                    $view->with(app(HeaderService::class)->data());
                    return;
                }

                $cart = app(CartController::class)->cart($request);
                $view->with(app(HeaderService::class)->data());
                $view->with('carts', $cart);
            } catch (\Throwable $e) {
                // Fallback: provide empty cart so views don't  
                $view->with('carts', ['items' => [], 'total' => 0]);
                try {
                    $view->with(app(HeaderService::class)->data());
                } catch (\Throwable $e2) {
                    // HeaderService also failed — provide defaults
                    $view->with('mainSchools', collect());
                    $view->with('mainCategories', collect());
                }
            }
        });


    }
}
