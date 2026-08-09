@props([
    'title' => '',
    'active' => false,
    'icon' => null,
])

<div x-data="{ open: {{ $active ? 'true' : 'false' }} }" class="space-y-1">
    <button @click="open = !open" 
            type="button"
            class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $active ? 'text-indigo-600 dark:text-indigo-400 bg-gray-100 dark:bg-gray-700/50' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-slate-100 hover:bg-gray-100 dark:hover:bg-gray-700/60' }} group">
        <div class="flex items-center gap-3 min-w-0">
            @if ($icon)
                <div class="{{ $active ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 dark:text-gray-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }} transition-colors duration-200 shrink-0">
                    {{ $icon }}
                </div>
            @endif
            <span class="truncate">{{ $title }}</span>
        </div>
        
        <svg class="w-4 h-4 transition-transform duration-200 text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300"
             :class="{ 'rotate-90': open }"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         x-cloak 
         class="pl-9 pr-2 py-1 space-y-1 border-l-2 border-gray-200 dark:border-gray-700 ml-4 my-1">
        {{ $slot }}
    </div>
</div>
