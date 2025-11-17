<?php

namespace App\Filament\Resources\Mtsputras\Pages;

use App\Filament\Resources\Mtsputras\MtsputraResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMtsputra extends EditRecord
{
    protected static string $resource = MtsputraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
