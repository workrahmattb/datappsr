<?php

namespace App\Filament\Resources\Maputris;

use App\Filament\Resources\Maputris\Pages\CreateMaputri;
use App\Filament\Resources\Maputris\Pages\EditMaputri;
use App\Filament\Resources\Maputris\Pages\ListMaputris;
use App\Filament\Resources\Maputris\Schemas\MaputriForm;
use App\Filament\Resources\Maputris\Tables\MaputrisTable;
use App\Models\Maputri;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaputriResource extends Resource
{
    protected static ?string $model = Maputri::class;

    protected static ?string $navigationLabel = 'MA Putri'; // Nama di sidebar
    protected static ?string $pluralLabel = 'Data Ma Putri'; // Judul di halaman daftar
    protected static ?string $label = 'Data MA Putri'; // Label di halaman form/detail


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MaputriForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaputrisTable::configure($table);
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
            'index' => ListMaputris::route('/'),
            'create' => CreateMaputri::route('/create'),
            'edit' => EditMaputri::route('/{record}/edit'),
        ];
    }
}
