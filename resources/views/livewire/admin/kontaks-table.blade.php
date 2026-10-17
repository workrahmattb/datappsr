<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Kontak</h1>
                <p class="text-sm text-zinc-500 mt-1 font-medium">Kelola daftar kontak person & unit pondok pesantren</p>
            </div>
            <div class="flex items-center gap-3">
                <a wire:navigate href="{{ route('admin.kontak-lembaga.index') }}" class="bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 px-4 py-2.5 rounded-lg font-semibold text-sm shadow-sm transition-colors">
                    Kontak Lembaga
                </a>
                <a wire:navigate href="{{ route('admin.kontaks.create') }}" class="bg-zinc-900 hover:bg-zinc-800 text-white px-5 py-2.5 rounded-lg flex items-center shadow-sm hover:shadow transition-all duration-200 font-semibold text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Kontak
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
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, unit, jabatan, telepon, atau email..."
                       class="w-full pl-9 pr-4 py-2 bg-zinc-50/50 border border-zinc-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition-colors">
            </div>
            <select wire:model.live="perPage" class="bg-zinc-50/50 border border-zinc-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition-colors min-w-[120px]">
                <option value="15">15 per halaman</option>
                <option value="25">25 per halaman</option>
                <option value="50">50 per halaman</option>
                <option value="100">100 per halaman</option>
            </select>
            @if($search)
                <button wire:click="$set('search', '')" class="bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
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
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Jabatan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Telepon / WhatsApp</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-zinc-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-zinc-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-zinc-200/80">
                    @forelse($kontaks as $kontak)
                    <tr class="hover:bg-zinc-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="w-5 text-xs font-bold text-zinc-400 text-center shrink-0">{{ $kontaks->firstItem() + $loop->index }}</span>
                                <div class="ml-1.5 min-w-0">
                                    <div class="text-sm font-medium text-zinc-900 truncate max-w-[16rem]">{{ $kontak->nama }}</div>
                                    <div class="text-xs text-zinc-500 mt-0.5">{{ $kontak->unit ?: 'Tanpa unit' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-zinc-900">{{ $kontak->jabatan ?: '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-zinc-900">{{ $kontak->telepon ?: '-' }}</div>
                            @if($kontak->whatsapp)
                                <div class="text-xs text-zinc-500 mt-0.5">WA: {{ $kontak->whatsapp }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-zinc-900">{{ $kontak->email ?: '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1 flex-wrap">
                                @if($kontak->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-zinc-100 text-zinc-600 border border-zinc-200">Nonaktif</span>
                                @endif
                                <span class="text-xs text-zinc-400">Urutan {{ $kontak->urutan }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a wire:navigate href="{{ route('admin.kontaks.show', $kontak) }}" class="p-1.5 text-zinc-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a wire:navigate href="{{ route('admin.kontaks.edit', $kontak) }}" class="p-1.5 text-zinc-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button type="button" class="delete-btn p-1.5 text-zinc-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus" data-id="{{ $kontak->id }}">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-zinc-900 mb-1">Belum ada kontak</h3>
                                <p class="text-sm text-zinc-500">Kontak yang Anda tambahkan akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($kontaks->hasPages())
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-4">
        {{ $kontaks->links() }}
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
                    <h3 class="text-lg font-bold text-zinc-900">Hapus Kontak?</h3>
                    <p class="text-sm text-zinc-500 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>

            <div class="bg-red-50 border border-red-100 rounded-lg p-4 mb-6">
                <p class="text-sm text-zinc-700">
                    Anda akan menghapus kontak atas nama
                    <span class="font-bold text-red-700">{{ $deleteItemName }}</span>
                </p>
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

