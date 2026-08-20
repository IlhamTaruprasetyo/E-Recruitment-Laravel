@extends('frontend.layouts.app')

@section('title', 'Beranda | Portal E-Rekrutmen')

@section('content')
    <div class="relative overflow-hidden">

        <!-- ==================== HERO SECTION (IMAGE BACKGROUND + MULTI-LAYER DARK GRADIENTS) ==================== -->
        <section
            class="relative min-h-[90vh] flex items-center justify-center pt-8 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden bg-[#040804]">

            <!-- Hero Background Image (Clear & Crisp) -->
            <div class="absolute inset-0 z-0">
                <img src="https://i.pinimg.com/736x/20/dc/f0/20dcf0cfb0122a38d938e3c3011fb0d4.jpg"
                    alt="Recruitment Career Background"
                    class="w-full h-full object-cover object-center filter brightness-90 contrast-105">
            </div>

            <!-- Subtle Dark Gradient & Edge Vignette (Keeps Text Readable while Image Stays Crisp & Clear) -->
            <div class="absolute inset-0 z-0 bg-gradient-to-b from-[#040804]/60 via-[#040804]/40 to-[#040804]"></div>
            <div class="absolute inset-0 z-0 bg-black/35"></div>
            <div class="absolute inset-0 z-0 bg-[radial-gradient(ellipse_at_center,_transparent_40%,_#040804_95%)]"></div>

            <!-- Ambient Green Glow #93F514 (Gentle Edge Highlights) -->
            <div
                class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[250px] bg-[#93F514]/15 rounded-full blur-[100px] pointer-events-none z-0">
            </div>

            <div class="relative max-w-5xl mx-auto text-center z-10 flex flex-col items-center">

                <!-- Main Headline Hero with Neon #93F514 & White Gradients -->
                <h1
                    class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-[#EEEEEE] leading-tight sm:leading-none max-w-4xl drop-shadow-[0_4px_16px_rgba(0,0,0,0.8)]">
                    Temukan Karir Impian, <br>
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-[#93F514] via-[#75f06a] to-[#5FE6B6] drop-shadow-[0_0_25px_rgba(147,245,20,0.4)]">
                        Wujudkan Potensi Terbaikmu
                    </span>
                </h1>

                <!-- Subtitle Description / Slogan Layer -->
                <p
                    class="mt-6 text-base sm:text-xl text-gray-200 max-w-2xl font-normal leading-relaxed drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)]">
                    Bergabunglah bersama ribuan profesional bertalenta. Jelajahi lowongan kerja, ikuti tes seleksi online
                    terintegrasi, dan raih karir masa depan sekarang.
                </p>

                <!-- Search Bar Form (Clean Segmented Solid Light Pill Bar) -->
                <div class="w-full max-w-5xl mt-10 p-2 sm:p-2.5 rounded-2xl lg:rounded-full bg-[#EEEEEE] text-gray-800 shadow-2xl shadow-black/80 border border-white/40"
                    style="background-color: #EEEEEE !important;">
                    <form action="{{ route('jobs.index') }}" method="GET"
                        class="flex flex-col lg:flex-row items-center gap-2 lg:gap-0 divide-y lg:divide-y-0 lg:divide-x divide-gray-300">

                        <!-- Search Input -->
                        <div class="w-full lg:flex-1 relative flex items-center px-4 py-1">
                            <div class="pr-2.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari lowongan yang Anda inginkan..."
                                class="w-full py-2 bg-transparent text-gray-900 placeholder-gray-400 border-0 outline-none focus:outline-none focus:ring-0 focus:border-0 shadow-none text-sm font-medium">
                        </div>

                        <!-- Dropdown Semua Perusahaan -->
                        <div class="w-full lg:w-56 relative" x-data="{
                            open: false,
                            search: '',
                            selected: '{{ request('company_id', '') }}',
                            selectedName: '{{ $companies->firstWhere('id', request('company_id'))?->name ?? '' }}',
                            tempSelected: '{{ request('company_id', '') }}',
                            init() {
                                this.tempSelected = this.selected;
                            },
                            openDropdown() {
                                this.tempSelected = this.selected;
                                this.search = '';
                                this.open = true;
                            },
                            reset() {
                                this.tempSelected = '';
                                this.selected = '';
                                this.selectedName = '';
                                this.open = false;
                            },
                            apply() {
                                this.selected = this.tempSelected;
                                let el = this.$root.querySelector('input[name=\'_home_temp_company\']:checked');
                                if (el) {
                                    let span = el.closest('label').querySelector('span');
                                    this.selectedName = span ? span.innerText.trim() : '';
                                } else {
                                    this.selectedName = '';
                                }
                                this.open = false;
                            }
                        }" @click.outside="open = false">

                            <input type="hidden" name="company_id" :value="selected">

                            <button type="button" @click="open ? open = false : openDropdown()"
                                :class="selected ? 'text-[#93F514] font-bold' : 'text-gray-700'"
                                class="w-full py-2.5 px-4 flex items-center justify-between text-left text-sm transition">
                                <div class="flex items-center gap-2 truncate">
                                    <template x-if="selected">
                                        <span
                                            class="w-5 h-5 rounded-full bg-[#93F514] text-black font-extrabold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                            1
                                        </span>
                                    </template>
                                    <span class="truncate"
                                        x-text="selected ? (selectedName || '1 Perusahaan') : 'Semua Perusahaan'">
                                        {{ request('company_id') ? $companies->firstWhere('id', request('company_id'))?->name ?? '1 Perusahaan' : 'Semua Perusahaan' }}
                                    </span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200"
                                    :class="open ? 'rotate-180 text-[#93F514]' : (selected ? 'text-[#93F514]' : '')"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Popover Panel -->
                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                class="absolute top-full left-0 lg:left-auto lg:right-0 mt-2 w-80 sm:w-[460px] bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 z-50 text-gray-800 flex flex-col">

                                <!-- Search Input -->
                                <div class="relative mb-3">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" x-model="search" placeholder="Temukan perusahaan..."
                                        class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#93F514]/40 focus:border-[#93F514]">
                                </div>

                                <!-- All Option -->
                                <label
                                    class="flex items-center gap-3 py-2 px-1 text-xs font-semibold text-gray-700 hover:text-black cursor-pointer border-b border-gray-100">
                                    <input type="radio" name="_home_temp_company" value="" x-model="tempSelected"
                                        class="w-4 h-4 rounded border-gray-300 text-[#93F514] focus:ring-[#93F514] cursor-pointer">
                                    <span>Semua Perusahaan</span>
                                </label>

                                <!-- Group Title -->
                                <div class="mt-3 mb-1.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                    Pilihan Perusahaan
                                </div>

                                <!-- 2-Column Grid List items (Compact & Scrollable) -->
                                <div class="max-h-44 overflow-y-auto pr-1 custom-scrollbar">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-3 gap-y-1">
                                        @if (isset($companies))
                                            @foreach ($companies as $comp)
                                                <label
                                                    class="flex items-center gap-2.5 py-1.5 px-1.5 rounded-lg text-xs text-gray-600 hover:text-black hover:bg-gray-50 cursor-pointer transition"
                                                    x-show="!search || '{{ strtolower($comp->name) }}'.includes(search.toLowerCase())">
                                                    <input type="radio" name="_home_temp_company"
                                                        value="{{ $comp->id }}" x-model="tempSelected"
                                                        class="w-4 h-4 rounded border-gray-300 text-[#93F514] focus:ring-[#93F514] cursor-pointer shrink-0">
                                                    <span class="truncate">{{ $comp->name }}</span>
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <!-- Footer Buttons (Always Visible at Bottom) -->
                                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between gap-3">
                                    <button type="button" @click="reset()"
                                        class="text-xs font-semibold text-gray-500 hover:text-[#93F514] transition">
                                        Atur Ulang
                                    </button>
                                    <button type="button" @click="apply()"
                                        class="px-5 py-2 rounded-xl bg-[#93F514] hover:bg-[#7edc0b] text-black font-bold text-xs shadow-md shadow-[#93F514]/25 transition">
                                        Pilih
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown Semua Departemen / Fungsi -->
                        <div class="w-full lg:w-56 relative" x-data="{
                            open: false,
                            search: '',
                            selected: '{{ request('department_id', '') }}',
                            selectedName: '{{ $departments->firstWhere('id', request('department_id'))?->name ?? '' }}',
                            tempSelected: '{{ request('department_id', '') }}',
                            init() {
                                this.tempSelected = this.selected;
                            },
                            openDropdown() {
                                this.tempSelected = this.selected;
                                this.search = '';
                                this.open = true;
                            },
                            reset() {
                                this.tempSelected = '';
                                this.selected = '';
                                this.selectedName = '';
                                this.open = false;
                            },
                            apply() {
                                this.selected = this.tempSelected;
                                let el = this.$root.querySelector('input[name=\'_home_temp_department\']:checked');
                                if (el) {
                                    let span = el.closest('label').querySelector('span');
                                    this.selectedName = span ? span.innerText.trim() : '';
                                } else {
                                    this.selectedName = '';
                                }
                                this.open = false;
                            }
                        }" @click.outside="open = false">

                            <input type="hidden" name="department_id" :value="selected">

                            <button type="button" @click="open ? open = false : openDropdown()"
                                :class="selected ? 'text-[#93F514] font-bold' : 'text-gray-700'"
                                class="w-full py-2.5 px-4 flex items-center justify-between text-left text-sm transition">
                                <div class="flex items-center gap-2 truncate">
                                    <template x-if="selected">
                                        <span
                                            class="w-5 h-5 rounded-full bg-[#93F514] text-black font-extrabold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                            1
                                        </span>
                                    </template>
                                    <span class="truncate"
                                        x-text="selected ? (selectedName || '1 Departemen') : 'Semua Departemen'">
                                        {{ request('department_id') ? $departments->firstWhere('id', request('department_id'))?->name ?? '1 Departemen' : 'Semua Departemen' }}
                                    </span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200"
                                    :class="open ? 'rotate-180 text-[#93F514]' : (selected ? 'text-[#93F514]' : '')"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Popover Panel -->
                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                class="absolute top-full left-0 lg:left-auto lg:right-0 mt-2 w-80 sm:w-[460px] bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 z-50 text-gray-800 flex flex-col">

                                <!-- Search Input -->
                                <div class="relative mb-3">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" x-model="search" placeholder="Temukan fungsi / departemen..."
                                        class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#93F514]/40 focus:border-[#93F514]">
                                </div>

                                <!-- All Option -->
                                <label
                                    class="flex items-center gap-3 py-2 px-1 text-xs font-semibold text-gray-700 hover:text-black cursor-pointer border-b border-gray-100">
                                    <input type="radio" name="_home_temp_department" value=""
                                        x-model="tempSelected"
                                        class="w-4 h-4 rounded border-gray-300 text-[#93F514] focus:ring-[#93F514] cursor-pointer">
                                    <span>Semua Departemen</span>
                                </label>

                                <!-- Group Title -->
                                <div class="mt-3 mb-1.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                    Pilihan Departemen
                                </div>

                                <!-- 2-Column Grid List items (Compact & Scrollable) -->
                                <div class="max-h-44 overflow-y-auto pr-1 custom-scrollbar">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-3 gap-y-1">
                                        @if (isset($departments))
                                            @foreach ($departments as $dept)
                                                <label
                                                    class="flex items-center gap-2.5 py-1.5 px-1.5 rounded-lg text-xs text-gray-600 hover:text-black hover:bg-gray-50 cursor-pointer transition"
                                                    x-show="!search || '{{ strtolower($dept->name) }}'.includes(search.toLowerCase())">
                                                    <input type="radio" name="_home_temp_department"
                                                        value="{{ $dept->id }}" x-model="tempSelected"
                                                        class="w-4 h-4 rounded border-gray-300 text-[#93F514] focus:ring-[#93F514] cursor-pointer shrink-0">
                                                    <span class="truncate">{{ $dept->name }}</span>
                                                </label>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <!-- Footer Buttons (Always Visible at Bottom) -->
                                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between gap-3">
                                    <button type="button" @click="reset()"
                                        class="text-xs font-semibold text-gray-500 hover:text-[#93F514] transition">
                                        Atur Ulang
                                    </button>
                                    <button type="button" @click="apply()"
                                        class="px-5 py-2 rounded-xl bg-[#93F514] hover:bg-[#7edc0b] text-black font-bold text-xs shadow-md shadow-[#93F514]/25 transition">
                                        Pilih
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown Semua Jenjang (Employment Type) -->
                        <div class="w-full lg:w-48 relative" x-data="{
                            open: false,
                            search: '',
                            selected: '{{ request('employment_type', '') }}',
                            types: ['Magang', 'Full Time', 'Part Time', 'Contract', 'Freelance', 'Remote'],
                            tempSelected: '{{ request('employment_type', '') }}',
                            init() {
                                this.tempSelected = this.selected;
                            },
                            openDropdown() {
                                this.tempSelected = this.selected;
                                this.search = '';
                                this.open = true;
                            },
                            reset() {
                                this.tempSelected = '';
                                this.selected = '';
                                this.open = false;
                            },
                            apply() {
                                this.selected = this.tempSelected;
                                this.open = false;
                            }
                        }" @click.outside="open = false">

                            <input type="hidden" name="employment_type" :value="selected">

                            <button type="button" @click="open ? open = false : openDropdown()"
                                :class="selected ? 'text-[#93F514] font-bold' : 'text-gray-700'"
                                class="w-full py-2.5 px-4 flex items-center justify-between text-left text-sm transition">
                                <div class="flex items-center gap-2 truncate">
                                    <template x-if="selected">
                                        <span
                                            class="w-5 h-5 rounded-full bg-[#93F514] text-black font-extrabold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                            1
                                        </span>
                                    </template>
                                    <span class="truncate" x-text="selected ? selected : 'Semua Jenjang'">
                                        {{ request('employment_type') ? request('employment_type') : 'Semua Jenjang' }}
                                    </span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200"
                                    :class="open ? 'rotate-180 text-[#93F514]' : (selected ? 'text-[#93F514]' : '')"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Popover Panel -->
                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                class="absolute top-full left-0 lg:left-auto lg:right-0 mt-2 w-80 sm:w-[420px] bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 z-50 text-gray-800 flex flex-col">

                                <!-- Search Input -->
                                <div class="relative mb-3">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" x-model="search" placeholder="Temukan jenjang..."
                                        class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#93F514]/40 focus:border-[#93F514]">
                                </div>

                                <!-- All Option -->
                                <label
                                    class="flex items-center gap-3 py-2 px-1 text-xs font-semibold text-gray-700 hover:text-black cursor-pointer border-b border-gray-100">
                                    <input type="radio" name="_home_temp_type" value="" x-model="tempSelected"
                                        class="w-4 h-4 rounded border-gray-300 text-[#93F514] focus:ring-[#93F514] cursor-pointer">
                                    <span>Semua Jenjang</span>
                                </label>

                                <!-- Group Title -->
                                <div class="mt-3 mb-1.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                    Pilihan Jenjang
                                </div>

                                <!-- 2-Column Grid List items (Compact & Scrollable) -->
                                <div class="max-h-44 overflow-y-auto pr-1 custom-scrollbar">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-3 gap-y-1">
                                        <template
                                            x-for="type in types.filter(t => !search || t.toLowerCase().includes(search.toLowerCase()))"
                                            :key="type">
                                            <label
                                                class="flex items-center gap-2.5 py-1.5 px-1.5 rounded-lg text-xs text-gray-600 hover:text-black hover:bg-gray-50 cursor-pointer transition">
                                                <input type="radio" name="_home_temp_type" :value="type"
                                                    x-model="tempSelected"
                                                    class="w-4 h-4 rounded border-gray-300 text-[#93F514] focus:ring-[#93F514] cursor-pointer shrink-0">
                                                <span x-text="type" class="truncate"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>

                                <!-- Footer Buttons (Always Visible at Bottom) -->
                                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between gap-3">
                                    <button type="button" @click="reset()"
                                        class="text-xs font-semibold text-gray-500 hover:text-[#93F514] transition">
                                        Atur Ulang
                                    </button>
                                    <button type="button" @click="apply()"
                                        class="px-5 py-2 rounded-xl bg-[#93F514] hover:bg-[#7edc0b] text-black font-bold text-xs shadow-md shadow-[#93F514]/25 transition">
                                        Pilih
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Actions (Submit & Reset) -->
                        <div class="w-full lg:w-auto p-1 shrink-0 flex items-center gap-2">
                            <button type="submit"
                                class="w-full lg:w-auto py-2.5 px-6 rounded-xl lg:rounded-full bg-[#051405] hover:bg-[#93F514] text-[#EEEEEE] hover:text-black border border-[#93F514]/40 font-bold text-sm tracking-wide shadow-md shadow-black/25 transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer outline-none group">
                                <svg class="w-4 h-4 text-[#93F514] group-hover:text-black transition-colors shrink-0"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span class="whitespace-nowrap">Cari Lowongan</span>
                            </button>
                            @if (request('search') || request('company_id') || request('department_id') || request('employment_type'))
                                <a href="{{ route('home') }}" title="Reset Filter"
                                    class="p-2.5 rounded-xl lg:rounded-full bg-gray-100 hover:bg-red-50 text-gray-500 hover:text-red-500 transition flex items-center justify-center border border-gray-200">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Popular Searches tags -->
                <div class="mt-5 flex flex-wrap items-center justify-center gap-2 text-xs text-gray-400">
                    <span class="font-bold text-[#93F514]">Pencarian Populer:</span>
                    <a href="{{ route('jobs.index', ['search' => 'Software Engineer']) }}"
                        class="px-3 py-1 rounded-full bg-[#051205] hover:bg-[#93F514]/20 border border-[#93F514]/30 text-gray-300 hover:text-[#93F514] transition">Software
                        Engineer</a>
                    <a href="{{ route('jobs.index', ['search' => 'Staff']) }}"
                        class="px-3 py-1 rounded-full bg-[#051205] hover:bg-[#93F514]/20 border border-[#93F514]/30 text-gray-300 hover:text-[#93F514] transition">Staff
                        Administrasi</a>
                    <a href="{{ route('jobs.index', ['search' => 'Marketing']) }}"
                        class="px-3 py-1 rounded-full bg-[#051205] hover:bg-[#93F514]/20 border border-[#93F514]/30 text-gray-300 hover:text-[#93F514] transition">Digital
                        Marketing</a>
                    <a href="{{ route('jobs.index', ['location' => 'Remote']) }}"
                        class="px-3 py-1 rounded-full bg-[#051205] hover:bg-[#93F514]/20 border border-[#93F514]/30 text-gray-300 hover:text-[#93F514] transition">Remote</a>
                </div>

                <!-- Quick Stats Summary -->
                <div
                    class="mt-14 grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 w-full max-w-4xl border-t border-[#93F514]/20 pt-8">
                    <div
                        class="p-4 rounded-2xl bg-gradient-to-b from-[#061506] to-[#040804] border border-[#93F514]/30 hover:border-[#93F514]/60 transition shadow-lg shadow-black/40">
                        <div class="text-2xl sm:text-3xl font-black text-[#EEEEEE]">{{ $totalJobsCount ?? 0 }}+</div>
                        <div class="text-xs text-[#93F514] font-semibold mt-1">Lowongan Aktif</div>
                    </div>
                    <div
                        class="p-4 rounded-2xl bg-gradient-to-b from-[#061506] to-[#040804] border border-[#93F514]/30 hover:border-[#93F514]/60 transition shadow-lg shadow-black/40">
                        <div class="text-2xl sm:text-3xl font-black text-[#EEEEEE]">{{ $companiesCount ?? 0 }}+</div>
                        <div class="text-xs text-[#93F514] font-semibold mt-1">Perusahaan Mitra</div>
                    </div>
                    <div
                        class="p-4 rounded-2xl bg-gradient-to-b from-[#061506] to-[#040804] border border-[#93F514]/30 hover:border-[#93F514]/60 transition shadow-lg shadow-black/40">
                        <div class="text-2xl sm:text-3xl font-black text-[#EEEEEE]">{{ $departmentsCount ?? 0 }}+</div>
                        <div class="text-xs text-[#93F514] font-semibold mt-1">Bidang / Departemen</div>
                    </div>
                    <div
                        class="p-4 rounded-2xl bg-gradient-to-b from-[#061506] to-[#040804] border border-[#93F514]/30 hover:border-[#93F514]/60 transition shadow-lg shadow-black/40">
                        <div class="text-2xl sm:text-3xl font-black text-[#EEEEEE]">{{ $totalQuotaCount ?? 0 }}+</div>
                        <div class="text-xs text-[#93F514] font-semibold mt-1">Total Kuota Formasi</div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ==================== SHOWCASE / ABOUT COMPANY CAROUSEL SECTION ==================== -->
        <section class="relative py-16 sm:py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto overflow-hidden"
            x-data="{
                currentSlide: 0,
                companyName: '{{ isset($mainCompany) ? $mainCompany->name : 'Mitra Karya Analitika' }}',
                companyWebsite: '{{ isset($mainCompany) && $mainCompany->website ? (Str::startsWith($mainCompany->website, ['http://', 'https://']) ? $mainCompany->website : 'https://' . $mainCompany->website) : '' }}',
                slides: [{
                        tag: 'Tentang Kami & Karir',
                        title: 'Ruang untuk Bertumbuh dan Berkembang',
                        description: 'Kami mendorong setiap individu untuk terus berkembang melalui pelatihan berkelanjutan, pengembangan sumber daya manusia, serta lingkungan kerja modern. Bersama {{ isset($mainCompany) ? $mainCompany->name : 'Mitra Karya Analitika' }}, kembangkan potensi, pengalaman, dan karier Anda secara optimal.',
                        img1: '{{ asset('storage/asset-compro/aniv1.jpg') }}',
                        img2: '{{ asset('storage/asset-compro/outbond.jpg') }}',
                        img3: '{{ asset('storage/asset-compro/aniv.jpg') }}',
                        badgeTitle: 'CAREER.',
                        badgeSub: 'Growth & Development'
                    },
                    {
                        tag: 'Acara & Kolaborasi',
                        title: 'Bimbingan Teknis ASPADIN 2026: Sinergi Kompetensi',
                        description: 'Menghadirkan sesi Bimbingan Teknis eksklusif di Semarang bagi para mitra industri. Kami berbagi pengetahuan, memamerkan inovasi solusi IoT terbaru, dan memperkuat jaringan untuk pertumbuhan profesional bersama.',
                        img1: '{{ asset('storage/asset-compro/aspadin1.jpg') }}', // Gambar poster utama acara
                        img2: '{{ asset('storage/asset-compro/aspadin2.jpg') }}', // Kolase foto aktivitas detail dan interaksi
                        img3: '{{ asset('storage/asset-compro/aspadin3.jpg') }}', // Kolase foto pameran produk dan pertemuan
                        badgeTitle: 'EVENT',
                        badgeSub: 'Technical Guidance'
                    },
                    {
                        tag: 'Acara & Pameran',
                        title: 'Partisipasi Aktif di Event HISFARIN 2025',
                        description: 'Memperluas jaringan dan memperkenalkan solusi teknologi analitik terkini dalam Musyawarah Nasional HISFARIN 2025. Kami hadir langsung menyapa para profesional, memamerkan perangkat keras inovatif, dan membangun sinergi kolaboratif untuk mendukung kemajuan industri.',
                        img1: '{{ asset('storage/asset-compro/hisfarin1.jpg') }}', // Gambar poster Event HISFARIN 2025 (tanggal & lokasi)
                        img2: '{{ asset('storage/asset-compro/hisfarin2.jpg') }}', // Kolase foto antusiasme pengunjung dan interaksi di booth MIKA
                        img3: '{{ asset('storage/asset-compro/hisfarin3.jpg') }}', // Dokumentasi display produk, presentasi, dan foto bersama
                        badgeTitle: 'EVENT',
                        badgeSub: 'Exhibition & Networking'
                    }
                ],
                autoplayTimer: null,
                progressTimer: null,
                duration: 7000,
                progress: 0,
                isPaused: false,
                init() {
                    this.startAutoplay();
                },
                next() {
                    this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                    this.restartAutoplay();
                },
                prev() {
                    this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                    this.restartAutoplay();
                },
                goTo(index) {
                    this.currentSlide = index;
                    this.restartAutoplay();
                },
                startAutoplay() {
                    this.isPaused = false;
                    this.stopAutoplay();
                    const intervalMs = 50;
                    const step = (intervalMs / this.duration) * 100;
                    this.progressTimer = setInterval(() => {
                        if (!this.isPaused) {
                            this.progress += step;
                            if (this.progress >= 100) {
                                this.progress = 0;
                                this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                            }
                        }
                    }, intervalMs);
                },
                stopAutoplay() {
                    if (this.progressTimer) clearInterval(this.progressTimer);
                    if (this.autoplayTimer) clearInterval(this.autoplayTimer);
                },
                pause() {
                    this.isPaused = true;
                },
                resume() {
                    this.isPaused = false;
                },
                restartAutoplay() {
                    this.progress = 0;
                    this.startAutoplay();
                }
            }">

            <!-- Background Decorative Patterns -->
            <div
                class="absolute inset-0 bg-gradient-to-b from-[#040804] via-[#051405] to-[#040804] rounded-3xl sm:rounded-[2.5rem] border border-[#93F514]/25 shadow-2xl shadow-black/80 overflow-hidden pointer-events-none">
                <!-- Hexagon Pattern Overlay -->
                <div
                    class="absolute inset-0 opacity-[0.07] bg-[radial-gradient(#93F514_1.5px,transparent_1.5px)] [background-size:24px_24px]">
                </div>

                <!-- Concentric Circular Background Ripples -->
                <div
                    class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full border border-[#93F514]/15 pointer-events-none">
                </div>
                <div
                    class="absolute -bottom-40 -left-40 w-[30rem] h-[30rem] rounded-full border border-[#93F514]/10 pointer-events-none">
                </div>
                <div
                    class="absolute -bottom-56 -left-56 w-[40rem] h-[40rem] rounded-full border border-[#93F514]/5 pointer-events-none">
                </div>

                <!-- Soft Ambient Glows -->
                <div
                    class="absolute top-0 right-1/4 w-80 h-80 bg-[#93F514]/10 rounded-full blur-[100px] pointer-events-none">
                </div>
                <div
                    class="absolute bottom-0 left-1/3 w-72 h-72 bg-[#93F514]/10 rounded-full blur-[90px] pointer-events-none">
                </div>
            </div>

            <!-- Main Inner Container -->
            <div class="relative z-10 p-6 sm:p-10 lg:p-14">

                <!-- Slides Content -->
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="currentSlide === index" x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 translate-x-16"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-500 absolute inset-0"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 -translate-x-16"
                        class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center min-h-[460px]">

                        <!-- Left Column: Typography & Description -->
                        <div class="lg:col-span-5 flex flex-col justify-between h-full space-y-6">
                            <div>
                                <!-- Tag / Category Header -->
                                <div
                                    class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#93F514]/15 border border-[#93F514]/40 text-[#93F514] text-xs font-bold uppercase tracking-wider mb-4">
                                    {{-- <span class="w-2 h-2 rounded-full bg-[#93F514] animate-pulse"></span> --}}
                                    <span x-text="slide.tag"></span>
                                </div>

                                <!-- Main Slide Title -->
                                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#EEEEEE] tracking-tight leading-tight sm:leading-snug"
                                    x-text="slide.title">
                                </h2>

                                <div class="w-16 h-1 bg-gradient-to-r from-[#93F514] to-transparent rounded-full my-4">
                                </div>

                                <!-- Slide Paragraph -->
                                <p class="text-sm sm:text-base text-gray-300 font-normal leading-relaxed text-justify sm:text-left"
                                    x-text="slide.description">
                                </p>
                            </div>

                            <!-- Left-Bottom Controls & Actions -->
                            <div class="pt-4 flex flex-wrap items-center gap-3">
                                <a href="{{ route('jobs.index') }}"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#93F514] hover:bg-[#7edc0b] text-black font-extrabold text-xs sm:text-sm tracking-wide shadow-lg shadow-[#93F514]/30 transition duration-200">
                                    <span>Lihat Lowongan</span>
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>

                                <template x-if="companyWebsite">
                                    <a :href="companyWebsite" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/5 hover:bg-white/10 border border-[#93F514]/40 text-[#EEEEEE] hover:text-[#93F514] font-semibold text-xs sm:text-sm transition duration-200 backdrop-blur-sm">
                                        <svg class="w-4 h-4 text-[#93F514]" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                        <span>Kunjungi Website</span>
                                        <svg class="w-3.5 h-3.5 opacity-70" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                </template>
                            </div>
                        </div>

                        <!-- Right Column: Staggered Dynamic Photo Collage & Floating Badge -->
                        <div class="lg:col-span-7 relative flex items-center justify-center lg:justify-end py-6 lg:py-0"
                            @mouseenter="pause()" @mouseleave="resume()">
                            <div class="relative w-full max-w-[560px] h-[340px] sm:h-[390px]">

                                <!-- Main Large Photo (Left Background Layer) -->
                                <div
                                    class="absolute left-0 top-6 w-[56%] sm:w-[58%] h-[260px] sm:h-[310px] rounded-2xl sm:rounded-3xl p-1.5 bg-gradient-to-br from-[#93F514]/50 via-white/10 to-transparent shadow-2xl shadow-black/80 group">
                                    <div
                                        class="w-full h-full rounded-[14px] sm:rounded-[22px] overflow-hidden bg-black/40 border border-white/20">
                                        <img :src="slide.img1" alt="Team Collaboration"
                                            class="w-full h-full object-cover object-center transform group-hover:scale-105 transition-transform duration-500 filter brightness-95">
                                    </div>
                                </div>

                                <!-- Top-Right Secondary Photo Layer -->
                                <div
                                    class="absolute right-0 top-0 w-[48%] sm:w-[50%] h-[200px] sm:h-[235px] rounded-2xl sm:rounded-3xl p-1.5 bg-gradient-to-bl from-[#93F514]/60 via-white/15 to-transparent shadow-2xl shadow-black/90 group z-10">
                                    <div
                                        class="w-full h-full rounded-[14px] sm:rounded-[22px] overflow-hidden bg-black/40 border border-white/20">
                                        <img :src="slide.img2" alt="Professional Presentation"
                                            class="w-full h-full object-cover object-center transform group-hover:scale-105 transition-transform duration-500 filter brightness-95">
                                    </div>
                                </div>

                                <!-- Bottom Center/Right Overlapping Tertiary Photo -->
                                <div
                                    class="absolute left-[35%] sm:left-[32%] bottom-0 w-[50%] sm:w-[52%] h-[190px] sm:h-[220px] rounded-2xl sm:rounded-3xl p-1.5 bg-gradient-to-tr from-[#93F514]/60 via-white/15 to-transparent shadow-2xl shadow-black/95 group z-20">
                                    <div
                                        class="w-full h-full rounded-[14px] sm:rounded-[22px] overflow-hidden bg-black/40 border border-white/25">
                                        <img :src="slide.img3" alt="Meeting and Discussion"
                                            class="w-full h-full object-cover object-center transform group-hover:scale-105 transition-transform duration-500 filter brightness-95">
                                    </div>
                                </div>

                                <!-- Simple, Light & Modern Floating Glass Badge (Bottom Right) -->
                                <div
                                    class="absolute -right-1 sm:-right-3 bottom-2 z-30 transform hover:scale-105 transition-transform">
                                    <div
                                        class="px-3.5 py-2 sm:px-4 sm:py-2.5 rounded-xl sm:rounded-2xl bg-[#061806]/85 border border-[#93F514]/50 shadow-lg shadow-black/60 backdrop-blur-md flex items-center gap-2.5">
                                        <div class="w-2 h-2 rounded-full bg-[#93F514] animate-ping"></div>
                                        <div>
                                            <div class="text-[11px] sm:text-xs font-bold tracking-wider text-[#93F514] leading-none"
                                                x-text="slide.badgeTitle">CAREER.</div>
                                            <div class="text-[10px] text-gray-300 font-medium mt-0.5 leading-none"
                                                x-text="slide.badgeSub">Growth & Development</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </template>

                <!-- Bottom Navigation Bar: Arrows + Live Animated Progress Indicator Lines -->
                <div
                    class="mt-8 pt-6 border-t border-[#93F514]/20 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Prev / Next Navigation Arrows -->
                    <div class="flex items-center gap-3">
                        <button @click="prev()" aria-label="Previous Slide"
                            class="w-10 h-10 rounded-xl bg-[#061506] hover:bg-[#93F514] text-gray-300 hover:text-black border border-[#93F514]/40 transition-all flex items-center justify-center cursor-pointer shadow-md">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button @click="next()" aria-label="Next Slide"
                            class="w-10 h-10 rounded-xl bg-[#061506] hover:bg-[#93F514] text-gray-300 hover:text-black border border-[#93F514]/40 transition-all flex items-center justify-center cursor-pointer shadow-md">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <span class="text-xs text-gray-400 font-semibold ml-2">
                            <span class="text-[#93F514] font-bold" x-text="currentSlide + 1"></span> / <span
                                x-text="slides.length"></span>
                        </span>
                    </div>

                    <!-- Lightweight Segmented Progress Indicator Bar with Real-time Fill Animation -->
                    <div class="flex items-center gap-2.5 w-full sm:w-80">
                        <template x-for="(slide, index) in slides" :key="index">
                            <button @click="goTo(index)" :aria-label="'Go to slide ' + (index + 1)"
                                class="h-1.5 sm:h-2 flex-1 rounded-full transition-all duration-300 cursor-pointer overflow-hidden relative bg-white/10 hover:bg-white/20">
                                <!-- Background fill for active slide with smooth real-time progress -->
                                <div class="h-full bg-gradient-to-r from-[#93F514] to-[#5ef558] rounded-full transition-[width] ease-linear shadow-[0_0_10px_rgba(147, 245, 20,0.8)]"
                                    :style="currentSlide === index ?
                                        `width: ${progress}%; transition-duration: ${isPaused ? '0ms' : '50ms'};` : (
                                            currentSlide > index ? 'width: 100%; transition-duration: 0ms;' :
                                            'width: 0%; transition-duration: 0ms;')">
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

            </div>
        </section>

        <!-- ==================== ALUR PENDAFTARAN DINAMIS ==================== -->
        <section id="alur-pendaftaran"
            class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative border-t border-[#93F514]/20"
            x-data="{ activeStep: 1 }">
            <div class="text-center max-w-3xl mx-auto mb-14">
                {{-- <div class="inline-flex items-center gap-2 text-[#93F514] text-xs font-bold uppercase tracking-widest mb-3">
                <span class="w-2 h-2 rounded-full bg-[#93F514] animate-ping"></span>
                <span>Proses Seleksi Praktis</span>
            </div> --}}
                <h2 class="text-3xl sm:text-4xl font-extrabold text-[#EEEEEE]">Alur Pendaftaran & Seleksi</h2>
                <p class="mt-3 text-sm sm:text-base text-gray-300 leading-relaxed">
                    Ikuti 4 tahapan sistematis untuk bergabung menjadi bagian dari talenta terbaik kami.
                </p>

                <!-- Dynamic Tab Step Switchers -->
                <div
                    class="mt-8 inline-flex p-1.5 rounded-2xl bg-[#061206] border border-[#93F514]/30 shadow-lg gap-1.5 flex-wrap justify-center">
                    <button @click="activeStep = 1"
                        :class="activeStep === 1 ?
                            'bg-gradient-to-r from-[#93F514] to-[#5ef558] text-black font-extrabold shadow-md shadow-[#93F514]/30' :
                            'text-gray-400 hover:text-[#EEEEEE]'"
                        class="px-4 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 cursor-pointer">
                        1. Registrasi Akun
                    </button>
                    <button @click="activeStep = 2"
                        :class="activeStep === 2 ?
                            'bg-gradient-to-r from-[#93F514] to-[#5ef558] text-black font-extrabold shadow-md shadow-[#93F514]/30' :
                            'text-gray-400 hover:text-[#EEEEEE]'"
                        class="px-4 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 cursor-pointer">
                        2. Lengkapi Data & CV
                    </button>
                    <button @click="activeStep = 3"
                        :class="activeStep === 3 ?
                            'bg-gradient-to-r from-[#93F514] to-[#5ef558] text-black font-extrabold shadow-md shadow-[#93F514]/30' :
                            'text-gray-400 hover:text-[#EEEEEE]'"
                        class="px-4 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 cursor-pointer">
                        3. Tes & Seleksi Online
                    </button>
                    <button @click="activeStep = 4"
                        :class="activeStep === 4 ?
                            'bg-gradient-to-r from-[#93F514] to-[#5ef558] text-black font-extrabold shadow-md shadow-[#93F514]/30' :
                            'text-gray-400 hover:text-[#EEEEEE]'"
                        class="px-4 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-200 cursor-pointer">
                        4. Hasil & Penawaran
                    </button>
                </div>
            </div>

            <!-- Dynamic Step Content Display -->
            <div
                class="relative rounded-3xl bg-gradient-to-b from-[#071a07] via-[#051105] to-[#040804] border border-[#93F514]/40 p-8 sm:p-12 shadow-2xl shadow-[#93F514]/20 overflow-hidden">
                <div
                    class="absolute -top-24 -right-24 w-72 h-72 bg-[#93F514]/15 rounded-full blur-3xl pointer-events-none">
                </div>

                <!-- Step 1 Content -->
                <div x-show="activeStep === 1" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
                    class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-7 space-y-4">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-[#93F514]/15 border border-[#93F514]/40 text-[#93F514] text-xs font-bold">
                            Tahap 01 - Registrasi Pengguna
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#EEEEEE]">Buat Akun Pelamar dengan Mudah</h3>
                        <p class="text-sm sm:text-base text-gray-300 leading-relaxed">
                            Lakukan registrasi menggunakan Nama, NIK valid, dan Email aktif Anda. Akun ini akan menjadi
                            pusat seluruh aktivitas pelamaran, ujian seleksi, hingga penerimaan kerja.
                        </p>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-gray-300 pt-2">
                            <li class="flex items-center gap-2.5">
                                <span
                                    class="w-5 h-5 rounded-full bg-[#93F514]/20 text-[#93F514] flex items-center justify-center font-bold text-xs">&check;</span>
                                <span>Verifikasi data diri yang cepat dan aman</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span
                                    class="w-5 h-5 rounded-full bg-[#93F514]/20 text-[#93F514] flex items-center justify-center font-bold text-xs">&check;</span>
                                <span>Dapat diakses kapan saja melalui smartphone atau desktop</span>
                            </li>
                        </ul>
                        <div class="pt-4">
                            @auth
                                @php
                                    $isAdminOrRecruiter =
                                        auth()->user()->role_id == 1 ||
                                        auth()->user()->role_id == 2 ||
                                        in_array(strtolower(auth()->user()->role?->name ?? ''), [
                                            'admin',
                                            'superadmin',
                                            'recruiter',
                                        ]);
                                    $dashRoute = $isAdminOrRecruiter
                                        ? (auth()->user()->role_id == 2 ||
                                        strtolower(auth()->user()->role?->name ?? '') === 'recruiter'
                                            ? route('recruiter.dashboard')
                                            : route('admin.dashboard'))
                                        : route('profile');
                                @endphp
                                <a href="{{ $dashRoute }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#93F514] text-black font-bold text-xs sm:text-sm hover:bg-[#7edc0b] transition shadow-lg shadow-[#93F514]/30">
                                    {{ $isAdminOrRecruiter ? 'Buka Dashboard Admin' : 'Buka Profil Saya' }}
                                </a>
                            @else
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#93F514] text-black font-bold text-xs sm:text-sm hover:bg-[#7edc0b] transition shadow-lg shadow-[#93F514]/30">
                                    Daftar Akun Sekarang &rarr;
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="lg:col-span-5 flex justify-center">
                        <div
                            class="w-full max-w-sm p-6 rounded-2xl bg-[#050e05] border border-[#93F514]/30 shadow-xl space-y-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-[#93F514]/15 border border-[#93F514]/40 flex items-center justify-center text-[#93F514]">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-[#EEEEEE] text-base">Tips Registrasi</h4>
                            <p class="text-xs text-gray-400 leading-relaxed">
                                Pastikan nomor NIK dan Email yang didaftarkan aktif untuk menerima notifikasi status
                                kelulusan berkas dan jadwal ujian.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 2 Content -->
                <div x-show="activeStep === 2" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
                    class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-7 space-y-4">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-[#93F514]/15 border border-[#93F514]/40 text-[#93F514] text-xs font-bold">
                            Tahap 02 - Kelengkapan Profil
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#EEEEEE]">Lengkapi Biodata, Riwayat & CV</h3>
                        <p class="text-sm sm:text-base text-gray-300 leading-relaxed">
                            Isi form riwayat pendidikan, pengalaman kerja, keahlian khusus, kontak sosial media, dan unggah
                            berkas pendukung (KTP, Ijazah, Transkrip, Sertifikat).
                        </p>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-gray-300 pt-2">
                            <li class="flex items-center gap-2.5">
                                <span
                                    class="w-5 h-5 rounded-full bg-[#93F514]/20 text-[#93F514] flex items-center justify-center font-bold text-xs">&check;</span>
                                <span>Fitur Generate & Preview CV otomatis</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span
                                    class="w-5 h-5 rounded-full bg-[#93F514]/20 text-[#93F514] flex items-center justify-center font-bold text-xs">&check;</span>
                                <span>Pembaruan profil fleksibel setiap saat</span>
                            </li>
                        </ul>
                    </div>
                    <div class="lg:col-span-5 flex justify-center">
                        <div
                            class="w-full max-w-sm p-6 rounded-2xl bg-[#050e05] border border-[#93F514]/30 shadow-xl space-y-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-[#93F514]/15 border border-[#93F514]/40 flex items-center justify-center text-[#93F514]">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-[#EEEEEE] text-base">Kelengkapan Berkas</h4>
                            <p class="text-xs text-gray-400 leading-relaxed">
                                Profil yang terisi 100% lengkap memiliki peluang 3x lebih cepat untuk lolos tahap seleksi
                                administrasi oleh tim HRD.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 3 Content -->
                <div x-show="activeStep === 3" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
                    class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-7 space-y-4">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-[#93F514]/15 border border-[#93F514]/40 text-[#93F514] text-xs font-bold">
                            Tahap 03 - Asesmen Online
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#EEEEEE]">Ikuti Ujian CBT Terintegrasi</h3>
                        <p class="text-sm sm:text-base text-gray-300 leading-relaxed">
                            Setelah berkas disetujui, Anda dapat langsung mengerjakan ujian tes online (Pilihan Ganda &
                            Essay) sesuai paket uji bidang keahlian dari rekruter.
                        </p>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-gray-300 pt-2">
                            <li class="flex items-center gap-2.5">
                                <span
                                    class="w-5 h-5 rounded-full bg-[#93F514]/20 text-[#93F514] flex items-center justify-center font-bold text-xs">&check;</span>
                                <span>Timer pengerjaan real-time dan penilaian transparan</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span
                                    class="w-5 h-5 rounded-full bg-[#93F514]/20 text-[#93F514] flex items-center justify-center font-bold text-xs">&check;</span>
                                <span>Kategori soal disesuaikan dengan posisi lamaran</span>
                            </li>
                        </ul>
                    </div>
                    <div class="lg:col-span-5 flex justify-center">
                        <div
                            class="w-full max-w-sm p-6 rounded-2xl bg-[#050e05] border border-[#93F514]/30 shadow-xl space-y-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-[#93F514]/15 border border-[#93F514]/40 flex items-center justify-center text-[#93F514]">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-[#EEEEEE] text-base">Sistem Ujian Online</h4>
                            <p class="text-xs text-gray-400 leading-relaxed">
                                Kerjakan soal dengan cermat dan stabilkan koneksi internet Anda selama proses ujian
                                berlangsung.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 4 Content -->
                <div x-show="activeStep === 4" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
                    class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-7 space-y-4">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-[#93F514]/15 border border-[#93F514]/40 text-[#93F514] text-xs font-bold">
                            Tahap 04 - Hasil & Penawaran
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#EEEEEE]">Pengumuman & Penawaran Karir</h3>
                        <p class="text-sm sm:text-base text-gray-300 leading-relaxed">
                            Pantau status kelulusan secara transparan di dashboard Anda. Kandidat terpilih akan langsung
                            menerima instruksi tahap penawaran kerja (*Offering Letter*).
                        </p>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-gray-300 pt-2">
                            <li class="flex items-center gap-2.5">
                                <span
                                    class="w-5 h-5 rounded-full bg-[#93F514]/20 text-[#93F514] flex items-center justify-center font-bold text-xs">&check;</span>
                                <span>Notifikasi hasil evaluasi langsung ke akun Anda</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span
                                    class="w-5 h-5 rounded-full bg-[#93F514]/20 text-[#93F514] flex items-center justify-center font-bold text-xs">&check;</span>
                                <span>Proses terstruktur tanpa biaya pendaftaran (Gratis)</span>
                            </li>
                        </ul>
                    </div>
                    <div class="lg:col-span-5 flex justify-center">
                        <div
                            class="w-full max-w-sm p-6 rounded-2xl bg-[#050e05] border border-[#93F514]/30 shadow-xl space-y-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-[#93F514]/15 border border-[#93F514]/40 flex items-center justify-center text-[#93F514]">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-[#EEEEEE] text-base">Selamat Bergabung!</h4>
                            <p class="text-xs text-gray-400 leading-relaxed">
                                Siapkan diri Anda untuk melangkah ke babak baru perjalanan karir profesional masa depan
                                bersama MAKNA.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ==================== KATEGORI DEPARTEMEN ==================== -->
        <section id="kategori"
            class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative border-t border-[#93F514]/20">
            <div class="mb-8">
                {{-- <div class="inline-flex items-center gap-2 text-[#93F514] text-xs font-bold uppercase tracking-widest mb-2">
                <span class="w-2 h-2 rounded-full bg-[#93F514]"></span> Bidang Karir
            </div> --}}
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#EEEEEE]">Kategori Departemen</h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($departments as $dept)
                    <a href="{{ route('jobs.index', ['department_id' => $dept->id]) }}"
                        class="group p-5 rounded-2xl bg-gradient-to-b from-[#061506] to-[#040804] border border-[#93F514]/30 hover:border-[#93F514] hover:shadow-xl hover:shadow-[#93F514]/20 transition-all duration-300 flex flex-col justify-between">
                        <div
                            class="w-10 h-10 rounded-xl bg-[#93F514]/15 border border-[#93F514]/40 flex items-center justify-center text-[#93F514] group-hover:bg-[#93F514] group-hover:text-black transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="mt-4">
                            <h3
                                class="font-bold text-[#EEEEEE] group-hover:text-[#93F514] transition-colors text-sm sm:text-base">
                                {{ $dept->name }}
                            </h3>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-xs text-gray-400">Belum ada data departemen.</div>
                @endforelse
            </div>
        </section>

        <!-- ==================== CALL TO ACTION BANNER ==================== -->
        <section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div
                class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-[#041a04] via-[#062906] to-[#031203] border border-[#93F514]/50 p-8 sm:p-12 text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-8 shadow-2xl shadow-[#93F514]/20">
                <div class="max-w-xl z-10">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#EEEEEE] leading-tight">
                        Siap Memulai Karir Baru Bersama Kami?
                    </h2>
                    <p class="mt-2 text-sm text-gray-300 leading-relaxed">
                        Daftar akun sekarang dan ikuti seleksi online untuk posisi pekerjaan impian Anda.
                    </p>
                </div>

                <div class="z-10 flex flex-col sm:flex-row items-center gap-3 shrink-0">
                    @auth
                        @php
                            $isAdminOrRecruiter =
                                auth()->user()->role_id == 1 ||
                                auth()->user()->role_id == 2 ||
                                in_array(strtolower(auth()->user()->role?->name ?? ''), [
                                    'admin',
                                    'superadmin',
                                    'recruiter',
                                ]);
                            $dashRoute = $isAdminOrRecruiter
                                ? (auth()->user()->role_id == 2 ||
                                strtolower(auth()->user()->role?->name ?? '') === 'recruiter'
                                    ? route('recruiter.dashboard')
                                    : route('admin.dashboard'))
                                : route('profile');
                        @endphp
                        <a href="{{ $dashRoute }}"
                            class="px-8 py-3.5 rounded-full bg-gradient-to-r from-[#93F514] to-[#5ef558] hover:from-[#7edc0b] hover:to-[#43e63d] text-black font-extrabold text-sm shadow-xl shadow-[#93F514]/30 transition-all duration-300">
                            {{ $isAdminOrRecruiter ? 'Buka Panel Dashboard' : 'Buka Profil Pelamar' }}
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-gradient-to-r from-[#93F514] to-[#5ef558] hover:from-[#7edc0b] hover:to-[#43e63d] text-black font-extrabold text-sm shadow-xl shadow-[#93F514]/30 transition-all duration-300 text-center">
                            Daftar Akun Sekarang
                        </a>
                        <a href="{{ route('login') }}"
                            class="w-full sm:w-auto px-6 py-3.5 rounded-full bg-black/50 hover:bg-black/80 border border-[#93F514]/50 text-[#EEEEEE] font-semibold text-sm transition text-center">
                            Masuk Akun
                        </a>
                    @endauth
                </div>
            </div>
        </section>

    </div>
@endsection
