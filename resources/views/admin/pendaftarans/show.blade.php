@php
    $student = $pendaftaran; 
    $title = 'Data Pendaftaran (' . ucfirst($student->jenjang ?? 'Siswa') . ')'; 
    $routePrefix = 'admin.pendaftarans';
@endphp
@extends('admin.layout')

@section('page-title', 'Detail ' . $title)

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-zinc-100 border border-zinc-200 rounded-full flex items-center justify-center text-zinc-700 font-bold text-2xl shrink-0">
                {{ substr($student->nama, 0, 1) }}
            </div>
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">{{ $student->nama }}</h1>
                <p class="text-sm text-zinc-500 font-medium mt-1">NISN: {{ $student->nisn ?? '-' }} &bull; NIK: {{ $student->nik ?? '-' }} <span class="mx-2 px-2 py-0.5 bg-zinc-100 text-zinc-600 rounded text-xs font-bold border border-zinc-200">{{ strtoupper($student->jenjang ?? '-') }}</span></p>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route($routePrefix . '.index') }}" wire:navigate class="bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 font-semibold px-4 py-2 rounded-lg text-sm transition-colors shadow-sm">
                Kembali
            </a>
            <a href="{{ route($routePrefix . '.edit', $student) }}" wire:navigate class="bg-zinc-900 hover:bg-zinc-800 text-white font-semibold px-4 py-2 rounded-lg text-sm transition-colors shadow-sm">
                Edit Data
            </a>
        </div>
    </div>

    <!-- Data Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Data Pribadi -->
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                <h3 class="font-bold text-zinc-900">Data Pribadi</h3>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-6">
                <div class="sm:col-span-2">
                    <x-detail-item label="Nama Lengkap" :value="$student->nama" />
                </div>
                <x-detail-item label="Tempat, Tgl Lahir" :value="$student->tempat_lahir . ', ' . ($student->tanggal_lahir ? \Carbon\Carbon::parse($student->tanggal_lahir)->translatedFormat('d F Y') : '-')" />
                <x-detail-item label="NIK" :value="$student->nik" />
                <x-detail-item label="No. KK" :value="$student->kk" />
                <x-detail-item label="Nama Kepala Keluarga (Sesuai KK)" :value="$student->nama_kk" />
                <x-detail-item label="Anak Ke" :value="$student->anak_ke" />
                <x-detail-item label="Jumlah Saudara Kandung" :value="$student->jumlah_saudara" />
                <x-detail-item label="Hobi" :value="$student->hobi" />
                <x-detail-item label="Cita-cita" :value="$student->cita_cita" />
            </div>
        </div>

        <!-- Informasi Akademik & Bantuan -->
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                <h3 class="font-bold text-zinc-900">Akademik & Bantuan Sosial</h3>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-6">
                <x-detail-item label="Tahun Ajaran" :value="$student->tahun_ajaran" />
                <x-detail-item label="NISN" :value="$student->nisn" />
                <x-detail-item label="NIS Lokal" :value="$student->nis" />
                <x-detail-item label="Tanggal Masuk" :value="$student->tgl_masuk ? \Carbon\Carbon::parse($student->tgl_masuk)->translatedFormat('d F Y') : '-'" />
                <x-detail-item label="Pernah Sekolah TK?" :value="$student->tk" />
                <x-detail-item label="Pernah Sekolah PAUD?" :value="$student->paud" />
                <div class="col-span-1 border border-zinc-200 rounded-lg p-3 bg-zinc-50/50">
                    <x-detail-item label="No. KKS" :value="$student->kks" />
                </div>
                <div class="col-span-1 border border-zinc-200 rounded-lg p-3 bg-zinc-50/50">
                    <x-detail-item label="No. PKH" :value="$student->pkh" />
                </div>
                <div class="sm:col-span-2 border border-zinc-200 rounded-lg p-3 bg-zinc-50/50">
                    <x-detail-item label="No. KIP" :value="$student->kip" />
                </div>
            </div>
        </div>

        <!-- Alamat & Tempat Tinggal -->
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden lg:col-span-2">
            <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                <h3 class="font-bold text-zinc-900">Alamat & Tempat Tinggal</h3>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-y-5 gap-x-6">
                <div class="sm:col-span-3">
                    <x-detail-item label="Status Tempat Tinggal" :value="$student->status_milik" />
                </div>
                <div class="sm:col-span-2">
                    <x-detail-item label="Alamat Rumah Tinggal Detail" :value="$student->alamat_rumah_tinggal" />
                </div>
                <x-detail-item label="RT / RW" :value="($student->rt ?? '-') . ' / ' . ($student->rw ?? '-')" />
                <x-detail-item label="Desa/Kelurahan" :value="$student->desa" />
                <x-detail-item label="Kecamatan" :value="$student->kecamatan" />
                <x-detail-item label="Kabupaten/Kota" :value="$student->kabupaten" />
                <x-detail-item label="Provinsi" :value="$student->provinsi" />
                <div class="sm:col-span-2"></div>
                <x-detail-item label="Kode Pos" :value="$student->kode_pos" />
            </div>
        </div>

        <!-- Riwayat Pendidikan Sebelumnya -->
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden lg:col-span-2">
            <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                <h3 class="font-bold text-zinc-900">Riwayat Pendidikan Sebelumnya</h3>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-y-5 gap-x-6">
                <x-detail-item label="Jenjang Pendidikan Terakhir" :value="$student->jenjang_pendidikan_sebelumnya" />
                <x-detail-item label="Status Sekolah" :value="$student->status_sekolah_sebelumnya" />
                <x-detail-item label="Nama Sekolah Asal (MTS/SMP/SD)" :value="$student->nama_sekolah_sebelumnya" />
                <div class="sm:col-span-3 border-t border-zinc-100 my-1"></div>
                <x-detail-item label="NPSN Sekolah Asal" :value="$student->npsn_sekolah_sebelumnya" />
                <div class="sm:col-span-2">
                    <x-detail-item label="Alamat Sekolah Asal" :value="$student->alamat_sekolah_sebelumnya" />
                </div>
                <x-detail-item label="Kecamatan Sekolah Asal" :value="$student->kecamatan_sekolah_sebelumnya" />
                <x-detail-item label="Kabupaten Sekolah Asal" :value="$student->kabupaten_sekolah_sebelumnya" />
                <x-detail-item label="Provinsi Sekolah Asal" :value="$student->provinsi_sekolah_sebelumnya" />
            </div>
        </div>

        <!-- Data Ayah -->
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50 flex justify-between items-center">
                <h3 class="font-bold text-zinc-900">Data Ayah Kandung</h3>
                <span class="text-xs font-bold px-2.5 py-1 rounded bg-zinc-200/50 text-zinc-700 border border-zinc-200/80">{{ $student->status_ayah ?? 'Tidak Diketahui' }}</span>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-6">
                <div class="sm:col-span-2">
                    <x-detail-item label="Nama Lengkap Ayah" :value="$student->nama_ayah" />
                </div>
                <div class="sm:col-span-2">
                    <x-detail-item label="NIK Ayah" :value="$student->nik_ayah" />
                </div>
                <div class="sm:col-span-2">
                    <x-detail-item label="Tempat, Tgl Lahir" :value="$student->tempat_lahir_ayah . ', ' . ($student->tanggal_lahir_ayah ? \Carbon\Carbon::parse($student->tanggal_lahir_ayah)->translatedFormat('d F Y') : '-')" />
                </div>
                <x-detail-item label="Pendidikan Terakhir" :value="$student->pendidikan_ayah" />
                <x-detail-item label="No. Handphone" :value="$student->no_hp_ayah" />
                <x-detail-item label="Pekerjaan Utama" :value="$student->pekerjaan_ayah" />
                <x-detail-item label="Penghasilan Rata-rata" :value="$student->penghasilan_ayah" />
            </div>
        </div>

        <!-- Data Ibu -->
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50 flex justify-between items-center">
                <h3 class="font-bold text-zinc-900">Data Ibu Kandung</h3>
                <span class="text-xs font-bold px-2.5 py-1 rounded bg-zinc-200/50 text-zinc-700 border border-zinc-200/80">{{ $student->status_ibu ?? 'Tidak Diketahui' }}</span>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-6">
                <div class="sm:col-span-2">
                    <x-detail-item label="Nama Lengkap Ibu" :value="$student->nama_ibu" />
                </div>
                <div class="sm:col-span-2">
                    <x-detail-item label="NIK Ibu" :value="$student->nik_ibu" />
                </div>
                <div class="sm:col-span-2">
                    <x-detail-item label="Tempat, Tgl Lahir" :value="$student->tempat_lahir_ibu . ', ' . ($student->tanggal_lahir_ibu ? \Carbon\Carbon::parse($student->tanggal_lahir_ibu)->translatedFormat('d F Y') : '-')" />
                </div>
                <x-detail-item label="Pendidikan Terakhir" :value="$student->pendidikan_ibu" />
                <x-detail-item label="No. Handphone" :value="$student->no_hp_ibu" />
                <x-detail-item label="Pekerjaan Utama" :value="$student->pekerjaan_ibu" />
                <x-detail-item label="Penghasilan Rata-rata" :value="$student->penghasilan_ibu" />
            </div>
        </div>

        <!-- Data Wali -->
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden lg:col-span-2">
            <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50 flex justify-between items-center">
                <h3 class="font-bold text-zinc-900">Data Wali (Tanggung Jawab Pembayaran)</h3>
            </div>
            @if($student->nama_wali)
                <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-y-5 gap-x-6">
                    <div class="sm:col-span-2">
                        <x-detail-item label="Nama Lengkap Wali" :value="$student->nama_wali" />
                    </div>
                    <x-detail-item label="Status Kel. thdp Anak" :value="$student->status_wali" />
                    <x-detail-item label="NIK Wali" :value="$student->nik_wali" />
                    <div class="sm:col-span-2">
                        <x-detail-item label="Tempat, Tgl Lahir" :value="$student->tempat_lahir_wali . ', ' . ($student->tanggal_lahir_wali ? \Carbon\Carbon::parse($student->tanggal_lahir_wali)->translatedFormat('d F Y') : '-')" />
                    </div>
                    <x-detail-item label="No. Handphone" :value="$student->no_hp_wali" />
                    <x-detail-item label="Pendidikan Terakhir" :value="$student->pendidikan_wali" />
                    <div class="col-span-1 hidden sm:block"></div>
                    <x-detail-item label="Pekerjaan Utama" :value="$student->pekerjaan_wali" />
                    <x-detail-item label="Penghasilan rata-rata" :value="$student->penghasilan_wali" />
                </div>
            @else
                <div class="p-8 text-center bg-zinc-50 border-t border-zinc-200/80">
                    <p class="text-zinc-500 font-medium text-sm">Tidak ada data wali tambahan yang didaftarkan. Menggunakan data orang tua.</p>
                </div>
            @endif
        </div>

        <!-- Dokumen / Berkas -->
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden lg:col-span-2">
            <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                <h3 class="font-bold text-zinc-900">Dokumen & Berkas Pendukung</h3>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Foto KK -->
                <div class="border border-zinc-200 rounded-xl overflow-hidden group hover:border-zinc-300 transition-colors">
                    <div class="h-48 bg-zinc-50 flex items-center justify-center p-4 relative">
                        @if($student->fotokk)
                            <img src="{{ Storage::url($student->fotokk) }}" class="max-h-full max-w-full object-contain mix-blend-multiply" alt="Foto KK">
                            <div class="absolute inset-0 bg-zinc-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <a href="{{ Storage::url($student->fotokk) }}" target="_blank" class="bg-white text-zinc-900 font-bold text-sm px-4 py-2 rounded-lg shadow-lg">Buka Gambar Penuh</a>
                            </div>
                        @else
                            <div class="text-zinc-400 flex flex-col items-center">
                                <svg class="w-8 h-8 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-xs font-semibold">TIDAK ADA BERKAS</span>
                            </div>
                        @endif
                    </div>
                    <div class="px-4 py-3 border-t border-zinc-200 bg-white">
                        <p class="font-bold text-sm text-zinc-900 text-center">Kartu Keluarga (KK)</p>
                    </div>
                </div>
                
                <!-- Foto Akta -->
                <div class="border border-zinc-200 rounded-xl overflow-hidden group hover:border-zinc-300 transition-colors">
                    <div class="h-48 bg-zinc-50 flex items-center justify-center p-4 relative">
                        @if($student->fotoakta)
                            <img src="{{ Storage::url($student->fotoakta) }}" class="max-h-full max-w-full object-contain mix-blend-multiply" alt="Foto Akta">
                            <div class="absolute inset-0 bg-zinc-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <a href="{{ Storage::url($student->fotoakta) }}" target="_blank" class="bg-white text-zinc-900 font-bold text-sm px-4 py-2 rounded-lg shadow-lg">Buka Gambar Penuh</a>
                            </div>
                        @else
                            <div class="text-zinc-400 flex flex-col items-center">
                                <svg class="w-8 h-8 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-xs font-semibold">TIDAK ADA BERKAS</span>
                            </div>
                        @endif
                    </div>
                    <div class="px-4 py-3 border-t border-zinc-200 bg-white">
                        <p class="font-bold text-sm text-zinc-900 text-center">Akta Kelahiran</p>
                    </div>
                </div>

                <!-- Foto Transfer -->
                <div class="border border-zinc-200 rounded-xl overflow-hidden group hover:border-zinc-300 transition-colors">
                    <div class="h-48 bg-zinc-50 flex items-center justify-center p-4 relative">
                        @if($student->fototransfer)
                            <img src="{{ Storage::url($student->fototransfer) }}" class="max-h-full max-w-full object-contain mix-blend-multiply" alt="Foto Transfer">
                            <div class="absolute inset-0 bg-zinc-900/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <a href="{{ Storage::url($student->fototransfer) }}" target="_blank" class="bg-white text-zinc-900 font-bold text-sm px-4 py-2 rounded-lg shadow-lg">Buka Gambar Penuh</a>
                            </div>
                        @else
                            <div class="text-zinc-400 flex flex-col items-center">
                                <svg class="w-8 h-8 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-xs font-semibold">TIDAK ADA BERKAS</span>
                            </div>
                        @endif
                    </div>
                    <div class="px-4 py-3 border-t border-zinc-200 bg-white">
                        <p class="font-bold text-sm text-zinc-900 text-center">Bukti Transfer Asrama</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
