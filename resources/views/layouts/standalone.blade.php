<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.head')
    @if (request()->routeIs('pendaftaran'))
        <meta name="description" content="{{ $description }}">
        <link rel="canonical" href="{{ rtrim(config('seo.url'), '/') }}/pendaftaran">
        <meta name="robots" content="index, follow">
    @else
        <meta name="robots" content="noindex, follow">
    @endif
</head>

<body class="min-h-screen bg-white">
    {{ $slot }}
</body>

</html>
