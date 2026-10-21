{{-- Hero carousel: tinggi konsisten di semua slide (rasio bertingkat per breakpoint)
     supaya tata letak rapi; gambar memakai object-cover agar tidak gepeng. --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 md:pt-8">
    <section
        class="relative overflow-hidden rounded-2xl md:rounded-3xl bg-gray-900 shadow-xl ring-1 ring-black/5 aspect-[3/2] sm:aspect-[2/1] lg:aspect-[21/9]"
        aria-label="Sorotan pondok pesantren"
        @if ($this->jumlahSlide() > 1) wire:poll.6s="berikut" @endif>
        @foreach ($slides as $i => $slide)
            <div wire:key="slide-{{ $i }}"
                @class([
                    'absolute inset-0 transition-opacity duration-700 ease-in-out',
                    'opacity-100 z-10' => $i === $aktif,
                    'opacity-0 z-0 pointer-events-none' => $i !== $aktif,
                ])>
                <img src="{{ Storage::url($slide['gambar']) }}"
                    alt="{{ $slide['judul'] ?: 'Sorotan pondok pesantren' }}"
                    @if ($i > 0) loading="lazy" @endif
                    class="absolute inset-0 w-full h-full object-cover object-center">

                {{-- Gradasi lembut: cukup untuk keterbacaan teks tanpa kotak kaca --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/25 to-transparent"></div>

                @if ($this->adaTeks($slide))
                    <div class="absolute inset-x-0 bottom-0 p-4 pb-12 sm:p-6 sm:pb-14 lg:p-8 lg:pb-16"
                        data-slide-caption>
                        <div class="max-w-xl">
                            @if (filled($slide['judul']))
                                <h2
                                    class="text-lg font-bold leading-snug text-white text-shadow-md text-shadow-black/60 sm:text-2xl lg:text-3xl">
                                    {{ $slide['judul'] }}</h2>
                            @endif

                            @if (filled($slide['deskripsi']))
                                <p
                                    class="mt-1.5 line-clamp-2 text-xs text-white/90 text-shadow-sm text-shadow-black/60 sm:text-sm lg:text-base">
                                    {{ $slide['deskripsi'] }}</p>
                            @endif

                            @if (filled($slide['link_url']) && filled($slide['link_text']))
                                <a href="{{ $slide['link_url'] }}" wire:navigate
                                    class="mt-3 inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-green-500 sm:mt-4 sm:text-sm">
                                    {{ $slide['link_text'] }}
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endforeach

        @if ($this->jumlahSlide() > 1)
            <button type="button" wire:click="sebelumnya" aria-label="Slide sebelumnya"
                class="absolute left-3 top-1/2 z-20 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full text-white drop-shadow-md transition hover:bg-white/20 md:left-5 md:h-11 md:w-11">
                <svg class="h-6 w-6 md:h-7 md:w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button type="button" wire:click="berikut" aria-label="Slide berikutnya"
                class="absolute right-3 top-1/2 z-20 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full text-white drop-shadow-md transition hover:bg-white/20 md:right-5 md:h-11 md:w-11">
                <svg class="h-6 w-6 md:h-7 md:w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            {{-- Titik indikator: di tengah bawah, kartu teks diberi ruang di atasnya --}}
            <div class="absolute inset-x-0 bottom-3 z-20 flex items-center justify-center gap-2 sm:bottom-4">
                @foreach ($slides as $i => $slide)
                    <button type="button" wire:key="dot-{{ $i }}" wire:click="keSlide({{ $i }})"
                        aria-label="Ke slide {{ $i + 1 }}"
                        @if ($i === $aktif) aria-current="true" @endif
                        @class([
                            'h-1.5 rounded-full transition-all duration-300',
                            'w-6 bg-white' => $i === $aktif,
                            'w-1.5 bg-white/50 hover:bg-white/80' => $i !== $aktif,
                        ])></button>
                @endforeach
            </div>
        @endif
    </section>
</div>
