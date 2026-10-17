@php
    $menu = [
        ['label' => 'Berita', 'route' => 'berita.index'],
        ['label' => 'Fasilitas', 'route' => 'fasilitas.index'],
        ['label' => 'Guru', 'route' => 'guru.index'],
        ['label' => 'Kontak', 'route' => 'kontak.index'],
    ];

    $kontakAlamat = \App\Models\Setting::value('kontak_alamat');
    $kontakTelepon = \App\Models\Setting::value('kontak_telepon');
    $kontakWhatsapp = \App\Models\Setting::value('kontak_whatsapp');
    $kontakEmail = \App\Models\Setting::value('kontak_email');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "Pondok Pesantren Syafa'aturrasul")</title>
    <meta name="description"
        content="@yield('description', "Pondok Pesantren Syafa'aturrasul — MTs & MA Putra/Putri, Kuantan Singingi, Riau.")">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>

<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">PPSR</div>
                <span class="text-gray-600 dark:text-gray-300 hidden sm:inline">2026</span>
            </a>

            <!-- Menu desktop -->
            <div class="hidden md:flex gap-7">
                @foreach ($menu as $item)
                    @php $aktif = request()->routeIs(explode('.', $item['route'])[0].'.*'); @endphp
                    <a href="{{ route($item['route']) }}"
                        class="{{ $aktif ? 'text-green-600 dark:text-green-400 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400' }} transition">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('psb') }}"
                    class="hidden sm:inline-block px-4 py-2 text-sm font-semibold rounded-lg transition
                        {{ request()->routeIs('psb') ? 'bg-green-600 text-white' : 'text-green-600 dark:text-green-400 border border-green-600 hover:bg-green-50 dark:hover:bg-gray-700' }}">
                    PSB
                </a>
                <button type="button" id="site-menu-btn"
                    class="md:hidden p-2 text-gray-600 dark:text-gray-300 hover:text-green-600 transition"
                    aria-label="Buka menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Menu mobile -->
        <div id="site-menu" class="hidden md:hidden border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="px-4 py-3 space-y-1">
                @foreach ($menu as $item)
                    @php $aktif = request()->routeIs(explode('.', $item['route'])[0].'.*'); @endphp
                    <a href="{{ route($item['route']) }}"
                        class="block px-3 py-2 rounded-lg {{ $aktif ? 'bg-green-50 dark:bg-gray-700 text-green-700 dark:text-green-400 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                <a href="{{ route('psb') }}"
                    class="block px-3 py-2 rounded-lg bg-green-600 text-white font-semibold text-center mt-2">
                    PSB &amp; Cari Data
                </a>
            </div>
        </div>
    </header>

    <!-- Konten halaman -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div>
                    <h4 class="text-white font-bold mb-4">PPSR 2026</h4>
                    <p class="text-sm">Pondok Pesantren Syafa'aturrasul — Kuantan Singingi, Riau. Mendidik generasi
                        Qur'ani yang berilmu, berakhlak, dan mandiri.</p>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4">Tautan</h4>
                    <ul class="space-y-2 text-sm">
                        @foreach ($menu as $item)
                            <li><a href="{{ route($item['route']) }}"
                                    class="hover:text-green-400 transition">{{ $item['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('pendaftaran') }}" class="hover:text-green-400 transition">Formulir
                                Pendaftaran</a></li>
                        <li><a href="{{ route('psb') }}" class="hover:text-green-400 transition">Cari Data Santri</a>
                        </li>
                        <li><a href="{{ route('foto.index') }}" class="hover:text-green-400 transition">Galeri Foto</a>
                        </li>
                        <li><a href="{{ route('uangmasuk.index') }}" class="hover:text-green-400 transition">Uang
                                Masuk</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm">
                        <li>Email: {{ filled($kontakEmail) ? $kontakEmail : 'syafaaturrasultatausaha@gmail.com' }}</li>
                        <li>Telp:
                            {{ filled($kontakTelepon) ? $kontakTelepon : (filled($kontakWhatsapp) ? $kontakWhatsapp : '+6285259875754') }}
                        </li>
                        <li>{{ filled($kontakAlamat) ? $kontakAlamat : 'KUANTAN SINGINGI, RIAU' }}</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-sm">&copy; {{ date('Y') }} PPSR. All rights reserved.</p>
                    <div class="flex gap-4 text-sm">
                        <a href="{{ route('kontak.index') }}" class="hover:text-green-400 transition">Kontak</a>
                        <a href="https://www.syafaaturrasul.com" target="_blank" rel="noopener"
                            class="hover:text-green-400 transition">Website Pondok</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    <script>
        document.getElementById('site-menu-btn')?.addEventListener('click', function() {
            document.getElementById('site-menu')?.classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>

</html>
