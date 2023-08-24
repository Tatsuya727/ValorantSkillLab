<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;  // 追加
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
        if (config('app.env') === 'production') { 
            URL::forceScheme('https');
        }

        Inertia::share([
            'flash' => function () {
                return [
                    'message' => session('message'),
                ];
            },
            'NavCategories' => function () {
                if (auth()->user()) {
                    return Category::where('user_id', auth()->id())->get();
                }
                return [];
            },
        ]);
    }
}
