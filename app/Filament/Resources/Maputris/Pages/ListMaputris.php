<?php

namespace App\Filament\Resources\Maputris\Pages;

use App\Filament\Resources\Maputris\MaputriResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaputris extends ListRecords
{
    protected static string $resource = MaputriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
