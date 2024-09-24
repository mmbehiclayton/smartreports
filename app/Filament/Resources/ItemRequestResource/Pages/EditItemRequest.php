<?php

namespace App\Filament\Resources\ItemRequestResource\Pages;

use App\Filament\Resources\ItemRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemRequest extends EditRecord
{

    use  \EightyNine\Approvals\Traits\HasApprovalHeaderActions;
    protected static string $resource = ItemRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
