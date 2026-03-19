@props(['label', 'value'])
<div>
    <p class="text-xs font-bold text-zinc-500 uppercase tracking-wider mb-1">{{ $label }}</p>
    <p class="text-sm font-semibold text-zinc-900">{{ (is_string($value) && trim($value) !== '') ? $value : (($value) ? $value : '-') }}</p>
</div>
