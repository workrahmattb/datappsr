<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Uang Masuk</h1>
                <p class="text-sm text-zinc-500 mt-1 font-medium">Data pembayaran uang masuk pendaftaran siswa</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6">
        <div class="flex gap-3 flex-wrap">
            <div class="flex-1 min-w-[250px] relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Cari nama..." 
                    class="w-full pl-9 pr-4 py-2 bg-zinc-50/50 border border-zinc-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition-colors"
                >
            </div>
            <select wire:model.live="tahunAjaran" class="bg-zinc-50/50 border border-zinc-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition-colors min-w-[140px]">
                <option value="">Semua Tahun Ajaran</option>
                @foreach($tahunAjarans as $ta)
                    <option value="{{ $ta }}">{{ $ta }}</option>
                @endforeach
            </select>
            <select wire:model.live="jenjang" class="bg-zinc-50/50 border border-zinc-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition-colors min-w-[140px]">
                <option value="">Semua Jenjang</option>
                <option value="MTs Putri">MTs Putri</option>
                <option value="MTs Putra">MTs Putra</option>
                <option value="MA Putri">MA Putri</option>
                <option value="MA Putra">MA Putra</option>
            </select>
            <select wire:model.live="perPage" class="bg-zinc-50/50 border border-zinc-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition-colors min-w-[120px]">
                <option value="15">15 per halaman</option>
                <option value="25">25 per halaman</option>
                <option value="50">50 per halaman</option>
                <option value="100">100 per halaman</option>
            </select>
            @if($search || $tahunAjaran || $jenjang)
                <button wire:click="$set('search', ''); $set('tahunAjaran', null); $set('jenjang', null)" class="bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                    Reset Filter
                </button>
            @endif
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200/80">
                <thead class="bg-zinc-50/80">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">
                            <button wire:click="sortBy('nama')" class="flex items-center gap-1.5 hover:text-zinc-800 transition-colors group">
                                Nama
                                @if($sortField === 'nama')
                                    <svg class="w-3.5 h-3.5 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                        @endif
                                    </svg>
                                @else
                                    <svg class="w-3.5 h-3.5 text-zinc-300 group-hover:text-zinc-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Jenjang Pendidikan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Asal Sekolah</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">
                            <button wire:click="sortBy('bayar_uang_masuk')" class="flex items-center gap-1.5 hover:text-zinc-800 transition-colors group">
                                Uang Masuk
                                @if($sortField === 'bayar_uang_masuk')
                                    <svg class="w-3.5 h-3.5 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                        @endif
                                    </svg>
                                @else
                                    <svg class="w-3.5 h-3.5 text-zinc-300 group-hover:text-zinc-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                @endif
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Alamat</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-zinc-200/80">
                    @forelse($pendaftarans as $pendaftaran)
                    <tr class="hover:bg-zinc-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="w-9 h-9 bg-zinc-100 border border-zinc-200 rounded-full flex items-center justify-center text-zinc-700 font-bold text-sm">
                                {{ $pendaftarans->firstItem() + $loop->index }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-zinc-900">{{ $pendaftaran->nama }}</div>
                            <div class="text-xs text-zinc-500 mt-0.5 font-medium">{{ $pendaftaran->nik ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-zinc-100 border border-zinc-200 text-zinc-800 text-xs font-semibold">
                                {{ strtoupper($pendaftaran->jenjang_pendidikan) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-zinc-900 font-medium">{{ $pendaftaran->nama_sekolah_sebelumnya ?? $pendaftaran->asal_sekolah ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5">
                                @if($pendaftaran->bayar_uang_masuk)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold">
                                        Rp {{ number_format($pendaftaran->bayar_uang_masuk, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-zinc-400 italic text-sm">-</span>
                                @endif
                            </div>
                            @if($pendaftaran->status_bayar_uang_masuk)
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        @if($pendaftaran->status_bayar_uang_masuk === 'lunas')
                                            bg-green-50 text-green-700
                                        @elseif($pendaftaran->status_bayar_uang_masuk === 'pending')
                                            bg-orange-50 text-orange-700
                                        @else
                                            bg-red-50 text-red-700
                                        @endif
                                    ">
                                        {{ ucfirst($pendaftaran->status_bayar_uang_masuk) }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-zinc-900 max-w-xs">
                                {{ $pendaftaran->alamat ?? (collect([$pendaftaran->desa, $pendaftaran->kecamatan, $pendaftaran->kabupaten, $pendaftaran->provinsi])->filter()->implode(', ') ?: '-') }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-zinc-50 rounded-full flex items-center justify-center border border-zinc-100 mb-4">
                                    <svg class="h-8 w-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-900 mb-1">Belum ada data pembayaran</h3>
                                <p class="text-sm text-zinc-500">Data uang masuk akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($pendaftarans->hasPages())
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-4">
        {{ $pendaftarans->links() }}
    </div>
    @endif
</div>
