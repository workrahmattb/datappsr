<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Profil Guru</h1>
                <p class="text-sm text-zinc-500 mt-1 font-medium">Kelola profil ustadz & ustadzah pondok pesantren</p>
            </div>
            <a wire:navigate href="{{ route('admin.gurus.create') }}" class="bg-zinc-900 hover:bg-zinc-800 text-white px-5 py-2.5 rounded-lg flex items-center shadow-sm hover:shadow transition-all duration-200 font-semibold text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Guru
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6">
        <div class="flex gap-3 flex-wrap">
            <div class="flex-1 min-w-[250px] relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, NIP, atau jabatan..."
                       class="w-full pl-9 pr-4 py-2 bg-zinc-50/50 border border-zinc-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition-colors">
            </div>
            <select wire:model.live="jenisKelamin" class="bg-zinc-50/50 border border-zinc-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition-colors min-w-[150px]">
                <option value="">Semua Jenis Kelamin</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
            <select wire:model.live="perPage" class="bg-zinc-50/50 border border-zinc-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition-colors min-w-[120px]">
                <option value="15">15 per halaman</option>
                <option value="25">25 per halaman</option>
                <option value="50">50 per halaman</option>
                <option value="100">100 per halaman</option>
            </select>
            @if($search || $jenisKelamin)
                <button wire:click="$set('search', ''); $set('jenisKelamin', null)" class="bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
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
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Guru</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Jabatan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Urutan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-zinc-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-zinc-200/80">
                    @forelse($gurus as $guru)
                    <tr class="hover:bg-zinc-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="w-5 text-xs font-bold text-zinc-400 text-center shrink-0">{{ $gurus->firstItem() + $loop->index }}</span>
                                @if($guru->foto)
                                    <img src="{{ Storage::url($guru->foto) }}" alt="{{ $guru->name }}" class="w-10 h-10 rounded-full object-cover border border-zinc-200 shrink-0 ml-1.5">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-emerald-50 border border-zinc-200 flex items-center justify-center text-emerald-600 font-bold text-sm shrink-0 ml-1.5">
                                        {{ strtoupper(substr($guru->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="ml-3 min-w-0">
                                    <div class="text-sm font-medium text-zinc-900 truncate max-w-[16rem]">{{ $guru->name }}</div>
                                    <div class="text-xs text-zinc-500 mt-0.5">{{ $guru->nip ? 'NIP: '.$guru->nip : 'Tanpa NIP' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-zinc-900">{{ $guru->jabatan ?: '-' }}</div>
                            @if($guru->pendidikan)
                                <div class="text-xs text-zinc-500 mt-0.5">{{ $guru->pendidikan }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-zinc-900">{{ $guru->no_hp ?: '-' }}</div>
                            @if($guru->email)
                                <div class="text-xs text-zinc-500 mt-0.5">{{ $guru->email }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-zinc-900 font-medium">{{ $guru->urutan }}</td>
                        <td class="px-6 py-4">
                            @if($guru->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-zinc-100 text-zinc-600 border border-zinc-200">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a wire:navigate href="{{ route('admin.gurus.show', $guru) }}" class="p-1.5 text-zinc-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a wire:navigate href="{{ route('admin.gurus.edit', $guru) }}" class="p-1.5 text-zinc-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button type="button" class="delete-btn p-1.5 text-zinc-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus" data-id="{{ $guru->id }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-zinc-50 rounded-full flex items-center justify-center border border-zinc-100 mb-4">
                                    <svg class="h-8 w-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7m-6-4v-4m12 4v-4"/>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-900 mb-1">Belum ada profil guru</h3>
                                <p class="text-sm text-zinc-500">Profil guru yang Anda tambahkan akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($gurus->hasPages())
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-4">
        {{ $gurus->links() }}
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
                    <h3 class="text-lg font-bold text-zinc-900">Hapus Profil Guru?</h3>
                    <p class="text-sm text-zinc-500 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>

            <div class="bg-red-50 border border-red-100 rounded-lg p-4 mb-6">
                <p class="text-sm text-zinc-700">
                    Anda akan menghapus profil guru
                    <span class="font-bold text-red-700">{{ $deleteItemName }}</span>
                </p>
                <p class="text-xs text-zinc-500 mt-2">Foto guru juga akan dihapus dari sistem.</p>
            </div>

            <div class="flex gap-3">
                <flux:button wire:click="closeModal" variant="ghost" class="flex-1">Batal</flux:button>
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
    document.addEventListener('click', function (e) {
        const deleteBtn = e.target.closest('.delete-btn');

        if (deleteBtn) {
            $wire.call('confirmDelete', deleteBtn.dataset.id);
        }
    });
</script>
@endscript
</div>

