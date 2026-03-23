<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - PPSR 2026</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                    PPSR
                </div>
                <span class="text-gray-600 dark:text-gray-300">2026</span>
            </div>

            <div class="hidden md:flex gap-8">
                <!-- <a href="#about"
                    class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition">About</a>
                <a href="#features"
                    class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition">Features</a>
                <a href="#contact"
                    class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition">Contact</a> -->
            </div>

            <div class="flex gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-green-600 dark:text-green-400 border border-green-600 rounded-lg hover:bg-green-50 dark:hover:bg-gray-700 transition">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Register
                        </a>
                    @endif
                @endauth
            </div> 
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        <!-- Hero Section -->
        <!-- <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                        Welcome to <span
                            class="text-green-600 dark:text-green-400 font-bold text-5xl md:text-6xl">PONDOK PESANTREN
                            SYAFA'ATURRASUL</span>
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                        Pendataan Santri & Santriwati Pondok Pesantren Syafa'aturrasul
                    </p>
                    <livewire:registration-buttons />
                </div>

                {{-- ini untuk tarok gambar atau semacamnya --}}
                {{-- <div class="relative">
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-8 text-white shadow-2xl">
                        <div
                            class="aspect-video bg-white/10 rounded-lg backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-24 h-24 text-white/50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section> -->


        <!-- Pendaftaran Data Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-12">Data Daftar Baru TA 2026/2027</h2>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <livewire:pendaftaran-table />
            </div>
        </section>

        <!-- Student Data Section -->
        {{-- <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-12">Data Siswa</h2>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <livewire:student-table />
            </div>
        </section> --}}

        <!-- Features Section -->
        <!-- <section id="features" class="bg-white dark:bg-gray-800 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white text-center mb-12">Features</h2>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="p-8 bg-gray-50 dark:bg-gray-700 rounded-xl hover:shadow-lg transition">
                        <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Analytics</h3>
                        <p class="text-gray-600 dark:text-gray-300">Dapatkan insight mendalam tentang performa siswa
                            dengan visualisasi data yang komprehensif.</p>
                    </div>

                    <div class="p-8 bg-gray-50 dark:bg-gray-700 rounded-xl hover:shadow-lg transition">
                        <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Management</h3>
                        <p class="text-gray-600 dark:text-gray-300">Kelola data siswa, informasi akademik
                            dengan mudah dalam satu platform.</p>
                    </div>

                    <div class="p-8 bg-gray-50 dark:bg-gray-700 rounded-xl hover:shadow-lg transition">
                        <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Security</h3>
                        <p class="text-gray-600 dark:text-gray-300">Keamanan data terjamin dengan sistem autentikasi dan
                            otorisasi yang ketat.</p>
                    </div>
                </div>
            </div>
        </section> -->

        <!-- About Section -->
        <section id="about" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-8">About PPSR</h2>
            <div class="bg-green-50 dark:bg-gray-800 p-8 rounded-xl border-l-4 border-green-600">
                <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
                    PPSR 2025 adalah sistem informasi terpadu untuk manajemen pendataan santri yang
                    dirancang khusus untuk memenuhi kebutuhan Pondok Pesantren Modern. Dengan antarmuka yang intuitif dan
                    fitur-fitur canggih, sistem ini membantu Pondok Pesantren dalam mengelola data lebih efisien.
                </p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-gray-300 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div>
                    <h4 class="text-white font-bold mb-4">PPSR 2025</h4>
                    <p class="text-sm">Sistem Pendaftaran yang modern dan terintegrasi Pondok Pesantren Syafaaturrasul Kuantan Singingi.</p>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-green-400 transition">Home</a></li>
                        <li><a href="#features" class="hover:text-green-400 transition">Features</a></li>
                        <li><a href="#about" class="hover:text-green-400 transition">About</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="mailto:support@ppsr.local" class="hover:text-green-400 transition">Email
                                Support</a></li>
                        <li><a href="#" class="hover:text-green-400 transition">Documentation</a></li>
                        <li><a href="#" class="hover:text-green-400 transition">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm">
                        <li>Email: syafaaturrasultatausaha@gmail.com</li>
                        <li>Phone: +6285259875754</li>
                        <li>KUANTAN SINGINGI, RIAU</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm">&copy; 2025 PPSR. All rights reserved.</p>
                    <div class="flex gap-4 mt-4 md:mt-0">
                        <a href="#" class="hover:text-green-400 transition">Privacy Policy</a>
                        <a href="#" class="hover:text-green-400 transition">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
