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

    public function registerRoutes(): void
    {
        Route::get('/admin', [HomeController::class, 'index'])->name('admin.dashboard');
    }
}
