<?php

namespace App\Filament\Resources\Kelas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Models\Guru;

class KelasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label('Nama Kelas')
                    ->placeholder('Contoh: VII A, X IPA 1')
                    ->maxLength(255),
                
                Select::make('tingkat')
                    ->required()
                    ->label('Tingkat')
                    ->options([
                        'MTs' => 'MTs (Madrasah Tsanawiyah)',
                        'MA' => 'MA (Madrasah Aliyah)',
                    ]),
                
                Select::make('nomor_kelas')
                    ->required()
                    ->label('Nomor Kelas')
                    ->options([
                        'VII' => 'VII (Kelas 7)',
                        'VIII' => 'VIII (Kelas 8)',
                        'IX' => 'IX (Kelas 9)',
                        'X' => 'X (Kelas 10)',
                        'XI' => 'XI (Kelas 11)',
                        'XII' => 'XII (Kelas 12)',
                    ]),
                
                Select::make('tahun_ajaran')
                    ->required()
                    ->label('Tahun Ajaran')
                    ->options([
                        '2023/2024' => '2023/2024',
                        '2024/2025' => '2024/2025',
                        '2025/2026' => '2025/2026',
                        '2026/2027' => '2026/2027',
                        '2027/2028' => '2027/2028',
                        '2028/2029' => '2028/2029',
                    ]),
                
                Select::make('guru_id')
                    ->label('Wali Kelas')
                    ->relationship('guru', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->placeholder('Pilih Guru sebagai Wali Kelas')
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->label('Nama Guru'),
                    ]),
                
                TextInput::make('kapasitas')
                    ->required()
                    ->label('Kapasitas Siswa')
                    ->numeric()
                    ->default(30)
                    ->minValue(1)
                    ->maxValue(50),
            ]);
    }
}
