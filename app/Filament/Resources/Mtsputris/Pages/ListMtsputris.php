<?php

namespace App\Filament\Resources\Mtsputris\Pages;

use App\Filament\Resources\Mtsputris\MtsputriResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMtsputris extends ListRecords
{
    protected static string $resource = MtsputriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
