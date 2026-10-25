<header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" wire:navigate
            @if ($this->apakahAktif('home')) aria-current="page" @endif class="flex items-center gap-2 shrink-0">
            <img src="{{ asset('images/logo-navbar.webp') }}" alt="PPSR 2026" width="600" height="134"
                class="h-10 w-auto object-contain" decoding="async" fetchpriority="high">
        </a>

        <!-- Menu desktop -->
        <div class="hidden md:flex gap-7">
            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}" wire:navigate wire:key="nav-desktop-{{ $item['route'] }}"
                    @if ($this->apakahAktif($item['route'])) aria-current="page" @endif
                    @class([
                        'transition',
                        'text-green-600 dark:text-green-400 font-semibold' => $this->apakahAktif($item['route']),
                        'text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400' => ! $this->apakahAktif($item['route']),
                    ])>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('psb') }}" wire:navigate
                @if ($this->apakahAktif('psb')) aria-current="page" @endif
                @class([
                    'hidden sm:inline-block px-4 py-2 text-sm font-semibold rounded-lg transition',
                    'bg-green-600 text-white' => $this->apakahAktif('psb'),
                    'text-green-600 dark:text-green-400 border border-green-600 hover:bg-green-50 dark:hover:bg-gray-700' => ! $this->apakahAktif('psb'),
                ])>
                PSB
            </a>

            <button type="button" wire:click="toggleMenu"
                class="md:hidden p-2 text-gray-600 dark:text-gray-300 hover:text-green-600 transition"
                aria-label="Menu" aria-expanded="{{ $menuTerbuka ? 'true' : 'false' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </nav>

    <!-- Menu mobile (state Livewire: $menuTerbuka) -->
    @if ($menuTerbuka)
        <div class="md:hidden border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="px-4 py-3 space-y-1">
                @foreach ($menu as $item)
                    <a href="{{ route($item['route']) }}" wire:navigate wire:key="nav-mobile-{{ $item['route'] }}"
                        @if ($this->apakahAktif($item['route'])) aria-current="page" @endif
                        @class([
                            'block px-3 py-2 rounded-lg',
                            'bg-green-50 dark:bg-gray-700 text-green-700 dark:text-green-400 font-semibold' => $this->apakahAktif($item['route']),
                            'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' => ! $this->apakahAktif($item['route']),
                        ])>
                        {{ $item['label'] }}
                    </a>
                @endforeach

                <a href="{{ route('psb') }}" wire:navigate
                    class="block px-3 py-2 rounded-lg bg-green-600 text-white font-semibold text-center mt-2">
                    PSB &amp; Cari Data
                </a>
            </div>
        </div>
    @endif
</header>

