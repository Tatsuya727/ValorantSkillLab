<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use App\Models\Category;

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
        Inertia::share([
            'flash' => function () {
                return [
                    'message' => session('message'),
                ];
            },
            'categories' => function () {
                if (auth()->user()) {
                    return Category::where('user_id', auth()->id())->get();
                }
                return [];
            },
        ]);
    }
}
