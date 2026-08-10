@if (auth()->check() && (auth()->user()->role?->name === 'admin' || auth()->user()->role_id == 1))
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
            <div
                class="flex items-center justify-between pb-6 mb-4 border-b border-gray-200 dark:border-gray-700/80 px-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-purple-500 flex items-center justify-center text-white shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0H9m4 0h2M9 11V7m0 0h6m-6 0v4" />
                        </svg>
                    </div>
                    <div>
                        <span
                            class="block font-bold text-lg tracking-tight text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">E-Rekruitmen</span>
                        <span
                            class="block text-[10px] font-semibold tracking-widest text-indigo-600 dark:text-indigo-400 uppercase">Admin
                            Portal</span>
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

                <!-- Section 1: Dashboard  Admin -->
                <div>
                    <div
                        class="px-3 mb-2 text-[11px] font-bold tracking-wider text-gray-400 dark:text-gray-500 uppercase">
                        Menu Utama
                    </div>
                    <div class="space-y-1">
                        <x-sidebar.single-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            <x-slot:icon>
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </x-slot:icon>
                            Dashboard
                        </x-sidebar.single-nav-link>
                    </div>
                </div>

                <!-- Section 3: Perusahaan & Divisi -->
                <div>
                    <div
                        class="px-3 mb-2 text-[11px] font-bold tracking-wider text-gray-400 dark:text-gray-500 uppercase">
                        Data Master
                    </div>
                    <div class="space-y-1">
                        <x-sidebar.nested-nav-link title="Perusahaan" :active="request()->routeIs('admin.company*') || request()->routeIs('admin.department*')">
                            <x-slot:icon>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                </svg>
                            </x-slot:icon>

                            <a href="{{ route('admin.company') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.company*') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Profil Perusahaan
                            </a>
                            <a href="{{ route('admin.department') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.department*') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Departemen / Divisi
                            </a>
                        </x-sidebar.nested-nav-link>
                    </div>
                </div>

                <!-- Section 2: Manajemen rekrutmen -->
                <div>
                    <div
                        class="px-3 mb-2 text-[11px] font-bold tracking-wider text-gray-400 dark:text-gray-500 uppercase">
                        Rekrutmen
                    </div>
                    <div class="space-y-1">
                        <x-sidebar.nested-nav-link title="Data Rekrutmen" :active="request()->routeIs('admin.job*') ||
                            request()->routeIs('admin.application*') ||
                            request()->routeIs('admin.candidate*') ||
                            request()->routeIs('admin.test*') ||
                            request()->routeIs('admin.test_evaluation*')">
                            <x-slot:icon>
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>

                            </x-slot:icon>

                            <a href="{{ route('admin.candidate') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.candidate') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Kandidat Pelamar
                            </a>
                            <a href="{{ route('admin.job') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.job') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Lowongan Kerja
                            </a>
                            <a href="{{ route('admin.application') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.application') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Lamaran Masuk
                            </a>
                            <a href="{{ route('admin.test') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.test') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Paket Ujian Tes
                            </a>
                            <a href="{{ route('admin.test_evaluation') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.test_evaluation') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Evaluasi & Nilai Ujian
                            </a>
                        </x-sidebar.nested-nav-link>
                    </div>
                </div>


                <!-- Section 4: Data Master -->
                <div>
                    <div
                        class="px-3 mb-2 text-[11px] font-bold tracking-wider text-gray-400 dark:text-gray-500 uppercase">
                        Data Soal
                    </div>
                    <div class="space-y-1">
                        <x-sidebar.nested-nav-link title="Kualifikasi & Tes" :active="request()->routeIs('admin.major') ||
                            request()->routeIs('admin.degree') ||
                            request()->routeIs('admin.test_category') ||
                            request()->routeIs('admin.question_bank')">
                            <x-slot:icon>
                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                </svg>


                            </x-slot:icon>
                            <a href="{{ route('admin.degree') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.degree') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Tingkat Pendidikan
                            </a>
                            <a href="{{ route('admin.major') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.major') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Jurusan
                            </a>
                            <a href="{{ route('admin.test_category') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.test_category') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Kategori Soal
                            </a>
                            <a href="{{ route('admin.question_bank') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.question_bank') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Bank Soal
                            </a>
                        </x-sidebar.nested-nav-link>
                    </div>
                </div>

                <!-- Section 3: Manajemen Perusahaan (Nested Example) -->
                {{-- <div>
                    <div
                        class="px-3 mb-2 text-[11px] font-bold tracking-wider text-gray-400 dark:text-gray-500 uppercase">
                        Manajemen Perusahaan
                    </div>
                    <div class="space-y-1">
                        <x-sidebar.nested-nav-link title="Data Perusahaan" :active="request()->routeIs('admin.company') || request()->routeIs('admin.department')">
                            <x-slot:icon>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                </svg>

                            </x-slot:icon>

                            <a href="{{ route('admin.company') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.company') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Perusahaan
                            </a>
                            <a href="{{ route('admin.department') }}"
                                class="block px-3 py-2 text-xs font-medium {{ request()->routeIs('admin.department') ? 'text-indigo-600 dark:text-indigo-400 font-semibold bg-indigo-50/50 dark:bg-indigo-950/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60' }} rounded-lg transition-colors">
                                Departemen
                            </a>
                        </x-sidebar.nested-nav-link>
                    </div>
                </div> --}}
                <!-- Settings  taruh dalam div kalo dipake-->
                {{-- <x-sidebar.single-nav-link 
                            href="#" 
                            :active="false">
                            <x-slot:icon>
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </x-slot:icon>
                            Pengaturan
                        </x-sidebar.single-nav-link> --}}
                <!-- Section 3: Manajemen Rekrutmen -->
                {{-- <div>
                    <div
                        class="px-3 mb-2 text-[11px] font-bold tracking-wider text-gray-400 dark:text-gray-500 uppercase">
                        Manajemen Rekrutmen
                    </div>
                    <div class="space-y-1">
                        <x-sidebar.nested-nav-link title="Manajemen Rekrutmen" :active="false">
                            <x-slot:icon>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>
                            </x-slot:icon>

                            <a href="#"
                                class="block px-3 py-2 text-xs font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/60 transition-colors">
                                Kelola Lowongan
                            </a>
                            <a href="#"
                                class="block px-3 py-2 text-xs font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/60 transition-colors">
                                Data Pelamar
                            </a>
                        </x-sidebar.nested-nav-link>
                    </div>
                </div> --}}
            </nav>
        </div>

    </aside>
@endif
