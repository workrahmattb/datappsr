@extends('admin.layout')

@section('page-title', 'Detail Slide Carousel')

@section('content')
<div class="space-y-4 max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $carousel->judul ?: 'Slide #'.$carousel->id }}</h1>
                <div class="flex items-center gap-2 mt-2 flex-wrap text-sm">
                    @if($carousel->is_active)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">Nonaktif</span>
                    @endif
                    <span class="text-gray-500">Urutan {{ $carousel->urutan }}</span>
                </div>
            </div>
            <div class="flex gap-2 shrink-0">
                <a wire:navigate href="{{ route('admin.carousels.edit', $carousel) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">Edit</a>
                <a wire:navigate href="{{ route('admin.carousels.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold">Kembali</a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 space-y-4">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Gambar Slide</p>
            <img src="{{ Storage::url($carousel->gambar) }}" alt="{{ $carousel->judul ?: 'Slide '.$carousel->id }}"
                 class="w-full rounded-lg border border-gray-200">
        </div>

        <x-detail-item label="Deskripsi" :value="$carousel->deskripsi" />
        <x-detail-item label="Label Tombol" :value="$carousel->link_text" />
        <x-detail-item label="Tautan Tujuan" :value="$carousel->link_url" />
        <x-detail-item label="Urutan Tampil" :value="$carousel->urutan" />
        <x-detail-item label="Dibuat" :value="$carousel->created_at?->translatedFormat('d F Y H:i')" />
        <x-detail-item label="Diperbarui" :value="$carousel->updated_at?->translatedFormat('d F Y H:i')" />

        @if($carousel->punya_tombol)
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pratinjau Tombol</p>
                <a href="{{ $carousel->link_url }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold text-sm">
                    {{ $carousel->link_text }}
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
