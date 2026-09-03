<div class="space-y-6">
    @php
        $candidateRoute = $isRecruiter ? route('recruiter.candidate') : route('admin.candidate');
        $applicationRoute = $isRecruiter ? route('recruiter.application') : route('admin.application');
    @endphp

    <!-- Welcome Banner -->
    <div
        class="p-6 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg text-white flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">
                {{ $isRecruiter ? 'Selamat Datang di Panel Recruiter E-Rekrutmen 👋' : 'Selamat Datang di Panel Admin E-Rekrutmen 👋' }}
            </h1>
            <p class="text-blue-100 text-sm mt-1">
                {{ $isRecruiter ? 'Kelola dan seleksi lamaran masuk kandidat pada lowongan yang aktif secara terstruktur.' : 'Pantau perkembangan rekrutmen, pelamar masuk, dan hasil tes online secara real-time.' }}
            </p>
        </div>
        <div class="flex gap-2 shrink-0">
            @if (!$isRecruiter)
                <a href="{{ route('admin.job') }}"
                    class="px-4 py-2 bg-white text-blue-700 font-semibold rounded-xl text-sm hover:bg-blue-50 transition shadow-sm">
                    + Pasang Lowongan
                </a>
            @else
                <a href="{{ $candidateRoute }}"
                    class="px-4 py-2 bg-white text-blue-700 font-semibold rounded-xl text-sm hover:bg-blue-50 transition shadow-sm">
                    Data Kandidat
                </a>
            @endif
            <a href="{{ $applicationRoute }}"
                class="px-4 py-2 bg-blue-800/60 hover:bg-blue-800 text-white font-medium rounded-xl text-sm transition">
                Seleksi Pelamar
            </a>
        </div>
    </div>

    <!-- Key Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Lowongan Kerja -->
        <div
            class="p-5 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-700/60 flex items-center gap-4">
            <div
                class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Lowongan
                    Aktif</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $activeJobs }}</span>
                    @if (!$isRecruiter)
                        <span class="text-xs text-slate-500">dari {{ $totalJobs }} total</span>
                    @else
                        <span class="text-xs text-emerald-600 font-medium">Siap Diseleksi</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card 2: Total Pelamar -->
        <div
            class="p-5 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-700/60 flex items-center gap-4">
            <div
                class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total
                    Pelamar</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalApplicants }}</span>
                    <span class="text-xs text-emerald-600 font-medium">Lamaran Masuk</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Perlu Review -->
        <div
            class="p-5 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-700/60 flex items-center gap-4">
            <div
                class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Perlu
                    Review</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $pendingReview }}</span>
                    <span class="text-xs text-slate-500">Berkas/Screening</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Ujian Online / Total Kandidat -->
        <div
            class="p-5 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-700/60 flex items-center gap-4">
            <div
                class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                @if (!$isRecruiter)
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                    </svg>
                @else
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                    </svg>
                @endif
            </div>
            <div>
                @if (!$isRecruiter)
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Ujian &
                        Bank Soal</p>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalTests }}</span>
                        <span class="text-xs text-slate-500">Paket Tes ({{ $totalQuestions }} Soal)</span>
                    </div>
                @else
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total
                        Kandidat</p>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $totalCandidates }}</span>
                        <span class="text-xs text-indigo-600 font-medium">Terdaftar di Sistem</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Middle Content Grid: Recent Applications & Active Jobs -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Applications Table (2 Columns) -->
        <div
            class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-700/60 p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-700">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">Pelamar Terbaru</h2>
                        <p class="text-xs text-slate-500">
                            {{ $isRecruiter ? 'Daftar pelamar terbaru pada lowongan yang aktif saat ini' : 'Daftar kandidat yang baru saja mengirimkan lamaran' }}
                        </p>
                    </div>
                    <a href="{{ $applicationRoute }}"
                        class="text-xs font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        Lihat Semua →
                    </a>
                </div>

                <div class="overflow-x-auto mt-4">
                    <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                        <thead>
                            <tr
                                class="text-xs uppercase font-semibold text-slate-400 border-b border-slate-100 dark:border-slate-700/60">
                                <th class="pb-3">Kandidat</th>
                                <th class="pb-3">Posisi</th>
                                <th class="pb-3">Tanggal</th>
                                <th class="pb-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @forelse($recentApplications as $app)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition">
                                    <td class="py-3 font-medium text-slate-900 dark:text-white flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300 flex items-center justify-center font-bold text-xs uppercase">
                                            {{ substr($app->applicantProfile->full_name ?? ($app->applicantProfile->user->name ?? 'A'), 0, 2) }}
                                        </div>
                                        <span>{{ $app->applicantProfile->full_name ?? ($app->applicantProfile->user->name ?? 'Pelamar') }}</span>
                                    </td>
                                    <td class="py-3 text-slate-600 dark:text-slate-400">
                                        {{ $app->job->title ?? '-' }}
                                    </td>
                                    <td class="py-3 text-xs text-slate-500">
                                        {{ $app->applied_at ? \Carbon\Carbon::parse($app->applied_at)->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB' : '-' }}
                                    </td>
                                    <td class="py-3 text-center">
                                        @php
                                            $statusColors = [
                                                'applied' =>
                                                    'bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                                                'pending' =>
                                                    'bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
                                                'screening' =>
                                                    'bg-purple-50 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300',
                                                'accepted' =>
                                                    'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                                                'hired' =>
                                                    'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                                                'rejected' =>
                                                    'bg-rose-50 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300',
                                            ];
                                            $colorClass =
                                                $statusColors[strtolower($app->status)] ??
                                                'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300';
                                        @endphp
                                        <span
                                            class="px-2.5 py-1 text-xs font-semibold rounded-full capitalize {{ $colorClass }}">
                                            {{ $app->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-sm text-slate-400">
                                        Belum ada data lamaran masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Menu & Active Jobs (1 Column) -->
        <div class="space-y-6">
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-700/60 p-6">
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Pintasan Cepat</h3>
                @php
                    $isAdmin =
                        auth()->user()->role_id == 1 ||
                        strtolower(auth()->user()->role?->name ?? '') === 'admin' ||
                        strtolower(auth()->user()->role?->name ?? '') === 'superadmin';
                @endphp
                <div class="grid grid-cols-2 gap-3">
                    @if ($isAdmin)
                        <a href="{{ route('admin.job') }}"
                            class="p-3 bg-slate-50 dark:bg-slate-700/50 hover:bg-blue-50 dark:hover:bg-blue-900/30 text-slate-700 dark:text-slate-200 rounded-xl transition text-center flex flex-col items-center gap-2 group">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-100/60 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center transition group-hover:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold group-hover:text-blue-600 dark:group-hover:text-blue-400">Lowongan</span>
                        </a>
                    @else
                        <a href="{{ $candidateRoute }}"
                            class="p-3 bg-slate-50 dark:bg-slate-700/50 hover:bg-blue-50 dark:hover:bg-blue-900/30 text-slate-700 dark:text-slate-200 rounded-xl transition text-center flex flex-col items-center gap-2 group">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-100/60 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 flex items-center justify-center transition group-hover:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-semibold group-hover:text-blue-600 dark:group-hover:text-blue-400">Kandidat</span>
                        </a>
                    @endif

                    <a href="{{ $applicationRoute }}"
                        class="p-3 bg-slate-50 dark:bg-slate-700/50 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 text-slate-700 dark:text-slate-200 rounded-xl transition text-center flex flex-col items-center gap-2 group">
                        <div
                            class="w-10 h-10 rounded-xl bg-emerald-100/60 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center transition group-hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="text-xs font-semibold group-hover:text-emerald-600 dark:group-hover:text-emerald-400">Pelamar</span>
                    </a>

                    @if ($isAdmin)
                        <a href="{{ route('admin.test') }}"
                            class="p-3 bg-slate-50 dark:bg-slate-700/50 hover:bg-purple-50 dark:hover:bg-purple-900/30 text-slate-700 dark:text-slate-200 rounded-xl transition text-center flex flex-col items-center gap-2 group">
                            <div
                                class="w-10 h-10 rounded-xl bg-purple-100/60 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 flex items-center justify-center transition group-hover:scale-110">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                </svg>

                            </div>
                            <span
                                class="text-xs font-semibold group-hover:text-purple-600 dark:group-hover:text-purple-400">Paket
                                Tes</span>
                        </a>
                    @endif
                    <a href="{{ $isAdmin ? route('admin.test_evaluation') : route('recruiter.test_evaluation') }}"
                        class="p-3 bg-slate-50 dark:bg-slate-700/50 hover:bg-amber-50 dark:hover:bg-amber-900/30 text-slate-700 dark:text-slate-200 rounded-xl transition text-center flex flex-col items-center gap-2 group">
                        <div
                            class="w-10 h-10 rounded-xl bg-amber-100/60 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center transition group-hover:scale-110">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                            </svg>

                        </div>
                        <span
                            class="text-xs font-semibold group-hover:text-amber-600 dark:group-hover:text-amber-400">Nilai
                            Ujian</span>
                    </a>
                </div>
            </div>

            <!-- Active Jobs Summary -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200/80 dark:border-slate-700/60 p-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Lowongan Terbaru</h3>
                    @if ($isAdmin)
                        <a href="{{ route('admin.job') }}"
                            class="text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat</a>
                    @endif
                </div>
                <div class="mt-3 divide-y divide-slate-100 dark:divide-slate-700/50">
                    @forelse($recentJobs as $job)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-semibold text-slate-900 dark:text-white">{{ $job->title }}
                                </h4>
                                <p class="text-xs text-slate-500">{{ $job->department->name ?? 'Dept' }} - Kuota:
                                    {{ $job->quota ?? '-' }}</p>
                            </div>
                            <span
                                class="px-2 py-1 text-xs font-bold bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 rounded-lg">
                                {{ $job->job_applications_count }} Pelamar
                            </span>
                        </div>
                    @empty
                        <p class="py-4 text-center text-xs text-slate-400">Belum ada lowongan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
