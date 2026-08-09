<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-Recruitment') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex bg-gray-100 dark:bg-gray-900">
            
            <!-- Admin Protected Sidebar Component -->
            <x-sidebar.sidebar />

            <!-- Main Content Container -->
            <div class="flex-1 flex flex-col min-w-0 transition-all duration-300 {{ auth()->check() && (auth()->user()->role?->name === 'admin' || auth()->user()->role_id == 1) ? 'lg:pl-64' : '' }}">
                
                <!-- Top Navbar / Header -->
                <header class="sticky top-0 z-30 bg-white dark:bg-gray-800 shadow border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <!-- Mobile Hamburger Button (Only visible for admin with sidebar) -->
                        @if(auth()->check() && (auth()->user()->role?->name === 'admin' || auth()->user()->role_id == 1))
                            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 mr-2 rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        @endif

                        <div class="flex-1 min-w-0">
                            @if (isset($header))
                                {{ $header }}
                            @endif
                        </div>

                        <!-- User Navigation / Dropdown -->
                        <div class="flex items-center gap-4">
                            <livewire:layout.navigation />
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
