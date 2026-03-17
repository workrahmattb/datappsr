<?php

namespace App\Filament\Imports;

use App\Models\Mtsputri;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class MtsputriImporter extends Importer
{
    protected static ?string $model = Mtsputri::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')->rules(['nullable']),
            ImportColumn::make('tempat_lahir')->rules(['nullable']),
            ImportColumn::make('tanggal_lahir')->rules(['nullable', 'date']),

            ImportColumn::make('nisn')->rules(['nullable']),
            ImportColumn::make('tahun_ajaran')->rules(['nullable']),

            ImportColumn::make('nama_ayah')->rules(['nullable']),

            ImportColumn::make('nama_ibu')->rules(['nullable']),


        ];
    }

    public function resolveRecord(): Mtsputri
    {
        return new Mtsputri();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your mtsputri import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
