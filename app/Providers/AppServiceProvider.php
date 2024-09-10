<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Models\Report;
use App\Observers\ReportObserver;
use Filament\Http\Controllers\HomeController;
use Route;


class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Report::observe(ReportObserver::class);
    }

    
}
