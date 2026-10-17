<div class="space-y-6 max-w-3xl">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 tracking-tight">Kontak Lembaga</h1>
                <p class="text-sm text-zinc-500 mt-1 font-medium">Informasi kontak resmi pondok pesantren (dipakai di halaman publik)</p>
            </div>
            <a wire:navigate href="{{ route('admin.kontaks.index') }}" class="bg-white border border-zinc-200 hover:bg-zinc-50 text-zinc-700 px-4 py-2.5 rounded-lg font-semibold text-sm shadow-sm transition-colors">
                Daftar Kontak
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-zinc-200/80 p-6">
        <form wire:submit="save" class="space-y-6">
            <div>
                <h3 class="text-lg font-semibold text-zinc-900 mb-4">Informasi Utama</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea wire:model="alamat" rows="3" placeholder="Jl. ... No. ..., Desa, Kecamatan, Kabupaten, Provinsi"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                        @error('alamat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Telepon</label>
                        <input type="text" wire:model="telepon" placeholder="mis. (021) 1234567"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                        @error('telepon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">WhatsApp</label>
                        <input type="text" wire:model="whatsapp" placeholder="mis. 6285259875754"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                        <p class="text-xs text-gray-500 mt-1">Gunakan format 62xxx agar bisa diklik (wa.me).</p>
                        @error('whatsapp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" wire:model="email" placeholder="info@example.com"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jam Layanan</label>
                        <input type="text" wire:model="jamLayanan" placeholder="mis. Senin - Sabtu, 07.00 - 16.00 WIB"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                        @error('jamLayanan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-zinc-900 mb-4">Peta & Media Sosial</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Embed Google Maps</label>
                        <textarea wire:model="mapsEmbed" rows="3" placeholder="&lt;iframe src=&quot;https://www.google.com/maps/embed?...&quot;&gt;&lt;/iframe&gt;"
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-xs font-mono focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Salin kode embed dari Google Maps (Share → Embed a map).</p>
                        @error('mapsEmbed')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Facebook</label>
                            <input type="text" wire:model="facebook" placeholder="https://facebook.com/..."
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                            @error('facebook')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Instagram</label>
                            <input type="text" wire:model="instagram" placeholder="https://instagram.com/..."
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                            @error('instagram')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">YouTube</label>
                            <input type="text" wire:model="youtube" placeholder="https://youtube.com/@..."
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                            @error('youtube')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit" wire:loading.attr="disabled"
                        class="bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 text-white px-5 py-2.5 rounded-lg font-semibold text-sm shadow-sm">
                    <span wire:loading.remove>Simpan Kontak Lembaga</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
                @if(session('success'))
                    <span class="text-sm font-medium text-emerald-600">{{ session('success') }}</span>
                @endif
            </div>
        </form>
    </div>
</div>

