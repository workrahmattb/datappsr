<?php

namespace App\Filament\Resources\Mtsputris;

use App\Filament\Resources\Mtsputris\Pages\CreateMtsputri;
use App\Filament\Resources\Mtsputris\Pages\EditMtsputri;
use App\Filament\Resources\Mtsputris\Pages\ListMtsputris;
use App\Filament\Resources\Mtsputris\Schemas\MtsputriForm;
use App\Filament\Resources\Mtsputris\Tables\MtsputrisTable;
use App\Models\Mtsputri;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MtsputriResource extends Resource
{
    protected static ?string $model = Mtsputri::class;

    protected static ?string $navigationLabel = 'MTs Putri'; // Nama di sidebar
    protected static ?string $pluralLabel = 'Data MTs Putri'; // Judul di halaman daftar
    protected static ?string $label = 'Data MTs Putri'; // Label di halaman form/detail

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MtsputriForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MtsputrisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMtsputris::route('/'),
            'create' => CreateMtsputri::route('/create'),
            'edit' => EditMtsputri::route('/{record}/edit'),
        ];
    }
}
