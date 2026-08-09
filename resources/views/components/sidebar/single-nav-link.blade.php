@props([
    'active' => false,
    'href' => '#',
    'badge' => null,
])

@php
$classes = $active
    ? 'flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 bg-indigo-600 text-white shadow-md shadow-indigo-500/20 group'
    : 'flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-slate-100 hover:bg-gray-100 dark:hover:bg-gray-700/60 group';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    <div class="flex items-center gap-3 min-w-0">
        @if (isset($icon))
            <div class="{{ $active ? 'text-white' : 'text-gray-400 dark:text-gray-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }} transition-colors duration-200 shrink-0">
                {{ $icon }}
            </div>
        @endif
        <span class="truncate">{{ $slot }}</span>
    </div>

    @if ($badge)
        <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-500/30">
            {{ $badge }}
        </span>
    @endif
</a>
