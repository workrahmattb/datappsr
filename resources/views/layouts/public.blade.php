<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? "Pondok Pesantren Syafa'aturrasul" }}</title>
    <meta name="description"
        content="{{ $description ?? "Pondok Pesantren Syafa'aturrasul — MTs & MA Putra/Putri, Kuantan Singingi, Riau." }}">
    @php
        $canonical = rtrim(config('seo.url'), '/').'/'.ltrim(request()->path(), '/');
        if (request()->routeIs('berita.index', 'guru.index', 'fasilitas.index') && (int) request()->query('page', 1) > 1) {
            $canonical .= '?page='.(int) request()->query('page');
        }
    @endphp
    <link rel="canonical" href="{{ $canonical }}">
    <meta name="robots" content="{{ request()->routeIs('psb', 'foto.*', 'uangmasuk.*') ? 'noindex, follow' : 'index, follow, max-image-preview:large' }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Pondok Pesantren Syafa'aturrasul">
    <meta property="og:title" content="{{ $title ?? "Pondok Pesantren Syafa'aturrasul" }}">
    <meta property="og:description" content="{{ $description ?? "MTs dan MA Putra/Putri di Kuantan Singingi, Riau." }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ rtrim(config('seo.url'), '/') }}/images/profil-pondok-syafaaturrasul.webp">
    @if (request()->routeIs('home'))
        @php
            $school = [
                '@context' => 'https://schema.org',
                '@type' => 'EducationalOrganization',
                '@id' => rtrim(config('seo.url'), '/').'/#pesantren',
                'name' => "Pondok Pesantren Syafa'aturrasul",
                'alternateName' => ['Pondok Pesantren Syafaaturrasul', 'Ponpes Syafaaturrasul'],
                'url' => rtrim(config('seo.url'), '/').'/',
                'description' => 'Pondok pesantren di Kuantan Singingi (Kuansing), Riau, dengan satuan pendidikan MTs Putra, MTs Putri, MA Putra, dan MA Putri.',
                'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Kuantan Singingi', 'addressRegion' => 'Riau', 'addressCountry' => 'ID'],
            ];
        @endphp
        <script type="application/ld+json">{!! json_encode($school, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @endif
    @vite('resources/css/site.css')
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
