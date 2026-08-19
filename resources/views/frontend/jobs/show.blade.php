@extends('frontend.layouts.app')

@section('title', $job->title . ' - ' . ($job->company?->name ?? 'Perusahaan') . ' | MAKNA E-Recruitment')

@section('content')
<div class="relative py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto"
     x-data="{
         showConfirmModal: false,
         showIncompleteModal: false,
         isSubmitting: false,
         isMandatoryComplete: {{ ($isMandatoryComplete ?? false) ? 'true' : 'false' }},
         hasApplied: {{ ($hasApplied ?? false) ? 'true' : 'false' }},
         missingSections: {{ json_encode($missingMandatorySections ?? []) }},
         handleApplyClick() {
             if (this.hasApplied) return;
             if (!this.isMandatoryComplete) {
                 this.showIncompleteModal = true;
             } else {
                 this.showConfirmModal = true;
             }
         }
     }">

    <!-- Flash Messages (Success / Error / Info) -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/40 text-emerald-400 flex items-center justify-between shadow-xl shadow-emerald-500/10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <span class="font-bold text-sm block">Lamaran Berhasil Diajukan!</span>
                    <span class="text-xs text-gray-300">{{ session('success') }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('profile', ['tab' => 'riwayat']) }}" class="px-3.5 py-1.5 rounded-xl bg-emerald-500 text-black font-bold text-xs hover:bg-emerald-400 transition">
                    Lihat Riwayat
                </a>
                <button @click="show = false" class="text-emerald-400/80 hover:text-emerald-300">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-2xl bg-blue-500/15 border border-blue-500/40 text-blue-400 flex items-center justify-between shadow-xl shadow-blue-500/10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-blue-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <span class="font-bold text-sm block">Informasi</span>
                    <span class="text-xs text-gray-300">{{ session('info') }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('profile', ['tab' => 'riwayat']) }}" class="px-3.5 py-1.5 rounded-xl bg-blue-500 text-white font-bold text-xs hover:bg-blue-400 transition">
                    Riwayat Lamaran
                </a>
                <button @click="show = false" class="text-blue-400/80 hover:text-blue-300">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-2xl bg-rose-500/15 border border-rose-500/40 text-rose-400 flex items-center justify-between shadow-xl shadow-rose-500/10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-rose-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <span class="font-bold text-sm block">Perhatian</span>
                    <span class="text-xs text-gray-300">{{ session('error') }}</span>
                </div>
            </div>
            <button @click="show = false" class="text-rose-400/80 hover:text-rose-300">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-[#08CB00] transition">Beranda</a>
        <span>/</span>
        <a href="{{ route('jobs.index') }}" class="hover:text-[#08CB00] transition">Lowongan</a>
        <span>/</span>
        <span class="text-[#08CB00] font-medium truncate max-w-xs sm:max-w-md">{{ $job->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Main Job Details (8 cols) -->
        <div class="lg:col-span-8 space-y-8">

            <!-- Job Header Card -->
            <div
                class="rounded-3xl bg-gradient-to-b from-[#061506] to-[#040804] border border-[#08CB00]/30 p-6 sm:p-8 shadow-2xl shadow-[#08CB00]/15">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div class="flex items-start gap-4">
                        @if ($job->company?->logo_url)
                            <div
                                class="w-16 h-16 rounded-2xl bg-[#051205] border border-[#08CB00]/40 p-2 flex items-center justify-center shadow-lg shadow-[#08CB00]/20 shrink-0 overflow-hidden">
                                <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}"
                                    class="w-full h-full object-contain">
                            </div>
                        @else
                            <div
                                class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#08CB00] to-[#5ef558] flex items-center justify-center text-black font-extrabold text-2xl shadow-lg shadow-[#08CB00]/25 shrink-0">
                                {{ strtoupper(substr($job->company?->name ?? 'M', 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <span
                                class="px-3 py-1 rounded-full text-xs font-semibold bg-[#08CB00]/15 border border-[#08CB00]/40 text-[#08CB00]">
                                {{ $job->employment_type }}
                            </span>
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#EEEEEE] mt-2">
                                {{ $job->title }}
                            </h1>
                            <p class="text-sm text-[#08CB00] font-medium mt-1">
                                {{ $job->company?->name ?? 'Perusahaan Mitra' }} &bull; <span
                                    class="text-gray-400">{{ $job->department?->name ?? 'Umum' }}</span>
                            </p>
                        </div>
                    </div>

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
                        @endphp

                        @if ($isAdminOrRecruiter)
                            <div class="flex flex-col sm:flex-row items-center gap-3">
                                <div
                                    class="px-4 py-2.5 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold text-center flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>Akun {{ auth()->user()->role?->name ?? 'Admin/Staff' }} tidak dapat
                                        melamar</span>
                                </div>
                                <a href="{{ auth()->user()->role_id == 2 || strtolower(auth()->user()->role?->name ?? '') === 'recruiter' ? route('recruiter.dashboard') : route('admin.dashboard') }}"
                                    class="w-full sm:w-auto px-5 py-3 rounded-xl bg-gray-800 hover:bg-gray-700 border border-gray-700 text-white font-bold text-xs shadow-lg text-center transition">
                                    Buka Dashboard
                                </a>
                            </div>
                        @elseif($hasApplied)
                            <div class="flex items-center gap-2.5">
                                <div class="px-5 py-3 rounded-xl bg-[#08CB00]/15 border border-[#08CB00]/40 text-[#08CB00] font-bold text-xs flex items-center gap-2 shadow-lg shadow-[#08CB00]/15">
                                    <svg class="w-4 h-4 text-[#08CB00]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Sudah Dilamar</span>
                                </div>
                                <a href="{{ route('profile', ['tab' => 'riwayat']) }}" 
                                   class="px-4 py-3 rounded-xl bg-[#051405] hover:bg-[#08CB00]/20 border border-[#08CB00]/30 text-gray-300 hover:text-[#08CB00] text-xs font-semibold transition">
                                    Pantau Status
                                </a>
                            </div>
                        @else
                            <button type="button" 
                                    @click="handleApplyClick()"
                                    class="w-full sm:w-auto px-6 py-3 rounded-xl bg-gradient-to-r from-[#08CB00] to-[#5ef558] hover:from-[#07b500] hover:to-[#43e63d] text-black font-extrabold text-sm shadow-xl shadow-[#08CB00]/30 text-center transition cursor-pointer flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                <span>Lamar Posisi Ini</span>
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="w-full sm:w-auto px-6 py-3 rounded-xl bg-gradient-to-r from-[#08CB00] to-[#5ef558] hover:from-[#07b500] hover:to-[#43e63d] text-black font-extrabold text-sm shadow-xl shadow-[#08CB00]/30 text-center transition flex items-center justify-center gap-2">
                            <span>Masuk & Lamar</span>
                        </a>
                    @endauth
                </div>

                    <!-- Info Highlights Grid -->
                    <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6 border-t border-[#08CB00]/15">
                        <div class="p-3 rounded-xl bg-[#050c05] border border-[#08CB00]/20">
                            <span class="text-[11px] text-gray-400 block">Lokasi</span>
                            <span
                                class="text-xs sm:text-sm font-bold text-[#EEEEEE] mt-0.5 block">{{ $job->location ?? 'Indonesia' }}</span>
                        </div>
                        <div class="p-3 rounded-xl bg-[#050c05] border border-[#08CB00]/20">
                            <span class="text-[11px] text-gray-400 block">Estimasi Gaji</span>
                            <span class="text-xs sm:text-sm font-bold text-[#08CB00] mt-0.5 block">
                                @if ($job->salary_min || $job->salary_max)
                                    Rp {{ number_format($job->salary_min / 1000000, 1) }} -
                                    {{ number_format($job->salary_max / 1000000, 1) }} Juta
                                @else
                                    Kompetitif
                                @endif
                            </span>
                        </div>
                        <div class="p-3 rounded-xl bg-[#050c05] border border-[#08CB00]/20">
                            <span class="text-[11px] text-gray-400 block">Kuota Diterima</span>
                            <span class="text-xs sm:text-sm font-bold text-[#EEEEEE] mt-0.5 block">{{ $job->quota }}
                                Orang</span>
                        </div>
                        <div class="p-3 rounded-xl bg-[#050c05] border border-[#08CB00]/20">
                            <span class="text-[11px] text-gray-400 block">Batas Lamaran</span>
                            <span class="text-xs sm:text-sm font-bold text-[#EEEEEE] mt-0.5 block">
                                {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('d M Y') : 'Hingga Terpenuhi' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Job Description Content -->
                <div class="rounded-3xl bg-[#050e05] border border-[#08CB00]/25 p-6 sm:p-8 space-y-6">
                    @php
                        $rawDesc = $job->description ?? '';
                        $isHtml =
                            str_contains($rawDesc, '<p>') ||
                            str_contains($rawDesc, '<ul>') ||
                            str_contains($rawDesc, '<ol>') ||
                            str_contains($rawDesc, '<h3>') ||
                            str_contains($rawDesc, '<h2>') ||
                            str_contains($rawDesc, '<li>');
                    @endphp

                    @if ($isHtml)
                        <!-- Rich Text HTML Content (Formatted with typography utilities) -->
                        <div
                            class="prose prose-invert max-w-none text-sm text-gray-300 leading-relaxed space-y-3 [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5 [&_li]:mt-1 [&_h2]:text-lg [&_h2]:font-extrabold [&_h2]:text-[#EEEEEE] [&_h3]:text-base [&_h3]:font-bold [&_h3]:text-[#EEEEEE] [&_strong]:text-[#EEEEEE] [&_p]:mb-3">
                            {!! $rawDesc !!}
                        </div>
                    @else
                        @php
                            $descPart = $rawDesc;
                            $reqPart = '';
                            if (str_contains($rawDesc, '### Persyaratan:') || str_contains($rawDesc, 'Persyaratan:')) {
                                $split = preg_split('/### Persyaratan:|Persyaratan:/', $rawDesc);
                                $descPart = trim(preg_replace('/### Deskripsi Pekerjaan:\s*/i', '', $split[0] ?? ''));
                                $reqPart = trim($split[1] ?? '');
                            }
                        @endphp

                        <!-- 1. Deskripsi Pekerjaan (Legacy Plain Text) -->
                        @if ($descPart)
                            <div>
                                <h2 class="text-lg sm:text-xl font-extrabold text-[#EEEEEE] mb-3 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#08CB00]"></span>
                                    Deskripsi Pekerjaan
                                </h2>
                                <div class="text-sm text-gray-300 leading-relaxed whitespace-pre-line">
                                    {{ $descPart }}
                                </div>
                            </div>
                        @endif

                        <!-- 2. Persyaratan Pekerjaan (Legacy Plain Text) -->
                        @if ($reqPart)
                            <div class="pt-6 border-t border-[#08CB00]/15">
                                <h2 class="text-lg sm:text-xl font-extrabold text-[#EEEEEE] mb-3 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#08CB00]"></span>
                                    Persyaratan & Kualifikasi
                                </h2>
                                <div class="text-sm text-gray-300 leading-relaxed whitespace-pre-line">
                                    {{ $reqPart }}
                                </div>
                            </div>
                        @endif

                        @if (!$descPart && !$reqPart)
                            <div class="text-sm text-gray-400 italic">
                                Deskripsi detail pekerjaan belum dicantumkan.
                            </div>
                        @endif
                    @endif

                    @if ($job->degrees->isNotEmpty())
                        <div class="pt-6 border-t border-[#08CB00]/15">
                            <h3 class="text-base font-bold text-[#EEEEEE] mb-3">Kualifikasi Pendidikan:</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($job->degrees as $deg)
                                    <span
                                        class="px-3 py-1.5 rounded-lg bg-[#08CB00]/15 border border-[#08CB00]/40 text-[#08CB00] text-xs font-semibold">
                                        {{ $deg->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($job->majors->isNotEmpty())
                        <div class="pt-6 border-t border-[#08CB00]/15">
                            <h3 class="text-base font-bold text-[#EEEEEE] mb-3">Jurusan yang Dicari:</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($job->majors as $maj)
                                    <span
                                        class="px-3 py-1.5 rounded-lg bg-[#08CB00]/15 border border-[#08CB00]/40 text-[#08CB00] text-xs font-semibold">
                                        {{ $maj->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Sidebar / Company Info & Related Jobs (4 cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Company Card -->
                <div class="rounded-3xl bg-[#050e05] border border-[#08CB00]/25 p-6 space-y-4">
                    <h3 class="text-base font-bold text-[#EEEEEE]">
                        Tentang Perusahaan
                    </h3>
                    <div class="flex items-center gap-3">
                        @if ($job->company?->logo_url)
                            <div
                                class="w-12 h-12 rounded-xl bg-[#051205] border border-[#08CB00]/40 p-1.5 flex items-center justify-center shrink-0 overflow-hidden shadow-md shadow-[#08CB00]/15">
                                <img src="{{ $job->company->logo_url }}" alt="{{ $job->company->name }}"
                                    class="w-full h-full object-contain">
                            </div>
                        @else
                            <div
                                class="w-12 h-12 rounded-xl bg-[#08CB00]/15 border border-[#08CB00]/40 flex items-center justify-center text-[#08CB00] font-bold text-lg shrink-0">
                                {{ strtoupper(substr($job->company?->name ?? 'M', 0, 2)) }}
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <h4 class="font-bold text-[#EEEEEE] text-sm truncate">
                                {{ $job->company?->name ?? 'Perusahaan Mitra' }}</h4>
                            <span class="text-xs text-gray-400 block truncate">
                                {{ implode(', ', array_filter([$job->company?->city, $job->company?->province])) ?: $job->company?->address ?? 'Indonesia' }}
                            </span>
                        </div>
                    </div>

                    @if ($job->company?->address)
                        <div
                            class="p-3 rounded-xl bg-[#030803] border border-[#08CB00]/15 text-xs text-gray-300 flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-[#08CB00] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="leading-relaxed">{{ $job->company->address }}</span>
                        </div>
                    @endif

                    @if ($job->company?->website)
                        @php
                            $webUrl = Str::startsWith($job->company->website, ['http://', 'https://'])
                                ? $job->company->website
                                : 'https://' . $job->company->website;
                            $displayWeb = preg_replace(
                                '/^https?:\/\/(www\.)?/',
                                '',
                                rtrim($job->company->website, '/'),
                            );
                        @endphp
                        <div class="pt-2">
                            <a href="{{ $webUrl }}" target="_blank" rel="noopener noreferrer"
                                class="w-full py-2.5 px-4 rounded-xl bg-[#08CB00]/10 hover:bg-[#08CB00] border border-[#08CB00]/40 text-[#08CB00] hover:text-black font-bold text-xs transition flex items-center justify-center gap-2 group">
                                <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                <span class="truncate">{{ $displayWeb }}</span>
                                <svg class="w-3.5 h-3.5 opacity-70 group-hover:opacity-100" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Other Open Jobs -->
                @if ($relatedJobs->isNotEmpty())
                    <div class="rounded-3xl bg-[#050e05] border border-[#08CB00]/25 p-6 space-y-4">
                        <h3 class="text-base font-bold text-[#EEEEEE]">Lowongan Terkait Lainnya</h3>
                        <div class="space-y-3">
                            @foreach ($relatedJobs as $rJob)
                                <a href="{{ route('jobs.show', $rJob->id) }}"
                                    class="block p-3.5 rounded-xl bg-[#030803] border border-[#08CB00]/15 hover:border-[#08CB00]/50 transition">
                                    <h4 class="text-xs font-bold text-[#EEEEEE] hover:text-[#08CB00] transition truncate">
                                        {{ $rJob->title }}</h4>
                                    <span class="text-[11px] text-[#08CB00]/80 block mt-1">{{ $rJob->company?->name }}
                                        &bull; {{ $rJob->location }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>

        <!-- Modal 1: Konfirmasi Pelamaran Pekerjaan -->
        <div x-show="showConfirmModal" 
             x-cloak 
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title-confirm" 
             role="dialog" 
             aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Backdrop -->
                <div x-show="showConfirmModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     @click="showConfirmModal = false" 
                     class="fixed inset-0 transition-opacity bg-black/80 backdrop-blur-sm"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Content Card -->
                <div x-show="showConfirmModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block align-bottom bg-[#061506] rounded-3xl text-left overflow-hidden shadow-2xl border border-[#08CB00]/40 transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    
                    <div class="p-6 sm:p-8 space-y-6">
                        <!-- Modal Header -->
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-12 h-12 rounded-2xl bg-[#08CB00]/15 border border-[#08CB00]/40 flex items-center justify-center text-[#08CB00] shadow-lg shadow-[#08CB00]/20 shrink-0">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg sm:text-xl font-extrabold text-[#EEEEEE]" id="modal-title-confirm">
                                        Konfirmasi Lamaran
                                    </h3>
                                    <p class="text-xs text-gray-400 mt-0.5">Pastikan profil dan data lamaran Anda telah sesuai.</p>
                                </div>
                            </div>
                            <button type="button" @click="showConfirmModal = false" class="p-1.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Job & Applicant Summary Box -->
                        <div class="p-4 rounded-2xl bg-[#040a04] border border-[#08CB00]/20 space-y-3 text-xs">
                            <div class="flex items-center justify-between pb-2 border-b border-[#08CB00]/15">
                                <span class="text-gray-400">Posisi yang Dilamar</span>
                                <span class="font-bold text-[#EEEEEE]">{{ $job->title }}</span>
                            </div>
                            <div class="flex items-center justify-between pb-2 border-b border-[#08CB00]/15">
                                <span class="text-gray-400">Perusahaan</span>
                                <span class="font-semibold text-[#08CB00]">{{ $job->company?->name ?? 'Perusahaan Mitra' }}</span>
                            </div>
                            <div class="flex items-center justify-between pb-2 border-b border-[#08CB00]/15">
                                <span class="text-gray-400">Penempatan & Tipe</span>
                                <span class="text-gray-300">{{ $job->location ?? 'Indonesia' }} ({{ $job->employment_type }})</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400">Nama Pelamar</span>
                                <span class="font-bold text-gray-200">{{ auth()->user()?->name ?? 'Pelamar' }}</span>
                            </div>
                        </div>

                        <!-- Statement Alert -->
                        <div class="p-3.5 rounded-xl bg-[#08CB00]/10 border border-[#08CB00]/30 text-gray-300 text-xs flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-[#08CB00] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="leading-relaxed">
                                Apakah Anda yakin ingin mengirim lamaran untuk posisi ini? Data CV dan profil Anda akan langsung diteruskan ke tim rekruter untuk proses seleksi berkas.
                            </p>
                        </div>

                        <!-- Actions Form -->
                        <form action="{{ route('jobs.apply', $job->id) }}" method="POST" @submit="isSubmitting = true" class="flex items-center justify-end gap-3 pt-2">
                            @csrf
                            <button type="button" 
                                    @click="showConfirmModal = false" 
                                    class="px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-gray-700 text-gray-300 hover:text-white font-semibold text-xs transition">
                                Batal
                            </button>
                            <button type="submit" 
                                    :disabled="isSubmitting"
                                    class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-[#08CB00] to-[#5ef558] hover:from-[#07b500] hover:to-[#43e63d] text-black font-extrabold text-xs shadow-lg shadow-[#08CB00]/30 transition flex items-center gap-2 cursor-pointer disabled:opacity-50">
                                <svg x-show="isSubmitting" class="animate-spin w-4 h-4 text-black" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="isSubmitting ? 'Mengirim Lamaran...' : 'Ya, Kirim Lamaran'"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal 2: Peringatan Data Wajib Belum Lengkap -->
        <div x-show="showIncompleteModal" 
             x-cloak 
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title-incomplete" 
             role="dialog" 
             aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Backdrop -->
                <div x-show="showIncompleteModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     @click="showIncompleteModal = false" 
                     class="fixed inset-0 transition-opacity bg-black/80 backdrop-blur-sm"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Content Card -->
                <div x-show="showIncompleteModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block align-bottom bg-[#0a0707] rounded-3xl text-left overflow-hidden shadow-2xl border border-amber-500/40 transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    
                    <div class="p-6 sm:p-8 space-y-6">
                        <!-- Modal Header -->
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-12 h-12 rounded-2xl bg-amber-500/15 border border-amber-500/40 flex items-center justify-center text-amber-400 shadow-lg shadow-amber-500/20 shrink-0">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg sm:text-xl font-extrabold text-[#EEEEEE]" id="modal-title-incomplete">
                                        Data Wajib Belum Lengkap
                                    </h3>
                                    <p class="text-xs text-amber-400/90 mt-0.5">Lengkapi profil untuk dapat mengajukan lamaran.</p>
                                </div>
                            </div>
                            <button type="button" @click="showIncompleteModal = false" class="p-1.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Explanation -->
                        <p class="text-xs sm:text-sm text-gray-300 leading-relaxed">
                            Mohon maaf, Anda belum dapat melamar pekerjaan ini karena terdapat data profil wajib yang belum diisi. Rekruter memerlukan data berikut untuk evaluasi kualifikasi Anda:
                        </p>

                        <!-- Incomplete Section Pills List -->
                        <div class="p-4 rounded-2xl bg-[#140c0c] border border-amber-500/20 space-y-2">
                            <span class="text-[11px] font-bold text-amber-400 uppercase tracking-wider block">Bagian yang Belum Dilengkapi:</span>
                            <div class="flex flex-wrap gap-2 pt-1">
                                <template x-for="(section, idx) in missingSections" :key="idx">
                                    <span class="px-3 py-1.5 rounded-xl bg-amber-500/15 border border-amber-500/30 text-amber-300 text-xs font-semibold flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span x-text="section"></span>
                                    </span>
                                </template>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-2">
                            <button type="button" 
                                    @click="showIncompleteModal = false" 
                                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-gray-700 text-gray-300 hover:text-white font-semibold text-xs transition">
                                Tutup
                            </button>
                            <a href="{{ route('profile') }}" 
                               class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-400 hover:from-amber-600 hover:to-amber-500 text-black font-extrabold text-xs shadow-lg shadow-amber-500/20 transition text-center flex items-center justify-center gap-2">
                                <span>Lengkapi Profil Sekarang</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
