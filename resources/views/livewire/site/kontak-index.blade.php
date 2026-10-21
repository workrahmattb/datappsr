<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            <a href="{{ route('home') }}" wire:navigate class="hover:text-green-600 transition">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700 dark:text-gray-300">Kontak</span>
        </nav>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Hubungi Kami</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Informasi kontak resmi Pondok Pesantren Syafa'aturrasul.</p>
    </div>

    <!-- Informasi Lembaga -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @if (filled($lembaga['alamat']))
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Alamat
                    </p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $lembaga['alamat'] }}</p>
                </div>
            @endif

            @if (filled($lembaga['telepon']) || filled($lembaga['whatsapp']))
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Telepon
                        / WhatsApp</p>
                    @if (filled($lembaga['telepon']))
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $lembaga['telepon'] }}</p>
                    @endif
                    @if (filled($lembaga['whatsapp']))
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $lembaga['whatsapp'])) }}"
                            target="_blank" rel="noopener"
                            class="block text-sm text-green-600 dark:text-green-400 hover:underline mt-1">
                            WhatsApp: {{ $lembaga['whatsapp'] }}
                        </a>
                    @endif
                </div>
            @endif

            @if (filled($lembaga['email']))
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Email
                    </p>
                    <a href="mailto:{{ $lembaga['email'] }}"
                        class="text-sm text-green-600 dark:text-green-400 hover:underline break-all">{{ $lembaga['email'] }}</a>
                </div>
            @endif

            @if (filled($lembaga['jam']))
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Jam
                        Layanan</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $lembaga['jam'] }}</p>
                </div>
            @endif
        </div>

        @if (filled($lembaga['facebook']) || filled($lembaga['instagram']) || filled($lembaga['youtube']))
            <div class="mt-6 flex flex-wrap gap-3">
                @foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'youtube' => 'YouTube'] as $key => $label)
                    @if (filled($lembaga[$key]))
                        <a href="{{ $lembaga[$key] }}" target="_blank" rel="noopener"
                            class="px-4 py-2 text-sm font-semibold bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-green-500 transition">{{ $label }}</a>
                    @endif
                @endforeach
            </div>
        @endif
    </section>

    <!-- Kontak Person -->
    @if ($kontaks->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Kontak Person</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($kontaks as $kontak)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        @if (filled($kontak->unit))
                            <span
                                class="inline-block px-2.5 py-0.5 text-xs font-semibold bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full mb-3">{{ $kontak->unit }}</span>
                        @endif
                        <h3 class="font-bold text-gray-900 dark:text-white">{{ $kontak->nama }}</h3>
                        @if (filled($kontak->jabatan))
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $kontak->jabatan }}</p>
                        @endif

                        <ul class="mt-4 space-y-2 text-sm">
                            @if (filled($kontak->telepon))
                                <li class="text-gray-700 dark:text-gray-300">Telp: {{ $kontak->telepon }}</li>
                            @endif
                            @if ($kontak->whatsapp_link)
                                <li>
                                    <a href="{{ $kontak->whatsapp_link }}" target="_blank" rel="noopener"
                                        class="text-green-600 dark:text-green-400 hover:underline">WhatsApp:
                                        {{ $kontak->whatsapp }}</a>
                                </li>
                            @endif
                            @if (filled($kontak->email))
                                <li>
                                    <a href="mailto:{{ $kontak->email }}"
                                        class="text-green-600 dark:text-green-400 hover:underline break-all">{{ $kontak->email }}</a>
                                </li>
                            @endif
                            @if (filled($kontak->alamat))
                                <li class="text-gray-500 dark:text-gray-400">{{ $kontak->alamat }}</li>
                            @endif
                        </ul>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Peta -->
    @if (filled($lembaga['maps']))
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Lokasi</h2>
            <div class="rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <iframe src="{{ $lembaga['maps'] }}" class="w-full h-96" style="border:0" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" allowfullscreen title="Lokasi PPSR"></iframe>
            </div>
        </section>
    @endif

    <!-- CTA -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-gradient-to-br from-green-600 to-emerald-700 rounded-xl p-8 text-white text-center">
            <h2 class="text-2xl font-bold mb-2">Ingin mendaftar sebagai santri baru?</h2>
            <p class="text-green-50 mb-6">Isi formulir pendaftaran daring, atau cek status data pendaftaran Anda.</p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('pendaftaran') }}" wire:navigate
                    class="px-6 py-3 bg-white text-green-700 font-semibold rounded-lg hover:bg-green-50 transition shadow-lg">Formulir
                    Pendaftaran</a>
                <a href="{{ route('psb') }}" wire:navigate
                    class="px-6 py-3 bg-white/10 border border-white/40 text-white font-semibold rounded-lg hover:bg-white/20 transition">Cari
                    Data Santri</a>
            </div>
        </div>
    </section>
</div>
