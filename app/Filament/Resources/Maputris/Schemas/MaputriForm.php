<?php

namespace App\Filament\Resources\Maputris\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;

class MaputriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required()
                    ->label('Nama Lengkap')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                TextInput::make('tempat_lahir')
                    ->required()
                    ->label('Tempat Lahir')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                DatePicker::make('tanggal_lahir')
                    ->required()
                    ->label('Tanggal Lahir'),
                TextInput::make('nik')
                    ->label('No. NIK (Nomor Induk Kependudukan)')
                    ->inputMode('numeric')
                    ->length(16)
                    ->rule('regex:/^[0-9]{16}$/')
                    ->helperText('NIK harus 16 digit')
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                TextInput::make('kk')
                    ->label('No. KK (Kartu Keluarga)')
                    ->inputMode('numeric')
                    ->length(16)
                    ->rule('regex:/^[0-9]{16}$/')
                    ->helperText('No. KK harus 16 digit')
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                TextInput::make('nama_kk')
                    ->label('Nama Kepala Keluarga'),
                TextInput::make('nisn')
                    ->label('NISN (Nomor Induk Siswa Nasional)')
                    ->inputMode('numeric')
                    ->length(10)
                    ->rule('regex:/^[0-9]{10}$/')
                    ->helperText('NISN harus 10 digit')
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                TextInput::make('nis')
                    ->label('NIS (Nomor Induk Siswa)')
                    ->numeric(),
                TextInput::make('anak_ke')
                    ->label('Anak Ke-')
                    ->numeric(),
                TextInput::make('jumlah_saudara')
                    ->label('Jumlah Saudara')
                    ->numeric(),

                Select::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->options([
                                '2023/2024' => '2023/2024',
                                '2024/2025' => '2024/2025',
                                '2025/2026' => '2025/2026',
                                '2026/2027' => '2026/2027',
                                '2027/2028' => '2027/2028',
                                '2028/2029' => '2028/2029',
                            ])
                    ->nullable(),

                Select::make('kelas_id')
                    ->label('Kelas')
                    ->relationship('kelas', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Pilih kelas dari daftar kelas yang tersedia'),

                DatePicker::make('tgl_masuk')
                    ->label('Tanggal Masuk'),
                TextInput::make('kks')
                    ->label('No. KKS (Kartu Keluarga Sejahtera)')
                    ->inputMode('numeric')
                    ->rule('regex:/^[0-9]+$/'),
                TextInput::make('pkh')
                    ->label('No. PKH (Program Keluarga Harapan)')
                    ->inputMode('numeric')
                    ->rule('regex:/^[0-9]+$/'),
                TextInput::make('kip')
                    ->label('No. KIP (Kartu Indonesia Pintar)')
                    ->inputMode('numeric')
                    ->rule('regex:/^[0-9]+$/'),



                Select::make('jenjang_pendidikan_sebelumnya')
                    ->label('Jenjang Pendidikan Sebelumnya')
                    ->options([
                                'SD' => 'SD / MI',
                                'SMP' => 'SMP / MTs',
                            ]),
                Select::make('status_sekolah_sebelumnya')
                    ->label('Status Sekolah Sebelumnya')
                    ->options([
                                 'Negeri' => 'Negeri',
                                 'Swasta' => 'Swasta',
                             ]),
                TextInput::make('nama_sekolah_sebelumnya')
                    ->label('Nama Sekolah Sebelumnya')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                TextInput::make('npsn_sekolah_sebelumnya')
                    ->label('No. NPSN Sekolah Sebelumnya')
                    ->numeric(),
                Textarea::make('alamat_sekolah_sebelumnya')
                    ->label('Alamat Sekolah Sebelumnya')
                    ->autosize()
                    ->columnSpanFull(),
                TextInput::make('kecamatan_sekolah_sebelumnya')
                    ->label('Kecamatan Sekolah Sebelumnya'),
                TextInput::make('kabupaten_sekolah_sebelumnya')
                    ->label('Kabupaten Sekolah Sebelumnya'),
                TextInput::make('provinsi_sekolah_sebelumnya')
                    ->label('Provinsi Sekolah Sebelumnya'),


                TextInput::make('nik_ayah')
                    ->label('No. NIK Ayah')
                    ->inputMode('numeric')
                    ->length(16)
                    ->rule('regex:/^[0-9]{16}$/')
                    ->helperText('NIK harus 16 digit')
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                TextInput::make('nama_ayah')
                    ->label('Nama Ayah')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                TextInput::make('tempat_lahir_ayah')
                    ->label('Tempat Lahir Ayah')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                DatePicker::make('tanggal_lahir_ayah')
                    ->label('Tanggal Lahir Ayah'),
                Select::make('status_ayah')
                    ->label('Status Ayah')
                    ->options([
                                 'Hidup' => 'Hidup',
                                 'Meninggal' => 'Meninggal',
                             ]),
                TextInput::make('no_hp_ayah')
                    ->label('Nomor Whatsapp Ayah')
                    ->inputMode('numeric')
                    ->rule('regex:/^[0-9]+$/'),
                Select::make('pendidikan_ayah')
                    ->label('Pendidikan Terakhir Ayah')
                    ->options([
                                 'SD/Sederajat' => 'SD/Sederajat',
                                 'SMP/Sederajat' => 'SMP/Sederajat',
                                 'SMA/Sederajat' => 'SMA/Sederajat',
                                 'D1' => 'D1',
                                 'D2' => 'D2',
                                 'D3' => 'D3',
                                 'D4/S1' => 'D4/S1',
                                 'S2' => 'S2',
                                 'S3' => 'S3',
                                 'Tidak Bersekolah' => 'Tidak Bersekolah',
                                 'Lainnya' => 'Lainnya',
                             ]) ,
                Select::make('pekerjaan_ayah')
                    ->label('Pekerjaan Ayah')
                    ->options([
                                 'Tidak Bekerja' => 'Tidak Bekerja',
                                 'Pensiunan' => 'Pensiunan',
                                 'PNS' => 'PNS',
                                 'TNI/Polisi' => 'TNI/Polisi',
                                 'Guru/Dosen' => 'Guru/Dosen',
                                 'Pegawai Swasta' => 'Pegawai Swasta',
                                 'Wiraswasta' => 'Wiraswasta',
                                 'Pengacara/Jaksa/Hakim/Notaris' => 'Pengacara/Jaksa/Hakim/Notaris',
                                 'Seniman/Pelukis/Artis/Sejenis' => 'Seniman/Pelukis/Artis/Sejenis',
                                 'Dokter/Bidan/Perawat' => 'Dokter/Bidan/Perawat',
                                 'Pilot/Pramugara' => 'Pilot/Pramugara',
                                 'Pedagang' => 'Pedagang',
                                 'Petani/Peternak' => 'Petani/Peternak',
                                 'Nelayan' => 'Nelayan',
                                 'Buruh (Tani/Pabrik/Bangunan)' => 'Buruh (Tani/Pabrik/Bangunan)',
                                 'Sopir/Masinis/Kondektur' => 'Sopir/Masinis/Kondektur',
                                 'Politikus' => 'Politikus',
                                 'Lainnya' => 'Lainnya',
                             ]),
                Select::make('penghasilan_ayah')
                    ->label('Penghasilan Ayah')
                    ->options([
                        'dibawah 800.000' => 'Dibawah 800.000',
                        '800.001 - 1.200.000' => '800.001 - 1.200.000',
                        '1.200.001 - 1.800.000' => '1.200.001 - 1.800.000',
                        '1.800.001 - 2.500.000' => '1.800.001 - 2.500.000',
                        '2.500.001 - 3.500.000' => '2.500.001 - 3.500.000',
                        '3.500.001 - 4.800.000' => '3.500.001 - 4.800.000',
                        '4.800.001 - 6.500.000' => '4.800.001 - 6.500.000',
                        '6.500.001 - 10.000.000' => '6.500.001 - 10.000.000',
                        '10.000.001 - 20.000.000' => '10.000.001 - 20.000.000',
                        'diatas 20.000.001' => 'Diatas 20.000.001',
                    ])
                    ->searchable()
                    ->getOptionLabelUsing(fn ($value) => [
                        // data lama (biar tetap terbaca)
                        'Tidak Ada Penghasilan' => 'Tidak Ada Penghasilan',
                        '0 - 1 Juta' => '0 - 1 Juta',
                        '1 - 3 Juta' => '1 - 3 Juta',
                        '3 - 5 Juta' => '3 - 5 Juta',
                        '5 - 10 Juta' => '5 - 10 Juta',
                        '10 - 20 Juta' => '10 - 20 Juta',
                        '20 - 50 Juta' => '20 - 50 Juta',
                        '50 Juta Lebih' => '50 Juta Lebih',
                        'Tidak Tahu' => 'Tidak Tahu',

                        // data baru
                        'dibawah 800.000' => 'Dibawah 800.000',
                        '800.001 - 1.200.000' => '800.001 - 1.200.000',
                        '1.200.001 - 1.800.000' => '1.200.001 - 1.800.000',
                        '1.800.001 - 2.500.000' => '1.800.001 - 2.500.000',
                        '2.500.001 - 3.500.000' => '2.500.001 - 3.500.000',
                        '3.500.001 - 4.800.000' => '3.500.001 - 4.800.000',
                        '4.800.001 - 6.500.000' => '4.800.001 - 6.500.000',
                        '6.500.001 - 10.000.000' => '6.500.001 - 10.000.000',
                        '10.000.001 - 20.000.000' => '10.000.001 - 20.000.000',
                        'diatas 20.000.001' => 'Diatas 20.000.001',
                    ][$value] ?? $value),
                TextInput::make('nik_ibu')
                    ->label('No. NIK Ibu')
                    ->inputMode('numeric')
                    ->length(16)
                    ->rule('regex:/^[0-9]{16}$/')
                    ->helperText('NIK harus 16 digit')
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                TextInput::make('nama_ibu')
                    ->label('Nama Ibu')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                TextInput::make('tempat_lahir_ibu')
                    ->label('Tempat Lahir Ibu')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                DatePicker::make('tanggal_lahir_ibu')
                    ->label('Tanggal Lahir Ibu'),
                Select::make('status_ibu')
                    ->label('Status Ibu')
                    ->options([
                                 'Hidup' => 'Hidup',
                                 'Meninggal' => 'Meninggal',
                             ]),
                TextInput::make('no_hp_ibu')
                    ->label('Nomor Whatsapp Ibu')
                    ->inputMode('numeric')
                    ->rule('regex:/^[0-9]+$/'),
                Select::make('pendidikan_ibu')
                    ->label('Pendidikan Terakhir Ibu')
                    ->options([
                                 'SD/Sederajat' => 'SD/Sederajat',
                                 'SMP/Sederajat' => 'SMP/Sederajat',
                                 'SMA/Sederajat' => 'SMA/Sederajat',
                                 'D1' => 'D1',
                                 'D2' => 'D2',
                                 'D3' => 'D3',
                                 'D4/S1' => 'D4/S1',
                                 'S2' => 'S2',
                                 'S3' => 'S3',
                                 'Tidak Bersekolah' => 'Tidak Bersekolah',
                                 'Lainnya' => 'Lainnya',
                             ]) ,
                Select::make('pekerjaan_ibu')
                    ->label('Pekerjaan Ibu')
                    ->options([
                                 'Tidak Bekerja' => 'Tidak Bekerja',
                                 'Pensiunan' => 'Pensiunan',
                                 'PNS' => 'PNS',
                                 'TNI/Polisi' => 'TNI/Polisi',
                                 'Guru/Dosen' => 'Guru/Dosen',
                                 'Pegawai Swasta' => 'Pegawai Swasta',
                                 'Wiraswasta' => 'Wiraswasta',
                                 'Pengacara/Jaksa/Hakim/Notaris' => 'Pengacara/Jaksa/Hakim/Notaris',
                                 'Seniman/Pelukis/Artis/Sejenis' => 'Seniman/Pelukis/Artis/Sejenis',
                                 'Dokter/Bidan/Perawat' => 'Dokter/Bidan/Perawat',
                                 'Pilot/Pramugara' => 'Pilot/Pramugara',
                                 'Pedagang' => 'Pedagang',
                                 'Petani/Peternak' => 'Petani/Peternak',
                                 'Nelayan' => 'Nelayan',
                                 'Buruh (Tani/Pabrik/Bangunan)' => 'Buruh (Tani/Pabrik/Bangunan)',
                                 'Sopir/Masinis/Kondektur' => 'Sopir/Masinis/Kondektur',
                                 'Politikus' => 'Politikus',
                                 'Lainnya' => 'Lainnya',
                             ]),
                Select::make('penghasilan_ibu')
                    ->label('Penghasilan Ibu')
                    ->options([
                        'dibawah 800.000' => 'Dibawah 800.000',
                        '800.001 - 1.200.000' => '800.001 - 1.200.000',
                        '1.200.001 - 1.800.000' => '1.200.001 - 1.800.000',
                        '1.800.001 - 2.500.000' => '1.800.001 - 2.500.000',
                        '2.500.001 - 3.500.000' => '2.500.001 - 3.500.000',
                        '3.500.001 - 4.800.000' => '3.500.001 - 4.800.000',
                        '4.800.001 - 6.500.000' => '4.800.001 - 6.500.000',
                        '6.500.001 - 10.000.000' => '6.500.001 - 10.000.000',
                        '10.000.001 - 20.000.000' => '10.000.001 - 20.000.000',
                        'diatas 20.000.001' => 'Diatas 20.000.001',
                    ])
                    ->searchable()
                    ->getOptionLabelUsing(fn ($value) => [
                        // data lama (biar tetap terbaca)
                        'Tidak Ada Penghasilan' => 'Tidak Ada Penghasilan',
                        '0 - 1 Juta' => '0 - 1 Juta',
                        '1 - 3 Juta' => '1 - 3 Juta',
                        '3 - 5 Juta' => '3 - 5 Juta',
                        '5 - 10 Juta' => '5 - 10 Juta',
                        '10 - 20 Juta' => '10 - 20 Juta',
                        '20 - 50 Juta' => '20 - 50 Juta',
                        '50 Juta Lebih' => '50 Juta Lebih',
                        'Tidak Tahu' => 'Tidak Tahu',

                        // data baru
                        'dibawah 800.000' => 'Dibawah 800.000',
                        '800.001 - 1.200.000' => '800.001 - 1.200.000',
                        '1.200.001 - 1.800.000' => '1.200.001 - 1.800.000',
                        '1.800.001 - 2.500.000' => '1.800.001 - 2.500.000',
                        '2.500.001 - 3.500.000' => '2.500.001 - 3.500.000',
                        '3.500.001 - 4.800.000' => '3.500.001 - 4.800.000',
                        '4.800.001 - 6.500.000' => '4.800.001 - 6.500.000',
                        '6.500.001 - 10.000.000' => '6.500.001 - 10.000.000',
                        '10.000.001 - 20.000.000' => '10.000.001 - 20.000.000',
                        'diatas 20.000.001' => 'Diatas 20.000.001',
                    ][$value] ?? $value),


                Select::make('status_milik')
                    ->label('Status Kepemilikan Rumah')
                    ->options([
                                 'Milik Sendiri' => 'Milik Sendiri',
                                 'Milik Orang Tua' => 'Milik Orang Tua',
                                 'Sewa/Kontrak' => 'Sewa/Kontrak',
                                 'Bebas Sewa' => 'Bebas Sewa',
                                 'Lainnya' => 'Lainnya',
                             ]),

                TextInput::make('rt'    )
                    ->label('RT'),
                TextInput::make('rw')
                    ->label('RW'),
                TextInput::make('desa')
                    ->label('Desa/Kelurahan'),
                TextInput::make('kecamatan')
                    ->label('Kecamatan'),
                TextInput::make('kabupaten')
                    ->label('Kabupaten/Kota'),
                TextInput::make('provinsi')
                    ->label('Provinsi'),
                TextInput::make('kode_pos')
                    ->label('Kode Pos'),


                TextInput::make('nik_wali')
                    ->label('No. NIK Wali'),
                TextInput::make('nama_wali')
                    ->label('Nama Wali')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                TextInput::make('tempat_lahir_wali')
                    ->label('Tempat Lahir Wali')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => strip_tags($state)),
                DatePicker::make('tanggal_lahir_wali')
                    ->label('Tanggal Lahir Wali'),
                TextInput::make('no_hp_wali')
                    ->label('Nomor Whatsapp Wali'),
                Select::make('pendidikan_wali')
                    ->label('Pendidikan Terakhir Wali')
                    ->options([
                                 'SD/Sederajat' => 'SD/Sederajat',
                                 'SMP/Sederajat' => 'SMP/Sederajat',
                                 'SMA/Sederajat' => 'SMA/Sederajat',
                                 'D1' => 'D1',
                                 'D2' => 'D2',
                                 'D3' => 'D3',
                                 'D4/S1' => 'D4/S1',
                                 'S2' => 'S2',
                                 'S3' => 'S3',
                                 'Tidak Bersekolah' => 'Tidak Bersekolah',
                                 'Lainnya' => 'Lainnya',
                             ]),
                Select::make('pekerjaan_wali')
                    ->label('Pekerjaan Wali')
                    ->options([
                                 'Tidak Bekerja' => 'Tidak Bekerja',
                                 'Pensiunan' => 'Pensiunan',
                                 'PNS' => 'PNS',
                                 'TNI/Polisi' => 'TNI/Polisi',
                                 'Guru/Dosen' => 'Guru/Dosen',
                                 'Pegawai Swasta' => 'Pegawai Swasta',
                                 'Wiraswasta' => 'Wiraswasta',
                                 'Pengacara/Jaksa/Hakim/Notaris' => 'Pengacara/Jaksa/Hakim/Notaris',
                                 'Seniman/Pelukis/Artis/Sejenis' => 'Seniman/Pelukis/Artis/Sejenis',
                                 'Dokter/Bidan/Perawat' => 'Dokter/Bidan/Perawat',
                                 'Pilot/Pramugara' => 'Pilot/Pramugara',
                                 'Pedagang' => 'Pedagang',
                                 'Petani/Peternak' => 'Petani/Peternak',
                                 'Nelayan' => 'Nelayan',
                                 'Buruh (Tani/Pabrik/Bangunan)' => 'Buruh (Tani/Pabrik/Bangunan)',
                                 'Sopir/Masinis/Kondektur' => 'Sopir/Masinis/Kondektur',
                                 'Politikus' => 'Politikus',
                                 'Lainnya' => 'Lainnya',
                             ]) ,
                Select::make('penghasilan_wali')
                    ->label('Penghasilan Wali')
                    ->options([
                                 'Tidak Berpenghasilan' => 'Tidak Berpenghasilan',
                                 '< Rp 1.000.000' => '< Rp 1.000.000',
                                 'Rp 1.000.000 - Rp 2.500.000' => 'Rp 1.000.000 - Rp 2.500.000',
                                 'Rp 2.500.001 - Rp 5.000.000' => 'Rp 2.500.001 - Rp 5.000.000',
                                 'Rp 5.000.001 - Rp 10.000.000' => 'Rp 5.000.001 - Rp 10.000.000',
                                 '> Rp 10.000.000' => '> Rp 10.000.000',
                             ]),


                FileUpload::make('fotokk')
                    ->label('Foto Kartu Keluarga (KK)')
                    ->disk('public')
                    ->directory('dokumen-siswa/kk')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'])
                    ->maxSize(5120)
                    ->downloadable()
                    ->openable()
                    ->previewable()
                    ->helperText('Format: JPG/PNG/PDF, Max: 5MB'),

                FileUpload::make('fotoakta')
                    ->label('Foto Akta Kelahiran')
                    ->disk('public')
                    ->directory('dokumen-siswa/akta')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'])
                    ->maxSize(5120)
                    ->downloadable()
                    ->openable()
                    ->previewable()
                    ->helperText('Format: JPG/PNG/PDF, Max: 5MB'),
                FileUpload::make('fototransfer')
                    ->label('Bukti Foto Transfer')
                    ->disk('public')
                    ->directory('dokumen-siswa/transfer')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'])
                    ->maxSize(5120)
                    ->downloadable()
                    ->openable()
                    ->previewable()
                    ->helperText('Format: JPG/PNG/PDF, Max: 5MB'),
            ]);
    }
}

