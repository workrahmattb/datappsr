<div>
    {{-- Judul utama halaman (judul slide & hero memakai <h2>) --}}
    <h1 class="sr-only">Pondok Pesantren Syafa'aturrasul — Kuantan Singingi</h1>

    @if ($adaSlide)
        {{-- Carousel Livewire (auto-rotate via wire:poll di dalam komponennya) --}}
        <livewire:site.carousel />
    @else
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 md:pt-8">
            <section
                class="relative overflow-hidden rounded-2xl md:rounded-3xl bg-gradient-to-br from-green-600 to-emerald-700 text-white shadow-xl ring-1 ring-black/5">
                <div class="px-6 py-12 sm:px-10 sm:py-16 lg:px-14 lg:py-20">
                    <div class="max-w-3xl">
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-white/20 rounded-full mb-5">
                            Tahun Ajaran {{ activeTahunAjaran() }}
                        </span>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-5 leading-tight">
                            Pondok Pesantren Syafa'aturrasul</h2>
                        <p class="text-base sm:text-lg md:text-xl text-green-50 mb-8 leading-relaxed">
                            Pendidikan Islam terpadu untuk putra dan putri — MTs dan MA — di Kuantan Singingi, Riau.
                            Mendidik generasi Qur'ani yang berilmu, berakhlak, dan mandiri.
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('pendaftaran') }}" wire:navigate
                                class="px-6 py-3 bg-white text-green-700 font-semibold rounded-lg hover:bg-green-50 transition shadow-lg">
                                Daftar Santri Baru
                            </a>
                            <a href="{{ route('psb') }}" wire:navigate
                                class="px-6 py-3 bg-white/10 border border-white/40 text-white font-semibold rounded-lg hover:bg-white/20 transition">
                                Cari Data Santri
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endif

    <section aria-labelledby="visi-misi-heading" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="flex flex-col gap-3 mb-8">
            <p class="text-sm font-semibold uppercase tracking-wider text-green-700 dark:text-green-400">Tentang Pesantren</p>
            <h2 id="visi-misi-heading" class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Visi &amp; Misi Pesantren</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8">
            <div class="lg:col-span-2 flex flex-col gap-6 rounded-2xl bg-linear-to-br from-green-700 to-emerald-900 p-6 sm:p-8 text-white">
                <h3 class="text-xl font-bold text-green-100">Visi Pesantren</h3>
                <p class="text-2xl sm:text-3xl font-semibold leading-relaxed">
                    Menjadi Lembaga Islam Yang Kokoh dalam Melahirkan Generasi Penghafal Al Qur’an Berakhlak Mulia Dan Berwawasan Dunia.
                </p>
            </div>

            <div class="lg:col-span-3 flex flex-col gap-6 rounded-2xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 sm:p-8 shadow-sm">
                <div class="flex flex-col gap-2">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Misi Pesantren</h3>
                    <p class="text-gray-600 dark:text-gray-300">Melahirkan Santri &amp; Santriwati:</p>
                </div>
                <ol class="flex flex-col gap-4 list-decimal pl-6 text-base sm:text-lg leading-relaxed text-gray-700 dark:text-gray-200 marker:font-bold marker:text-green-700 dark:marker:text-green-400">
                    <li class="pl-2">Hafal Al-Quran dan 100 Hadits</li>
                    <li class="pl-2">Berkarakter 10 Muwasofat</li>
                    <li class="pl-2">Aktif Berkomunikasi dengan Bahasa asing</li>
                    <li class="pl-2">Berjiwa Pemimpin dan Wirausaha</li>
                    <li class="pl-2">Berprestasi dalam Segala Bidang</li>
                    <li class="pl-2">Lulus PTN dan Swasta Favorit &amp; Lulus Perguruan Tinggi Luar Negeri</li>
                </ol>
            </div>
        </div>
    </section>

    <section aria-labelledby="profil-pesantren-heading" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">
        <div class="py-2 sm:py-4">
            <p class="text-sm font-semibold uppercase tracking-wider text-green-700 dark:text-green-400">Pondok Pesantren Syafa'aturrasul · Kuantan Singingi (Kuansing), Riau</p>
            <h2 id="profil-pesantren-heading" class="mt-3 mb-6 max-w-3xl text-3xl sm:text-4xl font-bold leading-tight text-gray-900 dark:text-white">Membangun Generasi Qur'ani, Berakhlak Mulia, Berilmu, dan Berprestasi</h2>
            <div class="flex flex-col gap-3 text-base sm:text-lg leading-relaxed text-gray-600 dark:text-gray-300">
                <div class="grid grid-cols-[104px_minmax(0,1fr)] sm:grid-cols-[160px_minmax(0,1fr)] items-center gap-3 sm:gap-5">
                    <figure class="min-w-0">
                        <x-site-image path="images/profil-santriwati.webp" :asset="true" sizes="(min-width: 640px) 160px, 104px"
                            alt="Santriwati Pondok Pesantren Syafa'aturrasul membawa buku" class="block w-full h-auto" />
                    </figure>
                    <p class="min-w-0">Memadukan pendidikan agama, ilmu pengetahuan, pembinaan karakter, dan pengembangan potensi santri.</p>
                </div>
                <div class="grid grid-cols-[104px_minmax(0,1fr)] sm:grid-cols-[160px_minmax(0,1fr)] items-center gap-3 sm:gap-5">
                    <figure class="min-w-0">
                        <x-site-image path="images/profil-santri-quran.webp" :asset="true" sizes="(min-width: 640px) 160px, 104px"
                            alt="Santri Pondok Pesantren Syafa'aturrasul memegang Al-Qur'an" class="block w-full h-auto" />
                    </figure>
                    <p class="min-w-0"><strong class="font-semibold text-gray-900 dark:text-white">MTs Putra, MTs Putri, MA Putra, dan MA Putri</strong> ber <strong class="font-semibold text-green-700 dark:text-green-400">Akreditasi A</strong>.</p>
                </div>
                <div class="grid grid-cols-[104px_minmax(0,1fr)] sm:grid-cols-[160px_minmax(0,1fr)] items-center gap-3 sm:gap-5">
                    <figure class="min-w-0">
                        <x-site-image path="images/profil-santri-pramuka.webp" :asset="true" sizes="(min-width: 640px) 160px, 104px"
                            alt="Santri Pondok Pesantren Syafa'aturrasul berseragam pramuka membawa buku" class="block w-full h-auto" />
                    </figure>
                    <p class="min-w-0">Berkomitmen mencetak generasi muslim yang beriman, berilmu, berakhlak mulia, mandiri, dan siap menghadapi tantangan zaman.</p>
                </div>
            </div>
            <p class="mt-6 border-l-4 border-green-600 pl-4 text-lg font-semibold leading-relaxed text-green-800 dark:text-green-300">Pondok Pesantren Syafa'aturrasul — Menanamkan Nilai Islam, Membangun Generasi Masa Depan.</p>
        </div>
    </section>

    <figure aria-label="Profil Pondok Pesantren Syafa'aturrasul" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">
        <x-site-image path="images/profil-pondok-syafaaturrasul.webp" :asset="true" sizes="(min-width: 1280px) 1216px, calc(100vw - 48px)"
            alt="Pondok Pesantren Syafa'aturrasul, Kuantan Singingi, Riau — logo pondok, bangunan, serta foto bersama santri dan santriwati"
            class="block w-full h-auto rounded-2xl shadow-sm" />
    </figure>

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
                    <a href="{{ route('fasilitas.index') }}" wire:navigate
                        class="text-sm font-semibold text-green-600 dark:text-green-400 hover:underline">Lihat semua
                        fasilitas →</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($fasilitasList as $fasilitas)
                        <a href="{{ route('fasilitas.index') }}#fasilitas-{{ $fasilitas->id }}" wire:navigate
                            wire:key="fasilitas-{{ $fasilitas->id }}"
                            class="group bg-gray-50 dark:bg-gray-700/40 rounded-xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 dark:border-gray-700 transition">
                            @if ($fasilitas->gambar)
                                <x-site-image :path="$fasilitas->gambar" :alt="$fasilitas->nama" sizes="(min-width: 768px) 400px, calc(100vw - 48px)"
                                    class="w-full h-44 object-cover" />
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
                <a href="{{ route('guru.index') }}" wire:navigate
                    class="text-sm font-semibold text-green-600 dark:text-green-400 hover:underline">Lihat semua guru
                    →</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($gurus as $guru)
                    <a href="{{ route('guru.index') }}#guru-{{ $guru->id }}" wire:navigate
                        wire:key="guru-{{ $guru->id }}"
                        class="group bg-white dark:bg-gray-800 rounded-xl p-6 text-center shadow-sm hover:shadow-lg border border-gray-100 dark:border-gray-700 transition">
                        @if ($guru->foto)
                            <x-site-image :path="$guru->foto" :alt="$guru->name" sizes="80px"
                                class="w-20 h-20 rounded-full object-cover mx-auto mb-4 border-2 border-green-100 dark:border-gray-600" />
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

    <!-- Berita -->
    @if ($beritas->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Berita &amp; Pengumuman</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Kabar terbaru dari pondok pesantren.</p>
                </div>
                <a href="{{ route('berita.index') }}" wire:navigate
                    class="text-sm font-semibold text-green-600 dark:text-green-400 hover:underline">Lihat semua berita
                    →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($beritas as $berita)
                    <a href="{{ route('berita.show', $berita->slug) }}" wire:navigate wire:key="berita-{{ $berita->id }}"
                        class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 dark:border-gray-700 transition">
                        @if ($berita->gambar)
                            <x-site-image :path="$berita->gambar" :alt="$berita->judul" sizes="(min-width: 768px) 400px, calc(100vw - 48px)"
                                class="w-full h-44 object-cover" />
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

    <section aria-labelledby="lokasi-pondok-heading" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="flex flex-col gap-3 mb-8">
            <h2 id="lokasi-pondok-heading" class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Lokasi Pondok Pesantren Syafa'aturasul</h2>
            <p class="text-gray-600 dark:text-gray-400">Temukan lokasi Pondok Putri dan Pondok Putra untuk merencanakan kunjungan Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <article class="overflow-hidden rounded-2xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
                <div class="flex flex-col gap-2 p-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Pondok Putri</h3>
                    <p class="text-gray-600 dark:text-gray-400">Pondok Pesantren Syafa'aturrasul</p>
                </div>
                <iframe src="https://www.google.com/maps?q=-0.5124461,101.577084&amp;z=16&amp;output=embed"
                    title="Peta lokasi Pondok Putri Syafa'aturrasul" class="w-full h-72 sm:h-80 border-0"
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                <div class="p-6">
                    <a href="https://maps.app.goo.gl/1aHyy2XN8Qn6W7h76" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center justify-center rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white hover:bg-green-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition">
                        Buka Google Maps Pondok Putri <span aria-hidden="true" class="pl-2">↗</span>
                    </a>
                </div>
            </article>

            <article class="overflow-hidden rounded-2xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
                <div class="flex flex-col gap-2 p-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Pondok Putra</h3>
                    <p class="text-gray-600 dark:text-gray-400">Ponpes Syafa'aturrasul 2 Putra</p>
                </div>
                <iframe src="https://www.google.com/maps?q=-0.415269,101.6124704&amp;z=16&amp;output=embed"
                    title="Peta lokasi Pondok Putra Syafa'aturrasul" class="w-full h-72 sm:h-80 border-0"
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                <div class="p-6">
                    <a href="https://maps.app.goo.gl/dmS8nThqcXPSDhe4A" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center justify-center rounded-lg bg-green-700 px-5 py-3 text-sm font-semibold text-white hover:bg-green-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 transition">
                        Buka Google Maps Pondok Putra <span aria-hidden="true" class="pl-2">↗</span>
                    </a>
                </div>
            </article>
        </div>
    </section>

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
                        <a href="{{ route('kontak.index') }}" wire:navigate
                            class="px-6 py-3 bg-white text-green-700 font-semibold rounded-lg hover:bg-green-50 transition shadow-lg">
                            Halaman Kontak
                        </a>
                        <a href="{{ route('pendaftaran') }}" wire:navigate
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
                        <div class="bg-white/10 border border-white/20 rounded-xl p-5"
                            wire:key="kontak-{{ $kontak->id }}">
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
</div>
