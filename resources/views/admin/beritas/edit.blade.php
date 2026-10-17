@extends('admin.layout')

@section('page-title', 'Edit Berita')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <form action="{{ route('admin.beritas.update', $berita) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Berita</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $berita->slug) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan agar dibuat ulang otomatis dari judul.</p>
                    @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                    <input type="text" name="kategori" value="{{ old('kategori', $berita->kategori) }}" list="kategori-list"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    <datalist id="kategori-list">
                        @foreach(['Pengumuman', 'Kegiatan', 'Prestasi', 'Akademik'] as $kategori)
                            <option value="{{ $kategori }}"></option>
                        @endforeach
                    </datalist>
                    @error('kategori')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis', $berita->penulis) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    @error('penulis')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                    <select name="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="draft" {{ old('status', $berita->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $berita->status) === 'published' ? 'selected' : '' }}>Terbit</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Publikasi</label>
                    <input type="datetime-local" name="published_at"
                           value="{{ old('published_at', $berita->published_at?->format('Y-m-d\TH:i')) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                    @error('published_at')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-2 md:pt-8">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1"
                           {{ old('is_featured', $berita->is_featured) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="is_featured" class="text-sm font-medium text-gray-700">Jadikan berita unggulan</label>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Isi Berita</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ringkasan</label>
                    <textarea name="ringkasan" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                    @error('ringkasan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                @include('admin.beritas.partials.editor-isi', ['value' => old('isi', $berita->isi)])
            </div>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Gambar Utama</h3>
            <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                @if($berita->gambar)
                    <img src="{{ Storage::url($berita->gambar) }}" alt="Gambar {{ $berita->judul }}"
                         class="w-40 h-28 object-cover rounded-lg border border-gray-200">
                @endif
                <div class="flex-1">
                    <input type="file" name="gambar" accept="image/*"
                           class="block w-full text-sm text-gray-600 border border-gray-300 rounded-md px-3 py-2">
                    <div class="mt-2 text-xs text-gray-600 bg-gray-50 border border-gray-200 rounded-md p-3 space-y-1">
                        <p class="font-semibold text-gray-700">Ketentuan gambar thumbnail:</p>
                        <ul class="list-disc pl-5 space-y-0.5">
                            <li>Rekomendasi ukuran <strong>1200 × 675 px</strong> (rasio 16:9)</li>
                            <li>Ukuran minimal <strong>800 × 450 px</strong>, wajib <strong>lanskap</strong> (rasio 1.3 – 2.2)</li>
                            <li>Format JPG, JPEG, PNG, atau WebP · maksimal <strong>2 MB</strong></li>
                        </ul>
                    </div>
                    @if($berita->gambar)
                        <p class="text-xs text-gray-500 mt-1">File saat ini: {{ $berita->gambar }}</p>
                        <p class="text-xs text-amber-600 mt-1">Pilih file baru untuk mengganti gambar. Gambar lama akan dihapus otomatis.</p>
                    @endif
                    @error('gambar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow-sm">
                Perbarui Berita
            </button>
            <a wire:navigate href="{{ route('admin.beritas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg font-semibold text-sm">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
