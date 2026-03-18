<?php

namespace App\Filament\Resources\Pendaftarans\Tables;

use App\Filament\Imports\PendaftaranImporter;
use App\Models\Pendaftaran;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Filament\Tables\Columns\ImageColumn;

class PendaftaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nisn')
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable()
                    ->formatStateUsing(function (string $state, Pendaftaran $record): \Illuminate\Support\HtmlString {
                        if ($record->status_pendaftaran === 'pending') {
                            $url = route('filament.admin.resources.pendaftarans.daftar-ulang', ['record' => $record]);
                            return new \Illuminate\Support\HtmlString(
                                $state . ' <a href="' . $url . '" style="display: inline-block; margin-left: 8px; padding: 4px 12px; background-color: #10b981; color: white; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none;">Daftar Ulang</a>'
                            );
                        }
                        return new \Illuminate\Support\HtmlString($state);
                    }),
                TextColumn::make('tahun_ajaran')
                    ->searchable(),
                TextColumn::make('jenjang_pendidikan')
                    ->searchable(),
                TextColumn::make('status_pendaftaran')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'completed' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'completed' => 'Selesai',
                        default => $state,
                    }),
                TextColumn::make('tempat_lahir')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('asal_sekolah')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('alamat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nama_ayah')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nama_ibu')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('no_hp')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('bayar_uang_masuk')
                    ->label('Bayar Uang Masuk')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('buktitransfer')
                    ->label('Bukti Transfer')
                    ->disk('public')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->headerActions([
                Action::make('download_template')
                    ->label('Download Template CSV')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->action(function () {
                        $templatePath = storage_path('app/public/templates/pendaftaran_template.csv');
                        
                        if (!file_exists($templatePath)) {
                            \Filament\Notifications\Notification::make()
                                ->title('Template tidak ditemukan')
                                ->danger()
                                ->send();
                            return;
                        }
                        
                        return response()->download($templatePath, 'template_import_pendaftaran.csv');
                    }),
                
                ImportAction::make()
                    ->importer(PendaftaranImporter::class)
                    ->label('Import Data')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->csvDelimiter(',')
                    ->maxRows(1000),
                
                Action::make('export')
                    ->label('Export Berdasarkan Tahun Ajaran')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->form([
                        Select::make('tahun_ajaran')
                            ->label('Pilih Tahun Ajaran')
                            ->options(
                                Pendaftaran::query()
                                    ->select('tahun_ajaran')
                                    ->distinct()
                                    ->orderBy('tahun_ajaran')
                                    ->pluck('tahun_ajaran', 'tahun_ajaran')
                            )
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        // Tahun ajaran asli dari database
                        $tahunAjaran = $data['tahun_ajaran'];

                        // Sanitasi untuk nama file (replace "/", spasi, dan karakter berbahaya)
                        $tahunFile = preg_replace('/[^A-Za-z0-9\-]/', '-', str_replace('/', '-', $tahunAjaran));

                        // Nama file final
                        $file = "pendaftaran-{$tahunFile}-" . now()->format('YmdHis') . '.xlsx';

                        // Ambil data sesuai tahun ajaran
                        $rows = Pendaftaran::where('tahun_ajaran', $tahunAjaran)->get();

                        // Generate Excel
                        $path = storage_path("app/$file");
                        SimpleExcelWriter::create($path)->addRows($rows->toArray());

                        // Download dan hapus setelah dikirim
                        return response()->download($path)->deleteFileAfterSend();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
