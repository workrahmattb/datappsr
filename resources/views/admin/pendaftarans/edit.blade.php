@extends('admin.layout')

@section('page-title', 'Edit Pendaftaran - ' . $pendaftaran->nama)

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Edit Pendaftaran</h1>
            <p class="text-sm text-zinc-500 font-medium mt-1">{{ $pendaftaran->nama }} &bull; {{ $pendaftaran->jenjang_pendidikan ?? '-' }}</p>
        </div>
        <a href="{{ route('admin.pendaftarans.index') }}" wire:navigate class="bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 font-semibold px-4 py-2 rounded-lg text-sm transition-colors shadow-sm">
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.pendaftarans.update', $pendaftaran) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Data Pendaftaran -->
            <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                    <h3 class="font-bold text-zinc-900">Data Pendaftaran</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Status Pendaftaran</label>
                        <select name="status_pendaftaran" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                            <option value="pending" {{ $pendaftaran->status_pendaftaran == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $pendaftaran->status_pendaftaran == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Jenjang Pendidikan</label>
                        <select name="jenjang_pendidikan" required class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                            <option value="MTs Putri" {{ $pendaftaran->jenjang_pendidikan == 'MTs Putri' ? 'selected' : '' }}>MTs Putri</option>
                            <option value="MTs Putra" {{ $pendaftaran->jenjang_pendidikan == 'MTs Putra' ? 'selected' : '' }}>MTs Putra</option>
                            <option value="MA Putri" {{ $pendaftaran->jenjang_pendidikan == 'MA Putri' ? 'selected' : '' }}>MA Putri</option>
                            <option value="MA Putra" {{ $pendaftaran->jenjang_pendidikan == 'MA Putra' ? 'selected' : '' }}>MA Putra</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $pendaftaran->nama) }}" required class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir) }}" required class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir ? \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('Y-m-d') : '') }}" required class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">NIK</label>
                        <input type="text" name="nik" value="{{ old('nik', $pendaftaran->nik) }}" maxlength="16" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn', $pendaftaran->nisn) }}" maxlength="10" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">NIS</label>
                        <input type="text" name="nis" value="{{ old('nis', $pendaftaran->nis) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $pendaftaran->tahun_ajaran) }}" placeholder="2026/2027" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">No. HP (Pendaftaran)</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $pendaftaran->no_hp) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                </div>
            </div>

            <!-- Data Pribadi Tambahan -->
            <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                    <h3 class="font-bold text-zinc-900">Data Pribadi Tambahan</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">No. KK</label>
                        <input type="text" name="kk" value="{{ old('kk', $pendaftaran->kk) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Nama Kepala Keluarga</label>
                        <input type="text" name="nama_kk" value="{{ old('nama_kk', $pendaftaran->nama_kk) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Anak Ke-</label>
                        <input type="text" name="anak_ke" value="{{ old('anak_ke', $pendaftaran->anak_ke) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Jumlah Saudara Kandung</label>
                        <input type="text" name="jumlah_saudara" value="{{ old('jumlah_saudara', $pendaftaran->jumlah_saudara) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Hobi</label>
                        <input type="text" name="hobi" value="{{ old('hobi', $pendaftaran->hobi) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Cita-cita</label>
                        <input type="text" name="cita_cita" value="{{ old('cita_cita', $pendaftaran->cita_cita) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Tanggal Masuk</label>
                        <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk', $pendaftaran->tgl_masuk ? \Carbon\Carbon::parse($pendaftaran->tgl_masuk)->format('Y-m-d') : '') }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Pernah TK?</label>
                        <input type="text" name="tk" value="{{ old('tk', $pendaftaran->tk) }}" placeholder="Ya/Tidak" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Pernah PAUD?</label>
                        <input type="text" name="paud" value="{{ old('paud', $pendaftaran->paud) }}" placeholder="Ya/Tidak" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden lg:col-span-2">
                <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                    <h3 class="font-bold text-zinc-900">Alamat & Tempat Tinggal</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Alamat Lengkap (Pendaftaran)</label>
                        <textarea name="alamat" rows="3" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900 resize-none">{{ old('alamat', $pendaftaran->alamat) }}</textarea>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Alamat Rumah Tinggal Detail</label>
                        <textarea name="alamat_rumah_tinggal" rows="2" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900 resize-none">{{ old('alamat_rumah_tinggal', $pendaftaran->alamat_rumah_tinggal) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Status Tempat Tinggal</label>
                        <input type="text" name="status_milik" value="{{ old('status_milik', $pendaftaran->status_milik) }}" placeholder="Milik Sendiri/Sewa/Dll" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">RT</label>
                        <input type="text" name="rt" value="{{ old('rt', $pendaftaran->rt) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">RW</label>
                        <input type="text" name="rw" value="{{ old('rw', $pendaftaran->rw) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Desa/Kelurahan</label>
                        <input type="text" name="desa" value="{{ old('desa', $pendaftaran->desa) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Kecamatan</label>
                        <input type="text" name="kecamatan" value="{{ old('kecamatan', $pendaftaran->kecamatan) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Kabupaten/Kota</label>
                        <input type="text" name="kabupaten" value="{{ old('kabupaten', $pendaftaran->kabupaten) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Provinsi</label>
                        <input type="text" name="provinsi" value="{{ old('provinsi', $pendaftaran->provinsi) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Kode Pos</label>
                        <input type="text" name="kode_pos" value="{{ old('kode_pos', $pendaftaran->kode_pos) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                </div>
            </div>

            <!-- Bantuan Sosial -->
            <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                    <h3 class="font-bold text-zinc-900">Bantuan Sosial</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">No. KKS</label>
                        <input type="text" name="kks" value="{{ old('kks', $pendaftaran->kks) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">No. PKH</label>
                        <input type="text" name="pkh" value="{{ old('pkh', $pendaftaran->pkh) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">No. KIP</label>
                        <input type="text" name="kip" value="{{ old('kip', $pendaftaran->kip) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                </div>
            </div>

            <!-- Pendidikan Sebelumnya -->
            <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                    <h3 class="font-bold text-zinc-900">Pendidikan Sebelumnya</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Asal Sekolah (Legacy)</label>
                        <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $pendaftaran->asal_sekolah) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Jenjang Pendidikan Terakhir</label>
                        <input type="text" name="jenjang_pendidikan_sebelumnya" value="{{ old('jenjang_pendidikan_sebelumnya', $pendaftaran->jenjang_pendidikan_sebelumnya) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Status Sekolah</label>
                        <input type="text" name="status_sekolah_sebelumnya" value="{{ old('status_sekolah_sebelumnya', $pendaftaran->status_sekolah_sebelumnya) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Nama Sekolah Asal</label>
                        <input type="text" name="nama_sekolah_sebelumnya" value="{{ old('nama_sekolah_sebelumnya', $pendaftaran->nama_sekolah_sebelumnya) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">NPSN Sekolah Asal</label>
                        <input type="text" name="npsn_sekolah_sebelumnya" value="{{ old('npsn_sekolah_sebelumnya', $pendaftaran->npsn_sekolah_sebelumnya) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Alamat Sekolah Asal</label>
                        <textarea name="alamat_sekolah_sebelumnya" rows="2" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900 resize-none">{{ old('alamat_sekolah_sebelumnya', $pendaftaran->alamat_sekolah_sebelumnya) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Kecamatan Sekolah Asal</label>
                        <input type="text" name="kecamatan_sekolah_sebelumnya" value="{{ old('kecamatan_sekolah_sebelumnya', $pendaftaran->kecamatan_sekolah_sebelumnya) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Kabupaten Sekolah Asal</label>
                        <input type="text" name="kabupaten_sekolah_sebelumnya" value="{{ old('kabupaten_sekolah_sebelumnya', $pendaftaran->kabupaten_sekolah_sebelumnya) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Provinsi Sekolah Asal</label>
                        <input type="text" name="provinsi_sekolah_sebelumnya" value="{{ old('provinsi_sekolah_sebelumnya', $pendaftaran->provinsi_sekolah_sebelumnya) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                </div>
            </div>

            <!-- Data Ayah -->
            <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                    <h3 class="font-bold text-zinc-900">Data Ayah Kandung</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Nama Ayah</label>
                        <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $pendaftaran->nama_ayah) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">NIK Ayah</label>
                        <input type="text" name="nik_ayah" value="{{ old('nik_ayah', $pendaftaran->nik_ayah) }}" maxlength="16" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Tempat Lahir Ayah</label>
                        <input type="text" name="tempat_lahir_ayah" value="{{ old('tempat_lahir_ayah', $pendaftaran->tempat_lahir_ayah) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Tanggal Lahir Ayah</label>
                        <input type="date" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah', $pendaftaran->tanggal_lahir_ayah ? \Carbon\Carbon::parse($pendaftaran->tanggal_lahir_ayah)->format('Y-m-d') : '') }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Status Ayah</label>
                        <input type="text" name="status_ayah" value="{{ old('status_ayah', $pendaftaran->status_ayah) }}" placeholder="Kandung/Wafat/Dll" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">No. HP Ayah</label>
                        <input type="text" name="no_hp_ayah" value="{{ old('no_hp_ayah', $pendaftaran->no_hp_ayah) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Pendidikan Ayah</label>
                        <input type="text" name="pendidikan_ayah" value="{{ old('pendidikan_ayah', $pendaftaran->pendidikan_ayah) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $pendaftaran->pekerjaan_ayah) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Penghasilan Ayah</label>
                        <input type="text" name="penghasilan_ayah" value="{{ old('penghasilan_ayah', $pendaftaran->penghasilan_ayah) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                </div>
            </div>

            <!-- Data Ibu -->
            <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                    <h3 class="font-bold text-zinc-900">Data Ibu Kandung</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Nama Ibu</label>
                        <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $pendaftaran->nama_ibu) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">NIK Ibu</label>
                        <input type="text" name="nik_ibu" value="{{ old('nik_ibu', $pendaftaran->nik_ibu) }}" maxlength="16" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Tempat Lahir Ibu</label>
                        <input type="text" name="tempat_lahir_ibu" value="{{ old('tempat_lahir_ibu', $pendaftaran->tempat_lahir_ibu) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Tanggal Lahir Ibu</label>
                        <input type="date" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu', $pendaftaran->tanggal_lahir_ibu ? \Carbon\Carbon::parse($pendaftaran->tanggal_lahir_ibu)->format('Y-m-d') : '') }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Status Ibu</label>
                        <input type="text" name="status_ibu" value="{{ old('status_ibu', $pendaftaran->status_ibu) }}" placeholder="Kandung/Wafat/Dll" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">No. HP Ibu</label>
                        <input type="text" name="no_hp_ibu" value="{{ old('no_hp_ibu', $pendaftaran->no_hp_ibu) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Pendidikan Ibu</label>
                        <input type="text" name="pendidikan_ibu" value="{{ old('pendidikan_ibu', $pendaftaran->pendidikan_ibu) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $pendaftaran->pekerjaan_ibu) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Penghasilan Ibu</label>
                        <input type="text" name="penghasilan_ibu" value="{{ old('penghasilan_ibu', $pendaftaran->penghasilan_ibu) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                </div>
            </div>

            <!-- Data Wali -->
            <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden lg:col-span-2">
                <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                    <h3 class="font-bold text-zinc-900">Data Wali (Tanggung Jawab Pembayaran)</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Nama Wali</label>
                        <input type="text" name="nama_wali" value="{{ old('nama_wali', $pendaftaran->nama_wali) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">NIK Wali</label>
                        <input type="text" name="nik_wali" value="{{ old('nik_wali', $pendaftaran->nik_wali) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Tempat Lahir Wali</label>
                        <input type="text" name="tempat_lahir_wali" value="{{ old('tempat_lahir_wali', $pendaftaran->tempat_lahir_wali) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Tanggal Lahir Wali</label>
                        <input type="date" name="tanggal_lahir_wali" value="{{ old('tanggal_lahir_wali', $pendaftaran->tanggal_lahir_wali ? \Carbon\Carbon::parse($pendaftaran->tanggal_lahir_wali)->format('Y-m-d') : '') }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">No. HP Wali</label>
                        <input type="text" name="no_hp_wali" value="{{ old('no_hp_wali', $pendaftaran->no_hp_wali) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Pendidikan Wali</label>
                        <input type="text" name="pendidikan_wali" value="{{ old('pendidikan_wali', $pendaftaran->pendidikan_wali) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Pekerjaan Wali</label>
                        <input type="text" name="pekerjaan_wali" value="{{ old('pekerjaan_wali', $pendaftaran->pekerjaan_wali) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Penghasilan Wali</label>
                        <input type="text" name="penghasilan_wali" value="{{ old('penghasilan_wali', $pendaftaran->penghasilan_wali) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                </div>
            </div>

            <!-- Keuangan -->
            <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden lg:col-span-2">
                <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                    <h3 class="font-bold text-zinc-900">Informasi Keuangan</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Bayar Uang Masuk</label>
                        <input type="number" name="bayar_uang_masuk" value="{{ old('bayar_uang_masuk', $pendaftaran->bayar_uang_masuk) }}" step="0.01" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Status Bayar Uang Masuk</label>
                        <select name="status_bayar_uang_masuk" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                            <option value="">Pilih Status</option>
                            <option value="lunas" {{ $pendaftaran->status_bayar_uang_masuk == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="belum" {{ $pendaftaran->status_bayar_uang_masuk == 'belum' ? 'selected' : '' }}>Belum</option>
                            <option value="pending" {{ $pendaftaran->status_bayar_uang_masuk == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Keterangan Bayar</label>
                        <input type="text" name="keterangan_bayar" value="{{ old('keterangan_bayar', $pendaftaran->keterangan_bayar) }}" class="w-full border border-zinc-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/20 focus:border-zinc-900">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Upload Bukti Transfer Uang Masuk</label>
                        <input type="file" name="bukti_transfer_uang_masuk" accept="image/*" class="mt-1 block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200">
                        @if($pendaftaran->bukti_transfer_uang_masuk)
                            <p class="text-xs text-zinc-500 mt-1">File saat ini: <a href="{{ Storage::url($pendaftaran->bukti_transfer_uang_masuk) }}" target="_blank" class="text-blue-600 underline">Lihat file</a></p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Dokumen -->
            <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden lg:col-span-2">
                <div class="px-6 py-4 border-b border-zinc-200/80 bg-zinc-50/50">
                    <h3 class="font-bold text-zinc-900">Dokumen & Berkas</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Foto KK</label>
                        @if($pendaftaran->fotokk)
                            <div class="mb-2">
                                <img src="{{ Storage::url($pendaftaran->fotokk) }}" class="h-32 w-full object-contain bg-zinc-50 rounded-lg border border-zinc-200">
                            </div>
                        @endif
                        <input type="file" name="fotokk" accept="image/*" class="mt-1 block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Foto Akta</label>
                        @if($pendaftaran->fotoakta)
                            <div class="mb-2">
                                <img src="{{ Storage::url($pendaftaran->fotoakta) }}" class="h-32 w-full object-contain bg-zinc-50 rounded-lg border border-zinc-200">
                            </div>
                        @endif
                        <input type="file" name="fotoakta" accept="image/*" class="mt-1 block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-zinc-700 mb-1.5">Foto Transfer</label>
                        @if($pendaftaran->fototransfer)
                            <div class="mb-2">
                                <img src="{{ Storage::url($pendaftaran->fototransfer) }}" class="h-32 w-full object-contain bg-zinc-50 rounded-lg border border-zinc-200">
                            </div>
                        @endif
                        <input type="file" name="fototransfer" accept="image/*" class="mt-1 block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end gap-3 pt-6">
            <a href="{{ route('admin.pendaftarans.index') }}" wire:navigate class="bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors shadow-sm">
                Batal
            </a>
            <button type="submit" class="bg-zinc-900 hover:bg-zinc-800 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors shadow-sm">
                Update Data
            </button>
        </div>
    </form>
</div>
@endsection
