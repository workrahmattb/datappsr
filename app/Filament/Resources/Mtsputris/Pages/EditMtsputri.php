<?php

namespace App\Filament\Resources\Mtsputris\Pages;

use App\Filament\Resources\Mtsputris\MtsputriResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMtsputri extends EditRecord
{
    protected static string $resource = MtsputriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
