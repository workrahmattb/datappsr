@extends('admin.layout')

@section('page-title', 'Data Fasilitas')

@section('content')
<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Data Fasilitas</h1>
        <a wire:navigate href="{{ route('admin.fasilitas.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg">Tambah Fasilitas</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($fasilitas as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item->kategori ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            @if($item->gambar)
                                <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->nama }}" class="w-14 h-10 rounded object-cover border border-gray-200">
                            @endif
                            <span class="text-xs text-gray-500">{{ $item->fotos_count }} foto</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item->urutan }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a wire:navigate href="{{ route('admin.fasilitas.show', $item) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                            <a wire:navigate href="{{ route('admin.fasilitas.edit', $item) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            <form action="{{ route('admin.fasilitas.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada fasilitas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($fasilitas->hasPages())
    <div class="bg-white rounded-lg shadow p-4">
        {{ $fasilitas->links() }}
    </div>
    @endif
</div>
@endsection
