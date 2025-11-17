<?php

namespace App\Filament\Resources\Maputras;

use App\Filament\Resources\Maputras\Pages\CreateMaputra;
use App\Filament\Resources\Maputras\Pages\EditMaputra;
use App\Filament\Resources\Maputras\Pages\ListMaputras;
use App\Filament\Resources\Maputras\Schemas\MaputraForm;
use App\Filament\Resources\Maputras\Tables\MaputrasTable;
use App\Models\Maputra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaputraResource extends Resource
{
    protected static ?string $model = Maputra::class;

    protected static ?string $navigationLabel = 'MA Putra'; // Nama di sidebar
    protected static ?string $pluralLabel = 'Data MA Putra'; // Judul di halaman daftar
    protected static ?string $label = 'Data MA Putra'; // Label di halaman form/detail


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MaputraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaputrasTable::configure($table);
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
            'index' => ListMaputras::route('/'),
            'create' => CreateMaputra::route('/create'),
            'edit' => EditMaputra::route('/{record}/edit'),
        ];
    }
}
