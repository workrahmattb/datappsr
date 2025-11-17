<?php

namespace App\Filament\Resources\Maputris\Schemas;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;

class MaputriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tempat_lahir')
                    ->searchable(),
                TextColumn::make('tanggal_lahir')
                    ->date(),
                TextColumn::make('nik')
                    ->searchable(),

                TextColumn::make('nisn')
                    ->searchable(),
                TextColumn::make('nis')
                    ->searchable(),


                TextColumn::make('tahun_ajaran')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_sekolah_sebelumnya')
                    ->searchable(),
                TextColumn::make('npsn_sekolah_sebelumnya')
                    ->searchable(),

                TextColumn::make('nama_ayah')
                    ->searchable(),


                TextColumn::make('no_hp_ayah')
                    ->searchable(),

                TextColumn::make('pekerjaan_ayah')
                    ->searchable(),
                TextColumn::make('penghasilan_ayah')
                    ->searchable(),

                TextColumn::make('nama_ibu')
                    ->searchable(),

                TextColumn::make('no_hp_ibu')
                    ->searchable(),

                TextColumn::make('pekerjaan_ibu')
                    ->searchable(),
                TextColumn::make('penghasilan_ibu')
                    ->searchable(),



                TextColumn::make('desa')
                    ->searchable(),
                TextColumn::make('kecamatan')
                    ->searchable(),
                TextColumn::make('kabupaten')
                    ->searchable(),
                TextColumn::make('provinsi')
                    ->searchable(),


                ImageColumn::make('fotokk')
                    ->disk('public'),
                ImageColumn::make('fotoakta')
                    ->disk('public'),
            ]);
    }
}
