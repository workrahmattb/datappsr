<div>
    <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-green-600 transition">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('berita.index') }}" wire:navigate class="hover:text-green-600 transition">Berita</a>
        </nav>

        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-3">
            @if (filled($berita->kategori))
                <span
                    class="px-2 py-0.5 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full font-semibold">{{ $berita->kategori }}</span>
            @endif
            <span>{{ $berita->published_at?->translatedFormat('d F Y') }}</span>
            @if (filled($berita->penulis))
                <span>· {{ $berita->penulis }}</span>
            @endif
        </div>

        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white leading-tight mb-6">
            {{ $berita->judul }}</h1>

        @if ($berita->gambar)
            <img src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->judul }}"
                class="w-full rounded-xl border border-gray-200 dark:border-gray-700 mb-8">
        @endif

        @if (filled($berita->ringkasan))
            <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed mb-6 font-medium">
                {{ $berita->ringkasan }}</p>
        @endif

        {{-- Isi berita: HTML sudah disanitasi (HtmlSanitizer) --}}
        <div class="rich-text">{!! $berita->isi_html !!}</div>

        <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('berita.index') }}" wire:navigate
                class="inline-flex items-center gap-2 text-sm font-semibold text-green-600 dark:text-green-400 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke daftar berita
            </a>
        </div>
    </article>

    @if ($lainnya->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Berita Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($lainnya as $item)
                    <a href="{{ route('berita.show', $item->slug) }}" wire:navigate
                        class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 dark:border-gray-700 transition">
                        @if ($item->gambar)
                            <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}"
                                class="w-full h-40 object-cover">
                        @endif
                        <div class="p-5">
                            <span
                                class="text-xs text-gray-500 dark:text-gray-400">{{ $item->published_at?->translatedFormat('d F Y') }}</span>
                            <h3
                                class="font-bold text-gray-900 dark:text-white mt-1 line-clamp-2 group-hover:text-green-600 dark:group-hover:text-green-400 transition">
                                {{ $item->judul }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
