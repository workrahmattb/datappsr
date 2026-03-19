<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #d1fae5;
            --secondary: #f0fdf4;
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-72 bg-gradient-to-b from-emerald-700 to-emerald-600 text-white flex-shrink-0 hidden md:block shadow-xl">
            <div class="p-6 border-b border-emerald-500">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">PPSR Admin</h1>
                        <p class="text-xs text-emerald-200">Panel Administrasi</p>
                    </div>
                </div>
            </div>
            
            <nav class="mt-4 px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }} transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-emerald-200 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-emerald-200 uppercase tracking-wider">Data Siswa</p>
                </div>

                <a href="{{ route('admin.mtsputras.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.mtsputras.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }} transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.mtsputras.*') ? 'text-white' : 'text-emerald-200 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="font-medium">MTs Putra</span>
                </a>

                <a href="{{ route('admin.mtsputris.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.mtsputris.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }} transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.mtsputris.*') ? 'text-white' : 'text-emerald-200 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="font-medium">MTs Putri</span>
                </a>

                <a href="{{ route('admin.maputras.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.maputras.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }} transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.maputras.*') ? 'text-white' : 'text-emerald-200 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="font-medium">MA Putra</span>
                </a>

                <a href="{{ route('admin.maputris.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.maputris.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }} transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.maputris.*') ? 'text-white' : 'text-emerald-200 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="font-medium">MA Putri</span>
                </a>

                <div class="pt-4 pb-2 border-t border-emerald-500">
                    <p class="px-4 text-xs font-semibold text-emerald-200 uppercase tracking-wider">Pendaftaran</p>
                </div>

                <a href="{{ route('admin.pendaftarans.index') }}" 
                   class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.pendaftarans.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }} transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.pendaftarans.*') ? 'text-white' : 'text-emerald-200 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="font-medium">Data Pendaftaran</span>
                </a>
            </nav>

            <div class="absolute bottom-0 w-72 p-4 border-t border-emerald-500 bg-emerald-800/30">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-sm font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-emerald-200 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition-all duration-200 text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <button id="mobile-menu-btn" class="md:hidden mr-4 text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                            <p class="text-sm text-gray-500 mt-0.5">{{ now()->translatedFormat('l, d F Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-emerald-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </a>
                        <div class="h-6 w-px bg-gray-300"></div>
                        <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-emerald-700 text-white">
                <nav class="p-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 hover:bg-white/10 rounded-lg">Dashboard</a>
                    <a href="{{ route('admin.mtsputras.index') }}" class="block py-2 px-4 hover:bg-white/10 rounded-lg">MTs Putra</a>
                    <a href="{{ route('admin.mtsputris.index') }}" class="block py-2 px-4 hover:bg-white/10 rounded-lg">MTs Putri</a>
                    <a href="{{ route('admin.maputras.index') }}" class="block py-2 px-4 hover:bg-white/10 rounded-lg">MA Putra</a>
                    <a href="{{ route('admin.maputris.index') }}" class="block py-2 px-4 hover:bg-white/10 rounded-lg">MA Putri</a>
                    <a href="{{ route('admin.pendaftarans.index') }}" class="block py-2 px-4 hover:bg-white/10 rounded-lg">Pendaftaran</a>
                    <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-emerald-500">
                        @csrf
                        <button type="submit" class="block w-full text-left py-2 px-4 hover:bg-white/10 rounded-lg">Logout</button>
                    </form>
                </nav>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-6 py-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast-notification"
        style="position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999; display: none;"
        class="flex items-center gap-3 bg-white border border-emerald-200 text-emerald-800 px-5 py-3 rounded-lg shadow-md">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span id="toast-message" class="text-sm font-medium"></span>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('success', (message) => {
                const toast = document.getElementById('toast-notification');
                const msg = document.getElementById('toast-message');
                msg.textContent = Array.isArray(message) ? message[0] : message;
                toast.style.display = 'flex';
                clearTimeout(toast._timeout);
                toast._timeout = setTimeout(() => { toast.style.display = 'none'; }, 3000);
            });
        });

        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
