<div>
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
            <div class="flex items-center justify-between pb-5 mb-3 px-2">
                <a href="{{ route('employee.dashboard') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/mikaaaa.png') }}" alt="Logo MIKA"
                        class="h-8 w-auto object-contain rounded-lg group-hover:scale-105 transition-transform duration-200">
                    <div>
                        <span
                            class="block font-bold text-lg tracking-tight text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">E-Rekrutmen</span>
                        <span
                            class="block text-[10px] font-semibold tracking-widest text-indigo-600 dark:text-indigo-400 uppercase">
                            Portal Karyawan
                        </span>
                    </div>
                </a>

                <!-- Mobile Close Button -->
                <button @click="sidebarOpen = false"
                    class="lg:hidden p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>


            <!-- Navigation Sections -->
            <nav class="space-y-6">

                <!-- Section 1: Dashboard -->
                <div>
                    <div
                        class="px-3 mb-2 text-[11px] font-bold tracking-wider text-gray-400 dark:text-gray-500 uppercase">
                        Menu Utama
                    </div>
                    <div class="space-y-1">
                        <button type="button"
                            @click="activeTab = 'dashboard'; if (window.innerWidth < 1024) sidebarOpen = false;"
                            :class="(activeTab === 'dashboard' || activeTab === 'pribadi') ?
                            'flex items-center justify-between w-full px-3.5 py-2.5 rounded-xl text-sm font-medium bg-indigo-600 text-white shadow-md shadow-indigo-500/20 group' :
                            'flex items-center justify-between w-full px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-slate-100 hover:bg-gray-100 dark:hover:bg-gray-700/60 group transition-colors'">
                            <div class="flex items-center gap-3 min-w-0">
                                <div :class="(activeTab === 'dashboard' || activeTab === 'pribadi') ? 'text-white' :
                                'text-gray-400 dark:text-gray-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400'"
                                    class="shrink-0 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <span class="truncate font-medium">Dashboard Asesmen</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Section 2: Asesmen Karyawan -->
                <div>
                    <div
                        class="px-3 mb-2 text-[11px] font-bold tracking-wider text-gray-400 dark:text-gray-500 uppercase">
                        Asesmen Karyawan
                    </div>
                    <div class="space-y-1">
                        <!-- Tugas Asesmen -->
                        <button type="button"
                            @click="activeTab = 'asesmen'; if (window.innerWidth < 1024) sidebarOpen = false;"
                            :class="activeTab === 'asesmen'
                                ?
                                'flex items-center justify-between w-full px-3.5 py-2.5 rounded-xl text-sm font-medium bg-indigo-600 text-white shadow-md shadow-indigo-500/20 group' :
                                'flex items-center justify-between w-full px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-slate-100 hover:bg-gray-100 dark:hover:bg-gray-700/60 group transition-colors'">
                            <div class="flex items-center gap-3 min-w-0">
                                <div :class="activeTab === 'asesmen' ? 'text-white' :
                                    'text-gray-400 dark:text-gray-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400'"
                                    class="shrink-0 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                                <span class="truncate font-medium">Tugas Asesmen</span>
                            </div>
                            @if ($availableTestsCount > 0)
                                <span
                                    :class="activeTab === 'asesmen' ? 'bg-white/20 text-white' :
                                        'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30'"
                                    class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold rounded-full">
                                    {{ $availableTestsCount }}
                                </span>
                            @endif
                        </button>

                        <!-- Riwayat Nilai & Evaluasi -->
                        <button type="button"
                            @click="activeTab = 'riwayat'; if (window.innerWidth < 1024) sidebarOpen = false;"
                            :class="activeTab === 'riwayat'
                                ?
                                'flex items-center justify-between w-full px-3.5 py-2.5 rounded-xl text-sm font-medium bg-indigo-600 text-white shadow-md shadow-indigo-500/20 group' :
                                'flex items-center justify-between w-full px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-slate-100 hover:bg-gray-100 dark:hover:bg-gray-700/60 group transition-colors'">
                            <div class="flex items-center gap-3 min-w-0">
                                <div :class="activeTab === 'riwayat' ? 'text-white' :
                                    'text-gray-400 dark:text-gray-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400'"
                                    class="shrink-0 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="truncate font-medium">Riwayat Asesmen</span>
                            </div>
                            @if ($completedAttemptsCount > 0)
                                <span
                                    :class="activeTab === 'riwayat' ? 'bg-white/20 text-white' :
                                        'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-slate-300 border border-gray-200 dark:border-slate-600'"
                                    class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold rounded-full">
                                    {{ $completedAttemptsCount }}
                                </span>
                            @endif
                        </button>
                    </div>
                </div>

                <!-- Section 3: Pengaturan Akun -->
                <div>
                    <div
                        class="px-3 mb-2 text-[11px] font-bold tracking-wider text-gray-400 dark:text-gray-500 uppercase">
                        Akun & Keamanan
                    </div>
                    <div class="space-y-1">
                        <button type="button"
                            @click="activeTab = 'pengaturan'; if (window.innerWidth < 1024) sidebarOpen = false;"
                            :class="activeTab === 'pengaturan'
                                ?
                                'flex items-center justify-between w-full px-3.5 py-2.5 rounded-xl text-sm font-medium bg-indigo-600 text-white shadow-md shadow-indigo-500/20 group' :
                                'flex items-center justify-between w-full px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-slate-100 hover:bg-gray-100 dark:hover:bg-gray-700/60 group transition-colors'">
                            <div class="flex items-center gap-3 min-w-0">
                                <div :class="activeTab === 'pengaturan' ? 'text-white' :
                                    'text-gray-400 dark:text-gray-500 group-hover:text-indigo-600 dark:group-hover:text-indigo-400'"
                                    class="shrink-0 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <span class="truncate font-medium">Pengaturan Sandi & Profil</span>
                            </div>
                        </button>
                    </div>
                </div>

            </nav>
        </div>

        <!-- Bottom: Logout Button -->
        {{-- <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2.5 text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div> --}}

    </aside>
</div>
