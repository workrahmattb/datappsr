@props(['path'])

@if ($path)
    <a href="{{ Storage::disk('public')->url($path) }}" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold text-zinc-900 underline">
        Lihat bukti
    </a>
@else
    <span class="text-sm text-zinc-500">Belum ada bukti</span>
@endif
