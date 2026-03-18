@extends('admin.layout')

@section('page-title', 'Siswa MTs Putri')

@section('content')
<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Data Siswi MTs Putri</h1>
        <a href="{{ route('admin.mtsputris.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Siswi
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <form action="{{ route('admin.mtsputris.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NISN, atau NIK..." class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg">Cari</button>
            @if(request('search'))<a href="{{ route('admin.mtsputris.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Reset</a>@endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NISN</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lahir</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($mtsputris as $mtsputri)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4"><div class="text-sm font-medium text-gray-900">{{ $mtsputri->nama }}</div><div class="text-sm text-gray-500">{{ $mtsputri->nik }}</div></td>
                    <td class="px-6 py-4"><div class="text-sm text-gray-900">{{ $mtsputri->nisn ?? '-' }}</div></td>
                    <td class="px-6 py-4"><div class="text-sm text-gray-900">{{ $mtsputri->kelas?->nama ?? '-' }}</div></td>
                    <td class="px-6 py-4"><div class="text-sm text-gray-900">{{ $mtsputri->tanggal_lahir }}</div><div class="text-sm text-gray-500">{{ $mtsputri->tempat_lahir }}</div></td>
                    <td class="px-6 py-4 text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.mtsputris.show', $mtsputri) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                            <a href="{{ route('admin.mtsputris.edit', $mtsputri) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            <form action="{{ route('admin.mtsputris.destroy', $mtsputri) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-900">Hapus</button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data siswi MTs Putri</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($mtsputris->hasPages())<div class="bg-white rounded-lg shadow p-4">{{ $mtsputris->links() }}</div>@endif
</div>
@endsection
