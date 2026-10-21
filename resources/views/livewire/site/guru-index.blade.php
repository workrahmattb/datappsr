<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-green-600 transition">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700 dark:text-gray-300">Guru</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Profil Guru</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Ustadz dan ustadzah yang mengajar di pondok pesantren.</p>
    </div>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($gurus->isEmpty())
            <div
                class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 14l9-5-9-5-9 5 9 5zm0 0v7m-6-4v-4m12 4v-4" />
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada data profil guru.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($gurus as $guru)
                    <div id="guru-{{ $guru->id }}"
                        class="bg-white dark:bg-gray-800 rounded-xl p-6 text-center shadow-sm hover:shadow-lg border border-gray-100 dark:border-gray-700 transition scroll-mt-24">
                        @if ($guru->foto)
                            <img src="{{ Storage::url($guru->foto) }}" alt="{{ $guru->name }}"
                                class="w-24 h-24 rounded-full object-cover mx-auto mb-4 border-2 border-green-100 dark:border-gray-600">
                        @else
                            <div
                                class="w-24 h-24 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-700 dark:text-green-400 font-bold text-3xl mx-auto mb-4">
                                {{ strtoupper(substr($guru->name, 0, 1)) }}
                            </div>
                        @endif

                        <h2 class="font-bold text-gray-900 dark:text-white">{{ $guru->name }}</h2>
                        <p class="text-sm text-green-600 dark:text-green-400 font-medium mt-0.5">
                            {{ $guru->jabatan ?: 'Pengajar' }}</p>

                        @if (filled($guru->pendidikan))
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ $guru->pendidikan }}</p>
                        @endif

                        @if (filled($guru->deskripsi))
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-4 line-clamp-4">
                                {{ $guru->deskripsi }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            @if ($gurus->hasPages())
                <div class="mt-10">
                    {{ $gurus->links() }}
                </div>
            @endif
        @endif
    </section>
</div>
