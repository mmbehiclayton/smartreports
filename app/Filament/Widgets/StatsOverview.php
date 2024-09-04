<?php

namespace App\Filament\Widgets;

use App\Models\ItemRequest;
use App\Models\Report;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total App Reports', Report::count()),
            Stat::make('Total App Users', User::count()),
            Stat::make('Total App Requests', ItemRequest::count()),
        ];
    }
}
