<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? "Pondok Pesantren Syafa'aturrasul" }}</title>
    <meta name="description"
        content="{{ $description ?? "Pondok Pesantren Syafa'aturrasul — MTs & MA Putra/Putri, Kuantan Singingi, Riau." }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>

<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900">
    {{-- Navbar: komponen Livewire (tautan pakai wire:navigate → SPA) --}}
    <livewire:site.navbar />

    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- Footer: komponen Livewire --}}
    <livewire:site.footer />

    {{-- Tombol WhatsApp mengambang di pojok kanan bawah --}}
    <livewire:site.whatsapp-button />

    @livewireScripts
    @stack('scripts')
</body>

</html>
