@extends('admin.layout')

@section('page-title', 'Edit Slide Carousel')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-3xl">
    <form action="{{ route('admin.carousels.update', $carousel) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ preview: null }">
        @csrf
        @method('PUT')

        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Gambar Slide</h3>
            <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                <div class="shrink-0">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Gambar saat ini</p>
                    <img src="{{ Storage::url($carousel->gambar) }}" alt="{{ $carousel->judul ?: 'Slide '.$carousel->id }}"
                         class="w-64 rounded-lg border border-gray-200">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Ganti Gambar (opsional)</label>
                    <input type="file" name="gambar" accept="image/*"
                           @change="preview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : null"
                           class="mt-1 block w-full text-sm text-gray-600 border border-gray-300 rounded-md px-3 py-2">
                    <p class="text-xs text-gray-500 mt-1">
                        Format JPG, JPEG, PNG, atau WebP. Maksimal 2 MB.
                        Rekomendasi ukuran <strong>1920 × 800 px</strong>.
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong bila tidak ingin mengganti gambar.</p>
                    @error('gambar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                    <template x-if="preview">
                        <div class="mt-3">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pratinjau gambar baru</p>
                            <img :src="preview" alt="Pratinjau slide" class="w-64 rounded-lg border border-gray-200">
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Teks Slide</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" name="judul" value="{{ old('judul', $carousel->judul) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">{{ old('deskripsi', $carousel->deskripsi) }}</textarea>
                    @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tombol (Opsional)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Label Tombol</label>
                    <input type="text" name="link_text" value="{{ old('link_text', $carousel->link_text) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    @error('link_text')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tautan Tujuan</label>
                    <input type="text" name="link_url" value="{{ old('link_url', $carousel->link_url) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    @error('link_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengaturan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Urutan Tampil</label>
                    <input type="number" name="urutan" min="0" value="{{ old('urutan', $carousel->urutan) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    @error('urutan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-2 md:pt-8">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $carousel->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="is_active" class="text-sm font-medium text-gray-700">Tampilkan slide ini (aktif)</label>
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow-sm">Perbarui Slide</button>
            <a wire:navigate href="{{ route('admin.carousels.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg font-semibold text-sm">Batal</a>
        </div>
    </form>
</div>
@endsection
