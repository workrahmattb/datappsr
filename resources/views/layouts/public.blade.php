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
    <meta property="og:type" content="{{ isset($article) ? 'article' : 'website' }}">
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
                'contactPoint' => array_map(fn ($contact) => [
                    '@type' => 'ContactPoint', 'name' => $contact['name'], 'telephone' => $contact['international'],
                    'contactType' => 'Informasi pesantren', 'availableLanguage' => 'Indonesian',
                ], config('pesantren.contacts')),
                'location' => array_values(array_map(fn ($location) => [
                    '@type' => 'Place', 'name' => $location['name'], 'hasMap' => $location['maps'],
                    'address' => ['@type' => 'PostalAddress', 'streetAddress' => $location['street'],
                        'addressLocality' => 'Kuantan Singingi', 'addressRegion' => 'Riau', 'addressCountry' => 'ID'],
                ], config('pesantren.locations'))),
            ];
        @endphp
        <script type="application/ld+json">{!! json_encode($school, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @endif
    @if (isset($article))
        @php
            $articleSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'NewsArticle',
                'headline' => $article->judul,
                'description' => $article->ringkasan_singkat,
                'mainEntityOfPage' => $canonical,
                'datePublished' => $article->published_at?->toAtomString(),
                'dateModified' => $article->updated_at?->toAtomString(),
                'publisher' => ['@type' => 'EducationalOrganization', 'name' => "Pondok Pesantren Syafa'aturrasul", 'url' => rtrim(config('seo.url'), '/').'/'],
            ];
            if (filled($article->penulis)) {
                $articleSchema['author'] = ['@type' => 'Person', 'name' => $article->penulis];
            }
            if (filled($article->gambar)) {
                $articleSchema['image'] = \Illuminate\Support\Facades\Storage::disk('public')->url($article->gambar);
            }
        @endphp
        <script type="application/ld+json">{!! json_encode($articleSchema, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
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
