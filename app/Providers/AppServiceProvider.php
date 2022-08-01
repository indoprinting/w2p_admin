<?php

namespace App\Providers;

use App\View\Composer\MenuComposer;
use App\View\Composer\setPaymentComposer;
use App\View\Composer\ThemeComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrap();
        View::composer(['layouts.sidebar'], MenuComposer::class);
        View::composer(['layouts.navbar', 'layouts.main', 'errors.minimal'], ThemeComposer::class);
        View::composer(['layouts.navbar'], setPaymentComposer::class);
    }
}
