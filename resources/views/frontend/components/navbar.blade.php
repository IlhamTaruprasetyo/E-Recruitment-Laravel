<!-- Floating Blur Rounded Sticky Header on Scroll -->
<header x-data="{ mobileMenuOpen: false, scrolled: window.scrollY > 20 }"
    @scroll.window="scrolled = (window.pageYOffset || document.documentElement.scrollTop) > 20" x-init="scrolled = (window.pageYOffset || document.documentElement.scrollTop) > 20"
    class="sticky top-0 z-50 transition-all duration-500 ease-in-out py-3 sm:py-4 px-3 sm:px-6">

    <div :class="scrolled
        ?
        'max-w-5xl mx-auto rounded-full bg-[#050c05]/85 backdrop-blur-xl border border-[#93F514]/40 shadow-2xl shadow-[#93F514]/15 py-2.5 px-6 sm:px-8' :
        'max-w-7xl mx-auto bg-transparent border-b border-[#EEEEEE]/10 py-3 px-4 sm:px-6'"
        class="transition-all duration-500 ease-in-out flex items-center justify-between">

        <!-- Brand Logo -->
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('storage/logo/mikaaaa.png') }}" alt="Logo MIKA"
                    class="h-10 w-auto object-contain rounded-lg group-hover:scale-105 transition-transform duration-300">
                <div>
                    <span class="text-lg sm:text-xl font-black tracking-tight text-[#EEEEEE] flex items-center gap-1">
                        MIKA <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-[#93F514] via-[#46ee40] to-[#5FE6B6]">CAREER</span>
                    </span>
                    {{-- <span class="block text-[9px] tracking-widest uppercase font-bold text-[#93F514]/90 -mt-1">
                        E-Recruitment Portal
                    </span> --}}
                </div>
            </a>
        </div>

        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex items-center gap-8 text-sm font-semibold">
            <a href="{{ route('home') }}"
                class="{{ request()->routeIs('home') ? 'text-[#93F514] font-bold drop-shadow-[0_0_12px_rgba(147, 245, 20,0.5)]' : 'text-gray-300 hover:text-[#93F514]' }} transition-all duration-200 py-1">
                Beranda
            </a>
            <a href="{{ route('jobs.index') }}"
                class="{{ request()->routeIs('jobs.*') ? 'text-[#93F514] font-bold drop-shadow-[0_0_12px_rgba(147, 245, 20,0.5)]' : 'text-gray-300 hover:text-[#93F514]' }} transition-all duration-200 py-1">
                Lowongan
            </a>

        </nav>

        <!-- Authentication Actions & Theme Toggle -->
        <div class="hidden md:flex items-center gap-3">

            <!-- Theme Toggle Button -->
            <button type="button" class="theme-toggle-btn" @click="$store.theme.toggle()"
                :title="$store.theme.isDark ? 'Aktifkan Light Mode' : 'Aktifkan Dark Mode'" x-data>
                <!-- Moon icon (shown in dark mode) -->
                <svg x-show="$store.theme.isDark" x-cloak x-data class="w-4.5 h-4.5" style="width:18px;height:18px"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <!-- Sun icon (shown in light mode) -->
                <svg x-show="!$store.theme.isDark" x-cloak x-data class="w-4.5 h-4.5"
                    style="width:18px;height:18px;color:#5a9e08" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m8.66-9H21M3 12H2m15.07-6.07-.71.71M7.64 16.36l-.71.71M18.36 16.36l-.71.71M6.34 7.64l-.71-.71M12 7a5 5 0 100 10A5 5 0 0012 7z" />
                </svg>
            </button>

            @auth
                @php
                    $isAdminUser =
                        auth()->user()->role_id == 1 ||
                        in_array(strtolower(auth()->user()->role?->name ?? ''), ['admin', 'superadmin']);
                    $isRecruiterUser =
                        auth()->user()->role_id == 2 || strtolower(auth()->user()->role?->name ?? '') === 'recruiter';
                    $targetDashboard = $isAdminUser
                        ? route('admin.dashboard')
                        : ($isRecruiterUser
                            ? route('recruiter.dashboard')
                            : route('profile'));
                    $userName = trim(auth()->user()->name ?? 'User');
                    $shortName = \Illuminate\Support\Str::words($userName, 2, '');
                @endphp
                <a href="{{ $targetDashboard }}" title="{{ $userName }}"
                    class="inline-flex items-center px-4 py-2 rounded-full bg-[#93F514]/10 hover:bg-[#93F514] text-[#93F514] hover:text-black border border-[#93F514]/40 text-xs sm:text-sm font-bold tracking-wide transition-all duration-200 shadow-sm hover:shadow-[#93F514]/30 max-w-[200px] truncate">
                    <span class="truncate">{{ $shortName }}</span>
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="text-xs sm:text-sm font-semibold text-gray-300 hover:text-[#EEEEEE] px-4 py-2 rounded-full hover:bg-[#EEEEEE]/5 transition">
                    Masuk
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-5 py-2 text-xs sm:text-sm font-bold text-[#EEEEEE] hover:text-black rounded-full bg-[#061806] hover:bg-[#93F514] border border-[#93F514]/50 shadow-md shadow-[#93F514]/15 hover:shadow-[#93F514]/30 transition-all duration-200">
                        Daftar
                    </a>
                @endif
            @endauth
        </div>

        <!-- Mobile Hamburger Button -->
        <div class="flex items-center md:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                class="p-2 rounded-full text-gray-400 hover:text-[#EEEEEE] hover:bg-[#93F514]/20 border border-[#93F514]/40 focus:outline-none">
                <svg class="w-5 h-5" x-show="!mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg class="w-5 h-5" x-show="mobileMenuOpen" x-cloak fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-4 scale-95" x-cloak
        class="md:hidden mt-2 max-w-sm mx-auto bg-[#050c05]/95 backdrop-blur-2xl border border-[#93F514]/40 rounded-3xl p-5 shadow-2xl space-y-3">
        <div class="flex flex-col space-y-2 font-semibold">
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}"
                class="px-4 py-2.5 rounded-2xl {{ request()->routeIs('home') ? 'bg-[#93F514]/20 text-[#93F514] font-bold border border-[#93F514]/40' : 'text-gray-300 hover:bg-[#EEEEEE]/5 hover:text-[#93F514]' }}">
                Beranda
            </a>
            <a @click="mobileMenuOpen = false" href="{{ route('jobs.index') }}"
                class="px-4 py-2.5 rounded-2xl {{ request()->routeIs('jobs.*') ? 'bg-[#93F514]/20 text-[#93F514] font-bold border border-[#93F514]/40' : 'text-gray-300 hover:bg-[#EEEEEE]/5 hover:text-[#93F514]' }}">
                Lowongan
            </a>
        </div>
        <div class="pt-3 border-t border-[#93F514]/20 flex flex-col gap-2">

            <!-- Theme Toggle (Mobile) -->
            <button type="button" @click="$store.theme.toggle()" x-data
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl border border-[#93F514]/30 text-sm font-semibold transition"
                :class="$store.theme.isDark ? 'text-gray-300 bg-transparent' : 'text-[#5a9e08] bg-[#f0fde4]'">
                <!-- Moon -->
                <svg x-show="$store.theme.isDark" x-cloak x-data style="width:16px;height:16px" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <!-- Sun -->
                <svg x-show="!$store.theme.isDark" x-cloak x-data style="width:16px;height:16px" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m8.66-9H21M3 12H2m15.07-6.07-.71.71M7.64 16.36l-.71.71M18.36 16.36l-.71.71M6.34 7.64l-.71-.71M12 7a5 5 0 100 10A5 5 0 0012 7z" />
                </svg>
                <span x-text="$store.theme.isDark ? 'Aktifkan Light Mode' : 'Aktifkan Dark Mode'"></span>
            </button>

            @auth
                <a href="{{ $targetDashboard }}" title="{{ $userName }}"
                    class="w-full text-center px-4 py-2.5 rounded-2xl bg-[#93F514] text-black font-extrabold text-sm shadow-md truncate">
                    {{ $shortName }}
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="w-full text-center px-4 py-2.5 rounded-2xl bg-[#93F514]/10 border border-[#93F514]/40 text-[#EEEEEE] font-semibold text-sm">
                    Masuk
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="w-full text-center px-4 py-2.5 rounded-2xl bg-[#061806] hover:bg-[#93F514] text-[#EEEEEE] hover:text-black border border-[#93F514]/50 font-bold text-sm shadow-md shadow-[#93F514]/20 transition">
                        Daftar Akun Baru
                    </a>
                @endif
            @endauth
        </div>
    </div>
</header>
