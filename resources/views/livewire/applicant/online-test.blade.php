<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto" x-data="{
    timeRemaining: {{ $timeRemainingSeconds }},
    timerInterval: null,
    formatTime(sec) {
        if (sec <= 0) return '00:00:00';
        let h = Math.floor(sec / 3600);
        let m = Math.floor((sec % 3600) / 60);
        let s = sec % 60;
        return (h > 0 ? String(h).padStart(2, '0') + ':' : '') + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
    },
    startTimer() {
        if (this.timeRemaining > 0 && !this.timerInterval) {
            this.timerInterval = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--;
                } else {
                    clearInterval(this.timerInterval);
                    $wire.finishTestAuto();
                }
            }, 1000);
        }
    },
    isImg(path) {
        if (!path) return false;
        const ext = path.split('.').pop().toLowerCase();
        return ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(ext);
    },
    getFileExt(path) {
        if (!path) return 'FILE';
        return path.split('.').pop().toUpperCase();
    },
    getFileName(path) {
        if (!path) return 'Lampiran File';
        return path.split('/').pop();
    }
}" x-init="if ('{{ $testState }}' === 'taking') { startTimer(); }">

    <!-- Header Breadcrumb & Title -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-1">
                <a href="{{ route('profile', ['tab' => 'riwayat']) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Riwayat Lamaran</a>
                <span>/</span>
                <span class="text-gray-900 dark:text-white font-medium">{{ $application->job->title ?? 'Ujian' }}</span>
                <span>/</span>
                <span class="text-indigo-600 dark:text-indigo-400 font-semibold">{{ $test->title ?? 'Tes Rekrutmen' }}</span>
            </div>
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">
                {{ $test->title }}
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                Lowongan: <span class="font-bold text-gray-700 dark:text-gray-300">{{ $application->job->title }}</span> di <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $application->job->company->name ?? 'Perusahaan' }}</span>
            </p>
        </div>

        @if ($testState === 'taking')
            <!-- Countdown Timer Badge -->
            <div class="flex items-center gap-3 bg-gradient-to-r from-amber-500/10 via-rose-500/10 to-indigo-500/10 p-3 rounded-2xl border border-amber-300/40 dark:border-amber-700/40 shadow-sm shrink-0">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-md shadow-amber-500/30">
                    <svg class="w-5 h-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <span class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Sisa Waktu Pengerjaan</span>
                    <span class="text-lg font-black text-rose-600 dark:text-rose-400 font-mono" x-text="formatTime(timeRemaining)">--:--</span>
                </div>
            </div>
        @endif
    </div>

    <!-- STATE 1: INTRO / PETUNJUK PENGERJAAN -->
    @if ($testState === 'intro')
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="flex items-center gap-4 pb-6 border-b border-gray-100 dark:border-gray-700">
                <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-2xl shadow-lg shadow-indigo-600/30 shrink-0">
                    📝
                </div>
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                        {{ $test->category->name ?? 'Kategori Ujian' }}
                    </span>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-1">Petunjuk Pelaksanaan Ujian</h2>
                </div>
            </div>

            <!-- Ringkasan Info Ujian -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 text-center">
                    <span class="block text-xs text-gray-400 mb-1">Durasi Waktu</span>
                    <span class="text-lg font-extrabold text-gray-900 dark:text-white">{{ $test->duration_minutes }} Menit</span>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 text-center">
                    <span class="block text-xs text-gray-400 mb-1">Nilai KKM Kelulusan</span>
                    <span class="text-lg font-extrabold text-emerald-600 dark:text-emerald-400">{{ number_format($test->passing_score, 0) }}%</span>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 text-center">
                    <span class="block text-xs text-gray-400 mb-1">Jumlah Pertanyaan</span>
                    <span class="text-lg font-extrabold text-indigo-600 dark:text-indigo-400">{{ count($questions) > 0 ? count($questions) : ($test->total_questions ?: 'Sesuai Soal') }} Soal</span>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 text-center">
                    <span class="block text-xs text-gray-400 mb-1">Metode Urutan</span>
                    <span class="text-lg font-extrabold text-purple-600 dark:text-purple-400">{{ $test->is_random ? 'Acak' : 'Urut' }}</span>
                </div>
            </div>

            <!-- Ketentuan Ujian -->
            <div class="p-5 rounded-2xl bg-indigo-50/50 dark:bg-indigo-950/30 border border-indigo-100 dark:border-indigo-900/50 text-xs text-gray-700 dark:text-gray-300 space-y-2.5">
                <h3 class="font-bold text-sm text-indigo-900 dark:text-indigo-200">Peraturan & Hal yang Perlu Diperhatikan:</h3>
                <ul class="list-disc list-inside space-y-1.5 leading-relaxed text-indigo-800/90 dark:text-indigo-300/90">
                    <li>Pastikan koneksi internet Anda stabil sebelum menekan tombol <strong>Mulai Ujian Sekarang</strong>.</li>
                    <li>Waktu akan langsung berjalan otomatis dan tidak dapat dijeda (pause).</li>
                    <li>Jawaban Anda otomatis tersimpan setiap kali Anda memilih opsi atau mengetik jawaban.</li>
                    <li>Jika butir soal memiliki <strong>file lampiran / studi kasus</strong> (PDF, Word, Excel, Gambar), tombol untuk mengunduh/melihat berkas akan muncul di atas pertanyaan.</li>
                    <li>Ujian akan otomatis disubmit jika batas waktu pengerjaan telah habis.</li>
                </ul>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('profile', ['tab' => 'riwayat']) }}" class="px-5 py-2.5 text-xs font-semibold text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition">
                    Kembali ke Riwayat
                </a>
                <button type="button" wire:click="startTest" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-500/25 transition transform active:scale-95 flex items-center gap-2">
                    <span>Mulai Ujian Sekarang</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- STATE 2: SEDANG MENGERJAKAN UJIAN (TAKING TEST) -->
    @if ($testState === 'taking')
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
            <!-- Left Side: Lembar Soal & Jawaban (3 Cols) -->
            <div class="lg:col-span-3 space-y-6">
                @if ($currentQuestion)
                    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 sm:p-8 space-y-6">
                        <!-- Question Header -->
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-xl bg-indigo-600 text-white font-black text-xs">
                                    Soal No. {{ $currentQuestionIndex + 1 }}
                                </span>
                                <span class="px-2.5 py-1 rounded-xl text-[11px] font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                    @if ($currentQuestion['question_type'] === 'multiple_choice')
                                        Pilihan Ganda
                                    @elseif ($currentQuestion['question_type'] === 'disc')
                                        Pernyataan DISC
                                    @else
                                        Uraian / Essay
                                    @endif
                                </span>
                            </div>
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-1 rounded-lg border border-emerald-200 dark:border-emerald-800">
                                Bobot: {{ $currentQuestion['points'] ?? 1 }} Poin
                            </span>
                        </div>

                        <!-- LAMPIRAN FILE ATAU GAMBAR SOAL (JIKA ADA) -->
                        @if (!empty($currentQuestion['image_path']))
                            @php
                                $filePath = $currentQuestion['image_path'];
                                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                                $fileUrl = asset('storage/' . $filePath);
                            @endphp

                            <div class="p-4 rounded-2xl bg-indigo-50/70 dark:bg-indigo-950/40 border border-indigo-100 dark:border-indigo-900 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-indigo-900 dark:text-indigo-200 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                        Dokumen & Lampiran Studi Kasus Soal
                                    </span>
                                    <a href="{{ $fileUrl }}" target="_blank" download class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span>Unduh / Buka Dokumen ({{ strtoupper($ext) }})</span>
                                    </a>
                                </div>

                                @if ($isImage)
                                    <div class="rounded-xl overflow-hidden border border-indigo-200 dark:border-indigo-800/60 bg-white dark:bg-gray-900 p-2 text-center">
                                        <img src="{{ $fileUrl }}" alt="Lampiran Soal" class="max-h-80 mx-auto object-contain rounded-lg">
                                    </div>
                                @else
                                    <p class="text-[11px] text-indigo-700 dark:text-indigo-300">
                                        Silakan unduh atau buka dokumen di atas untuk membaca deskripsi lengkap studi kasus terkait soal ini.
                                    </p>
                                @endif
                            </div>
                        @endif

                        <!-- Pertanyaan Teks -->
                        <div class="text-sm sm:text-base font-medium text-gray-900 dark:text-white whitespace-pre-line leading-relaxed">
                            {{ $currentQuestion['question'] }}
                        </div>

                        <!-- OPSI PILIHAN GANDA -->
                        @if ($currentQuestion['question_type'] === 'multiple_choice')
                            <div class="space-y-3 pt-2">
                                @php
                                    $labels = ['A', 'B', 'C', 'D', 'E'];
                                    $selectedOpt = $answers[$currentQuestion['id']] ?? null;
                                @endphp
                                @foreach ($currentQuestion['options'] as $idx => $opt)
                                    @php
                                        $isSelected = ($selectedOpt == $opt['id']);
                                    @endphp
                                    <label wire:click="saveAnswer({{ $currentQuestion['id'] }}, {{ $opt['id'] }})"
                                        class="flex items-center gap-3.5 p-4 rounded-2xl border cursor-pointer transition-all duration-200 {{ $isSelected ? 'bg-indigo-50/80 dark:bg-indigo-950/50 border-indigo-500 ring-2 ring-indigo-500/20 text-indigo-900 dark:text-indigo-100 font-semibold' : 'bg-gray-50/50 dark:bg-gray-900/40 border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-100/80 dark:hover:bg-gray-700/50' }}">
                                        <input type="radio" name="opt_{{ $currentQuestion['id'] }}" value="{{ $opt['id'] }}" {{ $isSelected ? 'checked' : '' }} class="sr-only">
                                        <span class="w-8 h-8 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 {{ $isSelected ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                                            {{ $labels[$idx] ?? ($idx + 1) }}
                                        </span>
                                        <span class="text-xs sm:text-sm flex-1 leading-snug">
                                            {{ $opt['option_text'] }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        <!-- FORM ESSAY / URAIAN -->
                        @if ($currentQuestion['question_type'] === 'essay')
                            <div class="space-y-4 pt-2" wire:key="essay-question-{{ $currentQuestion['id'] }}">
                                <div class="space-y-2">
                                    <label for="essay_{{ $currentQuestion['id'] }}" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                                        Tuliskan Jawaban Uraian / Analisis Anda:
                                    </label>
                                    <textarea id="essay_{{ $currentQuestion['id'] }}"
                                        rows="6"
                                        wire:model.lazy="answers.{{ $currentQuestion['id'] }}"
                                        wire:change="submitEssayAnswer({{ $currentQuestion['id'] }})"
                                        placeholder="Ketikkan jawaban essay Anda secara lengkap dan terstruktur..."
                                        class="w-full p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700 text-xs sm:text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none transition leading-relaxed"></textarea>
                                    <div class="flex items-center justify-between text-[11px] text-gray-400">
                                        <span>💡 Jawaban teks tersimpan otomatis saat Anda berpindah soal atau menekan tombol navigasi.</span>
                                    </div>
                                </div>

                                <!-- UPLOAD FILE ATTACHMENT ESSAY (ALL FILES, MAX 20MB, CLOUDINARY) -->
                                <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2 text-xs font-bold text-gray-800 dark:text-gray-200">
                                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            <span>Lampiran File Pendukung (Opsional)</span>
                                        </div>
                                        <span class="text-[11px] font-medium text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 px-2.5 py-0.5 rounded-full border border-slate-200 dark:border-slate-700">
                                            Semua Format File • Maks. 20 MB
                                        </span>
                                    </div>

                                    @error('essayFiles.' . $currentQuestion['id'])
                                        <div class="p-2.5 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/80 text-xs text-red-600 dark:text-red-400 flex items-center gap-2">
                                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror

                                    @php
                                        $uploadedAttachment = $essayAttachments[$currentQuestion['id']] ?? null;
                                    @endphp

                                    @if ($uploadedAttachment)
                                        <!-- PREVIEW FILE YANG SUDAH DIUNGGAH -->
                                        <div class="flex items-center justify-between p-3.5 rounded-xl bg-indigo-50/70 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-800/60 transition">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <div class="w-10 h-10 rounded-xl bg-indigo-600/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </div>
                                                <div class="truncate">
                                                    <a href="{{ $uploadedAttachment['url'] }}" target="_blank" class="text-xs font-semibold text-indigo-700 dark:text-indigo-300 hover:underline truncate block">
                                                        {{ $uploadedAttachment['name'] }}
                                                                                                     <span class="text-[11px] text-gray-500 dark:text-slate-400">
                                                         @if(!empty($uploadedAttachment['size']))
                                                             {{ round($uploadedAttachment['size'] / 1024, 1) }} KB •
                                                         @endif
                                                         File Tersimpan
                                                     </span>
                                                 </div>
                                             </div>
                                             <div class="flex items-center gap-2 shrink-0 ml-2">
                                                 <a href="{{ $uploadedAttachment['url'] }}" target="_blank" download class="p-2 text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 rounded-lg transition" title="Buka / Unduh File">
                                                     <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                     </svg>
                                                 </a>
                                                 <button type="button" wire:click="removeEssayAttachment({{ $currentQuestion['id'] }})" wire:confirm="Apakah Anda yakin ingin menghapus lampiran file ini?" class="p-2 text-xs font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-950/40 rounded-lg transition" title="Hapus File">
                                                     <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                     </svg>
                                                 </button>
                                             </div>
                                         </div>
                                     @else
                                        <!-- INPUT UPLOAD FILE BARU (AUTO SAVE) -->
                                        <div>
                                            <label class="flex items-center gap-3 px-4 py-3 rounded-xl border border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-slate-900/60 hover:border-indigo-400 cursor-pointer transition group">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                    </svg>
                                                </div>
                                                <div class="flex-1 truncate">
                                                    <span class="text-xs text-gray-700 dark:text-gray-300 font-medium">
                                                        Pilih atau drag file dokumen/analisis (Semua format, maks 20MB)
                                                    </span>
                                                    <span class="block text-[10px] text-gray-400">File langsung tersimpan otomatis setelah dipilih</span>
                                                </div>
                                                <input type="file" wire:model="essayFiles.{{ $currentQuestion['id'] }}" class="sr-only">
                                            </label>
                                        </div>

                                        <!-- Livewire Uploading & Saving Indicator -->
                                        <div wire:loading wire:target="essayFiles.{{ $currentQuestion['id'] }}" class="p-3 rounded-xl bg-indigo-50/70 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-800/60 text-xs text-indigo-700 dark:text-indigo-300 flex items-center gap-2.5">
                                            <svg class="animate-spin w-4 h-4 text-indigo-600 dark:text-indigo-400 shrink-0" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                            <span class="font-medium">Sedang mengunggah dan menyimpan file lampiran...</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- DISC QUESTION TYPE (LAYOUT HORIZONTAL DENGAN ATURAN: BARIS YANG SAMA TIDAK BISA DIKLIK SEBERANGNYA) -->
                        @if ($currentQuestion['question_type'] === 'disc')
                            @php
                                $mostOpt = $answers[$currentQuestion['id']]['most'] ?? null;
                                $leastOpt = $answers[$currentQuestion['id']]['least'] ?? null;
                            @endphp
                            <div class="space-y-4 pt-2" wire:key="disc-box-{{ $currentQuestion['id'] }}">
                                <!-- Instruction Header -->
                                <div class="flex items-center justify-between text-xs font-semibold px-1 text-gray-600 dark:text-gray-300">
                                    <span>Pilihlah <strong>1 pernyataan P</strong> (Paling Menggambarkan) dan <strong>1 pernyataan K</strong> (Kurang Menggambarkan).</span>
                                    <div class="flex items-center gap-1.5 font-mono text-[11px]">
                                        <span class="px-2.5 py-0.5 rounded font-bold {{ $mostOpt ? 'bg-amber-400 text-amber-950' : 'bg-gray-100 dark:bg-gray-700 text-gray-400' }}">
                                            P: {{ $mostOpt ? '✓' : '-' }}
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded font-bold {{ $leastOpt ? 'bg-sky-400 text-sky-950' : 'bg-gray-100 dark:bg-gray-700 text-gray-400' }}">
                                            K: {{ $leastOpt ? '✓' : '-' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Custom DISC Table Form matching Screenshot -->
                                <div class="overflow-x-auto rounded-xl border-2 border-gray-900 dark:border-gray-600 shadow-sm">
                                    <table class="w-full text-xs border-collapse text-left">
                                        <thead>
                                            <tr class="font-extrabold text-sm border-b-2 border-gray-900 dark:border-gray-600 text-center">
                                                <!-- Kolom No (Abu-abu) -->
                                                <th class="w-14 py-2.5 px-3 bg-gray-400 text-gray-900 border-r-2 border-gray-900 dark:border-gray-600">
                                                    No.
                                                </th>
                                                <!-- Kolom P (Kuning / Oranye) -->
                                                <th class="w-14 py-2.5 px-3 bg-amber-400 text-gray-900 border-r-2 border-gray-900 dark:border-gray-600">
                                                    P
                                                </th>
                                                <!-- Kolom K (Biru Langit) -->
                                                <th class="w-14 py-2.5 px-3 bg-sky-400 text-gray-900 border-r-2 border-gray-900 dark:border-gray-600">
                                                    K
                                                </th>
                                                <!-- Kolom Gambaran Diri (Ungu Tua / Indigo) -->
                                                <th class="py-2.5 px-4 bg-indigo-900 text-white font-bold text-left tracking-wide">
                                                    Gambaran Diri
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y-2 divide-gray-900 dark:divide-gray-600 font-medium text-xs">
                                            @foreach ($currentQuestion['options'] as $idx => $opt)
                                                @php
                                                    $isMost = ($mostOpt == $opt['id']);
                                                    $isLeast = ($leastOpt == $opt['id']);
                                                @endphp
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/60 transition {{ $isMost ? 'bg-amber-50/40 dark:bg-amber-950/20' : ($isLeast ? 'bg-sky-50/40 dark:bg-sky-950/20' : '') }}"
                                                    wire:key="opt-row-{{ $currentQuestion['id'] }}-{{ $opt['id'] }}">
                                                    <!-- Kolom Nomor (Hanya tampil di baris pertama dengan rowspan) -->
                                                    @if ($idx === 0)
                                                        <td rowspan="{{ count($currentQuestion['options']) }}" class="text-center font-black text-lg bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-white border-r-2 border-gray-900 dark:border-gray-600">
                                                            {{ $currentQuestionIndex + 1 }}
                                                        </td>
                                                    @endif

                                                    <!-- Kolom P (Kuning / Amber - Radio Button HIJAU) -->
                                                    <td class="text-center border-r-2 border-gray-900 dark:border-gray-600 p-0 {{ $isLeast ? 'bg-gray-200 dark:bg-gray-700 opacity-40 cursor-not-allowed' : 'bg-amber-400/90' }}">
                                                        <label class="w-full h-11 flex items-center justify-center {{ $isLeast ? 'cursor-not-allowed' : 'cursor-pointer hover:bg-amber-500/80 transition' }}">
                                                            <input type="radio" 
                                                                   name="disc_most_{{ $currentQuestion['id'] }}" 
                                                                   value="{{ $opt['id'] }}" 
                                                                   {{ $isMost ? 'checked' : '' }}
                                                                   {{ $isLeast ? 'disabled' : '' }}
                                                                   wire:click="saveAnswer({{ $currentQuestion['id'] }}, {{ $opt['id'] }}, null, 'most')"
                                                                   class="w-5 h-5 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0 border-2 border-gray-900 {{ $isLeast ? 'cursor-not-allowed opacity-30' : 'cursor-pointer' }}">
                                                        </label>
                                                    </td>

                                                    <!-- Kolom K (Biru / Sky - Radio Button MERAH) -->
                                                    <td class="text-center border-r-2 border-gray-900 dark:border-gray-600 p-0 {{ $isMost ? 'bg-gray-200 dark:bg-gray-700 opacity-40 cursor-not-allowed' : 'bg-sky-400/90' }}">
                                                        <label class="w-full h-11 flex items-center justify-center {{ $isMost ? 'cursor-not-allowed' : 'cursor-pointer hover:bg-sky-500/80 transition' }}">
                                                            <input type="radio" 
                                                                   name="disc_least_{{ $currentQuestion['id'] }}" 
                                                                   value="{{ $opt['id'] }}" 
                                                                   {{ $isLeast ? 'checked' : '' }}
                                                                   {{ $isMost ? 'disabled' : '' }}
                                                                   wire:click="saveAnswer({{ $currentQuestion['id'] }}, {{ $opt['id'] }}, null, 'least')"
                                                                   class="w-5 h-5 text-rose-600 focus:ring-rose-500 focus:ring-offset-0 border-2 border-gray-900 {{ $isMost ? 'cursor-not-allowed opacity-30' : 'cursor-pointer' }}">
                                                        </label>
                                                    </td>

                                                    <!-- Kolom Teks Gambaran Diri -->
                                                    <td class="py-2.5 px-4 text-gray-900 dark:text-gray-100 font-semibold bg-white dark:bg-gray-800 text-xs sm:text-sm">
                                                        {{ $opt['option_text'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- Navigation Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-gray-700 gap-3">
                            <button type="button" wire:click="prevQuestion" {{ $currentQuestionIndex === 0 ? 'disabled' : '' }}
                                class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                <span>Sebelumnya</span>
                            </button>

                            @if ($currentQuestionIndex < count($questions) - 1)
                                <button type="button" wire:click="nextQuestion"
                                    class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold transition flex items-center gap-1.5 shadow-md shadow-indigo-500/20">
                                    <span>Selanjutnya</span>
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            @else
                                <button type="button" wire:click="finishTest"
                                    onclick="return confirm('Apakah Anda yakin ingin menyelesaikan dan mengirim ujian ini?')"
                                    class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-md shadow-emerald-500/20">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Kirim Jawaban & Selesai</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Side: Nomor Soal Grid & Submit Button (1 Col) -->
            <div class="lg:col-span-1 space-y-4">
                <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-5 space-y-4 sticky top-24">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                            Navigasi Nomor Soal
                        </h3>
                        <span class="text-[11px] text-gray-400 font-medium">
                            {{ count($questions) }} Butir
                        </span>
                    </div>

                    <!-- Number Grid -->
                    <div class="grid grid-cols-5 gap-2">
                        @foreach ($questions as $idx => $q)
                            @php
                                $isAnswered = false;
                                if ($q['question_type'] === 'disc') {
                                    $isAnswered = isset($answers[$q['id']]['most']) && isset($answers[$q['id']]['least']);
                                } else {
                                    $isAnswered = isset($answers[$q['id']]) && $answers[$q['id']] !== '';
                                }
                                $isCurrent = ($currentQuestionIndex === $idx);
                            @endphp
                            <button type="button" wire:click="selectQuestion({{ $idx }})"
                                class="h-9 rounded-xl font-bold text-xs flex items-center justify-center transition border {{ $isCurrent ? 'ring-2 ring-indigo-500 border-indigo-500' : '' }} {{ $isAnswered ? 'bg-emerald-500 text-white border-emerald-600' : 'bg-gray-100 dark:bg-gray-700/60 text-gray-700 dark:text-gray-300 border-transparent hover:bg-gray-200' }}">
                                {{ $idx + 1 }}
                            </button>
                        @endforeach
                    </div>

                    <div class="pt-3 border-t border-gray-100 dark:border-gray-700 space-y-2 text-[11px] text-gray-500 dark:text-gray-400">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span>Sudah Dijawab</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-gray-200 dark:bg-gray-700"></span>
                            <span>Belum Dijawab</span>
                        </div>
                    </div>

                    <button type="button" wire:click="finishTest"
                        onclick="return confirm('Apakah Anda yakin ingin menyelesaikan ujian sekarang?')"
                        class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center justify-center gap-1.5 mt-4">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Selesaikan Ujian</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- STATE 3: COMPLETED / HASIL UJIAN -->
    @if ($testState === 'completed')
        @php
            $hasEssayQuestions = collect($questions)->contains('question_type', 'essay');
            $hasMultipleChoice = collect($questions)->contains('question_type', 'multiple_choice');
            $isWaitingReview = $hasEssayQuestions && ($attempt && is_null($attempt->essay_score));
        @endphp

        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 sm:p-10 text-center space-y-6">
            <div class="w-16 h-16 rounded-3xl {{ $isWaitingReview ? 'bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400' : 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400' }} flex items-center justify-center mx-auto text-3xl shadow-md">
                {{ $isWaitingReview ? '⏳' : '🎉' }}
            </div>

            <div>
                <h2 class="text-2xl font-black text-gray-900 dark:text-white">
                    {{ $isWaitingReview ? 'Jawaban Ujian Berhasil Terkirim!' : 'Ujian Berhasil Diselesaikan!' }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Terima kasih telah menyelesaikan ujian untuk posisi <span class="font-bold text-gray-800 dark:text-gray-200">{{ $application->job->title }}</span>.
                </p>
            </div>

            @if ($isWaitingReview)
                <!-- Banner Khusus Menunggu Review Essay -->
                <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/80 text-left space-y-2">
                    <div class="flex items-center gap-2 text-amber-800 dark:text-amber-200 font-bold text-xs">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Menunggu Evaluasi & Penilaian dari HR / Penguji</span>
                    </div>
                    <p class="text-[11px] text-amber-700 dark:text-amber-300 leading-relaxed">
                        Ujian ini memuat soal berbentuk <strong>Uraian / Essay</strong>. Jawaban Anda telah tersimpan dengan aman dan saat ini sedang dalam antrean pemeriksaan oleh tim penilai rekruter.
                    </p>
                </div>
            @endif

            <!-- Score Summary Card -->
            <div class="p-5 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 space-y-3">
                <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-300">
                    <span>Status Pengerjaan:</span>
                    @if ($isWaitingReview)
                        <span class="font-bold px-3 py-1 rounded-full text-[11px] bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                            Menunggu Review Essay
                        </span>
                    @elseif ($attempt && $attempt->status === 'passed')
                        <span class="font-bold px-3 py-1 rounded-full text-[11px] bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            Lulus (Passed)
                        </span>
                    @elseif ($attempt && $attempt->status === 'failed')
                        <span class="font-bold px-3 py-1 rounded-full text-[11px] bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300 border border-rose-200 dark:border-rose-800">
                            Belum Lolos KKM
                        </span>
                    @else
                        <span class="font-bold px-3 py-1 rounded-full text-[11px] bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                            Selesai (Completed)
                        </span>
                    @endif
                </div>

                @if ($hasMultipleChoice)
                    <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-300">
                        <span>Skor Pilihan Ganda:</span>
                        <span class="font-extrabold text-indigo-600 dark:text-indigo-400 text-sm">
                            {{ number_format($attempt->objective_score ?? 0, 1) }} Poin
                        </span>
                    </div>
                @endif

                @if ($hasEssayQuestions)
                    <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-300">
                        <span>Skor Essay / Uraian:</span>
                        @if ($attempt && $attempt->essay_score !== null)
                            <span class="font-extrabold text-amber-600 dark:text-amber-400 text-sm">
                                {{ number_format($attempt->essay_score, 1) }} Poin
                            </span>
                        @else
                            <span class="text-xs font-semibold text-amber-600 dark:text-amber-400 italic">
                                Sedang Dinilai Tim HR
                            </span>
                        @endif
                    </div>
                @endif

                <div class="pt-2 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <span class="font-bold text-xs text-gray-900 dark:text-white">Total Skor Akhir:</span>
                    @if ($isWaitingReview)
                        <span class="text-xs font-bold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/60 px-2.5 py-1 rounded-lg border border-amber-200 dark:border-amber-800">
                            Menunggu Penilaian Essay
                        </span>
                    @else
                        <span class="text-xl font-black text-gray-900 dark:text-white">
                            {{ number_format($attempt->total_score ?? 0, 1) }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- DISC RESULT SECTION (IF DISC TEST) -->
            @if ($discResult)
                @php
                    $line1 = $discResult->line_1_scores['raw'] ?? ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0, '*' => 0];
                    $line2 = $discResult->line_2_scores['raw'] ?? ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0, '*' => 0];
                    $line3 = $discResult->line_3_scores['raw'] ?? ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];
                    
                    $line1Conv = $discResult->line_1_scores['converted'] ?? ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];
                    $line2Conv = $discResult->line_2_scores['converted'] ?? ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];
                    $line3Conv = $discResult->line_3_scores['converted'] ?? ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];
                    
                    $profile = $discResult->discProfile;
                    $applicant = $application->applicantProfile;
                @endphp

                <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-700 text-left space-y-6">
                    <!-- Title Header -->
                    <div class="text-center pb-4 border-b border-gray-100 dark:border-gray-700">
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-purple-100 dark:bg-purple-950 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800 uppercase tracking-widest">
                            HASIL TES D I S C
                        </span>
                        <h3 class="text-xl font-black text-gray-900 dark:text-white mt-2">Self Inventory Personality Report</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Analisis Profil dan Kecenderungan Perilaku Kerja</p>
                    </div>

                    <!-- Applicant Bio Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-gray-50 dark:bg-gray-900/60 p-4 rounded-2xl border border-gray-100 dark:border-gray-800 text-xs">
                        <div>
                            <span class="text-gray-400 block text-[11px]">Nama Lengkap</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $applicant->full_name ?? auth()->user()->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[11px]">Jenis Kelamin</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $applicant->gender ?? 'Laki-Laki / Perempuan' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[11px]">Pola Kepribadian</span>
                            <span class="font-black text-purple-600 dark:text-purple-400 text-sm">{{ $profile->pattern_code ?? 'DISC' }} - {{ $profile->title ?? 'Profile' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[11px]">Tanggal Tes</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($attempt->finished_at ?? now())->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>

                    <!-- DISC Score Table -->
                    <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-700 shadow-2xs">
                        <table class="w-full text-xs text-center border-collapse">
                            <thead>
                                <tr class="bg-indigo-600 text-white font-bold">
                                    <th class="py-2.5 px-4 text-left">Line / Dimensi</th>
                                    <th class="py-2.5 px-3">D (Dominance)</th>
                                    <th class="py-2.5 px-3">I (Influence)</th>
                                    <th class="py-2.5 px-3">S (Steadiness)</th>
                                    <th class="py-2.5 px-3">C (Compliance)</th>
                                    <th class="py-2.5 px-3">*</th>
                                    <th class="py-2.5 px-3 font-black text-amber-300">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800/80 font-medium">
                                <tr>
                                    <td class="py-2 px-4 text-left font-bold text-gray-800 dark:text-gray-200">1 (MOST / Gambaran Publik)</td>
                                    <td class="py-2 px-3 font-bold">{{ $line1['D'] ?? 0 }}</td>
                                    <td class="py-2 px-3 font-bold">{{ $line1['I'] ?? 0 }}</td>
                                    <td class="py-2 px-3 font-bold">{{ $line1['S'] ?? 0 }}</td>
                                    <td class="py-2 px-3 font-bold">{{ $line1['C'] ?? 0 }}</td>
                                    <td class="py-2 px-3 text-gray-400">{{ $line1['*'] ?? 0 }}</td>
                                    <td class="py-2 px-3 font-black text-indigo-600 dark:text-indigo-400">{{ array_sum($line1) }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 text-left font-bold text-gray-800 dark:text-gray-200">2 (LEAST / Asli Tersembunyi)</td>
                                    <td class="py-2 px-3 font-bold">{{ $line2['D'] ?? 0 }}</td>
                                    <td class="py-2 px-3 font-bold">{{ $line2['I'] ?? 0 }}</td>
                                    <td class="py-2 px-3 font-bold">{{ $line2['S'] ?? 0 }}</td>
                                    <td class="py-2 px-3 font-bold">{{ $line2['C'] ?? 0 }}</td>
                                    <td class="py-2 px-3 text-gray-400">{{ $line2['*'] ?? 0 }}</td>
                                    <td class="py-2 px-3 font-black text-rose-600 dark:text-rose-400">{{ array_sum($line2) }}</td>
                                </tr>
                                <tr class="bg-gray-50 dark:bg-gray-900/40 font-bold">
                                    <td class="py-2 px-4 text-left text-purple-700 dark:text-purple-300">3 (CHANGE / Perceived Self)</td>
                                    <td class="py-2 px-3 {{ ($line3['D'] ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-500' }}">{{ $line3['D'] ?? 0 }}</td>
                                    <td class="py-2 px-3 {{ ($line3['I'] ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-500' }}">{{ $line3['I'] ?? 0 }}</td>
                                    <td class="py-2 px-3 {{ ($line3['S'] ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-500' }}">{{ $line3['S'] ?? 0 }}</td>
                                    <td class="py-2 px-3 {{ ($line3['C'] ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-500' }}">{{ $line3['C'] ?? 0 }}</td>
                                    <td class="py-2 px-3 text-gray-400">-</td>
                                    <td class="py-2 px-3 text-gray-500">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- 3 GRAPH VISUALIZATION CARDS (NATIVE SVG LINE CHARTS) -->
                    @php
                        // Helper closure untuk kalkulasi Y koordinat SVG (Rentang skor -8 s.d +8, tinggi viewBox 160, Y=0 di atas, Y=80 di tengah skor 0)
                        $calcY = function($score) {
                            $val = max(-8, min(8, (float) $score));
                            // Map +8 => 15, 0 => 80, -8 => 145
                            return 80 - ($val * 8.125);
                        };
                        
                        // Titik X untuk D(35), I(85), S(135), C(185)
                        $xPoints = ['D' => 35, 'I' => 85, 'S' => 135, 'C' => 185];
                        
                        $pts1 = $xPoints['D'].','.$calcY($line1Conv['D'] ?? 0).' '.$xPoints['I'].','.$calcY($line1Conv['I'] ?? 0).' '.$xPoints['S'].','.$calcY($line1Conv['S'] ?? 0).' '.$xPoints['C'].','.$calcY($line1Conv['C'] ?? 0);
                        $pts2 = $xPoints['D'].','.$calcY($line2Conv['D'] ?? 0).' '.$xPoints['I'].','.$calcY($line2Conv['I'] ?? 0).' '.$xPoints['S'].','.$calcY($line2Conv['S'] ?? 0).' '.$xPoints['C'].','.$calcY($line2Conv['C'] ?? 0);
                        $pts3 = $xPoints['D'].','.$calcY($line3Conv['D'] ?? 0).' '.$xPoints['I'].','.$calcY($line3Conv['I'] ?? 0).' '.$xPoints['S'].','.$calcY($line3Conv['S'] ?? 0).' '.$xPoints['C'].','.$calcY($line3Conv['C'] ?? 0);
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Graph 1: Mask Public Self (MOST) -->
                        <div class="p-4 rounded-2xl bg-white dark:bg-gray-800 border border-rose-200 dark:border-rose-900/60 shadow-2xs space-y-3">
                            <div class="text-center pb-2 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-rose-600 dark:text-rose-400">GRAPH 1 (MOST)</span>
                                <h4 class="text-xs font-bold text-gray-900 dark:text-white">Mask / Public Self</h4>
                            </div>
                            
                            <!-- SVG Chart -->
                            <div class="relative bg-rose-50/40 dark:bg-gray-900/60 rounded-xl p-2 border border-rose-100 dark:border-rose-950">
                                <svg viewBox="0 0 220 160" class="w-full h-44">
                                    <!-- Grid Lines -->
                                    <line x1="20" y1="15" x2="205" y2="15" stroke="#f43f5e" stroke-dasharray="2" stroke-opacity="0.3" />
                                    <text x="5" y="18" fill="#9ca3af" font-size="8" font-family="monospace">+8</text>

                                    <line x1="20" y1="47.5" x2="205" y2="47.5" stroke="#e5e7eb" stroke-dasharray="2" stroke-opacity="0.6" />
                                    <text x="5" y="50.5" fill="#9ca3af" font-size="8" font-family="monospace">+4</text>

                                    <!-- Zero Line (Baseline) -->
                                    <line x1="20" y1="80" x2="205" y2="80" stroke="#f43f5e" stroke-width="1.5" stroke-opacity="0.8" />
                                    <text x="5" y="83" fill="#f43f5e" font-size="9" font-weight="bold" font-family="monospace">0</text>

                                    <line x1="20" y1="112.5" x2="205" y2="112.5" stroke="#e5e7eb" stroke-dasharray="2" stroke-opacity="0.6" />
                                    <text x="5" y="115.5" fill="#9ca3af" font-size="8" font-family="monospace">-4</text>

                                    <line x1="20" y1="145" x2="205" y2="145" stroke="#f43f5e" stroke-dasharray="2" stroke-opacity="0.3" />
                                    <text x="5" y="148" fill="#9ca3af" font-size="8" font-family="monospace">-8</text>

                                    <!-- Vertical Column Axes -->
                                    @foreach($xPoints as $label => $x)
                                        <line x1="{{ $x }}" y1="10" x2="{{ $x }}" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.5" />
                                        <text x="{{ $x }}" y="158" fill="#64748b" font-size="10" font-weight="bold" text-anchor="middle">{{ $label }}</text>
                                    @endforeach

                                    <!-- Data Polyline -->
                                    <polyline fill="none" stroke="#e11d48" stroke-width="2.5" points="{{ $pts1 }}" stroke-linecap="round" stroke-linejoin="round" />

                                    <!-- Data Points & Labels -->
                                    @foreach(['D', 'I', 'S', 'C'] as $dim)
                                        @php 
                                            $cx = $xPoints[$dim]; 
                                            $cy = $calcY($line1Conv[$dim] ?? 0); 
                                            $val = number_format($line1Conv[$dim] ?? 0, 1);
                                        @endphp
                                        <!-- Diamond Marker -->
                                        <polygon points="{{ $cx }},{{ $cy - 4 }} {{ $cx + 4 }},{{ $cy }} {{ $cx }},{{ $cy + 4 }} {{ $cx - 4 }},{{ $cy }}" fill="#be123c" stroke="#ffffff" stroke-width="1.5" />
                                        <text x="{{ $cx }}" y="{{ $cy - 6 }}" fill="#be123c" font-size="8.5" font-weight="bold" text-anchor="middle">{{ $val }}</text>
                                    @endforeach
                                </svg>
                            </div>
                            <p class="text-[10px] text-gray-400 text-center leading-tight">Perilaku yang ditampilkan saat berinteraksi di ruang sosial/publik.</p>
                        </div>

                        <!-- Graph 2: Core Private Self (LEAST) -->
                        <div class="p-4 rounded-2xl bg-white dark:bg-gray-800 border border-amber-200 dark:border-amber-900/60 shadow-2xs space-y-3">
                            <div class="text-center pb-2 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-600 dark:text-amber-400">GRAPH 2 (LEAST)</span>
                                <h4 class="text-xs font-bold text-gray-900 dark:text-white">Core / Private Self</h4>
                            </div>

                            <!-- SVG Chart -->
                            <div class="relative bg-amber-50/40 dark:bg-gray-900/60 rounded-xl p-2 border border-amber-100 dark:border-amber-950">
                                <svg viewBox="0 0 220 160" class="w-full h-44">
                                    <!-- Grid Lines -->
                                    <line x1="20" y1="15" x2="205" y2="15" stroke="#f59e0b" stroke-dasharray="2" stroke-opacity="0.3" />
                                    <text x="5" y="18" fill="#9ca3af" font-size="8" font-family="monospace">+8</text>

                                    <line x1="20" y1="47.5" x2="205" y2="47.5" stroke="#e5e7eb" stroke-dasharray="2" stroke-opacity="0.6" />
                                    <text x="5" y="50.5" fill="#9ca3af" font-size="8" font-family="monospace">+4</text>

                                    <!-- Zero Line (Baseline) -->
                                    <line x1="20" y1="80" x2="205" y2="80" stroke="#f59e0b" stroke-width="1.5" stroke-opacity="0.8" />
                                    <text x="5" y="83" fill="#f59e0b" font-size="9" font-weight="bold" font-family="monospace">0</text>

                                    <line x1="20" y1="112.5" x2="205" y2="112.5" stroke="#e5e7eb" stroke-dasharray="2" stroke-opacity="0.6" />
                                    <text x="5" y="115.5" fill="#9ca3af" font-size="8" font-family="monospace">-4</text>

                                    <line x1="20" y1="145" x2="205" y2="145" stroke="#f59e0b" stroke-dasharray="2" stroke-opacity="0.3" />
                                    <text x="5" y="148" fill="#9ca3af" font-size="8" font-family="monospace">-8</text>

                                    <!-- Vertical Column Axes -->
                                    @foreach($xPoints as $label => $x)
                                        <line x1="{{ $x }}" y1="10" x2="{{ $x }}" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.5" />
                                        <text x="{{ $x }}" y="158" fill="#64748b" font-size="10" font-weight="bold" text-anchor="middle">{{ $label }}</text>
                                    @endforeach

                                    <!-- Data Polyline -->
                                    <polyline fill="none" stroke="#d97706" stroke-width="2.5" points="{{ $pts2 }}" stroke-linecap="round" stroke-linejoin="round" />

                                    <!-- Data Points & Labels -->
                                    @foreach(['D', 'I', 'S', 'C'] as $dim)
                                        @php 
                                            $cx = $xPoints[$dim]; 
                                            $cy = $calcY($line2Conv[$dim] ?? 0); 
                                            $val = number_format($line2Conv[$dim] ?? 0, 1);
                                        @endphp
                                        <polygon points="{{ $cx }},{{ $cy - 4 }} {{ $cx + 4 }},{{ $cy }} {{ $cx }},{{ $cy + 4 }} {{ $cx - 4 }},{{ $cy }}" fill="#b45309" stroke="#ffffff" stroke-width="1.5" />
                                        <text x="{{ $cx }}" y="{{ $cy - 6 }}" fill="#b45309" font-size="8.5" font-weight="bold" text-anchor="middle">{{ $val }}</text>
                                    @endforeach
                                </svg>
                            </div>
                            <p class="text-[10px] text-gray-400 text-center leading-tight">Karakter asli ketika berada di bawah tekanan kerja atau situasi intim.</p>
                        </div>

                        <!-- Graph 3: Mirror Perceived Self (CHANGE) -->
                        <div class="p-4 rounded-2xl bg-white dark:bg-gray-800 border border-indigo-200 dark:border-indigo-900/60 shadow-2xs space-y-3">
                            <div class="text-center pb-2 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">GRAPH 3 (CHANGE)</span>
                                <h4 class="text-xs font-bold text-gray-900 dark:text-white">Mirror / Perceived Self</h4>
                            </div>

                            <!-- SVG Chart -->
                            <div class="relative bg-indigo-50/40 dark:bg-gray-900/60 rounded-xl p-2 border border-indigo-100 dark:border-indigo-950">
                                <svg viewBox="0 0 220 160" class="w-full h-44">
                                    <!-- Grid Lines -->
                                    <line x1="20" y1="15" x2="205" y2="15" stroke="#6366f1" stroke-dasharray="2" stroke-opacity="0.3" />
                                    <text x="5" y="18" fill="#9ca3af" font-size="8" font-family="monospace">+8</text>

                                    <line x1="20" y1="47.5" x2="205" y2="47.5" stroke="#e5e7eb" stroke-dasharray="2" stroke-opacity="0.6" />
                                    <text x="5" y="50.5" fill="#9ca3af" font-size="8" font-family="monospace">+4</text>

                                    <!-- Zero Line (Baseline) -->
                                    <line x1="20" y1="80" x2="205" y2="80" stroke="#6366f1" stroke-width="1.5" stroke-opacity="0.8" />
                                    <text x="5" y="83" fill="#6366f1" font-size="9" font-weight="bold" font-family="monospace">0</text>

                                    <line x1="20" y1="112.5" x2="205" y2="112.5" stroke="#e5e7eb" stroke-dasharray="2" stroke-opacity="0.6" />
                                    <text x="5" y="115.5" fill="#9ca3af" font-size="8" font-family="monospace">-4</text>

                                    <line x1="20" y1="145" x2="205" y2="145" stroke="#6366f1" stroke-dasharray="2" stroke-opacity="0.3" />
                                    <text x="5" y="148" fill="#9ca3af" font-size="8" font-family="monospace">-8</text>

                                    <!-- Vertical Column Axes -->
                                    @foreach($xPoints as $label => $x)
                                        <line x1="{{ $x }}" y1="10" x2="{{ $x }}" y2="148" stroke="#cbd5e1" stroke-dasharray="2" stroke-opacity="0.5" />
                                        <text x="{{ $x }}" y="158" fill="#64748b" font-size="10" font-weight="bold" text-anchor="middle">{{ $label }}</text>
                                    @endforeach

                                    <!-- Data Polyline -->
                                    <polyline fill="none" stroke="#4f46e5" stroke-width="2.5" points="{{ $pts3 }}" stroke-linecap="round" stroke-linejoin="round" />

                                    <!-- Data Points & Labels -->
                                    @foreach(['D', 'I', 'S', 'C'] as $dim)
                                        @php 
                                            $cx = $xPoints[$dim]; 
                                            $cy = $calcY($line3Conv[$dim] ?? 0); 
                                            $val = number_format($line3Conv[$dim] ?? 0, 1);
                                        @endphp
                                        <polygon points="{{ $cx }},{{ $cy - 4 }} {{ $cx + 4 }},{{ $cy }} {{ $cx }},{{ $cy + 4 }} {{ $cx - 4 }},{{ $cy }}" fill="#4338ca" stroke="#ffffff" stroke-width="1.5" />
                                        <text x="{{ $cx }}" y="{{ $cy - 6 }}" fill="#4338ca" font-size="8.5" font-weight="bold" text-anchor="middle">{{ $val }}</text>
                                    @endforeach
                                </svg>
                            </div>
                            <p class="text-[10px] text-gray-400 text-center leading-tight">Integrasi persepsi diri dan kecenderungan adaptasi perilaku harian.</p>
                        </div>
                    </div>

                    <!-- DESKRIPSI KEPRIBADIAN & GAMBARAN SIKAP (HIGH CONTRAST PREMIUM CARD) -->
                    @if ($profile)
                        <div class="p-6 rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-blue-950 text-white border-2 border-indigo-500/40 shadow-xl shadow-indigo-950/30 space-y-3">
                            <div class="flex items-center justify-between pb-3 border-b border-indigo-800/60">
                                <div class="flex items-center gap-2.5">
                                    <span class="p-2 rounded-xl bg-indigo-600 text-white text-sm shadow-md shadow-indigo-600/40">📖</span>
                                    <div>
                                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-indigo-400 block">DESKRIPSI KEPRIBADIAN</span>
                                        <h4 class="text-base font-black text-white">{{ $profile->title }} ({{ $profile->pattern_code }})</h4>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">
                                    DISC Profile
                                </span>
                            </div>
                            <p class="text-xs text-indigo-100/90 leading-relaxed font-normal pt-1">
                                {{ $profile->general_description ?: 'Seorang yang praktis, analitis, dan memiliki ketelitian tinggi dalam memecahkan masalah terstruktur. Mengutamakan fakta, logika, dan prosedur kerja yang akurat.' }}
                            </p>
                        </div>
                    @endif
                </div>
            @endif

            <p class="text-xs text-gray-400 dark:text-gray-500 leading-relaxed pt-4">
                Anda dapat memantau perkembangan nilai dan tahapan seleksi selanjutnya pada menu <strong>Riwayat Lamaran</strong>.
            </p>

            <div class="pt-4">
                <a href="{{ route('profile', ['tab' => 'riwayat']) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/20 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Riwayat Lamaran</span>
                </a>
            </div>
        </div>
    @endif

</div>
