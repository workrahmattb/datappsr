<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white antialiased">
<head>
    @include('partials.head')
    <title>Login - Pondok Pesantren Syafaaturrasul</title>
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #d1fae5;
        }
        .bg-primary-gradient {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        }
        .text-primary {
            color: var(--primary-dark);
        }
        .focus-ring-primary:focus {
            box-shadow: 0 0 0 4px var(--primary-light);
            border-color: var(--primary);
        }
    </style>
</head>
<body class="flex h-full min-h-screen">

    <!-- Left Side - Branding / Graphic -->
    <div class="hidden lg:flex lg:flex-1 bg-primary-gradient relative overflow-hidden items-center justify-center">
        <!-- Abstract decorative shapes -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <svg class="absolute -top-24 -left-24 w-96 h-96 text-white transform rotate-45" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
            <svg class="absolute top-1/2 -right-24 w-[30rem] h-[30rem] text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
            <svg class="absolute -bottom-24 left-1/4 w-72 h-72 text-white transform -rotate-12" fill="currentColor" viewBox="0 0 100 100"><rect width="100" height="100" rx="20"/></svg>
        </div>
        
        <div class="z-10 text-center px-12 max-w-2xl text-white">
            <div class="w-24 h-24 bg-white/20 backdrop-blur-md rounded-3xl mx-auto flex items-center justify-center mb-10 border border-white/30 shadow-2xl">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-6 leading-tight">
                Sistem Informasi Terpadu
            </h1>
            <p class="text-lg md:text-xl text-emerald-50 leading-relaxed font-medium">
                Pondok Pesantren Syafaaturrasul<br>
                <span class="text-emerald-200/80 text-base mt-2 block font-normal">Kuat dalam Agama, Unggul dalam Prestasi</span>
            </p>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="flex flex-1 flex-col justify-center px-6 py-12 lg:px-20 xl:px-32 bg-gray-50/50">
        <div class="mx-auto w-full max-w-sm lg:w-[420px]">
            <!-- Mobile Logo -->
            <div class="lg:hidden flex justify-center mb-8">
                <div class="w-16 h-16 bg-primary-gradient rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
            </div>

            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang</h2>
                <p class="mt-2 text-sm text-gray-500 font-medium">
                    Silakan masuk ke akun Anda untuk melanjutkan.
                </p>
            </div>

            @if(session('status'))
                <div class="mt-4 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm font-medium flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif
            
            @if ($errors->any())
                <div class="mt-4 p-4 rounded-xl bg-red-50 border border-red-100 text-red-800 text-sm font-medium">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-8">
                <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                        <div class="mt-2 relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus-ring-primary transition-all shadow-sm sm:text-sm bg-white" 
                                placeholder="email@contoh.com">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" wire:navigate class="text-sm font-semibold text-primary hover:text-emerald-700 transition-colors">
                                    Lupa sandi?
                                </a>
                            @endif
                        </div>
                        <div class="mt-2 relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <!-- Note: Added class toggle trick for password visibility if needed, but keeping it simple and professional -->
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus-ring-primary transition-all shadow-sm sm:text-sm bg-white" 
                                placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                            class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded transition-colors cursor-pointer">
                        <label for="remember" class="ml-2.5 block text-sm font-medium text-gray-700 cursor-pointer">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                            class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-primary-gradient hover:opacity-95 focus:outline-none focus-ring-primary transform transition-all active:scale-[0.98]">
                            Masuk ke Sistem
                        </button>
                    </div>
                </form>

                @if (Route::has('register'))
                    <div class="mt-8 relative hidden">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                    </div>
                    
                    <div class="mt-8 text-center text-sm">
                        <span class="text-gray-500 font-medium">Belum memiliki akun?</span>
                        <a href="{{ route('register') }}" wire:navigate class="font-bold text-primary hover:text-emerald-700 transition-colors ml-1">
                            Daftar Sekarang
                        </a>
                    </div>
                @endif
            </div>
            
            <div class="mt-12 text-center">
                <p class="text-xs text-gray-400 font-medium">&copy; {{ date('Y') }} Pondok Pesantren Syafaaturrasul. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
