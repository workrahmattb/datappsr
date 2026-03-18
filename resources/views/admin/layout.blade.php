<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="min-h-screen bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-800 text-white flex-shrink-0 hidden md:block">
            <div class="p-4">
                <h1 class="text-xl font-bold">{{ config('app.name', 'Laravel') }}</h1>
                <p class="text-sm text-slate-400 mt-1">Admin Panel</p>
            </div>
            
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-700' : '' }} hover:bg-slate-700 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <div class="border-t border-slate-700 my-2"></div>
                <p class="px-4 py-2 text-xs text-slate-400 uppercase tracking-wider">Siswa</p>

                <a href="{{ route('admin.mtsputras.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.mtsputras.*') ? 'bg-slate-700' : '' }} hover:bg-slate-700 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    MTs Putra
                </a>

                <a href="{{ route('admin.mtsputris.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.mtsputris.*') ? 'bg-slate-700' : '' }} hover:bg-slate-700 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    MTs Putri
                </a>

                <a href="{{ route('admin.maputras.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.maputras.*') ? 'bg-slate-700' : '' }} hover:bg-slate-700 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    MA Putra
                </a>

                <a href="{{ route('admin.maputris.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.maputris.*') ? 'bg-slate-700' : '' }} hover:bg-slate-700 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    MA Putri
                </a>

                <div class="border-t border-slate-700 my-2"></div>
                <p class="px-4 py-2 text-xs text-slate-400 uppercase tracking-wider">Pendaftaran</p>

                <a href="{{ route('admin.pendaftarans.index') }}" 
                   class="flex items-center px-4 py-3 {{ request()->routeIs('admin.pendaftarans.*') ? 'bg-slate-700' : '' }} hover:bg-slate-700 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Data Pendaftaran
                </a>
            </nav>

            <div class="absolute bottom-0 w-64 p-4 border-t border-slate-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center text-slate-300 hover:text-white transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <header class="bg-white shadow-sm">
                <div class="px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center">
                        <button id="mobile-menu-btn" class="md:hidden mr-3 text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-slate-800 text-white">
                <nav class="p-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 hover:bg-slate-700 rounded">Dashboard</a>
                    <a href="{{ route('admin.mtsputras.index') }}" class="block py-2 hover:bg-slate-700 rounded">MTs Putra</a>
                    <a href="{{ route('admin.mtsputris.index') }}" class="block py-2 hover:bg-slate-700 rounded">MTs Putri</a>
                    <a href="{{ route('admin.maputras.index') }}" class="block py-2 hover:bg-slate-700 rounded">MA Putra</a>
                    <a href="{{ route('admin.maputris.index') }}" class="block py-2 hover:bg-slate-700 rounded">MA Putri</a>
                    <a href="{{ route('admin.pendaftarans.index') }}" class="block py-2 hover:bg-slate-700 rounded">Pendaftaran</a>
                    <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-slate-700">
                        @csrf
                        <button type="submit" class="block w-full text-left py-2 hover:bg-slate-700 rounded">Logout</button>
                    </form>
                </nav>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
