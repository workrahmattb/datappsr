<?php

namespace App\Filament\Resources\Gurus\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GuruForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label('Nama Lengkap')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                
                TextInput::make('no_hp')
                    ->label('Nomor HP/WhatsApp')
                    ->tel()
                    ->inputMode('numeric')
                    ->rule('regex:/^[0-9]+$/')
                    ->maxLength(15)
                    ->placeholder('08xxxxxxxxxx'),
                
                DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->maxDate(now()),
                
                Textarea::make('alamat')
                    ->required()
                    ->label('Alamat Lengkap')
                    ->rows(3)
                    ->autosize()
                    ->columnSpanFull(),
            ]);
    }
}
