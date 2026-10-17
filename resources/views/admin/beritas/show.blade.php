@extends('admin.layout')

@section('page-title', 'Detail Berita')

@section('content')
<div class="space-y-4 max-w-4xl">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $berita->judul }}</h1>
                <div class="flex items-center gap-2 mt-2 flex-wrap text-sm">
                    @if($berita->status === 'published')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Terbit</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">Draft</span>
                    @endif
                    @if($berita->is_featured)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">Unggulan</span>
                    @endif
                    @if($berita->kategori)
                        <span class="text-gray-500">{{ $berita->kategori }}</span>
                    @endif
                </div>
            </div>
            <div class="flex gap-2 shrink-0">
                <a wire:navigate href="{{ route('admin.beritas.edit', $berita) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">Edit</a>
                <a wire:navigate href="{{ route('admin.beritas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold">Kembali</a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 space-y-4">
        <x-detail-item label="Slug" :value="$berita->slug" />
        <x-detail-item label="Penulis" :value="$berita->penulis" />
        <x-detail-item label="Tanggal Publikasi" :value="$berita->published_at?->translatedFormat('d F Y H:i')" />
        <x-detail-item label="Dibuat" :value="$berita->created_at?->translatedFormat('d F Y H:i')" />
        <x-detail-item label="Diperbarui" :value="$berita->updated_at?->translatedFormat('d F Y H:i')" />

        @if($berita->gambar)
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Gambar Utama</p>
                <img src="{{ Storage::url($berita->gambar) }}" alt="Gambar {{ $berita->judul }}"
                     class="max-w-md w-full rounded-lg border border-gray-200">
            </div>
        @endif

        @if($berita->ringkasan)
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Ringkasan</p>
                <p class="text-sm text-gray-700">{{ $berita->ringkasan }}</p>
            </div>
        @endif

        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Isi Berita</p>
            <div class="rich-text">{!! $berita->isi_html !!}</div>
        </div>
    </div>
</div>
@endsection
