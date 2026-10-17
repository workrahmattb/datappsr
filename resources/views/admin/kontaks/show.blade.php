@extends('admin.layout')

@section('page-title', 'Detail Kontak')

@section('content')
<div class="space-y-4 max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $kontak->nama }}</h1>
                <p class="text-sm text-gray-500 mt-0.5">{{ $kontak->jabatan ?: 'Jabatan belum diisi' }}</p>
                <div class="flex items-center gap-2 mt-2">
                    @if($kontak->is_active)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">Nonaktif</span>
                    @endif
                    @if($kontak->unit)
                        <span class="text-xs text-gray-500">Unit: {{ $kontak->unit }}</span>
                    @endif
                </div>
            </div>
            <div class="flex gap-2 shrink-0">
                <a wire:navigate href="{{ route('admin.kontaks.edit', $kontak) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">Edit</a>
                <a wire:navigate href="{{ route('admin.kontaks.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold">Kembali</a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 space-y-4">
        <x-detail-item label="Telepon" :value="$kontak->telepon" />
        <x-detail-item label="WhatsApp" :value="$kontak->whatsapp" />
        <x-detail-item label="Email" :value="$kontak->email" />
        <x-detail-item label="Alamat" :value="$kontak->alamat" />
        <x-detail-item label="Urutan Tampil" :value="$kontak->urutan" />
        <x-detail-item label="Dibuat" :value="$kontak->created_at?->translatedFormat('d F Y H:i')" />
        <x-detail-item label="Diperbarui" :value="$kontak->updated_at?->translatedFormat('d F Y H:i')" />

        @if($kontak->whatsapp_link)
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Link WhatsApp</p>
                <a href="{{ $kontak->whatsapp_link }}" target="_blank" class="text-sm text-emerald-600 hover:underline break-all">{{ $kontak->whatsapp_link }}</a>
            </div>
        @endif
    </div>
</div>
@endsection
