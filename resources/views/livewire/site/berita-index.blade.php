<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-green-600 transition">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700 dark:text-gray-300">Berita</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Berita &amp; Pengumuman</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Kabar, pengumuman, dan kegiatan terbaru dari pondok pesantren.</p>
    </div>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($beritas->isEmpty())
            <div
                class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2zM14 4v6h6" />
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada berita yang diterbitkan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($beritas as $berita)
                    <a href="{{ route('berita.show', $berita->slug) }}" wire:navigate
                        class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 dark:border-gray-700 transition">
                        @if ($berita->gambar)
                            <img src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->judul }}"
                                class="w-full h-44 object-cover">
                        @else
                            <div
                                class="w-full h-44 bg-gradient-to-br from-green-100 to-emerald-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                                <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2zM14 4v6h6" />
                                </svg>
                            </div>
                        @endif

                        <div class="p-5">
                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-2">
                                @if (filled($berita->kategori))
                                    <span
                                        class="px-2 py-0.5 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full font-semibold">{{ $berita->kategori }}</span>
                                @endif
                                <span>{{ $berita->published_at?->translatedFormat('d F Y') }}</span>
                            </div>
                            <h2
                                class="font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-green-600 dark:group-hover:text-green-400 transition">
                                {{ $berita->judul }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
                                {{ $berita->ringkasan_singkat }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            @if ($beritas->hasPages())
                <div class="mt-10">
                    {{ $beritas->links('livewire.site.pagination') }}
                </div>
            @endif
        @endif
    </section>
</div>
