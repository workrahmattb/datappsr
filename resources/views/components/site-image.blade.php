@props(['path', 'asset' => false, 'priority' => false, 'sizes' => '100vw', 'alt' => ''])
@php
    $image = \App\Support\ResponsiveImage::attributes($path, $asset);
@endphp
<img src="{{ $image['src'] }}" alt="{{ $alt }}"
    @if ($image['srcset']) srcset="{{ $image['srcset'] }}" sizes="{{ $sizes }}" @endif
    @if ($image['width']) width="{{ $image['width'] }}" height="{{ $image['height'] }}" @endif
    loading="{{ $priority ? 'eager' : 'lazy' }}" fetchpriority="{{ $priority ? 'high' : 'auto' }}" decoding="async"
    {{ $attributes }}>
