<?php

namespace App\Filament\Resources\Kelas\Tables;

use Filament\Tables\Table;
use Filament\Tables;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class KelasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kelas')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('tingkat')
                    ->label('Tingkat')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'MTs' => 'info',
                        'MA' => 'success',
                    })
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('nomor_kelas')
                    ->label('Nomor Kelas')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('guru.name')
                    ->label('Wali Kelas')
                    ->searchable()
                    ->sortable()
                    ->default('-'),
                
                TextColumn::make('kapasitas')
                    ->label('Kapasitas')
                    ->numeric()
                    ->sortable(),
                
                TextColumn::make('mtsputris_count')
                    ->label('MTs Putri')
                    ->counts('mtsputris')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                
                TextColumn::make('mtsputras_count')
                    ->label('MTs Putra')
                    ->counts('mtsputras')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                
                TextColumn::make('maputris_count')
                    ->label('MA Putri')
                    ->counts('maputris')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                
                TextColumn::make('maputras_count')
                    ->label('MA Putra')
                    ->counts('maputras')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                
                TextColumn::make('total_siswa')
                    ->label('Total Siswa')
                    ->state(function ($record) {
                        return $record->mtsputris_count + 
                               $record->mtsputras_count + 
                               $record->maputris_count + 
                               $record->maputras_count;
                    })
                    ->badge()
                    ->color('danger')
                    ->sortable(query: function ($query, $direction) {
                        return $query->withCount(['mtsputris', 'mtsputras', 'maputris', 'maputras'])
                            ->orderByRaw('(mtsputris_count + mtsputras_count + maputris_count + maputras_count) ' . $direction);
                    }),
                
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tingkat')
                    ->label('Tingkat')
                    ->options([
                        'MTs' => 'MTs (Madrasah Tsanawiyah)',
                        'MA' => 'MA (Madrasah Aliyah)',
                    ]),
                
                Tables\Filters\SelectFilter::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->options([
                        '2023/2024' => '2023/2024',
                        '2024/2025' => '2024/2025',
                        '2025/2026' => '2025/2026',
                        '2026/2027' => '2026/2027',
                        '2027/2028' => '2027/2028',
                        '2028/2029' => '2028/2029',
                    ]),
            ])
            ->actions([
                EditAction::make()->label('Edit'),
                DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
