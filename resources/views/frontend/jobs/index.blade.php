@extends('frontend.layouts.app')

@section('title', 'Lowongan | Mika Career')

@section('content')
    <div class="relative py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

        <!-- Page Header (Dark & #93F514 Neon Gradient) -->
        <div
            class="reveal-on-scroll relative rounded-3xl bg-gradient-to-r from-[#051c05] via-[#072907] to-[#031103] border border-[#93F514]/40 p-8 sm:p-12 mb-10 overflow-hidden shadow-2xl shadow-[#93F514]/15">
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-[#93F514]/15 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="relative z-10 max-w-2xl">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#EEEEEE] leading-tight">
                    Jelajahi <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-[#93F514] via-[#75f06a] to-[#5FE6B6]">Lowongan
                        Pekerjaan</span>
                </h1>
                <p class="mt-3 text-sm sm:text-base text-gray-300">
                    Temukan posisi yang sesuai dengan keahlian, minat, dan kualifikasi Anda. Lamar sekarang dan ikuti
                    tahapan seleksi terintegrasi.
                </p>
            </div>
        </div>

        <!-- Filter & Search Bar (Clean Segmented Solid Light Pill Bar, samakan dengan Beranda) -->
        <div class="reveal-on-scroll relative z-30 w-full mb-10 p-2 sm:p-2.5 rounded-2xl lg:rounded-full bg-[#EEEEEE] text-gray-800 shadow-2xl shadow-black/80 border border-white/40"
            style="background-color: #EEEEEE !important;" data-delay="100">
            <form action="{{ route('jobs.index') }}" method="GET"
                class="flex flex-col lg:flex-row items-center gap-2 lg:gap-0 divide-y lg:divide-y-0 lg:divide-x divide-gray-300">

                <!-- Keyword Search -->
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
                <div class="w-full lg:w-56 relative" :class="open ? 'z-50' : 'z-10'" x-data="{
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
                        let el = this.$root.querySelector('input[name=\'_jobs_temp_company\']:checked');
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
                            :class="open ? 'rotate-180 text-[#93F514]' : (selected ? 'text-[#93F514]' : '')" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
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
                            <input type="radio" name="_jobs_temp_company" value="" x-model="tempSelected"
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
                                            <input type="radio" name="_jobs_temp_company" value="{{ $comp->id }}"
                                                x-model="tempSelected"
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
                <div class="w-full lg:w-56 relative" :class="open ? 'z-50' : 'z-10'" x-data="{
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
                        let el = this.$root.querySelector('input[name=\'_jobs_temp_department\']:checked');
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
                            :class="open ? 'rotate-180 text-[#93F514]' : (selected ? 'text-[#93F514]' : '')" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                            <input type="radio" name="_jobs_temp_department" value="" x-model="tempSelected"
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
                                            <input type="radio" name="_jobs_temp_department"
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
                <div class="w-full lg:w-48 relative" :class="open ? 'z-50' : 'z-10'" x-data="{
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
                            :class="open ? 'rotate-180 text-[#93F514]' : (selected ? 'text-[#93F514]' : '')" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                            <input type="radio" name="_jobs_temp_type" value="" x-model="tempSelected"
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
                                        class="flex items-center gap-2.5 py-1.5 px-1.5 rounded-lg text-xs text-gray-600 hover:text-black hover:bg-gray-50 cursor-pointer transition"
                                        x-show="!search || type.toLowerCase().includes(search.toLowerCase())">
                                        <input type="radio" name="_jobs_temp_type" :value="type"
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
                        <a href="{{ route('jobs.index') }}" title="Reset Filter"
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

        <div x-data="{
            viewMode: localStorage.getItem('mika_jobs_view') || 'grid',
            setView(mode) {
                this.viewMode = mode;
                localStorage.setItem('mika_jobs_view', mode);
            }
        }">
            <!-- Jobs Header / Title & View Mode Controls -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-[#EEEEEE]">
                        @if (request('company_id'))
                            Lowongan di <span
                                class="text-[#93F514]">{{ $companies->firstWhere('id', request('company_id'))?->name ?? 'Perusahaan Terpilih' }}</span>
                        @else
                            Daftar <span class="text-[#93F514]">Semua Lowongan</span>
                        @endif
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5">
                        Menampilkan total <strong class="text-[#93F514]">{{ $jobs->total() }}</strong> posisi lowongan kerja
                    </p>
                </div>

                <div class="flex items-center gap-3 self-end sm:self-auto">
                    @if (request('company_id') || request('search') || request('department_id') || request('employment_type'))
                        <a href="{{ route('jobs.index') }}"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#93F514] hover:text-[#52fa4d] transition shrink-0 px-3 py-1.5 rounded-xl bg-[#93F514]/10 border border-[#93F514]/30 hover:bg-[#93F514]/20">
                            <span>Reset Filter</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif

                    <!-- View Mode Toggle Pill (Grid / List Switcher) -->
                    <div class="view-mode-toggle-pill inline-flex items-center p-1 rounded-2xl bg-[#061506] border border-[#93F514]/30 shadow-inner">
                        <!-- Grid View Button -->
                        <button type="button" @click="setView('grid')"
                            :class="viewMode === 'grid'
                                ? 'bg-[#93F514] text-black shadow-md font-bold'
                                : 'text-gray-400 hover:text-[#93F514] bg-transparent'"
                            class="px-3 py-2 rounded-xl transition-all duration-200 flex items-center justify-center cursor-pointer outline-none"
                            title="Tampilan Grid">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <rect x="2" y="2" width="4.5" height="4.5" rx="1" />
                                <rect x="8" y="2" width="4.5" height="4.5" rx="1" />
                                <rect x="14" y="2" width="4.5" height="4.5" rx="1" />
                                <rect x="2" y="8" width="4.5" height="4.5" rx="1" />
                                <rect x="8" y="8" width="4.5" height="4.5" rx="1" />
                                <rect x="14" y="8" width="4.5" height="4.5" rx="1" />
                                <rect x="2" y="14" width="4.5" height="4.5" rx="1" />
                                <rect x="8" y="14" width="4.5" height="4.5" rx="1" />
                                <rect x="14" y="14" width="4.5" height="4.5" rx="1" />
                            </svg>
                        </button>

                        <!-- List View Button -->
                        <button type="button" @click="setView('list')"
                            :class="viewMode === 'list'
                                ? 'bg-[#93F514] text-black shadow-md font-bold'
                                : 'text-gray-400 hover:text-[#93F514] bg-transparent'"
                            class="px-3 py-2 rounded-xl transition-all duration-200 flex items-center justify-center cursor-pointer outline-none"
                            title="Tampilan List">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <rect x="2" y="3" width="3.5" height="3.5" rx="0.8" />
                                <rect x="7.5" y="3.5" width="10.5" height="2.5" rx="1" />
                                <rect x="2" y="8.5" width="3.5" height="3.5" rx="0.8" />
                                <rect x="7.5" y="9" width="10.5" height="2.5" rx="1" />
                                <rect x="2" y="14" width="3.5" height="3.5" rx="0.8" />
                                <rect x="7.5" y="14.5" width="10.5" height="2.5" rx="1" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Jobs Content: Grid Mode -->
            <div x-show="viewMode === 'grid'" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($jobs as $job)
                    <div
                        class="job-card-item reveal-on-scroll group relative rounded-3xl bg-gradient-to-b from-[#061506] to-[#030803] border border-[#93F514]/30 hover:border-[#93F514] p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-2xl hover:shadow-[#93F514]/20 hover:-translate-y-1"
                        data-delay="{{ ($loop->index % 6) * 100 }}">
                        <div>
                            <!-- Header Card -->
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <div class="flex items-center gap-3">
                                    @if ($job->company?->logo_url)
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-[#051205] border border-[#93F514]/40 p-1.5 flex items-center justify-center shrink-0 overflow-hidden shadow-md shadow-[#93F514]/15">
                                            <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}"
                                                class="w-full h-full object-contain">
                                        </div>
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-[#93F514]/15 border border-[#93F514]/40 flex items-center justify-center text-[#93F514] font-extrabold text-lg shrink-0">
                                            {{ strtoupper(substr($job->company?->name ?? 'M', 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                            {{ $job->company?->name ?? 'Perusahaan Mitra' }}
                                        </h4>
                                        <div class="flex items-center gap-1.5 flex-wrap mt-0.5">
                                            <span class="text-xs text-[#93F514] font-semibold">
                                                {{ $job->department?->name ?? 'Umum' }}
                                            </span>
                                            @if ($job->position)
                                                <span class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 rounded-full bg-[#93F514]/10 text-[#93F514] border border-[#93F514]/30 font-semibold">
                                                    <span>{{ $job->position->name }}</span>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold bg-[#93F514]/15 border border-[#93F514]/40 text-[#93F514] shrink-0">
                                    {{ $job->employment_type }}
                                </span>
                            </div>

                            <!-- Job Title -->
                            <a href="{{ route('jobs.show', $job->id) }}">
                                <h3
                                    class="text-lg font-bold text-[#EEEEEE] group-hover:text-[#93F514] transition-colors line-clamp-1">
                                    {{ $job->title }}
                                </h3>
                            </a>

                            <!-- Description -->
                            <p class="text-sm text-gray-400 mt-2 line-clamp-2 leading-relaxed">
                                {{ !empty($job->description) ? trim(preg_replace('/\s+/', ' ', strip_tags($job->description))) : 'Klik tombol detail untuk membaca rincian kualifikasi dan persyaratan lowongan pekerjaan ini.' }}
                            </p>

                            <!-- Details -->
                            <div class="mt-5 space-y-2.5 pt-4 border-t border-[#93F514]/15">
                                <div class="flex items-center gap-2 text-xs text-gray-300">
                                    <svg class="w-4 h-4 text-[#93F514] shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    <span>{{ $job->location ?? 'Indonesia' }}</span>
                                </div>

                                @if ($job->salary_min || $job->salary_max)
                                    <div class="flex items-center gap-2 text-xs text-[#93F514] font-semibold">
                                        <svg class="w-4 h-4 text-[#93F514] shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>
                                            Rp {{ number_format($job->salary_min, 0, ',', '.') }} -
                                            {{ number_format($job->salary_max, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endif

                                @if ($job->deadline)
                                    <div class="flex items-center gap-2 text-xs {{ $job->days_remaining === 0 ? 'text-rose-400 font-bold' : ($job->days_remaining !== null && $job->days_remaining <= 3 ? 'text-amber-400 font-semibold' : 'text-gray-400') }}">
                                        <svg class="w-4 h-4 {{ $job->days_remaining === 0 ? 'text-rose-400' : ($job->days_remaining !== null && $job->days_remaining <= 3 ? 'text-amber-400' : 'text-[#93F514]') }} shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>
                                            @if ($job->days_remaining === 0)
                                                Berakhir Hari Ini!
                                            @elseif ($job->days_remaining !== null && $job->days_remaining <= 3)
                                                Sisa {{ $job->days_remaining }} Hari ({{ \Carbon\Carbon::parse($job->deadline)->format('d M') }})
                                            @else
                                                Batas: {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Footer Card Action -->
                        <div class="mt-6 pt-4 border-t border-[#93F514]/15 flex items-center justify-between gap-3">
                            <span class="text-xs text-gray-400">Kuota: <strong
                                    class="text-[#EEEEEE]">{{ $job->quota }}</strong></span>
                            <a href="{{ route('jobs.show', $job->id) }}"
                                class="px-4 py-2 rounded-full bg-[#93F514] hover:bg-[#7edc0b] text-black font-extrabold text-xs shadow-md transition">
                                Detail & Lamar
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center rounded-3xl bg-[#050e05] border border-[#93F514]/30">
                        <div
                            class="w-16 h-16 mx-auto rounded-full bg-[#93F514]/15 flex items-center justify-center text-[#93F514] mb-4">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#EEEEEE]">Tidak Ada Lowongan Ditemukan</h3>
                        <p class="text-xs sm:text-sm text-gray-400 mt-1">
                            Silakan ubah filter atau kata kunci pencarian Anda.
                        </p>
                        <a href="{{ route('jobs.index') }}"
                            class="inline-block mt-4 px-5 py-2 rounded-full bg-[#93F514] text-black font-extrabold text-xs">
                            Reset Semua Filter
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Jobs Content: List Mode -->
            <div x-show="viewMode === 'list'" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="flex flex-col gap-4">
                @forelse($jobs as $job)
                    <div
                        class="job-card-item reveal-on-scroll group relative rounded-3xl bg-gradient-to-r from-[#061506] via-[#051205] to-[#030803] border border-[#93F514]/30 hover:border-[#93F514] p-5 sm:p-6 transition-all duration-300 hover:shadow-2xl hover:shadow-[#93F514]/15 hover:-translate-y-0.5 flex flex-col md:flex-row items-start md:items-center justify-between gap-5"
                        data-delay="{{ ($loop->index % 6) * 80 }}">
                        
                        <!-- Left / Main Info -->
                        <div class="flex items-start sm:items-center gap-4.5 flex-1 min-w-0">
                            <!-- Logo -->
                            @if ($job->company?->logo_url)
                                <div class="w-14 h-14 mr-5 rounded-2xl bg-[#051205] border border-[#93F514]/40 p-2 flex items-center justify-center shrink-0 overflow-hidden shadow-md shadow-[#93F514]/15">
                                    <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}" class="w-full h-full object-contain">
                                </div>
                            @else
                                <div class="w-14 h-14 mr-5 rounded-2xl bg-[#93F514]/15 border border-[#93F514]/40 flex items-center justify-center text-[#93F514] font-extrabold text-xl shrink-0">
                                    {{ strtoupper(substr($job->company?->name ?? 'M', 0, 2)) }}
                                </div>
                            @endif

                            <div class="flex-1 min-w-0 space-y-1.5">
                                <!-- Header Badges -->
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        {{ $job->company?->name ?? 'Perusahaan Mitra' }}
                                    </span>
                                    <span class="text-xs text-[#93F514] font-semibold">
                                        {{ $job->department?->name ?? 'Umum' }}
                                    </span>
                                    @if ($job->position)
                                        <span class="inline-flex items-center gap-1 text-[11px] px-2.5 py-0.5 rounded-full bg-[#93F514]/10 text-[#93F514] border border-[#93F514]/30 font-semibold">
                                            <span>Posisi: {{ $job->position->name }}</span>
                                        </span>
                                    @endif
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#93F514]/15 border border-[#93F514]/40 text-[#93F514]">
                                        {{ $job->employment_type }}
                                    </span>
                                </div>

                                <!-- Job Title -->
                                <a href="{{ route('jobs.show', $job->id) }}" class="block">
                                    <h3 class="text-lg sm:text-xl font-bold text-[#EEEEEE] group-hover:text-[#93F514] transition-colors truncate">
                                        {{ $job->title }}
                                    </h3>
                                </a>

                                <!-- Meta Badges: Location, Salary, Deadline, Quota -->
                                <div class="flex flex-wrap items-center gap-y-1.5 gap-x-4 text-xs text-gray-400 pt-1">
                                    <div class="flex items-center gap-1.5 text-gray-300">
                                        <svg class="w-4 h-4 text-[#93F514] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        <span>{{ $job->location ?? 'Indonesia' }}</span>
                                    </div>

                                    @if ($job->salary_min || $job->salary_max)
                                        <div class="flex items-center gap-1.5 text-[#93F514] font-semibold">
                                            <svg class="w-4 h-4 text-[#93F514] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Rp {{ number_format($job->salary_min, 0, ',', '.') }} - {{ number_format($job->salary_max, 0, ',', '.') }}</span>
                                        </div>
                                    @endif

                                    @if ($job->deadline)
                                        <div class="flex items-center gap-1.5 text-xs {{ $job->days_remaining === 0 ? 'text-rose-400 font-bold' : ($job->days_remaining !== null && $job->days_remaining <= 3 ? 'text-amber-400 font-semibold' : 'text-gray-400') }}">
                                            <svg class="w-4 h-4 {{ $job->days_remaining === 0 ? 'text-rose-400' : ($job->days_remaining !== null && $job->days_remaining <= 3 ? 'text-amber-400' : 'text-[#93F514]') }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>
                                                @if ($job->days_remaining === 0)
                                                    Berakhir Hari Ini!
                                                @elseif ($job->days_remaining !== null && $job->days_remaining <= 3)
                                                    Sisa {{ $job->days_remaining }} Hari ({{ \Carbon\Carbon::parse($job->deadline)->format('d M') }})
                                                @else
                                                    Batas: {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <span class="text-gray-400">Kuota: <strong class="text-[#EEEEEE]">{{ $job->quota }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <!-- Right / Action -->
                        <div class="w-full md:w-auto flex md:flex-col items-center md:items-end justify-between md:justify-center gap-3 shrink-0 pt-3 md:pt-0 border-t md:border-t-0 border-[#93F514]/15">
                            <a href="{{ route('jobs.show', $job->id) }}"
                                class="w-full md:w-auto px-6 py-2.5 rounded-full bg-[#93F514] hover:bg-[#7edc0b] text-black font-extrabold text-xs sm:text-sm shadow-md shadow-[#93F514]/20 transition text-center">
                                Detail & Lamar
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-16 text-center rounded-3xl bg-[#050e05] border border-[#93F514]/30">
                        <div
                            class="w-16 h-16 mx-auto rounded-full bg-[#93F514]/15 flex items-center justify-center text-[#93F514] mb-4">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#EEEEEE]">Tidak Ada Lowongan Ditemukan</h3>
                        <p class="text-xs sm:text-sm text-gray-400 mt-1">
                            Silakan ubah filter atau kata kunci pencarian Anda.
                        </p>
                        <a href="{{ route('jobs.index') }}"
                            class="inline-block mt-4 px-5 py-2 rounded-full bg-[#93F514] text-black font-extrabold text-xs">
                            Reset Semua Filter
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-10 mb-16">
            {{ $jobs->links('frontend.components.pagination') }}
        </div>

        <!-- Temukan Lowongan Berdasarkan Perusahaan (Di Bawah Menu Daftar Lowongan & Rata Tengah) -->
        @if (isset($companies) && $companies->count() > 0)
            <div class="pt-12 border-t border-[#93F514]/20">
                <!-- Header Rata Tengah -->
                <div class="text-center max-w-3xl mx-auto mb-8">
                    {{-- <div class="inline-flex items-center gap-2 text-[#93F514] text-xs font-bold uppercase tracking-wider mb-2">
                    <span class="w-2 h-2 rounded-full bg-[#93F514] animate-pulse"></span>
                    <span>Perusahaan Mitra</span>
                </div> --}}
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[#EEEEEE]">
                        Temukan Lowongan Berdasarkan <span class="text-[#93F514]">Perusahaan</span>
                    </h2>
                    <p class="mt-3 text-sm sm:text-base text-gray-300 leading-relaxed">
                        Pilih perusahaan mitra untuk melihat lowongan kerja dan karir yang sedang dibuka.
                    </p>

                    @if (request('company_id'))
                        <div class="mt-3">
                            <a href="{{ route('jobs.index', array_merge(request()->except('company_id', 'page'))) }}"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#93F514] hover:text-[#52fa4d] bg-[#93F514]/10 px-3 py-1 rounded-full border border-[#93F514]/30 transition">
                                <span>Tampilkan Semua Perusahaan</span>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Grid Card Perusahaan (Rata Tengah) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5 justify-center">
                    @foreach ($companies as $comp)
                        @php
                            $isActive = request('company_id') == $comp->id;
                            $jobCount = $comp->jobs_count ?? $comp->jobs()->where('status', 'Open')->count();
                        @endphp
                        <a href="{{ route('jobs.index', array_merge(request()->except('page'), ['company_id' => $comp->id])) }}"
                            class="group relative rounded-2xl p-5 border transition-all duration-300 flex flex-col justify-between
                              {{ $isActive
                                  ? 'bg-gradient-to-b from-[#0a2e0a] to-[#041404] border-[#93F514] shadow-lg shadow-[#93F514]/25 ring-1 ring-[#93F514]'
                                  : 'bg-gradient-to-b from-[#061506] to-[#030a03] border-[#93F514]/25 hover:border-[#93F514] hover:shadow-xl hover:shadow-[#93F514]/20 hover:-translate-y-1' }}">

                            <div class="flex items-start gap-3.5">
                                <!-- Logo Perusahaan -->
                                @if ($comp->logo_url)
                                    <div
                                        class="w-14 h-14 rounded-xl bg-[#051205] border border-[#93F514]/30 p-2 flex items-center justify-center shrink-0 overflow-hidden shadow-sm group-hover:border-[#93F514] transition-colors">
                                        <img src="{{ $comp->logo_url }}" alt="{{ $comp->name }}"
                                            class="w-full h-full object-contain">
                                    </div>
                                @else
                                    <div
                                        class="w-14 h-14 rounded-xl bg-[#93F514]/15 border border-[#93F514]/40 flex items-center justify-center text-[#93F514] font-extrabold text-lg shrink-0 group-hover:bg-[#93F514]/25 transition-colors">
                                        {{ strtoupper(substr($comp->name, 0, 2)) }}
                                    </div>
                                @endif

                                <!-- Nama Perusahaan & Lokasi/Kota -->
                                <div class="flex-1 min-w-0">
                                    <h3
                                        class="text-sm font-bold text-[#EEEEEE] group-hover:text-[#93F514] transition-colors truncate">
                                        {{ $comp->name }}
                                    </h3>
                                    <p class="text-xs text-gray-400 mt-0.5 truncate">
                                        {{ $comp->city ?? ($comp->province ?? 'Mitra Perusahaan') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Footer: Lowongan Tersedia Badge -->
                            <div class="mt-4 pt-3 border-t border-[#93F514]/15 flex items-center justify-between">
                                <span
                                    class="inline-flex items-center gap-1.5 text-xs {{ $jobCount > 0 ? 'text-[#93F514] font-bold' : 'text-gray-400' }}">
                                    <span>{{ $jobCount }} Lowongan Tersedia</span>
                                </span>

                                <span
                                    class="text-xs text-gray-400 group-hover:text-[#93F514] group-hover:translate-x-0.5 transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
