@if ($paginator->hasPages())
    <nav aria-label="Navigasi halaman" class="flex flex-wrap items-center justify-between gap-4 text-sm">
        @if ($paginator->onFirstPage())
            <span class="text-gray-500">Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" wire:navigate rel="prev" class="font-semibold text-green-700 dark:text-green-400 hover:underline">← Sebelumnya</a>
        @endif
        <span class="text-gray-600 dark:text-gray-300">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" wire:navigate rel="next" class="font-semibold text-green-700 dark:text-green-400 hover:underline">Berikutnya →</a>
        @else
            <span class="text-gray-500">Berikutnya</span>
        @endif
    </nav>
@endif
