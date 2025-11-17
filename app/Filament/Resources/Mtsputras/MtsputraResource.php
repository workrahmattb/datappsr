<?php

namespace App\Filament\Resources\Mtsputras;

use App\Filament\Resources\Mtsputras\Pages\CreateMtsputra;
use App\Filament\Resources\Mtsputras\Pages\EditMtsputra;
use App\Filament\Resources\Mtsputras\Pages\ListMtsputras;
use App\Filament\Resources\Mtsputras\Schemas\MtsputraForm;
use App\Filament\Resources\Mtsputras\Tables\MtsputrasTable;
use App\Models\Mtsputra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MtsputraResource extends Resource
{
    protected static ?string $model = Mtsputra::class;

    protected static ?string $navigationLabel = 'MTs Putra'; // Nama di sidebar
    protected static ?string $pluralLabel = 'Data MTs Putra'; // Judul di halaman daftar
    protected static ?string $label = 'Data MTs Putra'; // Label di halaman form/detail


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MtsputraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MtsputrasTable::configure($table);
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
            'index' => ListMtsputras::route('/'),
            'create' => CreateMtsputra::route('/create'),
            'edit' => EditMtsputra::route('/{record}/edit'),
        ];
    }
}
