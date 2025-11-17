<?php

namespace App\Filament\Resources\Mtsputras\Tables;

use App\Models\Mtsputra;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Barryvdh\DomPDF\Facade\Pdf;
class MtsputrasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
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
            ->recordUrl(null) // ⛔ supaya klik baris tidak membuka edit/view
            ->actions([
                Action::make('exportPdf')
                ->label('PDF')
                ->color('success')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function ($record) {
                    $pdf = Pdf::loadView('pdf.mtsputra', [
                        'record' => $record
                    ]);

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'mtsputra-' . $record->id . '.pdf');
                }),
                ViewAction::make()->label('Lihat'),
                EditAction::make()->label('Edit'),
                DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->headerActions([
                Action::make('export')
                    ->label('Export Berdasarkan Tahun Ajaran')
                    ->icon('heroicon-o-arrow-down-tray')

                    ->form([
                        Select::make('tahun_ajaran')
                            ->label('Pilih Tahun Ajaran')
                            ->options(
                                Mtsputra::query()
                                    ->select('tahun_ajaran')
                                    ->distinct()
                                    ->orderBy('tahun_ajaran')
                                    ->pluck('tahun_ajaran', 'tahun_ajaran')
                            )
                            ->searchable()
                            ->required(),
                    ])

                    ->action(function (array $data) {

                        // Tahun ajaran dari database
                        $tahunAjaran = $data['tahun_ajaran'];

                        // Sanitasi nama file (replace "/", spasi, karakter aneh)
                        $tahunFile = preg_replace('/[^A-Za-z0-9\-]/', '-', str_replace('/', '-', $tahunAjaran));

                        // Nama file final
                        $file = "mtsputra-{$tahunFile}-" . now()->format('YmdHis') . '.xlsx';

                        // Ambil data berdasarkan tahun ajaran
                        $rows = Mtsputra::where('tahun_ajaran', $tahunAjaran)->get();

                        // Buat dan isi file Excel
                        $path = storage_path("app/$file");
                        SimpleExcelWriter::create($path)->addRows($rows->toArray());

                        // Download + hapus file setelah dikirim
                        return response()->download($path)->deleteFileAfterSend();
                    }),
            ])

            ;
    }
}
