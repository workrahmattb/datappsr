@extends('admin.layout')

@section('page-title', 'Data Pendaftaran')

@section('content')
<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Data Pendaftaran</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.pendaftarans.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export Excel
            </a>
            <a href="{{ route('admin.pendaftarans.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pendaftaran
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <form action="{{ route('admin.pendaftarans.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NISN, atau NIK..." class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg">Cari</button>
            @if(request('search') || request('status'))<a href="{{ route('admin.pendaftarans.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Reset</a>@endif
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenjang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. HP</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pendaftarans as $pendaftaran)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4"><div class="text-sm font-medium text-gray-900">{{ $pendaftaran->nama }}</div><div class="text-sm text-gray-500">{{ $pendaftaran->nik }}</div></td>
                    <td class="px-6 py-4"><div class="text-sm text-gray-900">{{ $pendaftaran->jenjang_pendidikan }}</div></td>
                    <td class="px-6 py-4">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($pendaftaran->status_pendaftaran === 'completed') bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($pendaftaran->status_pendaftaran) }}
                        </span>
                    </td>
                    <td class="px-6 py-4"><div class="text-sm text-gray-900">{{ $pendaftaran->no_hp_ibu ?? $pendaftaran->no_hp_ayah ?? '-' }}</div></td>
                    <td class="px-6 py-4 text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.pendaftarans.show', $pendaftaran) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                            <a href="{{ route('admin.pendaftarans.edit', $pendaftaran) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            <form action="{{ route('admin.pendaftarans.destroy', $pendaftaran) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-900">Hapus</button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data pendaftaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pendaftarans->hasPages())<div class="bg-white rounded-lg shadow p-4">{{ $pendaftarans->links() }}</div>@endif
</div>
@endsection
