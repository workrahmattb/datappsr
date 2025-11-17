<?php

namespace App\Filament\Resources\Maputras\Pages;

use App\Filament\Resources\Maputras\MaputraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaputras extends ListRecords
{
    protected static string $resource = MaputraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
