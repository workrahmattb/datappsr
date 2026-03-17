<?php

namespace App\Filament\Resources\Kelas\RelationManagers;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
// gunakan namespace yang benar untuk actions di Filament v4:
use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;

class MaputrisRelationManager extends RelationManager
{
    protected static string $relationship = 'maputris';

    protected static ?string $title = 'Siswa MTs Putri';

    protected static ?string $label = 'Siswa MTs Putri';

    protected static ?string $pluralLabel = 'Siswa MTs Putri';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tgl_masuk')
                    ->label('Tanggal Masuk')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                        Action::make('attachStudent')
                            ->label('Tambahkan Siswa yang Sudah Ada')
                            ->icon('heroicon-o-plus')
                            ->form([
                                Select::make('siswa_id')
                                    ->label('Pilih Siswa')
                                    ->searchable()
                                    ->preload()
                                    ->options(
                                        \App\Models\Maputri::whereNull('kelas_id')
                                            ->orderBy('nama')
                                            ->pluck('nama', 'id')
                                    )
                                    ->required(),
                            ])
                            ->action(function (array $data, RelationManager $livewire) {
                                // ambil ID kelas dari parent
                                $kelasId = $livewire->ownerRecord->id;

                                // update siswa
                                \App\Models\Maputri::find($data['siswa_id'])
                                    ->update(['kelas_id' => $kelasId]);
                            })
                            ->modalHeading('Tambahkan Siswa ke Kelas Ini')
                            ->successNotificationTitle('Siswa berhasil dimasukkan ke kelas'),
                    ])

            // gunakan recordActions untuk aksi pada setiap baris
            ->recordActions([
                ViewAction::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => route('filament.admin.resources.maputris.edit', $record))
                    ->openUrlInNewTab(),

                Action::make('remove')
                    ->label('Keluarkan')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['kelas_id' => null]))
                    ->successNotificationTitle('Siswa berhasil dikeluarkan dari kelas'),
            ])
            ->bulkActions([
                //
            ]);
    }
}