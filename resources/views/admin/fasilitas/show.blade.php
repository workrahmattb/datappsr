@extends('admin.layout')

@section('page-title', 'Detail Fasilitas')

@section('content')
<div class="space-y-4 max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $fasilitas->nama }}</h1>
                <div class="flex items-center gap-2 mt-2 flex-wrap text-sm">
                    @if($fasilitas->is_active)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200">Nonaktif</span>
                    @endif
                    @if($fasilitas->kategori)
                        <span class="text-gray-500">{{ $fasilitas->kategori }}</span>
                    @endif
                </div>
            </div>
            <div class="flex gap-2 shrink-0">
                <a wire:navigate href="{{ route('admin.fasilitas.edit', $fasilitas) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">Edit</a>
                <a wire:navigate href="{{ route('admin.fasilitas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold">Kembali</a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 space-y-4">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                Foto Fasilitas ({{ $fasilitas->fotos->count() }})
            </p>
            @if($fasilitas->fotos->isEmpty())
                <p class="text-sm text-gray-500">Belum ada foto.</p>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($fasilitas->fotos as $foto)
                        <div class="relative">
                            <img src="{{ Storage::url($foto->path) }}" alt="Foto {{ $fasilitas->nama }}"
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                            @if($loop->first)
                                <span class="absolute top-2 left-2 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide bg-emerald-600 text-white rounded">
                                    Foto Utama
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <x-detail-item label="Urutan Tampil" :value="$fasilitas->urutan" />
        <x-detail-item label="Dibuat" :value="$fasilitas->created_at?->translatedFormat('d F Y H:i')" />
        <x-detail-item label="Diperbarui" :value="$fasilitas->updated_at?->translatedFormat('d F Y H:i')" />

        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Deskripsi</p>
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $fasilitas->deskripsi ?: '-' }}</p>
        </div>
    </div>
</div>
@endsection
