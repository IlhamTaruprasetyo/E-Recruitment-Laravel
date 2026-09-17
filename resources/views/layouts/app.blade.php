<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MIKA CAREER') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/mikaaaa.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tailwind CSS CDN Fallback -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configure Tailwind CDN for class-based dark mode
        tailwind.config = {
            darkMode: 'class'
        };
    </script>

    <!-- Dark Mode Init: Sync dengan frontend (mika-theme) — apply sebelum render -->
    <script>
        (function () {
            var mikaTheme = localStorage.getItem('mika-theme');
            var html = document.documentElement;
            if (mikaTheme === 'light') {
                html.classList.add('light-mode');
                html.classList.remove('dark');
            } else {
                html.classList.remove('light-mode');
                html.classList.add('dark');
            }
        })();

        // Global theme toggle function
        window.toggleMikaTheme = function () {
            var html = document.documentElement;
            var isCurrentlyDark = html.classList.contains('dark');
            var nextIsDark = !isCurrentlyDark;

            if (nextIsDark) {
                html.classList.add('dark');
                html.classList.remove('light-mode');
                localStorage.setItem('mika-theme', 'dark');
            } else {
                html.classList.remove('dark');
                html.classList.add('light-mode');
                localStorage.setItem('mika-theme', 'light');
            }

            if (window.Alpine && window.Alpine.store) {
                try {
                    var store = window.Alpine.store('theme');
                    if (store) {
                        store.isDark = nextIsDark;
                    }
                } catch (e) {}
            }

            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark: nextIsDark } }));
            return nextIsDark;
        };

        // Theme store helper for Alpine.js across all lifecycle events
        function registerThemeStore() {
            if (window.Alpine && window.Alpine.store) {
                try {
                    if (!window.Alpine.store('theme')) {
                        window.Alpine.store('theme', {
                            isDark: document.documentElement.classList.contains('dark'),
                            toggle: function () {
                                return window.toggleMikaTheme();
                            }
                        });
                    } else {
                        window.Alpine.store('theme').isDark = document.documentElement.classList.contains('dark');
                    }
                } catch (e) {}
            }
        }

        document.addEventListener('alpine:init', registerThemeStore);
        document.addEventListener('livewire:init', registerThemeStore);
        document.addEventListener('livewire:navigated', registerThemeStore);
        if (window.Alpine) {
            registerThemeStore();
        }
    </script>

    <!-- Native Date/Time Picker: Native browser calendar icon, white in dark mode, black in light mode -->
    <style>
        input[type="date"],
        input[type="datetime-local"],
        input[type="time"],
        input[type="month"],
        input[type="week"] {
            color-scheme: light;
        }

        html.dark input[type="date"],
        html.dark input[type="datetime-local"],
        html.dark input[type="time"],
        html.dark input[type="month"],
        html.dark input[type="week"],
        .dark input[type="date"],
        .dark input[type="datetime-local"],
        .dark input[type="time"],
        .dark input[type="month"],
        .dark input[type="week"] {
            color-scheme: dark !important;
        }

        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="datetime-local"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator,
        input[type="month"]::-webkit-calendar-picker-indicator,
        input[type="week"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            opacity: 0.85;
            transition: opacity 0.15s ease;
        }

        input[type="date"]::-webkit-calendar-picker-indicator:hover,
        input[type="datetime-local"]::-webkit-calendar-picker-indicator:hover,
        input[type="time"]::-webkit-calendar-picker-indicator:hover,
        input[type="month"]::-webkit-calendar-picker-indicator:hover,
        input[type="week"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
    </style>
</head>

    @php
        $user = auth()->user();
        $roleName = strtolower($user?->role?->name ?? '');
        $isAdminOrRecruiter =
            auth()->check() &&
            (in_array($roleName, ['admin', 'superadmin', 'recruiter']) || in_array($user->role_id, [1, 2]));
        $isEmployee = auth()->check() && ($user->role_id == 4 || $roleName === 'employee');
        $isApplicantProfile = auth()->check() && !$isAdminOrRecruiter && !$isEmployee;
        $hasSidebar = $isAdminOrRecruiter || $isApplicantProfile || $isEmployee;
        $defaultTab = $isEmployee ? 'dashboard' : 'pribadi';
        $currentTab = request('tab', $defaultTab);
    @endphp

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
    x-data="{ sidebarOpen: false, activeTab: '{{ $currentTab }}' }"
    x-on:switch-tab.window="activeTab = $event.detail">
    <div class="min-h-screen flex bg-gray-100 dark:bg-gray-900">

        <!-- Sidebar Component Based on Role -->
        @if ($isAdminOrRecruiter)
            <x-sidebar.sidebar />
        @elseif($isEmployee)
            <livewire:employee.employee-sidebar :active-tab="request('tab', 'dashboard')" />
        @elseif($isApplicantProfile)
            <livewire:applicant.applicant-sidebar :active-tab="request('tab', 'pribadi')" />
        @endif

        <!-- Main Content Container -->
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300 {{ $hasSidebar ? 'lg:pl-64' : '' }}">

            <!-- Top Navbar / Header -->
            <header
                class="sticky top-0 z-30 bg-white dark:bg-gray-800 shadow border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <!-- Mobile Hamburger Button (Visible when sidebar present) -->
                    @if ($hasSidebar)
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden p-2 mr-2 rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
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

    <!-- Alpine.js Global Store: Dark Mode sync check -->
    <script>
        if (typeof registerThemeStore === 'function') {
            registerThemeStore();
        }
    </script>

    <!-- Session Heartbeat (Sliding Refresh saat aktif bekerja) -->
    <x-session-heartbeat />
</body>

</html>
