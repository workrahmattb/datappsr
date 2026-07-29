<div class="p-6">
    <div class="max-w-2xl">
        <!-- Page Title -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-zinc-800">Pengaturan</h1>
            <p class="text-sm text-zinc-500 mt-1">Kelola pengaturan sistem Pondok Pesantren Syafa'aturrasul</p>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Card: Tahun Ajaran Aktif -->
        <div class="bg-white rounded-xl shadow-sm border border-zinc-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-zinc-100 bg-gradient-to-r from-emerald-50 to-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-zinc-800">Tahun Ajaran Aktif</h2>
                        <p class="text-xs text-zinc-500">Pengaturan ini akan digunakan untuk pendaftaran dan daftar ulang</p>
                    </div>
                </div>
            </div>

            <form wire:submit="save" class="p-6 space-y-6">
                <!-- Tahun Ajaran -->
                <div>
                    <label for="tahunAjaranAktif" class="block text-sm font-semibold text-zinc-700 mb-2">
                        Tahun Ajaran Aktif <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select wire:model="tahunAjaranAktif" id="tahunAjaranAktif"
                                class="w-full border border-zinc-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white transition-colors appearance-none">
                            @foreach($tahunAjaranList as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('tahunAjaranAktif') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                    <p class="text-xs text-zinc-400 mt-2">
                        Saat ini: <span class="font-semibold text-emerald-600">{{ \App\Models\Setting::activeTahunAjaran() }}</span>
                    </p>
                </div>

                <!-- Info -->
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-amber-800">Informasi</p>
                        <p class="text-xs text-amber-700 mt-1">
                            Tahun ajaran aktif akan digunakan otomatis pada halaman pendaftaran, daftar ulang, 
                            pencarian siswa, dan galeri foto. Data lama tetap tersimpan dengan tahun ajaran masing-masing.
                        </p>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-end pt-2">
                    <button type="submit"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                        <svg wire:loading.remove wire:target="save" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <span>Simpan Pengaturan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
