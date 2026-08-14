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
            answers: att.answers || []
        };
        this.showGradingModal = true;
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
                <select wire:model.live="status" class="px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition max-w-[160px]">
                    <option value="">Semua Status</option>
                    <option value="needs_grading">Perlu Penilaian Essay</option>
                    <option value="completed">Selesai Dikoreksi</option>
                    <option value="passed">Lulus (Passed)</option>
                    <option value="failed">Gagal (Failed)</option>
                    <option value="in_progress">Sedang Dikerjakan</option>
                </select>

                @if ($search || $jobId || $status)
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
        <div wire:loading wire:target="search, jobId, status, previousPage, nextPage, gotoPage, resetFilters" class="absolute inset-0 bg-white/60 dark:bg-slate-900/60 backdrop-blur-[1px] flex items-center justify-center z-10 transition">
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
                        <th class="px-6 py-4">Pelamar & Lowongan</th>
                        <th class="px-6 py-4">Paket Ujian</th>
                        <th class="px-6 py-4">Waktu Pengerjaan</th>
                        <th class="px-6 py-4">Nilai P. Ganda / Essay</th>
                        <th class="px-6 py-4">Total & KKM</th>
                        <th class="px-6 py-4">Status</th>
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
                        @endphp
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-500 dark:text-slate-400">
                                {{ $attempts->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-0.5">
                                    <span class="block font-bold text-gray-900 dark:text-white">{{ $applicantName }}</span>
                                    <span class="text-[11px] text-gray-500 dark:text-slate-400">{{ $att->jobApplication->job->title ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-0.5">
                                    <span class="font-semibold text-gray-800 dark:text-slate-200">{{ $att->test->title ?? '-' }}</span>
                                    <span class="block text-[11px] text-gray-400">{{ $att->test->category->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-0.5 text-[11px]">
                                    <span class="block text-gray-700 dark:text-slate-300">
                                        {{ $att->started_at ? \Carbon\Carbon::parse($att->started_at)->format('d M Y H:i') : '-' }}
                                    </span>
                                    @if ($att->duration)
                                        <span class="text-gray-400">Durasi: {{ round($att->duration / 60) }} menit</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-0.5 text-[11px]">
                                    <div class="flex items-center gap-1.5 text-indigo-600 dark:text-indigo-400 font-semibold">
                                        <span>PG: {{ number_format($att->objective_score ?? 0, 1) }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-amber-600 dark:text-amber-400 font-semibold">
                                        <span>Essay: {{ number_format($att->essay_score ?? 0, 1) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-0.5">
                                    <span class="block text-sm font-extrabold text-gray-900 dark:text-white">
                                        {{ number_format($att->total_score ?? 0, 1) }}
                                    </span>
                                    <span class="text-[11px] text-gray-400">KKM: {{ number_format($att->test->passing_score ?? 0, 0) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($hasUnreviewedEssay)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800 animate-pulse">
                                        Perlu Koreksi Essay
                                    </span>
                                @elseif ($att->status === 'passed')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Lulus (Passed)
                                    </span>
                                @elseif ($att->status === 'failed')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                                        Gagal (Failed)
                                    </span>
                                @elseif ($att->status === 'in_progress')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 dark:bg-sky-950/50 text-sky-700 dark:text-sky-300 border border-sky-200 dark:border-sky-800">
                                        Sedang Pengerjaan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 border border-gray-200 dark:border-slate-700">
                                        {{ ucfirst($att->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button @click="openGradingModal({{ json_encode($att) }})" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold shadow-sm transition-all flex items-center justify-center gap-1.5 ml-auto">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span>Evaluasi / Periksa</span>
                                </button>
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

                    <!-- Score Card Header -->
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

                    <!-- Form Penilaian Essay -->
                    <form :action="'{{ url('admin/test-evaluations') }}/' + gradingData.id + '/grade'" method="POST" @submit="isSubmittingGrading = true" class="space-y-4">
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
                                                <p class="font-medium text-gray-800 dark:text-slate-200 whitespace-pre-line" x-text="ans.essay_answer || '(Pelamar tidak mengisikan jawaban essay)'"></p>
                                            </div>

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

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-800">
                            <button type="button" @click="showGradingModal = false" class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit" :disabled="isSubmittingGrading" class="px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl shadow-md shadow-indigo-500/20 transition flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                                <svg x-show="isSubmittingGrading" class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="isSubmittingGrading ? 'Menyimpan...' : 'Simpan Penilaian Essay'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
