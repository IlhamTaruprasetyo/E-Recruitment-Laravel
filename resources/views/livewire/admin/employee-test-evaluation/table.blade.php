<div class="space-y-6" x-data="{
    showGradeModal: false,
    selectedAttempt: null,
    showPdfViewer: false,
    activePdfUrl: null,
    activePdfName: null,

    openGradeModal(attempt) {
        this.selectedAttempt = attempt;
        this.showGradeModal = true;
        this.showPdfViewer = false;
        this.activePdfUrl = null;
        this.activePdfName = null;
    },

    getGroupedQuestions() {
        if (!this.selectedAttempt || !this.selectedAttempt.answers) return [];

        let groups = [];
        let map = {};

        this.selectedAttempt.answers.forEach(ans => {
            let qId = ans.question_id || (ans.question ? ans.question.id : 0);
            if (!map[qId]) {
                map[qId] = {
                    question_id: qId,
                    question: ans.question,
                    question_type: ans.question ? ans.question.question_type : (ans.answer_type === 'most' || ans.answer_type === 'least' ? 'disc' : 'multiple_choice'),
                    points: ans.question ? ans.question.points : 1,
                    answers: [],
                    most_answer: null,
                    least_answer: null,
                    single_answer: null
                };
                groups.push(map[qId]);
            }

            map[qId].answers.push(ans);

            if (ans.answer_type === 'most') {
                map[qId].most_answer = ans;
            } else if (ans.answer_type === 'least') {
                map[qId].least_answer = ans;
            } else {
                map[qId].single_answer = ans;
            }
        });

        // Urutkan berdasarkan ID pertanyaan atau nomor soal jika tersedia
        return groups;
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
    },

    openPdfPreview(url, name) {
        this.activePdfUrl = url;
        this.activePdfName = name || 'Lampiran PDF';
        this.showPdfViewer = true;
    },

    closePdfViewer() {
        this.showPdfViewer = false;
        this.activePdfUrl = null;
        this.activePdfName = null;
    }
}">

    <!-- Session Notifications -->
    @if (session('grade_success') || session('update'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs font-semibold">{{ session('grade_success') ?? session('update') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="text-xs font-semibold">{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-rose-500- hover:text-rose-700 dark:hover:text-rose-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Control Header -->
    <div class="p-5 bg-white dark:bg-slate-800 rounded-3xl border border-gray-100 dark:border-slate-700 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">

        <!-- Search & Filter Controls -->
        <div class="flex flex-wrap items-center gap-3 w-full flex-1">
            <div class="relative w-full sm:w-64">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama karyawan / NIK..."
                    class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-xl text-xs text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition cursor-pointer">
                <svg class="w-4 h-4 text-gray-400 dark:text-slate-400 absolute left-3.5 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Filter Departemen -->
            <select wire:model.live="departmentId" class="pl-3 pr-8 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition cursor-pointer">
                <option value="">Semua Departemen</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>

            <!-- Filter Tipe Pegawai -->
            <select wire:model.live="employeeType" class="pl-3 pr-8 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition cursor-pointer">
                <option value="">Semua Tipe</option>
                <option value="permanent">Karyawan Tetap</option>
                <option value="contract">Kontrak</option>
                <option value="internship">Magang / Intern</option>
                <option value="probation">Probation</option>
            </select>

            <!-- Filter Paket Asesmen -->
            <select wire:model.live="testId" class="pl-3 pr-8 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition cursor-pointer">
                <option value="">Semua Paket Asesmen</option>
                @foreach ($tests as $t)
                    <option value="{{ $t->id }}">{{ $t->title }}</option>
                @endforeach
            </select>

            <!-- Filter Status -->
            <select wire:model.live="status" class="pl-3 pr-8 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition cursor-pointer">
                <option value="">Semua Hasil</option>
                <option value="in_progress">Sedang Mengerjakan</option>
                <option value="disc">Tes Kepribadian DISC</option>
                <option value="passed">Lolos Standar</option>
                <option value="failed">Di Bawah Standar</option>
                <option value="needs_grading">Perlu Penilaian Essay</option>
            </select>

            @if ($search || $departmentId || $employeeType || $testId || $status)
                <button wire:click="resetFilters" class="p-2 text-gray-400 hover:text-rose-500 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 transition" title="Reset Filter">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <!-- Table Card Container -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-slate-700/80 bg-gray-50/50 dark:bg-slate-700/20 text-[11px] font-bold text-gray-400 dark:text-slate-400 uppercase tracking-wider">
                        <th class="py-4 px-6 w-12 text-center">No</th>
                        <th class="py-4 px-6">Karyawan</th>
                        <th class="py-4 px-6">Departemen / Posisi</th>
                        <th class="py-4 px-6">Paket Asesmen</th>
                        <th class="py-4 px-6 text-center">Waktu Pengerjaan</th>
                        <th class="py-4 px-6 text-center">Hasil / Nilai</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-right">Laporan / Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700/50 text-xs">
                    @forelse ($attempts as $index => $attempt)
                        @php
                            $emp = $attempt->user?->employeeProfile;
                            $discResult = $attempt->discTestResult;
                            $isDisc = $discResult || str_contains(strtolower($attempt->test?->title ?? ''), 'disc');
                        @endphp
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-slate-700/30 transition duration-150">
                            <td class="py-4 px-6 text-center font-medium text-gray-400 dark:text-slate-500">
                                {{ $attempts->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <div class="font-bold text-gray-800 dark:text-slate-100 text-sm">
                                        {{ $emp?->full_name ?? ($attempt->user?->name ?? 'Karyawan') }}
                                    </div>
                                    @if ($emp?->employee_type === 'internship')
                                        <span class="px-2 py-0.5 rounded-md bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 font-bold text-[10px] border border-amber-200 dark:border-amber-800/60">
                                            Magang
                                        </span>
                                    @elseif ($emp?->employee_type === 'contract')
                                        <span class="px-2 py-0.5 rounded-md bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 font-semibold text-[10px]">
                                            Kontrak
                                        </span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-gray-400 dark:text-slate-500 mt-0.5">
                                    NIK: {{ $emp?->nik ?? ($attempt->user?->nik ?? '-') }} ; {{ $attempt->user?->email ?? '-' }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-700 dark:text-slate-200">
                                    {{ $emp?->department?->name ?? 'Semua Departemen' }}
                                </div>
                                @if ($emp?->position_title)
                                    <div class="text-[11px] text-gray-400 dark:text-slate-500">
                                        {{ $emp->position_title }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800 dark:text-slate-200">
                                    {{ $attempt->test?->title ?? '-' }}
                                </div>
                                <div class="text-[11px] text-gray-400">
                                    {{ $attempt->test?->category?->name ?? 'Asesmen Internal' }}
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="font-medium text-gray-700 dark:text-slate-300">
                                    {{ \Carbon\Carbon::parse($attempt->finished_at ?? $attempt->started_at ?? now())->translatedFormat('d M Y, H:i') }}
                                </div>
                                @if ($attempt->duration)
                                    <div class="text-[10px] text-gray-400">Durasi: {{ round($attempt->duration / 60) }} mnt</div>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if ($isDisc && $discResult)
                                    <div class="inline-flex flex-col items-center">
                                        <span class="px-2.5 py-1 rounded-lg bg-purple-50 dark:bg-purple-950/40 text-purple-700 dark:text-purple-300 font-bold text-xs border border-purple-200 dark:border-purple-800/60">
                                            {{ $discResult->discProfile?->pattern_name ?? ($discResult->primary_trait ?? 'DISC Profil') }}
                                        </span>
                                    </div>
                                @else
                                    <div class="font-bold text-base {{ $attempt->status === 'passed' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                        {{ (float)($attempt->total_score ?? 0) }}
                                    </div>
                                    <div class="text-[10px] text-gray-400">Standar: {{ (float)($attempt->test?->passing_score ?? 0) }}</div>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if ($attempt->status === 'in_progress')
                                    <span class="inline-flex items-center justify-center gap-1.5 whitespace-nowrap px-2.5 py-1 rounded-full bg-sky-100 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 font-semibold text-[11px] border border-sky-200 dark:border-sky-800">
                                        {{-- <span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-ping shrink-0"></span> --}}
                                        Sedang Mengerjakan
                                    </span>
                                @elseif ($isDisc)
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-2.5 py-1 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 font-semibold text-[11px]">
                                        Selesai
                                    </span>
                                @elseif ($attempt->status === 'passed')
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 font-semibold text-[11px]">
                                        Lolos Standar
                                    </span>
                                @elseif ($attempt->status === 'failed')
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-2.5 py-1 rounded-full bg-rose-100 dark:bg-rose-900/40 text-rose-700 dark:text-rose-300 font-semibold text-[11px]">
                                        Di Bawah Standar
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 font-semibold text-[11px]">
                                        Sedang Proses
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end">
                                    <!-- Tombol Evaluasi / Lihat Riwayat Jawaban -->
                                    <button @click="openGradeModal({{ \Illuminate\Support\Js::from($attempt) }})"
                                        class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-semibold text-xs rounded-xl shadow-sm transition flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>{{ $isDisc ? 'Riwayat Jawaban & Profil' : 'Riwayat Jawaban & Nilai' }}</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-400 dark:text-slate-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-gray-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span>Belum ada riwayat pengerjaan asesmen dari karyawan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($attempts->hasPages() || $perPage != 10)
            <div class="p-4 border-t border-gray-100 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500 dark:text-slate-400">Tampilkan</span>
                    <select wire:model.live="perPage" class="pl-2.5 pr-7 py-1.5 text-xs rounded-lg bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition cursor-pointer">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="text-xs text-gray-500 dark:text-slate-400">data per halaman</span>
                </div>
                @if ($attempts->hasPages())
                    <div>
                        {{ $attempts->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- MODAL EVALUASI & RIWAYAT JAWABAN KARYAWAN -->
    <div x-show="showGradeModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="min-h-screen px-4 flex items-center justify-center">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="showGradeModal = false"></div>

            <div class="relative bg-white dark:bg-slate-800 rounded-3xl max-w-4xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 dark:border-slate-700 z-10 max-h-[90vh] overflow-y-auto" x-show="selectedAttempt">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100">
                            Riwayat Jawaban & Evaluasi Asesmen Karyawan
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Karyawan: <span class="font-bold text-gray-700 dark:text-slate-200" x-text="selectedAttempt.user?.employee_profile?.full_name || selectedAttempt.user?.name || 'Karyawan'"></span> |
                            Departemen: <span class="font-medium text-indigo-600 dark:text-indigo-400" x-text="selectedAttempt.user?.employee_profile?.department?.name || 'Semua Divisi'"></span> |
                            Ujian: <span class="font-medium text-gray-700 dark:text-slate-300" x-text="selectedAttempt.test?.title || '-'"></span>
                        </p>
                    </div>
                    <button @click="showGradeModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-slate-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="selectedAttempt">
                    <div>
                        <!-- DISC PERSONALITY REPORT PREVIEW (IF DISC RESULT EXISTS) -->
                        <template x-if="selectedAttempt.disc_test_result">
                            <div class="mb-5 p-5 rounded-2xl bg-purple-50/50 dark:bg-purple-950/20 border border-purple-200 dark:border-purple-800 space-y-4">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-purple-200 dark:border-purple-800/80 gap-3">
                                    <div>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-purple-600 text-white uppercase tracking-wider">
                                            Hasil Profil DISC Karyawan
                                        </span>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white mt-1" x-text="selectedAttempt.disc_test_result.disc_profile ? (selectedAttempt.disc_test_result.disc_profile.pattern_code + ' - ' + selectedAttempt.disc_test_result.disc_profile.title) : 'Tipe Kepribadian DISC'"></h4>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a :href="'{{ url('admin/test-evaluations') }}/' + selectedAttempt.id + '/disc-pdf'" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-100/80 hover:bg-purple-200 dark:bg-purple-900/60 dark:hover:bg-purple-800 text-purple-900 dark:text-purple-200 border border-purple-200 dark:border-purple-700 rounded-xl text-xs font-semibold shadow-2xs transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Buka Lembar PDF DISC</span>
                                        </a>
                                        <a :href="'{{ url('admin/test-evaluations') }}/' + selectedAttempt.id + '/disc-pdf?download=1'" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-xs font-semibold shadow-sm transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            <span>Unduh PDF</span>
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
                                                <td class="py-1.5 px-2 font-bold" x-text="selectedAttempt.disc_test_result.line_1_scores?.raw?.D ?? 0"></td>
                                                <td class="py-1.5 px-2 font-bold" x-text="selectedAttempt.disc_test_result.line_1_scores?.raw?.I ?? 0"></td>
                                                <td class="py-1.5 px-2 font-bold" x-text="selectedAttempt.disc_test_result.line_1_scores?.raw?.S ?? 0"></td>
                                                <td class="py-1.5 px-2 font-bold" x-text="selectedAttempt.disc_test_result.line_1_scores?.raw?.C ?? 0"></td>
                                                <td class="py-1.5 px-2 text-gray-400" x-text="selectedAttempt.disc_test_result.line_1_scores?.raw?.['*'] ?? 0"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1.5 px-3 text-left font-bold text-gray-700 dark:text-slate-300">2 (LEAST - Core Self)</td>
                                                <td class="py-1.5 px-2 font-bold" x-text="selectedAttempt.disc_test_result.line_2_scores?.raw?.D ?? 0"></td>
                                                <td class="py-1.5 px-2 font-bold" x-text="selectedAttempt.disc_test_result.line_2_scores?.raw?.I ?? 0"></td>
                                                <td class="py-1.5 px-2 font-bold" x-text="selectedAttempt.disc_test_result.line_2_scores?.raw?.S ?? 0"></td>
                                                <td class="py-1.5 px-2 font-bold" x-text="selectedAttempt.disc_test_result.line_2_scores?.raw?.C ?? 0"></td>
                                                <td class="py-1.5 px-2 text-gray-400" x-text="selectedAttempt.disc_test_result.line_2_scores?.raw?.['*'] ?? 0"></td>
                                            </tr>
                                            <tr class="bg-purple-50/60 dark:bg-purple-950/40 font-bold">
                                                <td class="py-1.5 px-3 text-left text-purple-700 dark:text-purple-300">3 (CHANGE - Perceived Self)</td>
                                                <td class="py-1.5 px-2" x-text="selectedAttempt.disc_test_result.line_3_scores?.raw?.D ?? 0"></td>
                                                <td class="py-1.5 px-2" x-text="selectedAttempt.disc_test_result.line_3_scores?.raw?.I ?? 0"></td>
                                                <td class="py-1.5 px-2" x-text="selectedAttempt.disc_test_result.line_3_scores?.raw?.S ?? 0"></td>
                                                <td class="py-1.5 px-2" x-text="selectedAttempt.disc_test_result.line_3_scores?.raw?.C ?? 0"></td>
                                                <td class="py-1.5 px-2 text-gray-400">-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- 3 Graph Visualization Cards -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <!-- Graph 1: MOST -->
                                    <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-rose-200 dark:border-rose-900/60 text-center space-y-2">
                                        <span class="text-[10px] font-bold text-rose-600 uppercase">Graph 1 (MOST) - Mask / Public</span>
                                        <div class="bg-rose-50/40 dark:bg-slate-950/40 rounded-lg p-1.5 border border-rose-100 dark:border-rose-950">
                                            <svg viewBox="0 0 220 160" class="w-full h-36">
                                                <line x1="20" y1="15" x2="205" y2="15" stroke="#f43f5e" stroke-dasharray="2" stroke-opacity="0.3" />
                                                <text x="5" y="18" fill="#9ca3af" font-size="8" font-family="monospace">+8</text>
                                                <line x1="20" y1="80" x2="205" y2="80" stroke="#f43f5e" stroke-width="1.5" stroke-opacity="0.8" />
                                                <text x="5" y="83" fill="#f43f5e" font-size="9" font-weight="bold" font-family="monospace">0</text>
                                                <line x1="20" y1="145" x2="205" y2="145" stroke="#f43f5e" stroke-dasharray="2" stroke-opacity="0.3" />
                                                <text x="5" y="148" fill="#9ca3af" font-size="8" font-family="monospace">-8</text>

                                                <line x1="35" y1="10" x2="35" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                                <text x="35" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">D</text>
                                                <line x1="85" y1="10" x2="85" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                                <text x="85" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">I</text>
                                                <line x1="135" y1="10" x2="135" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                                <text x="135" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">S</text>
                                                <line x1="185" y1="10" x2="185" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                                <text x="185" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">C</text>

                                                <polyline fill="none" stroke="#e11d48" stroke-width="2.2" :points="getPolyline(selectedAttempt.disc_test_result.line_1_scores?.converted)" stroke-linecap="round" stroke-linejoin="round" />

                                                <text x="35" :y="calcY(selectedAttempt.disc_test_result.line_1_scores?.converted?.D) - 5" fill="#be123c" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(selectedAttempt.disc_test_result.line_1_scores?.converted?.D || 0).toFixed(1)"></text>
                                                <text x="85" :y="calcY(selectedAttempt.disc_test_result.line_1_scores?.converted?.I) - 5" fill="#be123c" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(selectedAttempt.disc_test_result.line_1_scores?.converted?.I || 0).toFixed(1)"></text>
                                                <text x="135" :y="calcY(selectedAttempt.disc_test_result.line_1_scores?.converted?.S) - 5" fill="#be123c" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(selectedAttempt.disc_test_result.line_1_scores?.converted?.S || 0).toFixed(1)"></text>
                                                <text x="185" :y="calcY(selectedAttempt.disc_test_result.line_1_scores?.converted?.C) - 5" fill="#be123c" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(selectedAttempt.disc_test_result.line_1_scores?.converted?.C || 0).toFixed(1)"></text>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Graph 2: LEAST -->
                                    <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-amber-200 dark:border-amber-900/60 text-center space-y-2">
                                        <span class="text-[10px] font-bold text-amber-600 uppercase">Graph 2 (LEAST) - Core / Private</span>
                                        <div class="bg-amber-50/40 dark:bg-slate-950/40 rounded-lg p-1.5 border border-amber-100 dark:border-amber-950">
                                            <svg viewBox="0 0 220 160" class="w-full h-36">
                                                <line x1="20" y1="15" x2="205" y2="15" stroke="#f59e0b" stroke-dasharray="2" stroke-opacity="0.3" />
                                                <text x="5" y="18" fill="#9ca3af" font-size="8" font-family="monospace">+8</text>
                                                <line x1="20" y1="80" x2="205" y2="80" stroke="#f59e0b" stroke-width="1.5" stroke-opacity="0.8" />
                                                <text x="5" y="83" fill="#f59e0b" font-size="9" font-weight="bold" font-family="monospace">0</text>
                                                <line x1="20" y1="145" x2="205" y2="145" stroke="#f59e0b" stroke-dasharray="2" stroke-opacity="0.3" />
                                                <text x="5" y="148" fill="#9ca3af" font-size="8" font-family="monospace">-8</text>

                                                <line x1="35" y1="10" x2="35" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                                <text x="35" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">D</text>
                                                <line x1="85" y1="10" x2="85" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                                <text x="85" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">I</text>
                                                <line x1="135" y1="10" x2="135" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                                <text x="135" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">S</text>
                                                <line x1="185" y1="10" x2="185" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                                <text x="185" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">C</text>

                                                <polyline fill="none" stroke="#d97706" stroke-width="2.2" :points="getPolyline(selectedAttempt.disc_test_result.line_2_scores?.converted)" stroke-linecap="round" stroke-linejoin="round" />

                                                <text x="35" :y="calcY(selectedAttempt.disc_test_result.line_2_scores?.converted?.D) - 5" fill="#b45309" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(selectedAttempt.disc_test_result.line_2_scores?.converted?.D || 0).toFixed(1)"></text>
                                                <text x="85" :y="calcY(selectedAttempt.disc_test_result.line_2_scores?.converted?.I) - 5" fill="#b45309" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(selectedAttempt.disc_test_result.line_2_scores?.converted?.I || 0).toFixed(1)"></text>
                                                <text x="135" :y="calcY(selectedAttempt.disc_test_result.line_2_scores?.converted?.S) - 5" fill="#b45309" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(selectedAttempt.disc_test_result.line_2_scores?.converted?.S || 0).toFixed(1)"></text>
                                                <text x="185" :y="calcY(selectedAttempt.disc_test_result.line_2_scores?.converted?.C) - 5" fill="#b45309" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(selectedAttempt.disc_test_result.line_2_scores?.converted?.C || 0).toFixed(1)"></text>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Graph 3: CHANGE -->
                                    <div class="p-3 rounded-xl bg-white dark:bg-slate-900 border border-indigo-200 dark:border-indigo-900/60 text-center space-y-2">
                                        <span class="text-[10px] font-bold text-indigo-600 uppercase">Graph 3 (CHANGE) - Mirror / Perceived</span>
                                        <div class="bg-indigo-50/40 dark:bg-slate-950/40 rounded-lg p-1.5 border border-indigo-100 dark:border-indigo-950">
                                            <svg viewBox="0 0 220 160" class="w-full h-36">
                                                <line x1="20" y1="15" x2="205" y2="15" stroke="#6366f1" stroke-dasharray="2" stroke-opacity="0.3" />
                                                <text x="5" y="18" fill="#9ca3af" font-size="8" font-family="monospace">+8</text>
                                                <line x1="20" y1="80" x2="205" y2="80" stroke="#6366f1" stroke-width="1.5" stroke-opacity="0.8" />
                                                <text x="5" y="83" fill="#6366f1" font-size="9" font-weight="bold" font-family="monospace">0</text>
                                                <line x1="20" y1="145" x2="205" y2="145" stroke="#6366f1" stroke-dasharray="2" stroke-opacity="0.3" />
                                                <text x="5" y="148" fill="#9ca3af" font-size="8" font-family="monospace">-8</text>

                                                <line x1="35" y1="10" x2="35" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                                <text x="35" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">D</text>
                                                <line x1="85" y1="10" x2="85" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                                <text x="85" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">I</text>
                                                <line x1="135" y1="10" x2="135" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                                <text x="135" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">S</text>
                                                <line x1="185" y1="10" x2="185" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.4" />
                                                <text x="185" y="157" fill="#64748b" font-size="9" font-weight="bold" text-anchor="middle">C</text>

                                                <polyline fill="none" stroke="#4f46e5" stroke-width="2.2" :points="getPolyline(selectedAttempt.disc_test_result.line_3_scores?.converted)" stroke-linecap="round" stroke-linejoin="round" />

                                                <text x="35" :y="calcY(selectedAttempt.disc_test_result.line_3_scores?.converted?.D) - 5" fill="#4338ca" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(selectedAttempt.disc_test_result.line_3_scores?.converted?.D || 0).toFixed(1)"></text>
                                                <text x="85" :y="calcY(selectedAttempt.disc_test_result.line_3_scores?.converted?.I) - 5" fill="#4338ca" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(selectedAttempt.disc_test_result.line_3_scores?.converted?.I || 0).toFixed(1)"></text>
                                                <text x="135" :y="calcY(selectedAttempt.disc_test_result.line_3_scores?.converted?.S) - 5" fill="#4338ca" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(selectedAttempt.disc_test_result.line_3_scores?.converted?.S || 0).toFixed(1)"></text>
                                                <text x="185" :y="calcY(selectedAttempt.disc_test_result.line_3_scores?.converted?.C) - 5" fill="#4338ca" font-size="8" font-weight="bold" text-anchor="middle" x-text="parseFloat(selectedAttempt.disc_test_result.line_3_scores?.converted?.C || 0).toFixed(1)"></text>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Score Summary Header Cards (Untuk Tes Non-DISC) -->
                        <template x-if="!selectedAttempt.disc_test_result">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
                                <div class="p-3.5 rounded-2xl bg-indigo-50/60 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-800">
                                    <span class="block text-[10px] font-semibold text-indigo-600 dark:text-indigo-400 uppercase">Skor Pilihan Ganda</span>
                                    <span class="text-base font-extrabold text-indigo-900 dark:text-indigo-200" x-text="(selectedAttempt.objective_score || 0) + ' Poin'"></span>
                                </div>
                                <div class="p-3.5 rounded-2xl bg-amber-50/60 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800">
                                    <span class="block text-[10px] font-semibold text-amber-600 dark:text-amber-400 uppercase">Skor Essay</span>
                                    <span class="text-base font-extrabold text-amber-900 dark:text-amber-200" x-text="(selectedAttempt.essay_score !== null ? selectedAttempt.essay_score : '-') + ' Poin'"></span>
                                </div>
                                <div class="p-3.5 rounded-2xl bg-emerald-50/60 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800">
                                    <span class="block text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 uppercase">Total Nilai Akhir</span>
                                    <span class="text-base font-extrabold text-emerald-900 dark:text-emerald-200" x-text="(selectedAttempt.total_score || 0) + ' Poin'"></span>
                                </div>
                                <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-slate-700/40 border border-gray-100 dark:border-slate-700">
                                    <span class="block text-[10px] font-semibold text-gray-400 uppercase">Standar Lolos KKM</span>
                                    <span class="text-base font-extrabold text-gray-800 dark:text-slate-200" x-text="(selectedAttempt.test ? selectedAttempt.test.passing_score : '-') + ' Poin'"></span>
                                </div>
                            </div>
                        </template>

                        <!-- FORM / DAFTAR SELURUH BUTIR JAWABAN BERURUTAN (PILIHAN GANDA, ESSAY, & DISC) -->
                        <form :action="'{{ url('admin/test-evaluations') }}/' + selectedAttempt.id + '/grade'" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="flex items-center justify-between pt-1">
                                <h4 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                                    Daftar Riwayat Soal & Jawaban (Urut per Nomor)
                                </h4>
                                <span class="text-[11px] text-gray-400" x-text="getGroupedQuestions().length + ' Nomor Soal Tercatat'"></span>
                            </div>

                            <div class="space-y-3.5 max-h-[50vh] overflow-y-auto pr-1">
                                <template x-for="(item, idx) in getGroupedQuestions()" :key="item.question_id || idx">
                                    <div class="p-4 rounded-2xl border transition text-xs space-y-3"
                                        :class="item.question_type === 'essay' ? 'bg-amber-50/40 dark:bg-amber-950/20 border-amber-200 dark:border-amber-800/60' : (item.question_type === 'disc' || item.most_answer || item.least_answer ? 'bg-purple-50/40 dark:bg-purple-950/20 border-purple-200 dark:border-purple-800/60' : 'bg-gray-50/60 dark:bg-slate-700/30 border-gray-200 dark:border-slate-700')">

                                        <!-- Header Butir Soal -->
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="flex items-center gap-2">
                                                <span class="w-6 h-6 rounded-lg bg-gray-200 dark:bg-slate-700 text-gray-800 dark:text-slate-200 font-bold text-xs flex items-center justify-center" x-text="idx + 1"></span>

                                                <!-- Badge Tipe Soal -->
                                                <template x-if="item.question_type === 'multiple_choice'">
                                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                                                        Soal Pilihan Ganda
                                                    </span>
                                                </template>
                                                <template x-if="item.question_type === 'essay'">
                                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300">
                                                        Soal Uraian / Essay
                                                    </span>
                                                </template>
                                                <template x-if="item.question_type === 'disc' || item.most_answer || item.least_answer">
                                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-purple-100 text-purple-700 dark:bg-purple-950 dark:text-purple-300">
                                                        Nomor DISC (P & K)
                                                    </span>
                                                </template>

                                                <template x-if="item.question_type !== 'disc' && !item.most_answer && !item.least_answer">
                                                    <span class="text-[11px] text-gray-400" x-text="'(Bobot: ' + (item.points || 1) + ' Poin)'"></span>
                                                </template>
                                            </div>

                                            <template x-if="item.single_answer && item.single_answer.reviewer">
                                                <span class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Dinilai: <span x-text="item.single_answer.reviewer.name"></span>
                                                </span>
                                            </template>
                                        </div>

                                        <!-- Pertanyaan Soal -->
                                        <div class="font-semibold text-gray-800 dark:text-slate-200" x-text="item.question?.question || ('Nomor Soal ' + (idx + 1))"></div>

                                        <!-- 1. JAWABAN PILIHAN GANDA -->
                                        <template x-if="item.question_type === 'multiple_choice' && item.single_answer">
                                            <div class="p-3 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 space-y-1.5">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-gray-500 dark:text-slate-400">Jawaban Karyawan:</span>
                                                    <span class="font-bold" :class="item.single_answer.option && item.single_answer.option.is_correct ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'" x-text="item.single_answer.option ? item.single_answer.option.option_text : '(Belum Dijawab)'"></span>
                                                </div>
                                                <div class="flex items-center justify-between pt-1 border-t border-gray-100 dark:border-slate-700">
                                                    <span class="text-gray-500 dark:text-slate-400">Status & Skor Sistem:</span>
                                                    <span class="font-bold" :class="item.single_answer.score > 0 ? 'text-emerald-600' : 'text-rose-500'" x-text="(item.single_answer.score || 0) + ' Poin ' + (item.single_answer.option?.is_correct ? '(Benar)' : '(Salah)')"></span>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- 2. JAWABAN DISC (1 SOAL = P DAN K) -->
                                        <template x-if="item.question_type === 'disc' || item.most_answer || item.least_answer">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                                <!-- Paling Sesuai (P / MOST) -->
                                                <div class="p-3 rounded-xl bg-white dark:bg-slate-800 border-2 border-emerald-300 dark:border-emerald-700/70 shadow-2xs space-y-1">
                                                    <div class="flex items-center justify-between">
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 font-extrabold text-[10px]">
                                                            {{-- <span class="w-2 h-2 rounded-full bg-emerald-500"></span> --}}
                                                            P (Paling Sesuai / Most)
                                                        </span>
                                                        <span class="text-[10px] font-bold text-gray-500 dark:text-slate-400" x-text="item.most_answer?.option?.most_tag || item.most_answer?.option?.attribute_tag ? 'Dimensi: ' + (item.most_answer?.option?.most_tag || item.most_answer?.option?.attribute_tag) : ''"></span>
                                                    </div>
                                                    <p class="font-bold text-gray-800 dark:text-slate-100 text-xs pt-1" x-text="item.most_answer?.option ? item.most_answer.option.option_text : '(Tidak Dipilih)'"></p>
                                                </div>

                                                <!-- Kurang Sesuai (K / LEAST) -->
                                                <div class="p-3 rounded-xl bg-white dark:bg-slate-800 border-2 border-rose-300 dark:border-rose-700/70 shadow-2xs space-y-1">
                                                    <div class="flex items-center justify-between">
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-rose-100 dark:bg-rose-950/60 text-rose-800 dark:text-rose-300 font-extrabold text-[10px]">
                                                            {{-- <span class="w-2 h-2 rounded-full bg-rose-500"></span> --}}
                                                            K (Kurang Sesuai / Least)
                                                        </span>
                                                        <span class="text-[10px] font-bold text-gray-500 dark:text-slate-400" x-text="item.least_answer?.option?.least_tag || item.least_answer?.option?.attribute_tag ? 'Dimensi: ' + (item.least_answer?.option?.least_tag || item.least_answer?.option?.attribute_tag) : ''"></span>
                                                    </div>
                                                    <p class="font-bold text-gray-800 dark:text-slate-100 text-xs pt-1" x-text="item.least_answer?.option ? item.least_answer.option.option_text : '(Tidak Dipilih)'"></p>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- 3. JAWABAN ESSAY & LAMPIRAN + INPUT NILAI KOREKSI -->
                                        <template x-if="item.question_type === 'essay' && item.single_answer">
                                            <div class="space-y-3">
                                                <!-- Jawaban Teks -->
                                                <div class="p-3 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-300 font-mono text-[11px] whitespace-pre-line" x-text="item.single_answer.essay_answer || '(Karyawan tidak mengisi jawaban teks)'"></div>

                                                <!-- Lampiran File / Dokumen -->
                                                <template x-if="item.single_answer.attachment_url">
                                                    <div class="rounded-xl border border-indigo-200 dark:border-indigo-800/60 bg-indigo-50/60 dark:bg-indigo-950/30 overflow-hidden">
                                                        <div class="flex items-center justify-between px-3.5 py-2.5 gap-2">
                                                            <div class="flex items-center gap-2.5 min-w-0">
                                                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                                                    :class="item.single_answer.attachment_name && item.single_answer.attachment_name.toLowerCase().endsWith('.pdf') ? 'bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400' : 'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400'">
                                                                    <template x-if="item.single_answer.attachment_name && item.single_answer.attachment_name.toLowerCase().endsWith('.pdf')">
                                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM9.5 17.5c-.28 0-.5-.22-.5-.5v-4c0-.28.22-.5.5-.5s.5.22.5.5v4c0 .28-.22.5-.5.5zm2-4.5h.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5H12v1c0 .28-.22.5-.5.5s-.5-.22-.5-.5v-4c0-.28.22-.5.5-.5zm.5 2c.28 0 .5-.22.5-.5s-.22-.5-.5-.5H12v1h.5zm2.5-2h1c.83 0 1.5.67 1.5 1.5v1c0 .83-.67 1.5-1.5 1.5h-1c-.28 0-.5-.22-.5-.5v-4c0-.28.22-.5.5-.5zm.5 3h.5c.28 0 .5-.22.5-.5v-1c0-.28-.22-.5-.5-.5H15v2z"/></svg>
                                                                    </template>
                                                                    <template x-if="!(item.single_answer.attachment_name && item.single_answer.attachment_name.toLowerCase().endsWith('.pdf'))">
                                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                                                    </template>
                                                                </div>
                                                                <div class="truncate">
                                                                    <span class="block font-semibold text-indigo-900 dark:text-indigo-200 truncate text-[11px]" x-text="item.single_answer.attachment_name || 'Lampiran File Jawaban'"></span>
                                                                    <span class="text-[10px] text-gray-500 dark:text-slate-400" x-text="item.single_answer.attachment_size ? Math.round(item.single_answer.attachment_size / 1024) + ' KB' : 'File Terlampir'"></span>
                                                                </div>
                                                            </div>
                                                            <div class="flex items-center gap-1.5 shrink-0">
                                                                <template x-if="item.single_answer.attachment_name && item.single_answer.attachment_name.toLowerCase().endsWith('.pdf')">
                                                                    <button type="button"
                                                                        @click="openPdfPreview(item.single_answer.attachment_url, item.single_answer.attachment_name)"
                                                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 text-[11px] font-semibold text-rose-700 dark:text-rose-300 bg-rose-100 dark:bg-rose-900/40 hover:bg-rose-200 dark:hover:bg-rose-900/70 rounded-lg border border-rose-200 dark:border-rose-800 transition">
                                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                                        <span>Preview PDF</span>
                                                                    </button>
                                                                </template>
                                                                <a :href="item.single_answer.attachment_url" target="_blank"
                                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 text-[11px] font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition">
                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                                                    <span>Unduh</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>

                                                <!-- Penilaian Essay -->
                                                <div class="flex items-center justify-between pt-2 border-t border-amber-200/80 dark:border-amber-900/60">
                                                    <span class="text-[11px] font-medium text-gray-500">Poin Maksimal: <span class="font-bold text-gray-700 dark:text-slate-300" x-text="item.points || 10"></span></span>
                                                    <div class="flex items-center gap-2">
                                                        <label class="text-[11px] font-bold text-amber-900 dark:text-amber-200">Beri Nilai Essay:</label>
                                                        <input type="number" :name="'essay_scores[' + item.single_answer.id + ']'" :value="item.single_answer.score !== null ? item.single_answer.score : ''" min="0" :max="item.points || 100" step="0.5" placeholder="0" class="w-20 px-2.5 py-1 bg-white dark:bg-slate-900 border border-amber-300 dark:border-amber-700 rounded-xl text-xs text-center font-bold focus:ring-2 focus:ring-amber-500 outline-none">
                                                        <span class="text-xs text-amber-800 dark:text-amber-300 font-semibold">Poin</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                    </div>
                                </template>
                            </div>

                            <!-- Footer Form -->
                            <div class="pt-4 border-t border-gray-100 dark:border-slate-700 flex items-center justify-between">
                                <span class="text-[11px] text-gray-400">
                                    *Penilaian essay otomatis menghitung total skor dan memperbarui status kelulusan KKM karyawan.
                                </span>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="showGradeModal = false" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-slate-600 text-xs font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                        Tutup
                                    </button>
                                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-md transition">
                                        Simpan Nilai Evaluasi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- MODAL PDF VIEWER -->
    <div x-show="showPdfViewer" x-cloak class="fixed inset-0 z-[60] overflow-hidden flex flex-col" style="display: none;">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gray-950/80 backdrop-blur-sm" @click="closePdfViewer()"></div>

        <!-- Modal Box -->
        <div class="relative z-10 flex flex-col w-full h-full max-w-5xl mx-auto my-4 px-4">
            <!-- Header -->
            <div class="flex items-center justify-between px-5 py-3.5 bg-white dark:bg-slate-800 rounded-t-2xl border border-b-0 border-gray-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800 dark:text-slate-100" x-text="activePdfName"></p>
                        <p class="text-[11px] text-gray-400">Pratinjau Lampiran Jawaban Essay</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a :href="activePdfUrl" target="_blank"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        Unduh File
                    </a>
                    <button type="button" @click="closePdfViewer()"
                        class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-xl transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>

            <!-- PDF Embed Frame -->
            <div class="flex-1 bg-gray-100 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-b-2xl overflow-hidden shadow-2xl">
                <iframe
                    :src="activePdfUrl + '#toolbar=1&navpanes=0&scrollbar=1'"
                    class="w-full h-full min-h-[70vh]"
                    frameborder="0"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>

</div>
