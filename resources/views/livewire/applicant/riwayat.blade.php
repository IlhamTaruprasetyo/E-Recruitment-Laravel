<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-indigo-500/10 via-purple-500/10 to-pink-500/10 dark:from-indigo-950/40 dark:via-purple-950/30 dark:to-pink-950/20 border-l-[5px] border-indigo-600 p-6 md:p-7 rounded-2xl overflow-hidden shadow-xs relative">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2.5">
                    <div class="p-2 bg-indigo-600 text-white rounded-xl shadow-md shadow-indigo-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Riwayat Lamaran Kerja</h2>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 font-medium">
                    Pantau status progress seleksi, riwayat perubahan tahapan, dan jadwal wawancara dari lowongan yang telah Anda lamar.
                </p>
            </div>
            <div>
                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition shadow-md shadow-indigo-500/20 shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Cari Lowongan Lain</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Total Lamaran -->
        <div wire:click="$set('statusFilter', 'all')"
            class="cursor-pointer p-4 rounded-2xl border transition-all duration-200 {{ $statusFilter === 'all' ? 'bg-indigo-50/70 dark:bg-indigo-950/50 border-indigo-300 dark:border-indigo-700 shadow-sm ring-2 ring-indigo-500/20' : 'bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700/80 hover:border-indigo-200 dark:hover:border-gray-600 shadow-xs' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Lamaran</span>
                <span class="p-2 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-2">{{ $stats['total'] }}</p>
            <span class="text-[11px] text-gray-400 dark:text-gray-500">Semua berkas terkirim</span>
        </div>

        <!-- Dalam Proses -->
        <div wire:click="$set('statusFilter', 'process')"
            class="cursor-pointer p-4 rounded-2xl border transition-all duration-200 {{ $statusFilter === 'process' ? 'bg-amber-50/70 dark:bg-amber-950/50 border-amber-300 dark:border-amber-700 shadow-sm ring-2 ring-amber-500/20' : 'bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700/80 hover:border-amber-200 dark:hover:border-gray-600 shadow-xs' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Dalam Proses</span>
                <span class="p-2 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <p class="text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-2">{{ $stats['process'] }}</p>
            <span class="text-[11px] text-gray-400 dark:text-gray-500">Sedang ditinjau / seleksi</span>
        </div>

        <!-- Diterima -->
        <div wire:click="$set('statusFilter', 'Accepted')"
            class="cursor-pointer p-4 rounded-2xl border transition-all duration-200 {{ $statusFilter === 'Accepted' ? 'bg-emerald-50/70 dark:bg-emerald-950/50 border-emerald-300 dark:border-emerald-700 shadow-sm ring-2 ring-emerald-500/20' : 'bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700/80 hover:border-emerald-200 dark:hover:border-gray-600 shadow-xs' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Diterima</span>
                <span class="p-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <p class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-2">{{ $stats['accepted'] }}</p>
            <span class="text-[11px] text-gray-400 dark:text-gray-500">Lolos tahap akhir</span>
        </div>

        <!-- Tidak Lolos -->
        <div wire:click="$set('statusFilter', 'Rejected')"
            class="cursor-pointer p-4 rounded-2xl border transition-all duration-200 {{ $statusFilter === 'Rejected' ? 'bg-rose-50/70 dark:bg-rose-950/50 border-rose-300 dark:border-rose-700 shadow-sm ring-2 ring-rose-500/20' : 'bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700/80 hover:border-rose-200 dark:hover:border-gray-600 shadow-xs' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wider">Tidak Lolos</span>
                <span class="p-2 rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <p class="text-2xl font-extrabold text-rose-600 dark:text-rose-400 mt-2">{{ $stats['rejected'] }}</p>
            <span class="text-[11px] text-gray-400 dark:text-gray-500">Belum berhasil</span>
        </div>
    </div>

    <!-- Filter Pills Status (Clean Horizontal Scrollbar) -->
    <div class="bg-white dark:bg-gray-800 p-3 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-xs">
        <div class="flex items-center gap-2 overflow-x-auto pb-1 custom-scrollbar scroll-smooth">
            <button type="button" wire:click="$set('statusFilter', 'all')"
                class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 shrink-0 {{ $statusFilter === 'all' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-500/20' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Semua Status
            </button>
            <button type="button" wire:click="$set('statusFilter', 'Submitted')"
                class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 shrink-0 {{ $statusFilter === 'Submitted' ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/20' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Terkirim (Submitted)
            </button>
            <button type="button" wire:click="$set('statusFilter', 'Reviewed')"
                class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 shrink-0 {{ $statusFilter === 'Reviewed' ? 'bg-amber-600 text-white shadow-sm shadow-amber-500/20' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Lolos Berkas / Tahap Tes (Reviewed)
            </button>
            <button type="button" wire:click="$set('statusFilter', 'Shortlisted')"
                class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 shrink-0 {{ $statusFilter === 'Shortlisted' ? 'bg-purple-600 text-white shadow-sm shadow-purple-500/20' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Lolos Ujian / Siap Wawancara (Shortlisted)
            </button>
            <button type="button" wire:click="$set('statusFilter', 'Interview')"
                class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 shrink-0 {{ $statusFilter === 'Interview' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-500/20' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Wawancara (Interview)
            </button>
            <button type="button" wire:click="$set('statusFilter', 'Accepted')"
                class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 shrink-0 {{ $statusFilter === 'Accepted' ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-500/20' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Diterima (Accepted)
            </button>
            <button type="button" wire:click="$set('statusFilter', 'Rejected')"
                class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 shrink-0 {{ $statusFilter === 'Rejected' ? 'bg-rose-600 text-white shadow-sm shadow-rose-500/20' : 'bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                Ditolak (Rejected)
            </button>
        </div>
    </div>

    <!-- Application List -->
    <div class="space-y-4">
        @forelse ($applications as $app)
            @php
                $status = $app->status;
                $statusClass = match($status) {
                    'Accepted', 'accepted' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800',
                    'Rejected', 'rejected' => 'bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border-rose-200 dark:border-rose-800',
                    'Interview', 'interview' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300 border-indigo-200 dark:border-indigo-800',
                    'Shortlisted', 'shortlisted' => 'bg-purple-50 text-purple-700 dark:bg-purple-950/60 dark:text-purple-300 border-purple-200 dark:border-purple-800',
                    'Reviewed', 'reviewed' => 'bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border-amber-200 dark:border-amber-800',
                    default => 'bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border-blue-200 dark:border-blue-800',
                };
                
                $statusLabel = match($status) {
                    'Accepted', 'accepted' => 'Diterima (Accepted)',
                    'Rejected', 'rejected' => 'Tidak Lolos (Rejected)',
                    'Interview', 'interview' => 'Tahap Wawancara (Interview)',
                    'Shortlisted', 'shortlisted' => 'Lolos Ujian / Siap Wawancara (Shortlisted)',
                    'Reviewed', 'reviewed' => 'Lolos Berkas / Tahap Ujian (Reviewed)',
                    default => 'Lamaran Diajukan (Submitted)',
                };

                // Determine step stage index (1: Submitted, 2: Lolos Berkas (Reviewed) / Ikut Tes, 3: Lolos Ujian (Shortlisted), 4: Wawancara, 5: Keputusan Akhir)
                $stepStage = 1;
                $hasCompletedTest = $app->testAttempts && $app->testAttempts->where('status', 'passed')->isNotEmpty();

                if (in_array(strtolower($status), ['reviewed'])) {
                    $stepStage = 2;
                } elseif (in_array(strtolower($status), ['shortlisted'])) {
                    $stepStage = 3;
                } elseif (in_array(strtolower($status), ['interview'])) {
                    $stepStage = 4;
                } elseif (in_array(strtolower($status), ['accepted', 'rejected'])) {
                    $stepStage = 5;
                }
            @endphp

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-xs hover:border-indigo-200 dark:hover:border-indigo-900/60 transition-all duration-200 p-5 md:p-6 space-y-4">
                <!-- Top Row: Company & Job Information -->
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <!-- Company Logo / Initials -->
                        @if ($app->job && $app->job->company && $app->job->company->logo)
                            <img src="{{ \Illuminate\Support\Str::startsWith($app->job->company->logo, ['http://', 'https://']) ? $app->job->company->logo : asset('storage/' . $app->job->company->logo) }}" alt="{{ $app->job->company->name }}"
                                class="w-12 h-12 rounded-xl object-contain bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-1 shrink-0">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-base shadow-sm shrink-0">
                                {{ strtoupper(substr($app->job->company->name ?? ($app->job->title ?? 'J'), 0, 2)) }}
                            </div>
                        @endif

                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-base font-bold text-gray-900 dark:text-white leading-tight">
                                    {{ $app->job->title ?? 'Lowongan Pekerjaan' }}
                                </h3>
                                @if ($app->job && $app->job->employment_type)
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                        {{ $app->job->employment_type }}
                                    </span>
                                @endif
                            </div>

                            <div class="flex flex-wrap items-center gap-y-1 gap-x-2 text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <span class="font-semibold text-indigo-600 dark:text-indigo-400">
                                    {{ $app->job->company->name ?? 'Perusahaan' }}
                                </span>
                                @if ($app->job && $app->job->department)
                                    <span>•</span>
                                    <span>{{ $app->job->department->name }}</span>
                                @endif
                                @if ($app->job && $app->job->location)
                                    <span>•</span>
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $app->job->location }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-start gap-1 shrink-0">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                            @if (in_array(strtolower($status), ['accepted']))
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            @elseif (in_array(strtolower($status), ['rejected']))
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @else
                                <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                            @endif
                            <span>{{ $statusLabel }}</span>
                        </span>
                        <span class="text-[11px] text-gray-400 dark:text-gray-500">
                            Dilamar: {{ \Carbon\Carbon::parse($app->applied_at)->translatedFormat('d M Y, H:i') }}
                        </span>
                    </div>
                </div>

                <!-- Middle Row: Visual Timeline Progress Bar (Horizontal Connected Stepper) -->
                <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-2xl border border-gray-100 dark:border-gray-800/80">
                    <div class="relative flex items-center justify-between">
                        <!-- Connecting Background Line -->
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-gray-200 dark:bg-gray-700 -z-0"></div>
                        
                        <!-- Active Progress Line -->
                        @php
                            $progressWidths = [1 => '0%', 2 => '25%', 3 => '50%', 4 => '75%', 5 => '100%'];
                            $activeWidth = $progressWidths[$stepStage] ?? '0%';
                        @endphp
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-500 transition-all duration-500 -z-0" style="width: {{ $activeWidth }};"></div>

                        <!-- Step 1: Terkirim -->
                        <div class="relative z-10 flex flex-col items-center group">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-sm {{ $stepStage >= 1 ? 'bg-indigo-600 text-white ring-4 ring-indigo-100 dark:ring-indigo-950/60' : 'bg-gray-200 dark:bg-gray-700 text-gray-500' }}">
                                ✓
                            </div>
                            <span class="text-[11px] font-bold mt-1.5 whitespace-nowrap {{ $stepStage >= 1 ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 dark:text-gray-500' }}">
                                Terkirim
                            </span>
                        </div>

                        <!-- Step 2: Seleksi Berkas -->
                        <div class="relative z-10 flex flex-col items-center group">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-sm {{ $stepStage >= 2 ? 'bg-indigo-600 text-white ring-4 ring-indigo-100 dark:ring-indigo-950/60' : 'bg-gray-200 dark:bg-gray-700 text-gray-500' }}">
                                {{ $stepStage > 2 ? '✓' : '2' }}
                            </div>
                            <span class="text-[11px] font-bold mt-1.5 whitespace-nowrap {{ $stepStage >= 2 ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 dark:text-gray-500' }}">
                                Seleksi Berkas
                            </span>
                        </div>

                        <!-- Step 3: Tes Online -->
                        <div class="relative z-10 flex flex-col items-center group">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-sm {{ $stepStage >= 3 ? 'bg-purple-600 text-white ring-4 ring-purple-100 dark:ring-purple-950/60 animate-pulse' : 'bg-gray-200 dark:bg-gray-700 text-gray-500' }}">
                                {{ $stepStage > 3 ? '✓' : '3' }}
                            </div>
                            <span class="text-[11px] font-bold mt-1.5 whitespace-nowrap {{ $stepStage >= 3 ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400 dark:text-gray-500' }}">
                                Tes Online
                            </span>
                        </div>

                        <!-- Step 4: Wawancara -->
                        <div class="relative z-10 flex flex-col items-center group">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-sm {{ $stepStage >= 4 ? 'bg-indigo-600 text-white ring-4 ring-indigo-100 dark:ring-indigo-950/60' : 'bg-gray-200 dark:bg-gray-700 text-gray-500' }}">
                                {{ $stepStage > 4 ? '✓' : '4' }}
                            </div>
                            <span class="text-[11px] font-bold mt-1.5 whitespace-nowrap {{ $stepStage >= 4 ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 dark:text-gray-500' }}">
                                Wawancara
                            </span>
                        </div>

                        <!-- Step 5: Hasil Akhir -->
                        <div class="relative z-10 flex flex-col items-center group">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-sm {{ $stepStage >= 5 ? (strtolower($status) === 'accepted' ? 'bg-emerald-600 text-white ring-4 ring-emerald-100' : 'bg-rose-600 text-white ring-4 ring-rose-100') : 'bg-gray-200 dark:bg-gray-700 text-gray-500' }}">
                                {{ $stepStage >= 5 ? (strtolower($status) === 'accepted' ? '✓' : '✕') : '5' }}
                            </div>
                            <span class="text-[11px] font-bold mt-1.5 whitespace-nowrap {{ $stepStage >= 5 ? (strtolower($status) === 'accepted' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400') : 'text-gray-400 dark:text-gray-500' }}">
                                {{ strtolower($status) === 'accepted' ? 'Diterima' : (strtolower($status) === 'rejected' ? 'Ditolak' : 'Hasil Akhir') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Row: Notes & Detail Button -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1 border-t border-gray-100 dark:border-gray-700/60">
                    <div class="min-w-0 flex-1">
                        @if ($app->notes)
                            <p class="text-xs text-gray-600 dark:text-gray-300 truncate">
                                <strong class="text-gray-800 dark:text-gray-200">Catatan:</strong> {{ $app->notes }}
                            </p>
                        @elseif ($app->interviewSchedules && $app->interviewSchedules->isNotEmpty())
                            @php $latestInterview = $app->interviewSchedules->last(); @endphp
                            <p class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Jadwal Wawancara: {{ \Carbon\Carbon::parse($latestInterview->interview_date)->translatedFormat('d M Y, H:i') }}</span>
                            </p>
                        @else
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                Belum ada catatan tambahan dari tim rekruter.
                            </p>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        @php
                            $availableTest = $app->job && $app->job->tests ? $app->job->tests->first() : null;
                            $latestAttempt = $app->testAttempts ? $app->testAttempts->where('test_id', $availableTest?->id)->last() : null;
                            $canTakeTest = in_array(strtolower($status), ['reviewed', 'shortlisted', 'interview', 'accepted']);
                        @endphp

                        @if ($availableTest && !in_array(strtolower($status), ['rejected']))
                            @if ($latestAttempt && $latestAttempt->status !== 'in_progress')
                                <!-- Sudah Mengerjakan Tes -->
                                <a href="{{ route('applicant.test', ['applicationId' => $app->id, 'testId' => $availableTest->id]) }}"
                                    class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-xs font-semibold rounded-xl transition">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Lihat Hasil Tes</span>
                                </a>
                            @elseif ($canTakeTest || ($latestAttempt && $latestAttempt->status === 'in_progress'))
                                <!-- Sudah Lolos Berkas / Diizinkan Ikut Tes -->
                                <a href="{{ route('applicant.test', ['applicationId' => $app->id, 'testId' => $availableTest->id]) }}"
                                    class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs font-bold rounded-xl shadow-md shadow-indigo-500/20 transition transform active:scale-95">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span>{{ $latestAttempt ? 'Lanjutkan Ujian' : 'Mulai Ujian Online' }}</span>
                                </a>
                            @else
                                <!-- Masih tahap awal Submitted (Belum Lolos Berkas) -->
                                <div class="inline-flex items-center gap-1.5 px-3 py-2 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 text-amber-700 dark:text-amber-300 text-xs font-medium rounded-xl" title="Ujian online akan terbuka setelah berkas lamaran Anda selesai diverifikasi & disetujui tim HR.">
                                    <svg class="w-3.5 h-3.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <span>Ujian: Menunggu Seleksi Berkas</span>
                                </div>
                            @endif
                        @endif

                        <button wire:click="openDetail({{ $app->id }})"
                            class="inline-flex items-center justify-center gap-1.5 px-4 py-2 border border-indigo-200 dark:border-indigo-800 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 text-xs font-semibold rounded-xl transition shadow-2xs">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>Lihat Detail</span>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State matching project design standard -->
            <div class="col-span-full bg-white dark:bg-gray-800 p-8 md:p-10 rounded-2xl border border-gray-100 dark:border-gray-700/80 text-center flex flex-col items-center justify-center space-y-4">
                <svg class="w-10 h-10 text-gray-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.816c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6A2.25 2.25 0 0 0 4.727 20.25h14.546a2.25 2.25 0 0 0 2.224-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                </svg>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ !empty($search) || $statusFilter !== 'all' ? 'Tidak ada lamaran yang sesuai dengan filter pencarian.' : 'Belum ada data untuk ditampilkan' }}
                </p>
                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-indigo-600 dark:border-indigo-500 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 text-sm font-semibold rounded-2xl transition shadow-2xs">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Jelajahi Lowongan Kerja</span>
                </a>
            </div>
        @endforelse
    </div>

    <!-- Modal Detail Lamaran -->
    @if ($showDetailModal && $selectedApplication)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Backdrop -->
                <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" wire:click="closeDetail"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Content -->
                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100 dark:border-gray-700">
                    <!-- Modal Header -->
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/50 dark:bg-gray-900/30">
                        <div class="flex items-center gap-3">
                            @if ($selectedApplication->job && $selectedApplication->job->company && $selectedApplication->job->company->logo)
                                <img src="{{ \Illuminate\Support\Str::startsWith($selectedApplication->job->company->logo, ['http://', 'https://']) ? $selectedApplication->job->company->logo : asset('storage/' . $selectedApplication->job->company->logo) }}" alt="{{ $selectedApplication->job->company->name }}"
                                    class="w-10 h-10 rounded-xl object-contain bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-1 shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                    {{ strtoupper(substr($selectedApplication->job->company->name ?? 'J', 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                    {{ $selectedApplication->job->title ?? 'Detail Lamaran' }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $selectedApplication->job->company->name ?? '-' }} • {{ $selectedApplication->job->department->name ?? '-' }}
                                </p>
                            </div>
                        </div>
                        <button type="button" wire:click="closeDetail" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1 rounded-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">
                        <!-- Summary Info Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <div class="p-3 bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-800">
                                <span class="block text-[10px] font-bold text-gray-400 uppercase">Status Terkini</span>
                                <span class="block text-xs font-bold text-indigo-600 dark:text-indigo-400 mt-0.5">
                                    {{ $selectedApplication->status }}
                                </span>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-800">
                                <span class="block text-[10px] font-bold text-gray-400 uppercase">Tanggal Melamar</span>
                                <span class="block text-xs font-bold text-gray-800 dark:text-gray-200 mt-0.5">
                                    {{ \Carbon\Carbon::parse($selectedApplication->applied_at)->translatedFormat('d M Y, H:i') }}
                                </span>
                            </div>
                            <div class="p-3 bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-800 col-span-2 sm:col-span-1">
                                <span class="block text-[10px] font-bold text-gray-400 uppercase">Lokasi Penempatan</span>
                                <span class="block text-xs font-bold text-gray-800 dark:text-gray-200 mt-0.5">
                                    {{ $selectedApplication->job->location ?? 'Tidak ditentukan' }}
                                </span>
                            </div>
                        </div>

                        <!-- Section: Riwayat Perubahan Status (Horizontal Timeline Tracker) -->
                        <div>
                            <h4 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Riwayat Perubahan Status Seleksi</span>
                            </h4>

                            @if ($selectedApplication->statusHistories && $selectedApplication->statusHistories->isNotEmpty())
                                <div class="overflow-x-auto pb-3 pt-1 scrollbar-thin">
                                    <div class="flex items-start gap-4 min-w-max">
                                        @foreach ($selectedApplication->statusHistories->sortBy('changed_at') as $index => $hist)
                                            <div class="flex items-start gap-3">
                                                <div class="w-64 p-3.5 bg-gray-50 dark:bg-gray-900/60 rounded-2xl border border-gray-100 dark:border-gray-800 space-y-1.5 shadow-2xs relative">
                                                    <div class="flex items-center justify-between">
                                                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-extrabold bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                                            {{ $hist->status }}
                                                        </span>
                                                        <span class="text-[10px] text-gray-400 font-mono">
                                                            {{ \Carbon\Carbon::parse($hist->changed_at)->translatedFormat('d M Y, H:i') }}
                                                        </span>
                                                    </div>
                                                    @if ($hist->notes)
                                                        <p class="text-xs text-gray-600 dark:text-gray-300 line-clamp-3 leading-snug">
                                                            {{ $hist->notes }}
                                                        </p>
                                                    @else
                                                        <p class="text-[11px] text-gray-400 italic">
                                                            Status diperbarui.
                                                        </p>
                                                    @endif
                                                </div>

                                                @if (!$loop->last)
                                                    <div class="pt-6 text-gray-300 dark:text-gray-700">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="p-3.5 bg-gray-50 dark:bg-gray-900/40 rounded-xl text-xs text-gray-400 text-center">
                                    Belum ada log riwayat perubahan status tercatat.
                                </div>
                            @endif
                        </div>

                        <!-- Section: Jadwal Wawancara -->
                        @if ($selectedApplication->interviewSchedules && $selectedApplication->interviewSchedules->isNotEmpty())
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>Jadwal Wawancara</span>
                                </h4>
                                <div class="space-y-2">
                                    @foreach ($selectedApplication->interviewSchedules as $interview)
                                        <div class="p-4 bg-emerald-50/50 dark:bg-emerald-950/30 rounded-xl border border-emerald-200/80 dark:border-emerald-900/50 space-y-2">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-bold text-emerald-800 dark:text-emerald-300">
                                                    Waktu: {{ \Carbon\Carbon::parse($interview->interview_date)->translatedFormat('l, d F Y - H:i') }} WIB
                                                </span>
                                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-emerald-100 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-300">
                                                    {{ $interview->status }}
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-700 dark:text-gray-300 space-y-1">
                                                <p><strong>Lokasi:</strong> {{ $interview->location }}</p>
                                                @if ($interview->meeting_link)
                                                    <p>
                                                        <strong>Link Meeting:</strong>
                                                        <a href="{{ $interview->meeting_link }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 underline font-semibold break-all">
                                                            {{ $interview->meeting_link }}
                                                        </a>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Section: Riwayat Tes Online -->
                        @if ($selectedApplication->testAttempts && $selectedApplication->testAttempts->isNotEmpty())
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span>Tes Rekrutmen Online</span>
                                </h4>
                                <div class="space-y-2">
                                    @foreach ($selectedApplication->testAttempts as $attempt)
                                        <div class="p-3.5 bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-800 flex items-center justify-between">
                                            <div>
                                                <h5 class="text-xs font-bold text-gray-900 dark:text-white">
                                                    {{ $attempt->test->title ?? 'Ujian Tes Online' }}
                                                </h5>
                                                <span class="text-[10px] text-gray-400">
                                                    Status: {{ ucfirst($attempt->status) }}
                                                </span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-xs font-extrabold text-indigo-600 dark:text-indigo-400">
                                                    Skor: {{ $attempt->total_score ?? $attempt->objective_score ?? '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                        <button type="button" wire:click="closeDetail"
                            class="px-5 py-2 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
