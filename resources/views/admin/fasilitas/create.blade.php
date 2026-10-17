@extends('admin.layout')

@section('page-title', 'Tambah Fasilitas')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-3xl">
    <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ files: [] }">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Nama Fasilitas <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori') }}" list="kategori-list"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                <datalist id="kategori-list">
                    @foreach(['Asrama', 'Ibadah', 'Belajar', 'Olahraga', 'Umum'] as $kategori)
                        <option value="{{ $kategori }}"></option>
                    @endforeach
                </datalist>
                @error('kategori')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Urutan Tampil</label>
                <input type="number" name="urutan" min="0" value="{{ old('urutan', 0) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                <p class="text-xs text-gray-500 mt-1">Angka kecil tampil lebih dulu.</p>
                @error('urutan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Foto Fasilitas <span class="text-red-500">*</span></label>
                <input type="file" name="fotos[]" accept="image/*" multiple
                       x-on:change="files = Array.from($event.target.files)"
                       class="block w-full text-sm text-gray-600 border border-gray-300 rounded-md px-3 py-2">
                <p class="text-xs text-gray-500 mt-1">
                    Bisa pilih <strong>lebih dari satu foto</strong> sekaligus (maksimal
                    {{ \App\Http\Requests\FasilitasRequest::MAX_FOTOS }} foto). <strong>Foto pertama menjadi foto utama</strong>.
                </p>

                <div class="mt-2 text-xs text-gray-600 bg-gray-50 border border-gray-200 rounded-md p-3 space-y-1">
                    <p class="font-semibold text-gray-700">Ketentuan ukuran foto:</p>
                    <ul class="list-disc pl-5 space-y-0.5">
                        <li>Rekomendasi ukuran <strong>1200 × 900 px</strong> (rasio 4:3)</li>
                        <li>Ukuran minimal <strong>800 × 600 px</strong>, wajib <strong>lanskap</strong> (rasio 1.2 – 1.8)</li>
                        <li>Format JPG, JPEG, PNG, atau WebP · maksimal <strong>2 MB per foto</strong></li>
                    </ul>
                </div>

                @error('fotos')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                @error('fotos.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                <template x-if="files.length">
                    <div class="mt-3">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Pratinjau (<span x-text="files.length"></span> foto)
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="(file, index) in files" :key="index">
                                <img :src="URL.createObjectURL(file)" alt="Pratinjau foto"
                                     class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                            </template>
                        </div>
                    </div>
                </template>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <label for="is_active" class="text-sm font-medium text-gray-700">Tampilkan (aktif)</label>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow-sm">Simpan Fasilitas</button>
            <a wire:navigate href="{{ route('admin.fasilitas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg font-semibold text-sm">Batal</a>
        </div>
    </form>
</div>
@endsection
