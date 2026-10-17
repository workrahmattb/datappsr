@extends('admin.layout')

@section('page-title', 'Detail Profil Guru')

@section('content')
<div class="space-y-4 max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start gap-4">
            <div class="flex items-center gap-4">
                @if($guru->foto)
                    <img src="{{ Storage::url($guru->foto) }}" alt="{{ $guru->name }}" class="w-16 h-16 rounded-full object-cover border border-gray-200">
                @else
                    <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xl border border-gray-200">
                        {{ strtoupper(substr($guru->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $guru->name }}</h1>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $guru->jabatan ?: 'Jabatan belum diisi' }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        @if($guru->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">Nonaktif</span>
                        @endif
                        @if($guru->jenis_kelamin)
                            <span class="text-xs text-gray-500">{{ $guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex gap-2 shrink-0">
                <a wire:navigate href="{{ route('admin.gurus.edit', $guru) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">Edit</a>
                <a wire:navigate href="{{ route('admin.gurus.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold">Kembali</a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 space-y-4">
        <x-detail-item label="NIP" :value="$guru->nip" />
        <x-detail-item label="Pendidikan" :value="$guru->pendidikan" />
        <x-detail-item label="Email" :value="$guru->email" />
        <x-detail-item label="No. HP" :value="$guru->no_hp" />
        <x-detail-item label="Tanggal Lahir" :value="$guru->tanggal_lahir?->translatedFormat('d F Y')" />
        <x-detail-item label="Alamat" :value="$guru->alamat" />
        <x-detail-item label="Urutan Tampil" :value="$guru->urutan" />
        <x-detail-item label="Dibuat" :value="$guru->created_at?->translatedFormat('d F Y H:i')" />
        <x-detail-item label="Diperbarui" :value="$guru->updated_at?->translatedFormat('d F Y H:i')" />

        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Deskripsi</p>
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $guru->deskripsi ?: '-' }}</p>
        </div>
    </div>
</div>
@endsection
