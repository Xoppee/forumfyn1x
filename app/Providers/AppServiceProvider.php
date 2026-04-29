<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Pages;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('components.sidebar', function ($view) {
            $pages = Pages::where('is_published', true)->orderBy('index')->get();
            $view->with('pages', $pages);
        });
    }
}