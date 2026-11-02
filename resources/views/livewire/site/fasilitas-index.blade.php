<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-green-600 transition">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700 dark:text-gray-300">Fasilitas</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Fasilitas</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Sarana dan prasarana yang menunjang pendidikan dan kehidupan
            santri.</p>
    </div>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($fasilitasList->isEmpty())
            <div
                class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6" />
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada data fasilitas.</p>
            </div>
        @else
            <div class="grid gap-6 lg:gap-8">
                @foreach ($fasilitasList as $fasilitas)
                    <div id="fasilitas-{{ $fasilitas->id }}"
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden scroll-mt-24">
                        <div class="grid grid-cols-1 lg:grid-cols-2">
                            <div @class(['relative min-h-52 bg-emerald-50 dark:bg-gray-700 lg:min-h-72', 'lg:order-last' => $loop->even])>
                                @if ($fasilitas->gambar)
                                    <img src="{{ Storage::url($fasilitas->gambar) }}" alt="{{ $fasilitas->nama }}"
                                        class="absolute inset-0 h-full w-full object-cover">
                                @else
                                    <div
                                        class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 self-center p-6 sm:p-8 lg:p-10">
                                @if (filled($fasilitas->kategori))
                                    <span
                                        class="inline-block px-2.5 py-0.5 text-xs font-semibold bg-emerald-50 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-200 rounded-full mb-3">{{ $fasilitas->kategori }}</span>
                                @endif
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ $fasilitas->nama }}
                                </h2>
                                <p class="text-gray-600 dark:text-gray-400 text-justify leading-relaxed whitespace-pre-line">{{ $fasilitas->deskripsi ?: 'Belum ada deskripsi untuk fasilitas ini.' }}</p>
                            </div>
                        </div>

                        @if ($fasilitas->fotos->count() > 1)
                            <div class="border-t border-gray-100 dark:border-gray-700 p-6 lg:p-8">
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">
                                    Galeri Foto ({{ $fasilitas->fotos->count() }})
                                </p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                    @foreach ($fasilitas->fotos as $foto)
                                        <a href="{{ Storage::url($foto->path) }}" target="_blank" rel="noopener"
                                            class="block group">
                                            <img src="{{ Storage::url($foto->path) }}"
                                                alt="Foto {{ $fasilitas->nama }}"
                                                class="w-full h-28 object-cover rounded-lg border border-gray-200 dark:border-gray-700 group-hover:opacity-90 transition">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if ($fasilitasList->hasPages())
                <div class="mt-10">
                    {{ $fasilitasList->links('livewire.site.pagination') }}
                </div>
            @endif
        @endif
    </section>
</div>
