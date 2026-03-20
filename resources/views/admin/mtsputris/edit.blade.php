@extends('admin.layout')

@section('page-title', 'Edit Siswa MTs Putri')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <form action="{{ route('admin.mtsputris.update', $mtsputri) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Siswa</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $mtsputri->nama) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $mtsputri->tempat_lahir) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $mtsputri->tanggal_lahir) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $mtsputri->nik) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn', $mtsputri->nisn) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <div class="border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Orang Tua</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $mtsputri->nama_ayah) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">No. HP Ayah</label>
                    <input type="text" name="no_hp_ayah" value="{{ old('no_hp_ayah', $mtsputri->no_hp_ayah) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $mtsputri->nama_ibu) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">No. HP Ibu</label>
                    <input type="text" name="no_hp_ibu" value="{{ old('no_hp_ibu', $mtsputri->no_hp_ibu) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <div class="border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumen</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Foto KK</label>
                    <input type="file" name="fotokk" accept="image/*" class="mt-1 block w-full text-sm text-gray-500">
                    @if($mtsputri->fotokk)<p class="text-xs text-gray-500 mt-1">File saat ini: {{ $mtsputri->fotokk }}</p>@endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Foto Akta</label>
                    <input type="file" name="fotoakta" accept="image/*" class="mt-1 block w-full text-sm text-gray-500">
                    @if($mtsputri->fotoakta)<p class="text-xs text-gray-500 mt-1">File saat ini: {{ $mtsputri->fotoakta }}</p>@endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Foto Transfer</label>
                    <input type="file" name="fototransfer" accept="image/*" class="mt-1 block w-full text-sm text-gray-500">
                    @if($mtsputri->fototransfer)<p class="text-xs text-gray-500 mt-1">File saat ini: {{ $mtsputri->fototransfer }}</p>@endif
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.mtsputris.index') }}" wire:navigate class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection
