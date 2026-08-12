@props([
    'activeTab' => 'pribadi',
])

<!-- Off-canvas / Mobile backdrop -->
<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
    class="fixed inset-0 z-40 bg-gray-900/50 dark:bg-gray-950/80 backdrop-blur-sm lg:hidden" x-cloak></div>

<!-- Main Sidebar Container -->
<aside x-cloak :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed top-0 left-0 z-50 h-screen w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 transition-transform duration-300 ease-in-out flex flex-col justify-between shadow-xl">

    <!-- Top Section: Brand Header & Navigation -->
    <div class="flex-1 overflow-y-auto px-4 py-5 custom-scrollbar">

        <!-- Brand Logo Header -->
        <div class="flex items-center justify-between pb-6 mb-4 border-b border-gray-200 dark:border-gray-700/80 px-2">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-purple-500 flex items-center justify-center text-white shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0H9m4 0h2M9 11V7m0 0h6m-6 0v4" />
                    </svg>
                </div>
                <div>
                    <span
                        class="block font-bold text-lg tracking-tight text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">E-Rekrutmen</span>
                    <span
                        class="block text-[10px] font-semibold tracking-widest text-indigo-600 dark:text-indigo-400 uppercase">
                        Panel Pelamar
                    </span>
                </div>
            </a>

            <!-- Mobile Close Button -->
            <button @click="sidebarOpen = false"
                class="lg:hidden p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        @php
            $applicantProfile = auth()->user()?->applicantProfile;
            $completionPercentage = $applicantProfile ? $applicantProfile->completion_percentage : 0;
            $sectionStatuses = $applicantProfile ? $applicantProfile->section_statuses : [];
        @endphp

        <!-- Navigation Sections -->
        <nav class="space-y-6">

            <!-- Section 1: Data Profil -->
            <div>
                <div
                    class="px-3 mb-2 text-[11px] font-bold tracking-wider text-gray-400 dark:text-gray-500 uppercase flex items-center justify-between">
                    <span>Data Profil</span>
                    <span
                        class="text-xs text-indigo-600 dark:text-indigo-400 font-extrabold">{{ $completionPercentage }}%</span>
                </div>

                <!-- Profile Completeness Progress Bar Card -->
                <div class="px-1 mb-3">
                    <div
                        class="p-3 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-950/40 dark:to-purple-950/30 border border-indigo-100 dark:border-indigo-900/50 rounded-xl shadow-2xs">
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden mb-1.5">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full transition-all duration-500"
                                style="width: {{ $completionPercentage }}%"></div>
                        </div>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium">
                            @if ($completionPercentage >= 100)
                                <span class="text-emerald-600 dark:text-emerald-400 font-bold flex items-center gap-1">
                                    <svg class="w-3 h-3 inline" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Profil Sangat Lengkap
                                </span>
                            @elseif($completionPercentage >= 50)
                                <span class="text-indigo-600 dark:text-indigo-400">Lengkapi data untuk hasil
                                    terbaik</span>
                            @else
                                <span class="text-amber-600 dark:text-amber-400">Harap lengkapi kolom data
                                    pribadi</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="space-y-1">
                    <!-- 1. Data Pribadi -->
                    <x-sidebar.single-nav-link :href="route('profile', ['tab' => 'pribadi'])" tab="pribadi"
                        x-on:click.prevent="activeTab = 'pribadi'; $dispatch('switch-tab', 'pribadi')">
                        <x-slot:icon>
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                            </svg>

                        </x-slot:icon>
                        Data Pribadi
                        @if (!empty($sectionStatuses['pribadi']))
                            <x-slot:append>
                                <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </x-slot:append>
                        @endif
                    </x-sidebar.single-nav-link>

                    <!-- 2. Pendidikan -->
                    <x-sidebar.single-nav-link :href="route('profile', ['tab' => 'pendidikan'])" tab="pendidikan"
                        x-on:click.prevent="activeTab = 'pendidikan'; $dispatch('switch-tab', 'pendidikan')">
                        <x-slot:icon>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </x-slot:icon>
                        Pendidikan
                        @if (!empty($sectionStatuses['pendidikan']))
                            <x-slot:append>
                                <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </x-slot:append>
                        @endif
                    </x-sidebar.single-nav-link>

                    <!-- 3. Pengalaman Kerja -->
                    <x-sidebar.single-nav-link :href="route('profile', ['tab' => 'pengalaman'])" tab="pengalaman"
                        x-on:click.prevent="activeTab = 'pengalaman'; $dispatch('switch-tab', 'pengalaman')">
                        <x-slot:icon>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </x-slot:icon>
                        Pengalaman Kerja
                        @if (!empty($sectionStatuses['pengalaman']))
                            <x-slot:append>
                                <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </x-slot:append>
                        @endif
                    </x-sidebar.single-nav-link>

                    <!-- 4. Organisasi -->
                    <x-sidebar.single-nav-link :href="route('profile', ['tab' => 'organisasi'])" tab="organisasi"
                        x-on:click.prevent="activeTab = 'organisasi'; $dispatch('switch-tab', 'organisasi')">
                        <x-slot:icon>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </x-slot:icon>
                        Organisasi
                        @if (!empty($sectionStatuses['organisasi']))
                            <x-slot:append>
                                <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </x-slot:append>
                        @endif
                    </x-sidebar.single-nav-link>

                    <!-- 5. Prestasi -->
                    <x-sidebar.single-nav-link :href="route('profile', ['tab' => 'prestasi'])" tab="prestasi"
                        x-on:click.prevent="activeTab = 'prestasi'; $dispatch('switch-tab', 'prestasi')">
                        <x-slot:icon>
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                        </x-slot:icon>
                        Prestasi
                        @if (!empty($sectionStatuses['prestasi']))
                            <x-slot:append>
                                <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </x-slot:append>
                        @endif
                    </x-sidebar.single-nav-link>

                    <!-- 6. Social Media -->
                    <x-sidebar.single-nav-link :href="route('profile', ['tab' => 'social_media'])" tab="social_media"
                        x-on:click.prevent="activeTab = 'social_media'; $dispatch('switch-tab', 'social_media')">
                        <x-slot:icon>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </x-slot:icon>
                        Social Media
                        @if (!empty($sectionStatuses['social_media']))
                            <x-slot:append>
                                <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </x-slot:append>
                        @endif
                    </x-sidebar.single-nav-link>

                    <!-- 7. Data Tambahan -->
                    <x-sidebar.single-nav-link :href="route('profile', ['tab' => 'data_tambahan'])" tab="data_tambahan"
                        x-on:click.prevent="activeTab = 'data_tambahan'; $dispatch('switch-tab', 'data_tambahan')">
                        <x-slot:icon>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </x-slot:icon>
                        Data Tambahan
                        @if (!empty($sectionStatuses['data_tambahan']))
                            <x-slot:append>
                                <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </x-slot:append>
                        @endif
                    </x-sidebar.single-nav-link>

                    <!-- Generate CV Action Button -->
                    <div class="pt-2 px-1">
                        <a href="{{ route('profile.cv.preview') }}" target="_blank"
                            class="w-full flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-xs font-bold text-white bg-gradient-to-r from-indigo-600 via-indigo-500 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-md shadow-indigo-500/20 hover:shadow-indigo-500/35 transition-all duration-200 group">
                            <svg class="w-4 h-4 text-white group-hover:scale-110 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Generate / Cetak CV</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Section 2: Aktivitas & Pengaturan -->
            <div>
                <div class="px-3 mb-2 text-[11px] font-bold tracking-wider text-gray-400 dark:text-gray-500 uppercase">
                    Aktivitas & Pengaturan
                </div>
                <div class="space-y-1">
                    <x-sidebar.single-nav-link :href="route('profile', ['tab' => 'riwayat'])" tab="riwayat"
                        x-on:click.prevent="activeTab = 'riwayat'; $dispatch('switch-tab', 'riwayat')">
                        <x-slot:icon>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </x-slot:icon>
                        Riwayat Lamaran
                    </x-sidebar.single-nav-link>

                    <x-sidebar.single-nav-link :href="route('profile', ['tab' => 'pengaturan'])" tab="pengaturan"
                        x-on:click.prevent="activeTab = 'pengaturan'; $dispatch('switch-tab', 'pengaturan')">
                        <x-slot:icon>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </x-slot:icon>
                        Pengaturan
                    </x-sidebar.single-nav-link>
                </div>
            </div>

        </nav>
    </div>

    <!-- Bottom Section: Logout (Commented out) -->
    {{-- <div class="p-4 border-t border-gray-200 dark:border-gray-700/80">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2.5 px-3.5 py-2.5 rounded-xl text-sm font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-950/40 hover:bg-red-100 dark:hover:bg-red-900/60 transition-all duration-200 group border border-red-200/60 dark:border-red-900/40 shadow-sm">
                <svg class="w-4 h-4 text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div> --}}
</aside>
