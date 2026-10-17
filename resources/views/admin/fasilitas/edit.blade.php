@extends('admin.layout')

@section('page-title', 'Edit Fasilitas')

@section('content')
<div class="space-y-4 max-w-3xl">
    {{-- Galeri foto saat ini (di luar form utama agar tombol hapus tidak nested) --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Foto Fasilitas</h3>
            <span class="text-xs font-semibold text-gray-500">{{ $fasilitas->fotos->count() }} foto</span>
        </div>

        @if($fasilitas->fotos->isEmpty())
            <p class="text-sm text-gray-500">Belum ada foto. Silakan tambahkan foto pada form di bawah.</p>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                @foreach($fasilitas->fotos as $foto)
                    <div class="relative">
                        <img src="{{ Storage::url($foto->path) }}" alt="Foto {{ $fasilitas->nama }}"
                             class="w-full h-28 object-cover rounded-lg border border-gray-200">
                        @if($loop->first)
                            <span class="absolute top-2 left-2 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide bg-emerald-600 text-white rounded">
                                Foto Utama
                            </span>
                        @endif
                        <form action="{{ route('admin.fasilitas.foto.destroy', [$fasilitas, $foto]) }}" method="POST"
                              class="absolute top-2 right-2"
                              onsubmit="return confirm('Hapus foto ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus foto"
                                    class="w-7 h-7 flex items-center justify-center bg-white/90 hover:bg-red-600 hover:text-white text-red-600 rounded-full border border-gray-200 shadow-sm transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
            <p class="text-xs text-gray-500 mt-3">Foto urutan pertama otomatis dipakai sebagai foto utama (cover).</p>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.fasilitas.update', $fasilitas) }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ files: [] }">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Nama Fasilitas <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $fasilitas->nama) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', $fasilitas->kategori) }}" list="kategori-list"
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
                <input type="number" name="urutan" min="0" value="{{ old('urutan', $fasilitas->urutan) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                @error('urutan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea>
                @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Tambah Foto</label>
                <input type="file" name="fotos[]" accept="image/*" multiple
                       x-on:change="files = Array.from($event.target.files)"
                       class="block w-full text-sm text-gray-600 border border-gray-300 rounded-md px-3 py-2">
                <p class="text-xs text-gray-500 mt-1">
                    Bisa pilih <strong>lebih dari satu foto</strong> sekaligus (maksimal
                    {{ \App\Http\Requests\FasilitasRequest::MAX_FOTOS }} foto per unggahan).
                    Foto baru ditambahkan di belakang foto yang sudah ada.
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
                            Pratinjau foto baru (<span x-text="files.length"></span>)
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
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $fasilitas->is_active) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <label for="is_active" class="text-sm font-medium text-gray-700">Tampilkan (aktif)</label>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow-sm">Perbarui Fasilitas</button>
            <a wire:navigate href="{{ route('admin.fasilitas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg font-semibold text-sm">Batal</a>
        </div>
    </form>
    </div>
</div>
@endsection
