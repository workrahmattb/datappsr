<?php

namespace App\Filament\Resources\Mtsputras\Pages;

use App\Filament\Resources\Mtsputras\MtsputraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMtsputras extends ListRecords
{
    protected static string $resource = MtsputraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
