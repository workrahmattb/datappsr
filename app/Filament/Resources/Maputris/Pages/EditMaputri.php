<?php

namespace App\Filament\Resources\Maputris\Pages;

use App\Filament\Resources\Maputris\MaputriResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMaputri extends EditRecord
{
    protected static string $resource = MaputriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
