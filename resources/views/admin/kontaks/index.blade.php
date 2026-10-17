@extends('admin.layout')

@section('page-title', 'Data Kontak')

@section('content')
<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Data Kontak</h1>
        <div class="flex gap-2">
            <a wire:navigate href="{{ route('admin.kontak-lembaga.index') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg">Kontak Lembaga</a>
            <a wire:navigate href="{{ route('admin.kontaks.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg">Tambah Kontak</a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($kontaks as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $item->nama }}</div>
                        <div class="text-xs text-gray-500">{{ $item->jabatan ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item->unit ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $item->telepon ?? '-' }}</div>
                        <div class="text-xs text-gray-500">{{ $item->email ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a wire:navigate href="{{ route('admin.kontaks.show', $item) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                            <a wire:navigate href="{{ route('admin.kontaks.edit', $item) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            <form action="{{ route('admin.kontaks.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada kontak.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kontaks->hasPages())
    <div class="bg-white rounded-lg shadow p-4">
        {{ $kontaks->links() }}
    </div>
    @endif
</div>
@endsection
