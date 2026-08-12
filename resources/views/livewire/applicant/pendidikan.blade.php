<div class="space-y-6">

    <!-- Header Card -->
    <div
        class="bg-indigo-50/70 dark:bg-indigo-950/30 border-l-[5px] border-indigo-600 p-6 md:p-7 rounded-2xl overflow-hidden shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Riwayat Pendidikan</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">* Tambahkan riwayat pendidikan formal
                dan non-formal Anda.</p>
        </div>
        <button wire:click="openModal"
            class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-xs font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Pendidikan</span>
        </button>
    </div>

    <!-- Success Flash Alert -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="flex items-center justify-between p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-xl shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm font-medium">{{ session('message') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Education List Cards -->
    <div class="space-y-4">
        @forelse ($educations as $item)
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/80 hover:border-indigo-200 dark:hover:border-indigo-900 transition duration-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-2 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="px-3 py-1 bg-indigo-100 dark:bg-indigo-950/80 text-indigo-700 dark:text-indigo-300 font-semibold text-xs rounded-lg border border-indigo-200/60 dark:border-indigo-800/60">
                            {{ $item->degreeRelation ? $item->degreeRelation->name : $item->degree ?? 'Pendidikan' }}
                        </span>
                        @if ($item->gpa)
                            @php
                                $degreeName = strtoupper(
                                    $item->degreeRelation ? $item->degreeRelation->name : $item->degree ?? '',
                                );
                                $isSchoolItem =
                                    str_contains($degreeName, 'SMA') ||
                                    str_contains($degreeName, 'SMK') ||
                                    str_contains($degreeName, 'SLTA') ||
                                    str_contains($degreeName, 'SMP') ||
                                    str_contains($degreeName, 'SD') ||
                                    $item->gpa > 4.0;
                            @endphp
                            <span
                                class="px-2.5 py-1 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 font-medium text-xs rounded-lg border border-emerald-200 dark:border-emerald-800">
                                {{ $isSchoolItem ? 'Nilai:' : 'IPK:' }} {{ number_format($item->gpa, 2) }}
                            </span>
                        @endif
                        <span class="text-xs text-gray-400 font-medium ml-auto md:ml-0">
                            🗓️ {{ $item->start_year }} - {{ $item->end_year ? $item->end_year : 'Sekarang' }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 dark:text-white tracking-tight">
                        {{ $item->school_name }}
                    </h3>

                    <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                        {{ $item->majorRelation ? $item->majorRelation->name : $item->major ?? '' }}
                        @if ($item->study_program && $item->study_program !== $item->major)
                            <span class="text-gray-400 dark:text-gray-500">({{ $item->study_program }})</span>
                        @endif
                    </p>

                    @if ($item->description)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 line-clamp-2 leading-relaxed">
                            {{ $item->description }}
                        </p>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div
                    class="flex items-center gap-2 pt-3 md:pt-0 border-t md:border-t-0 border-gray-100 dark:border-gray-700 shrink-0">
                    <button wire:click="edit({{ $item->id }})"
                        class="px-3 py-2 text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/50 rounded-xl transition flex items-center gap-1.5 border border-indigo-200 dark:border-indigo-800">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Edit</span>
                    </button>
                    <button wire:click="delete({{ $item->id }})"
                        wire:confirm="Apakah Anda yakin ingin menghapus riwayat pendidikan ini?"
                        class="px-3 py-2 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-xl transition flex items-center gap-1.5 border border-red-200 dark:border-red-800">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Hapus</span>
                    </button>
                </div>
            </div>
        @empty
            <div
                class="bg-white dark:bg-gray-800 p-10 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 text-center space-y-3">
                <div
                    class="w-16 h-16 mx-auto rounded-full bg-indigo-50 dark:bg-indigo-950/50 flex items-center justify-center text-indigo-500">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <h4 class="text-base font-semibold text-gray-800 dark:text-gray-200">Belum Ada Riwayat Pendidikan</h4>
                <p class="text-xs text-gray-400 dark:text-gray-500 max-w-md mx-auto">Tambahkan riwayat sekolah SMA/SMK,
                    Diploma, Sarjana, atau pendidikan formal/non-formal lainnya untuk memperkuat profil Anda.</p>
                <button wire:click="openModal"
                    class="mt-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition">
                    + Tambah Pendidikan Pertama
                </button>
            </div>
        @endforelse
    </div>

    <!-- Modal Form (Tambah / Edit Pendidikan) -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Backdrop -->
                <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" wire:click="closeModal">
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Content -->
                <div
                    class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100 dark:border-gray-700">

                    <!-- Header -->
                    <div
                        class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>

                            <span>{{ $isEdit ? 'Edit Riwayat Pendidikan' : 'Tambah Riwayat Pendidikan' }}</span>
                        </h3>
                        <button wire:click="closeModal"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body Form -->
                    <form wire:submit.prevent="save" class="p-6 space-y-5">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            <!-- Tingkat Pendidikan (Degree) -->
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Tingkat / Jenjang Pendidikan
                                </label>
                                <select wire:model.live="degree_id"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                    <option value="">-- Pilih Jenjang --</option>
                                    @foreach ($degrees as $deg)
                                        <option value="{{ $deg->id }}">{{ $deg->name }}</option>
                                    @endforeach
                                </select>
                                @error('degree_id')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nama Sekolah / Universitas -->
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Nama Institusi / Sekolah <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="school_name"
                                    placeholder="Contoh: Universitas Diponegoro / SMA 1"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                @error('school_name')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jurusan (Major) -->
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Jurusan
                                </label>
                                @if ($this->isSchoolDegree())
                                    <input type="text" value="Tidak Berlaku (SMA/SMK)" disabled
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800/80 text-gray-400 dark:text-gray-500 text-sm cursor-not-allowed font-medium select-none">
                                    <p
                                        class="text-[11px] text-amber-600 dark:text-amber-400 mt-1 font-medium flex items-start gap-1">
                                        <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>* Untuk jenjang SMA/SMK, silakan isikan jurusan/konsentrasi keahlian Anda
                                            pada kolom <strong>Program Studi / Konsentrasi</strong> di sebelah.</span>
                                    </p>
                                @else
                                    <select wire:model="major_id"
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                        <option value="">-- Pilih Jurusan --</option>
                                        @foreach ($majors as $maj)
                                            <option value="{{ $maj->id }}">{{ $maj->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('major_id')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                    @enderror
                                @endif
                            </div>

                            <!-- Program Studi / Konsentrasi -->
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Program Studi / Konsentrasi
                                </label>
                                <input type="text" wire:model="study_program"
                                    placeholder="{{ $this->isSchoolDegree() ? 'Contoh: IPA / IPS / Teknik Komputer & Jaringan' : 'Contoh: Teknik Informatika / Manajemen' }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                @error('study_program')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tahun Masuk -->
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Tahun Masuk <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model="start_year" placeholder="Contoh: 2020"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                @error('start_year')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tahun Lulus / Selesai -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label
                                        class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        Tahun Lulus
                                    </label>
                                    <label
                                        class="flex items-center gap-1.5 cursor-pointer text-xs font-medium text-indigo-600 dark:text-indigo-400 select-none">
                                        <input type="checkbox" wire:model.live="is_ongoing"
                                            class="w-3.5 h-3.5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                                        <span>Masih Berlangsung / Belum Lulus</span>
                                    </label>
                                </div>
                                <input type="number" wire:model="end_year"
                                    placeholder="{{ $is_ongoing ? 'Masih Berlangsung' : 'Contoh: 2024' }}"
                                    @if ($is_ongoing) disabled @endif
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition {{ $is_ongoing ? 'bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 cursor-not-allowed select-none' : 'bg-gray-50/50 dark:bg-gray-900/50' }}">
                                @error('end_year')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- IPK / Nilai Akhir -->
                            <div class="md:col-span-2">
                                <label
                                    class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    {{ $this->isSchoolDegree() ? 'Nilai Rata-Rata / Nilai Ujian (Skala 0 - 100)' : 'IPK / Nilai Akhir (Skala 0.00 - 4.00)' }}
                                </label>
                                <input type="number" step="0.01" min="0"
                                    max="{{ $this->isSchoolDegree() ? '100' : '4.00' }}" wire:model="gpa"
                                    placeholder="{{ $this->isSchoolDegree() ? 'Contoh: 85.50' : 'Contoh: 3.75' }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                @error('gpa')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Deskripsi / Catatan -->
                            <div class="md:col-span-2">
                                <label
                                    class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Deskripsi / Prestasi Pendidikan
                                </label>
                                <textarea wire:model="description" rows="3"
                                    placeholder="Tuliskan judul skripsi, prestasi akademik, atau kegiatan ekstrakurikuler penting..."
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"></textarea>
                                @error('description')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <!-- Footer Actions -->
                        <div
                            class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <button type="button" wire:click="closeModal"
                                class="px-5 py-2.5 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled"
                                class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition flex items-center gap-2">
                                <span wire:loading.remove
                                    wire:target="save">{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Pendidikan' }}</span>
                                <span wire:loading wire:target="save" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
