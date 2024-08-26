<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Models\Report;
use App\Observers\ReportObserver;


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
        Report::observe(ReportObserver::class);
    }
}
