<?php

namespace App\Filament\Resources\ItemRequestResource\Pages;

use App\Filament\Resources\ItemRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItemRequests extends ListRecords
{
    protected static string $resource = ItemRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
