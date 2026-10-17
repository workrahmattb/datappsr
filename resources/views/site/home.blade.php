@extends('layouts.public')

@section('title', "Pondok Pesantren Syafa'aturrasul — Kuantan Singingi")
@section('description', "Pondok Pesantren Syafa'aturrasul — MTs & MA Putra/Putri di Kuantan Singingi, Riau. Informasi berita, fasilitas, profil guru, dan kontak.")

@section('content')
    <!-- Carousel / Hero -->
    @if ($slides->isNotEmpty())
        <section class="relative bg-gray-900 overflow-hidden" x-data="{
                aktif: 0,
                total: {{ $slides->count() }},
                mulai() { if (this.total > 1) { setInterval(() => this.berikut(), 6000); } },
                berikut() { this.aktif = (this.aktif + 1) % this.total; },
                sebelumnya() { this.aktif = (this.aktif - 1 + this.total) % this.total; }
            }" x-init="mulai()">
            @foreach ($slides as $i => $slide)
                <div x-show="aktif === {{ $i }}" x-transition.opacity.duration.700ms class="relative">
                    <img src="{{ Storage::url($slide->gambar) }}" alt="{{ $slide->judul ?: 'Slide' }}"
                        class="w-full h-[380px] md:h-[520px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 flex items-end">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14 w-full">
                            <div class="max-w-2xl">
                                @if (filled($slide->judul))
                                    <h1 class="text-3xl md:text-5xl font-bold text-white mb-3 leading-tight">
                                        {{ $slide->judul }}</h1>
                                @endif
                                @if (filled($slide->deskripsi))
                                    <p class="text-white/90 text-base md:text-lg mb-6">{{ $slide->deskripsi }}</p>
                                @endif
                                @if ($slide->punya_tombol)
                                    <a href="{{ $slide->link_url }}"
                                        class="inline-block px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition shadow-lg">
                                        {{ $slide->link_text }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($slides->count() > 1)
                <button type="button" x-on:click="sebelumnya()" aria-label="Slide sebelumnya"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 hover:bg-black/60 text-white flex items-center justify-center transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button type="button" x-on:click="berikut()" aria-label="Slide berikutnya"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 hover:bg-black/60 text-white flex items-center justify-center transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2">
                    @foreach ($slides as $i => $slide)
                        <button type="button" x-on:click="aktif = {{ $i }}" aria-label="Ke slide {{ $i + 1 }}"
                            :class="aktif === {{ $i }} ? 'bg-white w-6' : 'bg-white/50 w-2.5'"
                            class="h-2.5 rounded-full transition-all duration-300"></button>
                    @endforeach
                </div>
            @endif
        </section>
    @else
        <section class="bg-gradient-to-br from-green-600 to-emerald-700 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
                <div class="max-w-3xl">
                    <span class="inline-block px-3 py-1 text-xs font-semibold bg-white/20 rounded-full mb-5">
                        Tahun Ajaran {{ activeTahunAjaran() }}
                    </span>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">Pondok Pesantren Syafa'aturrasul</h1>
                    <p class="text-lg md:text-xl text-green-50 mb-8 leading-relaxed">
                        Pendidikan Islam terpadu untuk putra dan putri — MTs dan MA — di Kuantan Singingi, Riau.
                        Mendidik generasi Qur'ani yang berilmu, berakhlak, dan mandiri.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('pendaftaran') }}"
                            class="px-6 py-3 bg-white text-green-700 font-semibold rounded-lg hover:bg-green-50 transition shadow-lg">Daftar
                            Santri Baru</a>
                        <a href="{{ route('psb') }}"
                            class="px-6 py-3 bg-white/10 border border-white/40 text-white font-semibold rounded-lg hover:bg-white/20 transition">Cari
                            Data Santri</a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Berita -->
    @if ($beritas->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Berita &amp; Pengumuman</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Kabar terbaru dari pondok pesantren.</p>
                </div>
                <a href="{{ route('berita.index') }}"
                    class="text-sm font-semibold text-green-600 dark:text-green-400 hover:underline">Lihat semua berita
                    →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($beritas as $berita)
                    <a href="{{ route('berita.show', $berita->slug) }}"
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
                            <h3
                                class="font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-green-600 dark:group-hover:text-green-400 transition">
                                {{ $berita->judul }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
                                {{ $berita->ringkasan_singkat }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Fasilitas -->
    @if ($fasilitasList->isNotEmpty())
        <section class="bg-white dark:bg-gray-800 border-y border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
                <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Fasilitas</h2>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Sarana dan prasarana penunjang pendidikan
                            santri.</p>
                    </div>
                    <a href="{{ route('fasilitas.index') }}"
                        class="text-sm font-semibold text-green-600 dark:text-green-400 hover:underline">Lihat semua
                        fasilitas →</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($fasilitasList as $fasilitas)
                        <a href="{{ route('fasilitas.index') }}#fasilitas-{{ $fasilitas->id }}"
                            class="group bg-gray-50 dark:bg-gray-700/40 rounded-xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 dark:border-gray-700 transition">
                            @if ($fasilitas->gambar)
                                <img src="{{ Storage::url($fasilitas->gambar) }}" alt="{{ $fasilitas->nama }}"
                                    class="w-full h-44 object-cover">
                            @else
                                <div class="w-full h-44 bg-emerald-50 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6" />
                                    </svg>
                                </div>
                            @endif
                            <div class="p-5">
                                @if (filled($fasilitas->kategori))
                                    <span
                                        class="inline-block px-2 py-0.5 text-xs font-semibold bg-zinc-100 dark:bg-gray-600 text-zinc-700 dark:text-gray-200 rounded-full mb-2">{{ $fasilitas->kategori }}</span>
                                @endif
                                <h3
                                    class="font-bold text-gray-900 dark:text-white mb-2 group-hover:text-green-600 dark:group-hover:text-green-400 transition">
                                    {{ $fasilitas->nama }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
                                    {{ $fasilitas->deskripsi ?: '-' }}</p>
                                @if ($fasilitas->fotos->count() > 1)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">
                                        {{ $fasilitas->fotos->count() }} foto</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Profil Guru -->
    @if ($gurus->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Profil Guru</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Ustadz dan ustadzah pengajar di pondok pesantren.</p>
                </div>
                <a href="{{ route('guru.index') }}"
                    class="text-sm font-semibold text-green-600 dark:text-green-400 hover:underline">Lihat semua guru →</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($gurus as $guru)
                    <a href="{{ route('guru.index') }}#guru-{{ $guru->id }}"
                        class="group bg-white dark:bg-gray-800 rounded-xl p-6 text-center shadow-sm hover:shadow-lg border border-gray-100 dark:border-gray-700 transition">
                        @if ($guru->foto)
                            <img src="{{ Storage::url($guru->foto) }}" alt="{{ $guru->name }}"
                                class="w-20 h-20 rounded-full object-cover mx-auto mb-4 border-2 border-green-100 dark:border-gray-600">
                        @else
                            <div
                                class="w-20 h-20 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-700 dark:text-green-400 font-bold text-2xl mx-auto mb-4">
                                {{ strtoupper(substr($guru->name, 0, 1)) }}
                            </div>
                        @endif
                        <h3
                            class="font-bold text-gray-900 dark:text-white text-sm group-hover:text-green-600 dark:group-hover:text-green-400 transition line-clamp-2">
                            {{ $guru->name }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $guru->jabatan ?: 'Pengajar' }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Kontak -->
    <section class="bg-gradient-to-br from-green-600 to-emerald-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-3">Hubungi Kami</h2>
                    <p class="text-green-50 leading-relaxed">
                        Ingin bertanya tentang pendaftaran, program, atau kunjungan? Hubungi kami atau datang langsung ke
                        pondok pesantren.
                    </p>
                    <div class="flex flex-wrap gap-3 mt-6">
                        <a href="{{ route('kontak.index') }}"
                            class="px-6 py-3 bg-white text-green-700 font-semibold rounded-lg hover:bg-green-50 transition shadow-lg">
                            Halaman Kontak
                        </a>
                        <a href="{{ route('pendaftaran') }}"
                            class="px-6 py-3 bg-white/10 border border-white/40 text-white font-semibold rounded-lg hover:bg-white/20 transition">
                            Daftar Santri Baru
                        </a>
                    </div>
                </div>

                <div class="bg-white/10 border border-white/20 rounded-xl p-6 backdrop-blur-sm">
                    <ul class="space-y-4 text-sm">
                        @if (filled($lembaga['alamat']))
                            <li>
                                <p class="text-xs font-semibold uppercase tracking-wider text-green-100 mb-1">Alamat</p>
                                <p>{{ $lembaga['alamat'] }}</p>
                            </li>
                        @endif
                        @if (filled($lembaga['telepon']) || filled($lembaga['whatsapp']))
                            <li>
                                <p class="text-xs font-semibold uppercase tracking-wider text-green-100 mb-1">Telepon /
                                    WhatsApp</p>
                                <p>{{ $lembaga['telepon'] ?: $lembaga['whatsapp'] }}</p>
                            </li>
                        @endif
                        @if (filled($lembaga['email']))
                            <li>
                                <p class="text-xs font-semibold uppercase tracking-wider text-green-100 mb-1">Email</p>
                                <p class="break-all">{{ $lembaga['email'] }}</p>
                            </li>
                        @endif
                        @if (filled($lembaga['jam']))
                            <li>
                                <p class="text-xs font-semibold uppercase tracking-wider text-green-100 mb-1">Jam Layanan
                                </p>
                                <p>{{ $lembaga['jam'] }}</p>
                            </li>
                        @endif
                        @if (!filled($lembaga['alamat']) && !filled($lembaga['telepon']) && !filled($lembaga['whatsapp']) && !filled($lembaga['email']))
                            <li>
                                <p class="text-xs font-semibold uppercase tracking-wider text-green-100 mb-1">Kontak</p>
                                <p>Informasi kontak dapat diisi melalui menu Pengaturan → Kontak Lembaga.</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            @if ($kontaks->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-10">
                    @foreach ($kontaks as $kontak)
                        <div class="bg-white/10 border border-white/20 rounded-xl p-5">
                            @if (filled($kontak->unit))
                                <span
                                    class="inline-block px-2 py-0.5 text-xs font-semibold bg-white/20 rounded-full mb-2">{{ $kontak->unit }}</span>
                            @endif
                            <p class="font-semibold">{{ $kontak->nama }}</p>
                            @if (filled($kontak->jabatan))
                                <p class="text-xs text-green-100 mt-0.5">{{ $kontak->jabatan }}</p>
                            @endif
                            @if ($kontak->whatsapp_link)
                                <a href="{{ $kontak->whatsapp_link }}" target="_blank" rel="noopener"
                                    class="inline-block text-xs text-white underline mt-2">WhatsApp
                                    {{ $kontak->whatsapp }}</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
