<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Data Pendaftaran</h1>
                <p class="text-sm text-zinc-500 mt-1 font-medium">Kelola data pendaftaran siswa baru secara menyeluruh</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto mt-4 sm:mt-0">
                <button wire:click="export" wire:loading.attr="disabled" class="bg-white border border-zinc-200 text-zinc-700 hover:bg-zinc-50 hover:text-zinc-900 px-5 py-2.5 rounded-lg flex items-center justify-center shadow-sm hover:shadow transition-all duration-200 font-semibold text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="export" class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Excel
                    </span>
                    <span wire:loading wire:target="export" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-zinc-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mengexport...
                    </span>
                </button>
                <a wire:navigate href="{{ route('admin.pendaftarans.create') }}" class="bg-zinc-900 hover:bg-zinc-800 text-white px-5 py-2.5 rounded-lg flex items-center justify-center shadow-sm hover:shadow transition-all duration-200 font-semibold text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Pendaftaran
                </a>
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
                    placeholder="Cari nama, NISN, atau NIK..." 
                    class="w-full pl-9 pr-4 py-2 bg-zinc-50/50 border border-zinc-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition-colors"
                >
            </div>
            <select wire:model.live="tahunAjaran" class="bg-zinc-50/50 border border-zinc-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition-colors min-w-[140px]">
                <option value="">Semua Tahun Ajaran</option>
                @foreach($tahunAjarans as $ta)
                    <option value="{{ $ta }}">{{ $ta }}</option>
                @endforeach
            </select>
            <select wire:model.live="status" class="bg-zinc-50/50 border border-zinc-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition-colors min-w-[140px]">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
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
            @if($search || $tahunAjaran || $status || $jenjang)
                <button wire:click="$set('search', ''); $set('tahunAjaran', null); $set('status', ''); $set('jenjang', null)" class="bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
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
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">
                            <button wire:click="sortBy('nama')" class="flex items-center gap-1.5 hover:text-zinc-800 transition-colors group">
                                Pendaftar
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
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Jenjang</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Asal Sekolah</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Tgl. Daftar</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Uang Masuk</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-zinc-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-zinc-200/80">
                    @forelse($pendaftarans as $pendaftaran)
                    <tr class="hover:bg-zinc-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-9 h-9 bg-zinc-100 border border-zinc-200 rounded-full flex items-center justify-center text-zinc-700 font-bold text-sm shrink-0">
                                    {{ $pendaftarans->firstItem() + $loop->index }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-zinc-900">{{ $pendaftaran->nama }}</div>
                                    <div class="text-xs text-zinc-500 mt-0.5 font-medium">{{ $pendaftaran->nik }}</div>
                                </div>
                            </div>
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
                            @php($wib = $pendaftaran->created_at->setTimezone('Asia/Jakarta'))
                            <div class="text-sm text-zinc-900 font-medium">{{ $wib->locale('id')->isoFormat('D MMMM Y') }}</div>
                            <div class="text-xs text-zinc-400 font-medium mt-0.5">{{ $wib->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold border
                                @if($pendaftaran->status_pendaftaran === 'completed')
                                    bg-green-50 text-green-700 border-green-200
                                @else
                                    bg-orange-50 text-orange-700 border-orange-200
                                @endif">
                                @if($pendaftaran->status_pendaftaran === 'completed')
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                                {{ ucfirst($pendaftaran->status_pendaftaran) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($editingBayar === $pendaftaran->id)
                                <div x-data="{ nilai: '{{ $pendaftaran->bayar_uang_masuk ?? '' }}' }" class="flex items-center gap-1">
                                    <span class="text-sm text-zinc-500 font-medium">Rp</span>
                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        x-model="nilai"
                                        x-on:keydown.enter="$wire.saveBayar('{{ $pendaftaran->id }}', nilai)"
                                        x-on:keydown.escape="$wire.cancelBayar()"
                                        x-on:blur="$wire.saveBayar('{{ $pendaftaran->id }}', nilai)"
                                        class="w-28 px-2 py-1 text-sm border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent"
                                        autofocus
                                        placeholder="0"
                                    >
                                </div>
                            @else
                                <button
                                    wire:click="editBayar('{{ $pendaftaran->id }}')"
                                    class="group/uang inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-md text-sm font-semibold transition-all duration-150 border border-transparent hover:border-zinc-200 hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-zinc-300"
                                    title="Klik untuk edit"
                                >
                                    @if($pendaftaran->bayar_uang_masuk)
                                        <span class="text-zinc-900">Rp {{ number_format($pendaftaran->bayar_uang_masuk, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-zinc-400 italic">-</span>
                                    @endif
                                    <svg class="w-3.5 h-3.5 text-zinc-300 group-hover/uang:text-zinc-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-zinc-900 font-medium">{{ $pendaftaran->no_hp ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ \App\Livewire\Admin\PendaftaransTable::waUrl($pendaftaran) }}" target="_blank" class="p-1.5 text-zinc-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Kirim ke WhatsApp">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                </a>
                                <a wire:navigate href="{{ route('admin.pendaftarans.show', $pendaftaran) }}" class="p-1.5 text-zinc-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a wire:navigate href="{{ route('admin.pendaftarans.edit', $pendaftaran) }}" class="p-1.5 text-zinc-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button
                                    type="button"
                                    class="delete-btn p-1.5 text-zinc-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Hapus"
                                    data-id="{{ $pendaftaran->id }}"
                                    data-name="{{ $pendaftaran->nama }}"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-zinc-50 rounded-full flex items-center justify-center border border-zinc-100 mb-4">
                                    <svg class="h-8 w-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-900 mb-1">Belum ada data pendaftaran</h3>
                                <p class="text-sm text-zinc-500">Pendaftaran baru akan muncul di sini.</p>
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

    <!-- Delete Confirmation Modal -->
    <flux:modal name="delete-confirm" class="max-w-md" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); margin: 0;">
        <div class="p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 rounded-full bg-red-100 border border-red-200 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-zinc-900">Hapus Data Pendaftaran?</h3>
                    <p class="text-sm text-zinc-500 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>

            <div class="bg-red-50 border border-red-100 rounded-lg p-4 mb-6">
                <p class="text-sm text-zinc-700">
                    Anda akan menghapus data pendaftaran atas nama
                    <span class="font-bold text-red-700">{{ $deleteItemName }}</span>
                </p>
                <p class="text-xs text-zinc-500 mt-2">
                    Semua file terkait (Foto KK, Akta, Transfer, Bukti Transfer) juga akan dihapus dari sistem.
                </p>
            </div>

            <div class="flex gap-3">
                <flux:button wire:click="closeModal" variant="ghost" class="flex-1">
                    Batal
                </flux:button>
                <flux:button wire:click="deleteConfirmed" variant="danger" class="flex-1">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Ya, Hapus
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>

@script
<script>
    document.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.delete-btn');
        if (deleteBtn) {
            const id = deleteBtn.dataset.id;
            const name = deleteBtn.dataset.name;
            $wire.call('confirmDelete', id, name);
        }
    });

    Livewire.on('download-excel', (event) => {
        const a = document.createElement('a');
        a.href = event.url;
        a.download = '';
        document.body.appendChild(a);
        a.click();
        a.remove();
    });
</script>
@endscript
