@php
    $isRecruiter = auth()->check() && (auth()->user()->role_id == 2 || strtolower(auth()->user()->role?->name ?? '') === 'recruiter');
    $gradeActionPrefix = $isRecruiter ? '/recruiter/test-evaluations/' : '/admin/test-evaluations/';
@endphp

<div class="space-y-6" x-data="{ 
    showGradingModal: false,
    isSubmittingGrading: false,
    gradingData: {
        id: '',
        applicant_name: '',
        job_title: '',
        test_title: '',
        passing_score: 0,
        objective_score: 0,
        essay_score: 0,
        total_score: 0,
        status: '',
        answers: []
    },

    openGradingModal(att) {
        let name = 'Pelamar';
        if (att.job_application && att.job_application.applicant_profile) {
            name = att.job_application.applicant_profile.full_name || 'Pelamar';
        }

        this.gradingData = {
            id: att.id,
            applicant_name: name,
            job_title: att.job_application && att.job_application.job ? att.job_application.job.title : '-',
            test_title: att.test ? att.test.title : '-',
            passing_score: att.test ? att.test.passing_score : 0,
            objective_score: att.objective_score || 0,
            essay_score: att.essay_score || 0,
            total_score: att.total_score || 0,
            status: att.status || 'in_progress',
            application_status: att.job_application ? att.job_application.status : 'Reviewed',
            application_notes: att.job_application ? (att.job_application.notes || '') : '',
            answers: att.answers || [],
            disc_result: att.disc_test_result || null
        };
        this.showGradingModal = true;
    },

    calcY(score) {
        let val = Math.max(-8, Math.min(8, parseFloat(score) || 0));
        return 80 - (val * 8.125);
    },

    getPolyline(scores) {
        if (!scores) return '';
        let dY = this.calcY(scores.D || 0);
        let iY = this.calcY(scores.I || 0);
        let sY = this.calcY(scores.S || 0);
        let cY = this.calcY(scores.C || 0);
        return `35,${dY} 85,${iY} 135,${sY} 185,${cY}`;
    }
}">

    <!-- Session Notifications -->
    @if (session('update'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs font-semibold">{{ session('update') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs font-semibold">{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-rose-500 hover:text-rose-700 dark:hover:text-rose-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Header & Action Section -->
    <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 overflow-hidden shadow-sm rounded-2xl p-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hasil & Evaluasi Ujian Pelamar</h3>
                <p class="text-xs text-gray-500 dark:text-slate-400">Tinjau riwayat pengerjaan tes pelamar, berikan penilaian (grading) soal essay, dan evaluasi hasil tes.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                <!-- Search Input -->
                <div class="relative flex-1 sm:w-64 min-w-[180px]">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Cari nama pelamar / ujian..." 
                           class="w-full pl-9 pr-4 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Filter Job -->
                <select wire:model.live="jobId" class="px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition max-w-[180px]">
                    <option value="">Semua Lowongan</option>
                    @foreach ($jobs as $job)
                        <option value="{{ $job->id }}">{{ $job->title }}</option>
                    @endforeach
                </select>

                <!-- Filter Status -->
                <select wire:model.live="status" class="px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition max-w-[180px]">
                    <option value="">Semua Status</option>
                    <option value="needs_grading">Perlu Koreksi Essay</option>
                    <option value="passed">Lulus (Passed)</option>
                    <option value="failed">Gagal / Ditolak</option>
                    <option value="disc">Tes Kepribadian (DISC)</option>
                    <option value="in_progress">Sedang Dikerjakan</option>
                </select>

                @if ($search || $jobId || $status || $sortField !== 'id')
                    <button wire:click="resetFilters" class="px-3 py-2 text-xs font-medium text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-xl transition">
                        Reset
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="relative bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
        
        <!-- Livewire Loading Overlay -->
        <div wire:loading wire:target="search, jobId, status, sortField, sortDirection, sortBy, previousPage, nextPage, gotoPage, resetFilters" class="absolute inset-0 bg-white/60 dark:bg-slate-900/60 backdrop-blur-[1px] flex items-center justify-center z-10 transition">
            <div class="flex items-center gap-2.5 px-4 py-2.5 bg-slate-900/90 dark:bg-slate-800/90 text-white rounded-xl shadow-xl text-xs font-semibold">
                <svg class="animate-spin w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Memuat data...</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-800/50 text-gray-500 dark:text-slate-400 uppercase tracking-wider font-semibold">
                        <th class="px-6 py-4 w-12">No</th>
                        <th class="px-6 py-4 cursor-pointer hover:text-indigo-600 transition" wire:click="sortBy('applicant')">
                            <div class="flex items-center gap-1">
                                <span>Pelamar & Lowongan</span>
                                @if ($sortField === 'applicant')
                                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4">Paket Ujian</th>
                        <th class="px-6 py-4 cursor-pointer hover:text-indigo-600 transition" wire:click="sortBy('started_at')">
                            <div class="flex items-center gap-1">
                                <span>Waktu Pengerjaan</span>
                                @if ($sortField === 'started_at')
                                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4">Nilai P. Ganda / Essay</th>
                        <th class="px-6 py-4 cursor-pointer hover:text-indigo-600 transition" wire:click="sortBy('score')">
                            <div class="flex items-center gap-1">
                                <span>Total & KKM</span>
                                @if ($sortField === 'score')
                                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 cursor-pointer hover:text-indigo-600 transition" wire:click="sortBy('status')">
                            <div class="flex items-center gap-1">
                                <span>Status</span>
                                @if ($sortField === 'status')
                                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800/60 text-gray-700 dark:text-slate-300">
                    @forelse ($attempts as $index => $att)
                        @php
                            $profile = $att->jobApplication->applicantProfile ?? null;
                            $applicantName = $profile->full_name ?? 'Pelamar';
                            $hasUnreviewedEssay = $att->answers->contains(function($ans) {
                                return $ans->question && $ans->question->question_type === 'essay' && is_null($ans->reviewed_by);
                            });
                            $isDisc = ($att->discTestResult && (
                                str_contains(strtolower($att->test?->title ?? ''), 'disc') ||
                                str_contains(strtolower($att->test?->category?->name ?? ''), 'disc') ||
                                $att->answers->contains(fn($ans) => $ans->question?->question_type === 'disc' || in_array($ans->answer_type, ['most', 'least']))
                            )) || ($att->test && (str_contains(strtolower($att->test->title ?? ''), 'disc') || str_contains(strtolower($att->test->category?->name ?? ''), 'disc')));
                        @endphp
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-500 dark:text-slate-400">
                                {{ $attempts->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-0.5">
                                    <span class="block font-bold text-gray-900 dark:text-white">{{ $applicantName }}</span>
                                    <span class="text-[11px] text-gray-500 dark:text-slate-400 font-medium">{{ $att->jobApplication->job->title ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-0.5">
                                    <span class="font-semibold text-gray-800 dark:text-slate-200">{{ $att->test->title ?? '-' }}</span>
                                    <span class="block text-[11px] text-gray-400 dark:text-slate-500">{{ $att->test->category->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-0.5 text-[11px]">
                                    <span class="block text-gray-700 dark:text-slate-300 font-medium">
                                        {{ $att->started_at ? \Carbon\Carbon::parse($att->started_at)->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB' : '-' }}
                                    </span>
                                    @if ($att->duration)
                                        <span class="text-gray-400 dark:text-slate-500">Durasi: {{ round($att->duration / 60) }} menit</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($isDisc)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 dark:bg-slate-800/80 text-slate-500 dark:text-slate-400 border border-slate-200/60 dark:border-slate-700/60">
                                        Self-Inventory
                                    </span>
                                @else
                                    <div class="space-y-0.5 text-[11px]">
                                        <div class="flex items-center gap-1.5 text-indigo-600 dark:text-indigo-400 font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                            <span>PG: {{ number_format($att->objective_score ?? 0, 1) }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-amber-600 dark:text-amber-400 font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            <span>Essay: {{ number_format($att->essay_score ?? 0, 1) }}</span>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-0.5">
                                    @if ($isDisc && $att->discTestResult)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                            DISC: {{ $att->discTestResult->discProfile->pattern_code ?? 'Profile' }}
                                        </span>
                                        <span class="block text-[11px] text-gray-400 dark:text-slate-500">Tes Kepribadian</span>
                                    @elseif ($isDisc)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                            Belum Ada Hasil
                                        </span>
                                        <span class="block text-[10px] text-gray-400">Tes Kepribadian</span>
                                    @else
                                        <span class="block text-sm font-extrabold text-gray-900 dark:text-white">
                                            {{ number_format($att->total_score ?? 0, 1) }}
                                        </span>
                                        <span class="text-[11px] text-gray-400 dark:text-slate-500">KKM: {{ number_format($att->test->passing_score ?? 0, 0) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1.5">
                                    @if ($isDisc && $att->discTestResult)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-purple-50 dark:bg-purple-950/50 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                            <svg class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Profil Terbentuk
                                        </span>
                                    @elseif ($isDisc)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                            Belum Lengkap
                                        </span>
                                    @elseif ($hasUnreviewedEssay)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Perlu Koreksi Essay
                                        </span>
                                    @elseif ($att->status === 'passed')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Lulus (Passed)
                                        </span>
                                    @elseif ($att->status === 'failed')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                                            <svg class="w-3.5 h-3.5 text-rose-600 dark:text-rose-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Gagal (Failed)
                                        </span>
                                    @elseif ($att->status === 'in_progress')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-sky-50 dark:bg-sky-950/50 text-sky-700 dark:text-sky-300 border border-sky-200 dark:border-sky-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-ping"></span>
                                            Sedang Pengerjaan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                            Selesai (Completed)
                                        </span>
                                    @endif

                                    @if ($att->jobApplication)
                                        @php
                                            $appStatus = $att->jobApplication->status;
                                            $badgeBg = match(strtolower($appStatus)) {
                                                'accepted' => 'text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/50 border-emerald-200 dark:border-emerald-800',
                                                'rejected' => 'text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/50 border-rose-200 dark:border-rose-800',
                                                'interview' => 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 border-indigo-200 dark:border-indigo-800',
                                                'shortlisted' => 'text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-950/50 border-purple-200 dark:border-purple-800',
                                                'reviewed' => 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/50 border-amber-200 dark:border-amber-800',
                                                default => 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/50 border-blue-200 dark:border-blue-800',
                                            };
                                        @endphp
                                        <div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border {{ $badgeBg }}">
                                                Lamaran: {{ $appStatus }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($isDisc && $att->discTestResult)
                                        <a href="{{ route($isRecruiter ? 'recruiter.test_evaluation.disc_pdf' : 'admin.test_evaluation.disc_pdf', $att->id) }}" target="_blank" title="Preview Laporan PDF DISC di Tab Baru" class="px-2.5 py-1.5 bg-purple-50 hover:bg-purple-100 dark:bg-purple-950/60 dark:hover:bg-purple-900 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800 rounded-xl text-xs font-semibold shadow-2xs transition-all flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="hidden sm:inline">Preview PDF</span>
                                        </a>
                                    @endif
                                    <button @click="openGradingModal({{ \Illuminate\Support\Js::from($att) }})" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold shadow-sm transition-all flex items-center justify-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <span>{{ ($isDisc && $att->discTestResult) ? 'Lihat Hasil DISC' : 'Evaluasi / Periksa' }}</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-400 dark:text-slate-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-10 h-10 text-gray-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-sm font-medium">Belum ada data pengerjaan tes pelamar</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($attempts->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-800">
                {{ $attempts->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Evaluasi & Essay Grading -->
    <div x-show="showGradingModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showGradingModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showGradingModal = false" class="fixed inset-0 transition-opacity bg-gray-900/60 dark:bg-black/70 backdrop-blur-sm"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showGradingModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full border border-gray-200 dark:border-slate-800">
                
                <div class="p-6">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-slate-800">
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-white">
                                Evaluasi & Penilaian Jawaban Pelamar
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                                Pelamar: <span class="font-bold text-gray-800 dark:text-gray-200" x-text="gradingData.applicant_name"></span> | Lowongan: <span class="font-medium text-indigo-600 dark:text-indigo-400" x-text="gradingData.job_title"></span>
                            </p>
                        </div>
                        <button @click="showGradingModal = false" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- DISC Personality Analysis Report (If DISC Result exists) -->
                    <template x-if="gradingData.disc_result">
                        <div class="my-4 p-5 rounded-2xl bg-purple-50/50 dark:bg-purple-950/20 border border-purple-200 dark:border-purple-800 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-purple-200 dark:border-purple-800/80 gap-3">
                                <div>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-purple-600 text-white uppercase tracking-wider">
                                        Hasil Profil DISC Pelamar
                                    </span>
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mt-1" x-text="gradingData.disc_result.disc_profile ? (gradingData.disc_result.disc_profile.pattern_code + ' - ' + gradingData.disc_result.disc_profile.title) : 'Tipe Kepribadian DISC'"></h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a :href="'{{ $isRecruiter ? '/recruiter/test-evaluations/' : '/admin/test-evaluations/' }}' + gradingData.id + '/disc-pdf'" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-100/80 hover:bg-purple-200 dark:bg-purple-900/60 dark:hover:bg-purple-800 text-purple-900 dark:text-purple-200 border border-purple-200 dark:border-purple-700 rounded-xl text-xs font-semibold shadow-2xs transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Preview PDF</span>
                                    </a>
                                    <a :href="'{{ $isRecruiter ? '/recruiter/test-evaluations/' : '/admin/test-evaluations/' }}' + gradingData.id + '/disc-pdf?download=1'" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-xs font-semibold shadow-sm shadow-purple-500/20 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span>Download PDF</span>
                                    </a>
                                </div>
                            </div>

                            <!-- DISC Score Table -->
                            <div class="overflow-x-auto rounded-xl border border-purple-200 dark:border-purple-800/80 shadow-2xs">
                                <table class="w-full text-xs text-center border-collapse bg-white dark:bg-slate-900">
                                    <thead>
                                        <tr class="bg-purple-600 text-white font-bold text-[11px]">
                                            <th class="py-2 px-3 text-left">Line / Dimensi</th>
                                            <th class="py-2 px-2">D</th>
                                            <th class="py-2 px-2">I</th>
                                            <th class="py-2 px-2">S</th>
                                            <th class="py-2 px-2">C</th>
                                            <th class="py-2 px-2">*</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-purple-100 dark:divide-purple-900/40 text-[11px] font-medium">
                                        <tr>
                                            <td class="py-1.5 px-3 text-left font-bold text-gray-700 dark:text-slate-300">1 (MOST - Public Self)</td>
                                            <td class="py-1.5 px-2 font-bold" x-text="gradingData.disc_result.line_1_scores?.raw?.D ?? 0"></td>
                                            <td class="py-1.5 px-2 font-bold" x-text="gradingData.disc_result.line_1_scores?.raw?.I ?? 0"></td>
                                            <td class="py-1.5 px-2 font-bold" x-text="gradingData.disc_result.line_1_scores?.raw?.S ?? 0"></td>
                                            <td class="py-1.5 px-2 font-bold" x-text="gradingData.disc_result.line_1_scores?.raw?.C ?? 0"></td>
                                            <td class="py-1.5 px-2 text-gray-400" x-text="gradingData.disc_result.line_1_scores?.raw?.['*'] ?? 0"></td>
                                        </tr>
                                        <tr>
                                            <td class="py-1.5 px-3 text-left font-bold text-gray-700 dark:text-slate-300">2 (LEAST - Core Self)</td>
                                            <td class="py-1.5 px-2 font-bold" x-text="gradingData.disc_result.line_2_scores?.raw?.D ?? 0"></td>
                                            <td class="py-1.5 px-2 font-bold" x-text="gradingData.disc_result.line_2_scores?.raw?.I ?? 0"></td>
                                            <td class="py-1.5 px-2 font-bold" x-text="gradingData.disc_result.line_2_scores?.raw?.S ?? 0"></td>
                                            <td class="py-1.5 px-2 font-bold" x-text="gradingData.disc_result.line_2_scores?.raw?.C ?? 0"></td>
                                            <td class="py-1.5 px-2 text-gray-400" x-text="gradingData.disc_result.line_2_scores?.raw?.['*'] ?? 0"></td>
                                        </tr>
                                        <tr class="bg-purple-50/60 dark:bg-purple-950/40 font-bold">
                                            <td class="py-1.5 px-3 text-left text-purple-700 dark:text-purple-300">3 (CHANGE - Perceived Self)</td>
                                            <td class="py-1.5 px-2" x-text="gradingData.disc_result.line_3_scores?.raw?.D ?? 0"></td>
                                            <td class="py-1.5 px-2" x-text="gradingData.disc_result.line_3_scores?.raw?.I ?? 0"></td>
                                            <td class="py-1.5 px-2" x-text="gradingData.disc_result.line_3_scores?.raw?.S ?? 0"></td>
                                            <td class="py-1.5 px-2" x-text="gradingData.disc_result.line_3_scores?.raw?.C ?? 0"></td>
                                            <td class="py-1.5 px-2 text-gray-400">-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- 3 Graph SVG Visualization Cards for Admin -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <!-- Graph 1: MOST -->
                                <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-rose-200 dark:border-rose-900/60 text-center space-y-2">
                                    <span class="text-[10px] font-bold text-rose-600 uppercase">Graph 1 (MOST) - Mask / Public</span>
                                    <div class="bg-rose-50/40 dark:bg-slate-950/40 rounded-lg p-1.5 border border-rose-100 dark:border-rose-950">
                                        <svg viewBox="0 0 220 160" class="w-full h-36">
                                            <!-- Grid Lines -->
                                            <line x1="20" y1="15" x2="205" y2="15" stroke="#f43f5e" stroke-dasharray="2" stroke-opacity="0.3" />
                                            <text x="5" y="18" fill="#9ca3af" font-size="8" font-family="monospace">+8</text>

                                            <line x1="20" y1="80" x2="205" y2="80" stroke="#f43f5e" stroke-width="1.5" stroke-opacity="0.8" />
                                            <text x="5" y="83" fill="#f43f5e" font-size="9" font-weight="bold" font-family="monospace">0</text>

                                            <line x1="20" y1="145" x2="205" y2="145" stroke="#f43f5e" stroke-dasharray="2" stroke-opacity="0.3" />
                                            <text x="5" y="148" fill="#9ca3af" font-size="8" font-family="monospace">-8</text>

                                            <!-- Axes & Labels -->
                                            <line x1="35" y1="10" x2="35" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                            <text x="35" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">D</text>

                                            <line x1="85" y1="10" x2="85" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                            <text x="85" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">I</text>

                                            <line x1="135" y1="10" x2="135" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                            <text x="135" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">S</text>

                                            <line x1="185" y1="10" x2="185" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                            <text x="185" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">C</text>

                                            <!-- Polyline -->
                                            <polyline fill="none" stroke="#e11d48" stroke-width="2.2" :points="getPolyline(gradingData.disc_result.line_1_scores?.converted)" stroke-linecap="round" stroke-linejoin="round" />

                                            <!-- Value Labels -->
                                            <text x="35" :y="calcY(gradingData.disc_result.line_1_scores?.converted?.D) - 5" fill="#be123c" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(gradingData.disc_result.line_1_scores?.converted?.D || 0).toFixed(1)"></text>
                                            <text x="85" :y="calcY(gradingData.disc_result.line_1_scores?.converted?.I) - 5" fill="#be123c" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(gradingData.disc_result.line_1_scores?.converted?.I || 0).toFixed(1)"></text>
                                            <text x="135" :y="calcY(gradingData.disc_result.line_1_scores?.converted?.S) - 5" fill="#be123c" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(gradingData.disc_result.line_1_scores?.converted?.S || 0).toFixed(1)"></text>
                                            <text x="185" :y="calcY(gradingData.disc_result.line_1_scores?.converted?.C) - 5" fill="#be123c" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(gradingData.disc_result.line_1_scores?.converted?.C || 0).toFixed(1)"></text>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Graph 2: LEAST -->
                                <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-amber-200 dark:border-amber-900/60 text-center space-y-2">
                                    <span class="text-[10px] font-bold text-amber-600 uppercase">Graph 2 (LEAST) - Core / Private</span>
                                    <div class="bg-amber-50/40 dark:bg-slate-950/40 rounded-lg p-1.5 border border-amber-100 dark:border-amber-950">
                                        <svg viewBox="0 0 220 160" class="w-full h-36">
                                            <!-- Grid Lines -->
                                            <line x1="20" y1="15" x2="205" y2="15" stroke="#f59e0b" stroke-dasharray="2" stroke-opacity="0.3" />
                                            <text x="5" y="18" fill="#9ca3af" font-size="8" font-family="monospace">+8</text>

                                            <line x1="20" y1="80" x2="205" y2="80" stroke="#f59e0b" stroke-width="1.5" stroke-opacity="0.8" />
                                            <text x="5" y="83" fill="#f59e0b" font-size="9" font-weight="bold" font-family="monospace">0</text>

                                            <line x1="20" y1="145" x2="205" y2="145" stroke="#f59e0b" stroke-dasharray="2" stroke-opacity="0.3" />
                                            <text x="5" y="148" fill="#9ca3af" font-size="8" font-family="monospace">-8</text>

                                            <!-- Axes & Labels -->
                                            <line x1="35" y1="10" x2="35" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                            <text x="35" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">D</text>

                                            <line x1="85" y1="10" x2="85" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                            <text x="85" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">I</text>

                                            <line x1="135" y1="10" x2="135" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                            <text x="135" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">S</text>

                                            <line x1="185" y1="10" x2="185" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                            <text x="185" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">C</text>

                                            <!-- Polyline -->
                                            <polyline fill="none" stroke="#d97706" stroke-width="2.2" :points="getPolyline(gradingData.disc_result.line_2_scores?.converted)" stroke-linecap="round" stroke-linejoin="round" />

                                            <!-- Value Labels -->
                                            <text x="35" :y="calcY(gradingData.disc_result.line_2_scores?.converted?.D) - 5" fill="#b45309" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(gradingData.disc_result.line_2_scores?.converted?.D || 0).toFixed(1)"></text>
                                            <text x="85" :y="calcY(gradingData.disc_result.line_2_scores?.converted?.I) - 5" fill="#b45309" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(gradingData.disc_result.line_2_scores?.converted?.I || 0).toFixed(1)"></text>
                                            <text x="135" :y="calcY(gradingData.disc_result.line_2_scores?.converted?.S) - 5" fill="#b45309" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(gradingData.disc_result.line_2_scores?.converted?.S || 0).toFixed(1)"></text>
                                            <text x="185" :y="calcY(gradingData.disc_result.line_2_scores?.converted?.C) - 5" fill="#b45309" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(gradingData.disc_result.line_2_scores?.converted?.C || 0).toFixed(1)"></text>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Graph 3: CHANGE -->
                                <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-indigo-200 dark:border-indigo-900/60 text-center space-y-2">
                                    <span class="text-[10px] font-bold text-indigo-600 uppercase">Graph 3 (CHANGE) - Mirror / Perceived</span>
                                    <div class="bg-indigo-50/40 dark:bg-slate-950/40 rounded-lg p-1.5 border border-indigo-100 dark:border-indigo-950">
                                        <svg viewBox="0 0 220 160" class="w-full h-36">
                                            <!-- Grid Lines -->
                                            <line x1="20" y1="15" x2="205" y2="15" stroke="#6366f1" stroke-dasharray="2" stroke-opacity="0.3" />
                                            <text x="5" y="18" fill="#9ca3af" font-size="8" font-family="monospace">+8</text>

                                            <line x1="20" y1="80" x2="205" y2="80" stroke="#6366f1" stroke-width="1.5" stroke-opacity="0.8" />
                                            <text x="5" y="83" fill="#6366f1" font-size="9" font-weight="bold" font-family="monospace">0</text>

                                            <line x1="20" y1="145" x2="205" y2="145" stroke="#6366f1" stroke-dasharray="2" stroke-opacity="0.3" />
                                            <text x="5" y="148" fill="#9ca3af" font-size="8" font-family="monospace">-8</text>

                                            <!-- Axes & Labels -->
                                            <line x1="35" y1="10" x2="35" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                            <text x="35" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">D</text>

                                            <line x1="85" y1="10" x2="85" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                            <text x="85" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">I</text>

                                            <line x1="135" y1="10" x2="135" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                            <text x="135" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">S</text>

                                            <line x1="185" y1="10" x2="185" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                            <text x="185" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">C</text>

                                            <!-- Polyline -->
                                            <polyline fill="none" stroke="#4f46e5" stroke-width="2.2" :points="getPolyline(gradingData.disc_result.line_3_scores?.converted)" stroke-linecap="round" stroke-linejoin="round" />

                                            <!-- Value Labels -->
                                            <text x="35" :y="calcY(gradingData.disc_result.line_3_scores?.converted?.D) - 5" fill="#4338ca" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(gradingData.disc_result.line_3_scores?.converted?.D || 0).toFixed(1)"></text>
                                            <text x="85" :y="calcY(gradingData.disc_result.line_3_scores?.converted?.I) - 5" fill="#4338ca" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(gradingData.disc_result.line_3_scores?.converted?.I || 0).toFixed(1)"></text>
                                            <text x="135" :y="calcY(gradingData.disc_result.line_3_scores?.converted?.S) - 5" fill="#4338ca" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(gradingData.disc_result.line_3_scores?.converted?.S || 0).toFixed(1)"></text>
                                            <text x="185" :y="calcY(gradingData.disc_result.line_3_scores?.converted?.C) - 5" fill="#4338ca" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(gradingData.disc_result.line_3_scores?.converted?.C || 0).toFixed(1)"></text>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Description (High Contrast Premium Card) -->
                            <template x-if="gradingData.disc_result.disc_profile">
                                <div class="p-4 rounded-xl bg-gradient-to-br from-slate-900 via-indigo-950 to-blue-950 text-white border border-indigo-500/40 shadow-md text-xs space-y-1.5">
                                    <div class="flex items-center gap-2 pb-1.5 border-b border-indigo-800/60">
                                        <span class="p-1 rounded bg-indigo-600 text-white text-[10px]">📖</span>
                                        <span class="text-[10px] font-black text-indigo-300 uppercase tracking-wider">Deskripsi Kepribadian:</span>
                                    </div>
                                    <p class="text-indigo-100/90 leading-relaxed font-normal pt-0.5" x-text="gradingData.disc_result.disc_profile.general_description || 'Analisis kepribadian pelamar berhasil dibentuk.'"></p>
                                </div>
                            </template>

                            <!-- Suitable Jobs Recommendation (Standar Internasional) -->
                            <template x-if="gradingData.disc_result.disc_profile && gradingData.disc_result.disc_profile.suitable_jobs">
                                <div class="rounded-xl overflow-hidden border border-amber-400/70 dark:border-amber-500/50 shadow-sm text-xs">
                                    <div class="bg-gradient-to-r from-amber-400 via-amber-300 to-yellow-400 dark:from-amber-500 dark:via-amber-400 dark:to-yellow-500 py-1.5 px-3 text-center">
                                        <h5 class="text-xs font-black text-gray-950 uppercase tracking-wide flex items-center justify-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-gray-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span>Profesi yang cocok :</span>
                                        </h5>
                                    </div>
                                    <div class="p-3 bg-white dark:bg-slate-900 text-gray-800 dark:text-slate-100 font-medium leading-relaxed text-center" x-text="gradingData.disc_result.disc_profile.suitable_jobs"></div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <!-- Score Card Header (Untuk Tes Objektif / Essay) -->
                    <template x-if="!gradingData.disc_result">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 my-4">
                            <div class="p-3 rounded-xl bg-indigo-50/60 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-800">
                                <span class="block text-[10px] font-semibold text-indigo-600 dark:text-indigo-400 uppercase">Skor Pilihan Ganda</span>
                                <span class="text-base font-extrabold text-indigo-900 dark:text-indigo-200" x-text="gradingData.objective_score"></span>
                            </div>
                            <div class="p-3 rounded-xl bg-amber-50/60 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800">
                                <span class="block text-[10px] font-semibold text-amber-600 dark:text-amber-400 uppercase">Skor Essay</span>
                                <span class="text-base font-extrabold text-amber-900 dark:text-amber-200" x-text="gradingData.essay_score"></span>
                            </div>
                            <div class="p-3 rounded-xl bg-emerald-50/60 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800">
                                <span class="block text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 uppercase">Total Skor Akhir</span>
                                <span class="text-base font-extrabold text-emerald-900 dark:text-emerald-200" x-text="gradingData.total_score"></span>
                            </div>
                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700">
                                <span class="block text-[10px] font-semibold text-gray-500 uppercase">KKM Minimum</span>
                                <span class="text-base font-extrabold text-gray-800 dark:text-slate-200" x-text="gradingData.passing_score + '%'"></span>
                            </div>
                        </div>
                    </template>

                    <!-- Form Penilaian Essay -->
                    <form :action="'{{ $gradeActionPrefix }}' + gradingData.id + '/grade'" method="POST" @submit="isSubmittingGrading = true" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="max-h-96 overflow-y-auto space-y-4 pr-1">
                            <template x-for="(ans, index) in gradingData.answers" :key="ans.id">
                                <div class="p-4 rounded-xl border transition" :class="ans.question && ans.question.question_type === 'essay' ? 'bg-amber-50/30 dark:bg-amber-950/20 border-amber-200 dark:border-amber-800/60' : 'bg-gray-50/50 dark:bg-slate-800/40 border-gray-200 dark:border-slate-700'">
                                    
                                    <div class="flex items-start justify-between gap-3 mb-2">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-lg bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-slate-300 font-bold text-xs flex items-center justify-center" x-text="index + 1"></span>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold" :class="ans.question && ans.question.question_type === 'multiple_choice' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300'" x-text="ans.question && ans.question.question_type === 'multiple_choice' ? 'Pilihan Ganda' : 'Essay / Uraian'"></span>
                                            <span class="text-xs font-bold text-gray-500 dark:text-slate-400" x-text="'(Bobot Max: ' + (ans.question ? ans.question.points : 1) + ' Poin)'"></span>
                                        </div>

                                        <!-- Reviewer badge if already reviewed -->
                                        <template x-if="ans.reviewer">
                                            <span class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Dinilai oleh: <span x-text="ans.reviewer.name"></span>
                                            </span>
                                        </template>
                                    </div>

                                    <!-- Pertanyaan -->
                                    <p class="text-xs font-bold text-gray-900 dark:text-white mb-2" x-text="ans.question ? ans.question.question : '-'"></p>

                                    <!-- Tipe Pilihan Ganda Display -->
                                    <template x-if="ans.question && ans.question.question_type === 'multiple_choice'">
                                        <div class="p-2.5 rounded-lg bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-xs space-y-1">
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-500 dark:text-slate-400">Jawaban Pelamar:</span>
                                                <span class="font-bold" :class="ans.option && ans.option.is_correct ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'" x-text="ans.option ? ans.option.option_text : 'Tidak Dijawab'"></span>
                                            </div>
                                            <div class="flex items-center justify-between pt-1 border-t border-gray-100 dark:border-slate-800">
                                                <span class="text-gray-500 dark:text-slate-400">Nilai Otomatis:</span>
                                                <span class="font-bold text-indigo-600 dark:text-indigo-400" x-text="ans.score + ' Poin'"></span>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Tipe Essay Grading Box -->
                                    <template x-if="ans.question && ans.question.question_type === 'essay'">
                                        <div class="space-y-3">
                                            <div class="p-3 rounded-lg bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-xs">
                                                <span class="block text-[11px] font-semibold text-gray-400 uppercase mb-1">Jawaban Teks Pelamar:</span>
                                                <p class="font-medium text-gray-800 dark:text-slate-200 whitespace-pre-line" x-text="ans.essay_answer || '(Pelamar tidak mengisikan jawaban teks)'"></p>
                                            </div>

                                            <!-- Lampiran File Pelamar (Local Storage) -->
                                            <template x-if="ans.attachment_url">
                                                <div class="flex items-center justify-between p-3 rounded-lg bg-indigo-50/70 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-800/60 text-xs">
                                                    <div class="flex items-center gap-2.5 min-w-0">
                                                        <div class="w-8 h-8 rounded-lg bg-indigo-600/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                            </svg>
                                                        </div>
                                                        <div class="truncate">
                                                            <span class="block font-semibold text-indigo-900 dark:text-indigo-200 truncate" x-text="ans.attachment_name || 'Lampiran File Jawaban'"></span>
                                                            <span class="text-[10px] text-gray-500 dark:text-slate-400" x-text="(ans.attachment_size ? Math.round(ans.attachment_size / 1024) + ' KB • ' : '') + 'Lampiran Tersimpan'"></span>
                                                        </div>
                                                    </div>
                                                    <a :href="ans.attachment_url" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-lg shadow-sm transition shrink-0 ml-2">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                        </svg>
                                                        <span>Buka / Unduh File</span>
                                                    </a>
                                                </div>
                                            </template>

                                            <div class="flex items-center justify-between bg-amber-100/50 dark:bg-amber-950/40 p-3 rounded-lg border border-amber-200 dark:border-amber-800/80">
                                                <label :for="'score_' + ans.id" class="text-xs font-bold text-amber-900 dark:text-amber-200">
                                                    Beri Nilai Skor (Max: <span x-text="ans.question ? ans.question.points : 1"></span>):
                                                </label>
                                                <div class="flex items-center gap-2">
                                                    <input type="number" step="0.5" min="0" :max="ans.question ? ans.question.points : 1" :name="'essay_scores[' + ans.id + ']'" :id="'score_' + ans.id" :value="ans.score !== null ? ans.score : ''" required placeholder="0" class="w-24 px-3 py-1 text-xs rounded-lg bg-white dark:bg-slate-900 border border-amber-300 dark:border-amber-700 text-gray-900 dark:text-white font-bold text-center focus:ring-2 focus:ring-amber-500 focus:outline-none">
                                                    <span class="text-xs font-semibold text-amber-800 dark:text-amber-300">Poin</span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                </div>
                            </template>
                        </div>

                        <!-- KEPUTUSAN STATUS LAMARAN OLEH HR (ONE-STOP DECISION) -->
                        <div class="mt-6 p-4 rounded-2xl bg-indigo-50/50 dark:bg-indigo-950/30 border border-indigo-200 dark:border-indigo-800/60 space-y-3">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                    ✓
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 dark:text-white">
                                        Tindakan & Keputusan Status Lamaran
                                    </h4>
                                    <p class="text-[11px] text-gray-500 dark:text-slate-400">
                                        Perbarui status lamaran kandidat secara langsung setelah evaluasi ujian selesai
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                <div>
                                    <label for="eval_app_status" class="block text-[11px] font-bold text-gray-700 dark:text-slate-300 mb-1">
                                        Pilih Status Lamaran:
                                    </label>
                                    <select name="application_status" id="eval_app_status" x-model="gradingData.application_status" class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white font-medium focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                                        <option value="Reviewed">Reviewed (Lolos Berkas / Tahap Tes)</option>
                                        <option value="Shortlisted">Shortlisted (Lolos Ujian / Siap Wawancara)</option>
                                        <option value="Interview">Interview (Wawancara)</option>
                                        <option value="Accepted">Accepted (Diterima)</option>
                                        <option value="Rejected">Rejected (Ditolak)</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="eval_app_notes" class="block text-[11px] font-bold text-gray-700 dark:text-slate-300 mb-1">
                                        Catatan / Feedback Evaluasi:
                                    </label>
                                    <input type="text" name="application_notes" id="eval_app_notes" x-model="gradingData.application_notes" placeholder="Contoh: Jawaban essay sangat analitis, siap dijadwalkan user interview..." class="w-full px-3 py-2 text-xs rounded-xl bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-800">
                            <button type="button" @click="showGradingModal = false" class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit" :disabled="isSubmittingGrading" class="px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl shadow-md shadow-indigo-500/20 transition flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                                <svg x-show="isSubmittingGrading" class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="isSubmittingGrading ? 'Menyimpan...' : 'Simpan Evaluasi & Perbarui Status'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
