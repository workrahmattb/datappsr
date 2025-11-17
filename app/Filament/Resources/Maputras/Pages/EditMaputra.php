<?php

namespace App\Filament\Resources\Maputras\Pages;

use App\Filament\Resources\Maputras\MaputraResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMaputra extends EditRecord
{
    protected static string $resource = MaputraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
