<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Curriculum Vitae - {{ $profile?->full_name ?? $user->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; padding: 0 !important; }
            .cv-container { shadow: none !important; border: none !important; width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important; position: relative !important; }
            .cv-powered-by {
                display: block !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            @page { margin: 1.5cm; }
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen font-sans antialiased py-8 px-4 sm:px-6">

    <!-- Top Action Bar -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-end no-print">
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Main CV Document Container -->
    <main class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8 sm:p-12 cv-container relative overflow-hidden">
        
        <div class="relative z-10">
        
        <!-- Header Section -->
        <header class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b-2 border-indigo-600 pb-6 mb-8 gap-6">
            <div class="space-y-1">
                <!-- Powered By Tag Directly Above Name -->
                <p class="cv-powered-by text-xs font-semibold text-indigo-600/90 dark:text-indigo-400/90 tracking-wide flex items-center gap-1 pb-1">
                    <span>Powered by</span> <span class="font-bold">Sistem Recruitment MAKNA</span>
                </p>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    {{ $profile?->full_name ?? $user->name }}
                </h1>
                <p class="text-sm text-indigo-600 dark:text-indigo-400 font-semibold tracking-wide uppercase">
                    Curriculum Vitae Pelamar
                </p>
                <div class="flex flex-wrap items-center gap-y-1 gap-x-4 text-xs text-gray-600 dark:text-gray-300 pt-1">
                    @if($user->email)
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $user->email }}
                        </span>
                    @endif
                    @if($profile?->phone)
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $profile->phone }}
                        </span>
                    @endif
                    @if($profile?->city || $profile?->province)
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ implode(', ', array_filter([$profile->city, $profile->province])) }}
                        </span>
                    @endif
                </div>
            </div>

            @if($profile?->photo)
                <img src="{{ asset('storage/' . $profile->photo) }}" alt="Foto Profile" class="w-24 h-28 object-cover rounded-xl border border-gray-300 shadow-sm flex-shrink-0">
            @endif
        </header>

        <!-- Profile / Summary Section -->
        @if($profile?->about_me)
            <section class="mb-8">
                <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700 pb-1 mb-3">
                    Tentang Saya
                </h2>
                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                    {{ $profile->about_me }}
                </p>
            </section>
        @endif

        <!-- Data Pribadi Details -->
        <section class="mb-8">
            <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700 pb-1 mb-3">
                Informasi Pribadi
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-6 text-sm">
                <div><span class="text-gray-500">NIK:</span> <span class="font-medium text-gray-900 dark:text-white">{{ $profile?->nik ?? '-' }}</span></div>
                <div><span class="text-gray-500">Jenis Kelamin:</span> <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($profile?->gender ?? '-') }}</span></div>
                <div><span class="text-gray-500">Tempat, Tgl Lahir:</span> <span class="font-medium text-gray-900 dark:text-white">{{ $profile?->birth_place ?? '-' }}, {{ $profile?->birth_date ? \Carbon\Carbon::parse($profile->birth_date)->isoFormat('D MMMM YYYY') : '-' }}</span></div>
                <div><span class="text-gray-500">NPWP:</span> <span class="font-medium text-gray-900 dark:text-white">{{ $profile?->npwp ?? '-' }}</span></div>
                <div class="sm:col-span-2"><span class="text-gray-500">Alamat Lengkap:</span> <span class="font-medium text-gray-900 dark:text-white">{{ $profile?->address ?? '-' }}</span></div>
            </div>
        </section>

        <!-- Pendidikan -->
        @if($profile?->educations && $profile->educations->count() > 0)
            <section class="mb-8">
                <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700 pb-1 mb-3">
                    Riwayat Pendidikan
                </h2>
                <div class="space-y-4">
                    @foreach($profile->educations as $edu)
                        <div class="flex flex-col sm:flex-row sm:items-baseline justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $edu->school_name }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-300">
                                    {{ $edu->degree }} - {{ $edu->major }} {{ $edu->study_program ? '('.$edu->study_program.')' : '' }}
                                </p>
                                @if($edu->gpa)
                                    <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-0.5">IPK: {{ $edu->gpa }}</p>
                                @endif
                            </div>
                            <span class="text-xs text-gray-500 font-medium">
                                {{ $edu->start_year }} - {{ $edu->end_year ?? 'Sekarang' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Pengalaman Kerja -->
        @if($profile?->workExperiences && $profile->workExperiences->count() > 0)
            <section class="mb-8">
                <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700 pb-1 mb-3">
                    Pengalaman Kerja
                </h2>
                <div class="space-y-5">
                    @foreach($profile->workExperiences as $exp)
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-baseline justify-between mb-1">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $exp->position }} <span class="font-normal text-gray-600 dark:text-gray-400">di {{ $exp->company_name }}</span>
                                </h3>
                                <span class="text-xs text-gray-500 font-medium">
                                    {{ \Carbon\Carbon::parse($exp->start_date)->isoFormat('MMM YYYY') }} - 
                                    {{ $exp->currently_working ? 'Sekarang' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->isoFormat('MMM YYYY') : '-') }}
                                </span>
                            </div>
                            @if($exp->description)
                                <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $exp->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Pengalaman Organisasi -->
        @if($profile?->organizations && $profile->organizations->count() > 0)
            <section class="mb-8">
                <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700 pb-1 mb-3">
                    Pengalaman Organisasi
                </h2>
                <div class="space-y-4">
                    @foreach($profile->organizations as $org)
                        <div class="flex flex-col sm:flex-row sm:items-baseline justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $org->position }} - {{ $org->name }}</h3>
                                @if($org->description)
                                    <p class="text-xs text-gray-600 dark:text-gray-300 mt-0.5">{{ $org->description }}</p>
                                @endif
                            </div>
                            <span class="text-xs text-gray-500 font-medium">
                                {{ $org->start_month }} {{ $org->start_year }} - {{ $org->is_active ? 'Sekarang' : ($org->end_year ? $org->end_month.' '.$org->end_year : '-') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Prestasi & Penghargaan -->
        @if($profile?->achievements && $profile->achievements->count() > 0)
            <section class="mb-8">
                <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700 pb-1 mb-3">
                    Prestasi & Penghargaan
                </h2>
                <div class="space-y-3">
                    @foreach($profile->achievements as $ach)
                        <div class="flex items-baseline justify-between text-xs">
                            <div>
                                <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $ach->name }}</span>
                                <span class="ml-2 px-2 py-0.5 bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300 rounded text-[10px] font-semibold">{{ $ach->scale }}</span>
                                @if($ach->description)
                                    <p class="text-gray-600 dark:text-gray-300 mt-0.5">{{ $ach->description }}</p>
                                @endif
                            </div>
                            <span class="text-gray-500 font-medium">{{ $ach->month }} {{ $ach->year }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Keahlian, Sertifikasi & Pelatihan -->
        @php
            $hasSkills = $profile?->skills && $profile->skills->count() > 0;
            $hasCerts = $profile?->certifications && $profile->certifications->count() > 0;
            $hasTrainings = $profile?->trainings && $profile->trainings->count() > 0;
            $hasLangs = $profile?->languages && $profile->languages->count() > 0;
        @endphp

        @if($hasSkills || $hasCerts || $hasTrainings || $hasLangs)
            <section class="mb-8">
                <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700 pb-1 mb-3">
                    Keahlian & Data Tambahan
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
                    @if($hasSkills)
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Keahlian (Skills):</h3>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($profile->skills as $sk)
                                    <span class="px-2.5 py-1 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 rounded-lg text-xs font-medium">
                                        {{ $sk->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($hasCerts)
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Sertifikasi:</h3>
                            <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                                @foreach($profile->certifications as $cert)
                                    <li>{{ $cert->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($hasTrainings)
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Pelatihan:</h3>
                            <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                                @foreach($profile->trainings as $tr)
                                    <li>{{ $tr->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($hasLangs)
                        <div>
                            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Bahasa:</h3>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($profile->languages as $lang)
                                    <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded font-medium">
                                        {{ $lang->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        <!-- Social Media -->
        @if($profile?->socialMedias && $profile->socialMedias->count() > 0)
            <section>
                <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700 pb-1 mb-3">
                    Media Sosial
                </h2>
                <div class="flex flex-wrap gap-4 text-xs">
                    @foreach($profile->socialMedias as $soc)
                        <a href="{{ $soc->url }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 font-medium hover:underline flex items-center gap-1">
                            <span class="font-bold">{{ $soc->platform_name }}:</span> {{ $soc->url }}
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
        </div>
    </main>
</body>
</html>
