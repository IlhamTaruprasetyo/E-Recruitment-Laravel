<div class="space-y-6" x-data="{
    showGradeModal: false,
    selectedAttempt: null,

    openGradeModal(attempt) {
        this.selectedAttempt = attempt;
        this.showGradeModal = true;
    }
}">

    <!-- Session Notifications -->
    @if (session('grade_success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs font-semibold">{{ session('grade_success') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-200">
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
                    class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-xl text-xs text-gray-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#93F514] focus:border-transparent transition-all">
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
                <option value="disc">Tes Kepribadian DISC</option>
                <option value="passed">Lolos Standar</option>
                <option value="failed">Di Bawah Standar</option>
                <option value="needs_grading">Perlu Penilaian Essay</option>
            </select>

            @if ($search || $departmentId || $testId || $status)
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
                    @forelse ($attempts as $attempt)
                        @php
                            $emp = $attempt->user?->employeeProfile;
                            $discResult = $attempt->discTestResult;
                            $isDisc = $discResult || str_contains(strtolower($attempt->test?->title ?? ''), 'disc');
                        @endphp
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-slate-700/30 transition duration-150">
                            <td class="py-4 px-6">
                                <div class="font-bold text-gray-800 dark:text-slate-100 text-sm">
                                    {{ $emp?->full_name ?? ($attempt->user?->name ?? 'Karyawan') }}
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
                                @if ($isDisc)
                                    <span class="px-2.5 py-1 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 font-semibold text-[11px]">
                                        Selesai
                                    </span>
                                @elseif ($attempt->status === 'passed')
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 font-semibold text-[11px]">
                                        Lolos Standar
                                    </span>
                                @elseif ($attempt->status === 'failed')
                                    <span class="px-2.5 py-1 rounded-full bg-rose-100 dark:bg-rose-900/40 text-rose-700 dark:text-rose-300 font-semibold text-[11px]">
                                        Di Bawah Standar
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 font-semibold text-[11px]">
                                        Sedang Proses
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if ($isDisc)
                                        <!-- PDF DISC Button -->
                                        <a href="{{ route('admin.test_evaluation.disc_pdf', $attempt->id) }}" target="_blank"
                                            class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 active:scale-95 text-white font-semibold text-[11px] rounded-xl shadow-sm transition flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span>PDF DISC</span>
                                        </a>
                                    @else
                                        <!-- Koreksi Essay Button -->
                                        <button @click="openGradeModal({{ json_encode($attempt) }})"
                                            class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-semibold text-[11px] rounded-xl shadow-sm transition flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span>Koreksi / Nilai</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-400 dark:text-slate-500">
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

        @if ($attempts->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-slate-700">
                {{ $attempts->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL GRADING ESSAY -->
    <div x-show="showGradeModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="min-h-screen px-4 flex items-center justify-center">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="showGradeModal = false"></div>

            <div class="relative bg-white dark:bg-slate-800 rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-gray-100 dark:border-slate-700 z-10 max-h-[90vh] overflow-y-auto" x-show="selectedAttempt">
                <div class="flex items-center justify-between pb-4 mb-5 border-b border-gray-100 dark:border-slate-700">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100">Koreksi & Nilai Ujian Karyawan</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Periksa jawaban essay dan sesuaikan nilai akhir karyawan</p>
                    </div>
                    <button @click="showGradeModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-slate-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="selectedAttempt">
                    <form :action="'{{ url('admin/test-evaluations') }}/' + selectedAttempt.id + '/grade'" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-3.5 rounded-2xl bg-gray-50 dark:bg-slate-700/40 border border-gray-100 dark:border-slate-700 text-xs">
                            <div>
                                <span class="text-gray-400 block text-[10px] uppercase font-semibold">Skor Pilihan Ganda</span>
                                <span class="font-bold text-gray-800 dark:text-slate-200 text-sm" x-text="(selectedAttempt.objective_score || 0) + ' Poin'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[10px] uppercase font-semibold">Standar Lolos</span>
                                <span class="font-bold text-gray-800 dark:text-slate-200 text-sm" x-text="selectedAttempt.test ? selectedAttempt.test.passing_score : '-'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[10px] uppercase font-semibold">Total Nilai Saat Ini</span>
                                <span class="font-bold text-emerald-600 text-sm" x-text="selectedAttempt.total_score || 0"></span>
                            </div>
                        </div>

                        <!-- Daftar Jawaban Essay -->
                        <div class="space-y-3 pt-2">
                            <h4 class="text-xs font-bold text-gray-800 dark:text-slate-200">Jawaban Essay</h4>
                            <template x-for="(ans, idx) in (selectedAttempt.answers || []).filter(a => a.question && a.question.question_type === 'essay')" :key="ans.id">
                                <div class="p-3.5 rounded-xl bg-gray-50 dark:bg-slate-700/30 border border-gray-100 dark:border-slate-700 text-xs space-y-2">
                                    <div class="font-semibold text-gray-800 dark:text-slate-200" x-text="(idx + 1) + '. ' + ans.question.question"></div>
                                    <div class="p-2.5 rounded-lg bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-300 font-mono text-[11px]" x-text="ans.essay_answer || '(Tidak ada jawaban teks)'"></div>
                                    <div class="flex items-center justify-between pt-1">
                                        <span class="text-[10px] text-gray-400">Poin Maksimal: <span x-text="ans.question.points || 10"></span></span>
                                        <div class="flex items-center gap-1.5">
                                            <label class="text-[11px] font-semibold text-gray-600 dark:text-slate-300">Nilai:</label>
                                            <input type="number" :name="'scores[' + ans.id + ']'" :value="ans.score || 0" min="0" :max="ans.question.points || 100" step="0.5" class="w-16 px-2 py-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg text-xs text-center font-bold focus:ring-1 focus:ring-emerald-500">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="pt-4 border-t border-gray-100 dark:border-slate-700 flex justify-end gap-2">
                            <button type="button" @click="showGradeModal = false" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 text-xs font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-md transition">
                                Simpan Nilai
                            </button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>

</div>
