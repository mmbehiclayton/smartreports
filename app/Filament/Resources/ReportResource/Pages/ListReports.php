<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All')
                ->query(fn (Builder $query) => $query
                    ->where('user_id', Auth::id())
                    ->orWhereHas('recipients', fn (Builder $query) => $query->where('user_id', Auth::id()))
                ),

            'Sent Reports' => Tab::make('Sent Reports')
                ->query(fn (Builder $query) => $query->where('user_id', Auth::id())),

            'Received Reports' => Tab::make('Received Reports')
                ->query(fn (Builder $query) => $query->whereHas('recipients', fn (Builder $query) => $query->where('user_id', Auth::id())))
        ];
    }
}
