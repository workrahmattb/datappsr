@extends('admin.layout')

@section('page-title', 'Detail Siswa MA Putri')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">{{ $maputri->nama }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.maputris.edit', $maputri) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg">Edit</a>
            <a href="{{ route('admin.maputris.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Kembali</a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Data Siswa</h3>
        </div>
        <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><span class="text-sm text-gray-500">NIK:</span><p class="font-medium">{{ $maputri->nik ?? '-' }}</p></div>
            <div><span class="text-sm text-gray-500">NISN:</span><p class="font-medium">{{ $maputri->nisn ?? '-' }}</p></div>
            <div><span class="text-sm text-gray-500">Tempat, Tanggal Lahir:</span><p class="font-medium">{{ $maputri->tempat_lahir }}, {{ $maputri->tanggal_lahir }}</p></div>
            <div><span class="text-sm text-gray-500">Kelas:</span><p class="font-medium">{{ $maputri->kelas?->nama ?? '-' }}</p></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Data Orang Tua</h3>
        </div>
        <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><span class="text-sm text-gray-500">Nama Ayah:</span><p class="font-medium">{{ $maputri->nama_ayah ?? '-' }}</p></div>
            <div><span class="text-sm text-gray-500">No. HP Ayah:</span><p class="font-medium">{{ $maputri->no_hp_ayah ?? '-' }}</p></div>
            <div><span class="text-sm text-gray-500">Nama Ibu:</span><p class="font-medium">{{ $maputri->nama_ibu ?? '-' }}</p></div>
            <div><span class="text-sm text-gray-500">No. HP Ibu:</span><p class="font-medium">{{ $maputri->no_hp_ibu ?? '-' }}</p></div>
        </div>
    </div>

    @if($maputri->fotokk || $maputri->fotoakta || $maputri->fototransfer)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Dokumen</h3>
        </div>
        <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            @if($maputri->fotokk)<div><span class="text-sm text-gray-500">Foto KK:</span><a href="{{ Storage::url($maputri->fotokk) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a></div>@endif
            @if($maputri->fotoakta)<div><span class="text-sm text-gray-500">Foto Akta:</span><a href="{{ Storage::url($maputri->fotoakta) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a></div>@endif
            @if($maputri->fototransfer)<div><span class="text-sm text-gray-500">Foto Transfer:</span><a href="{{ Storage::url($maputri->fototransfer) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a></div>@endif
        </div>
    </div>
    @endif
</div>
@endsection
