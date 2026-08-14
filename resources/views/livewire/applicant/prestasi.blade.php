<div class="space-y-8">

    <!-- Main Header Card -->
    <div
        class="bg-indigo-50/70 dark:bg-indigo-950/30 border-l-[5px] border-indigo-600 p-6 md:p-7 rounded-2xl overflow-hidden shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Organisasi & Prestasi</h2>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-950/80 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">Opsional</span>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">* Kelola daftar pengalaman organisasi serta penghargaan/prestasi Anda dalam satu halaman.</p>
        </div>
    </div>

    <!-- Success Flash Alert -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
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

    <!-- ========================================== -->
    <!-- SECTION 1: PENGALAMAN ORGANISASI CRUD -->
    <!-- ========================================== -->
    <div class="space-y-4">
        <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Pengalaman Organisasi</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Pengalaman keanggotaan atau kepengurusan dalam organisasi/komunitas</p>
        </div>

        <div class="space-y-3">
            @forelse ($organizations as $org)
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-xs border border-gray-100 dark:border-gray-700/80 hover:border-indigo-200 dark:hover:border-indigo-900 transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h4 class="text-base font-bold text-gray-900 dark:text-white tracking-tight">
                                {{ $org->name }}
                            </h4>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                &bull; {{ $org->position }}
                            </span>
                            @if ($org->is_active)
                                <span class="px-2 py-0.5 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 font-semibold text-[11px] rounded-md border border-emerald-200 dark:border-emerald-800">
                                    Aktif
                                </span>
                            @endif
                        </div>

                        <p class="text-xs text-gray-400 font-medium">
                            {{ $org->start_month }} {{ $org->start_year }} -
                            @if ($org->is_active)
                                Sekarang
                            @else
                                {{ $org->end_month }} {{ $org->end_year }}
                            @endif
                        </p>

                        @if ($org->description)
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2 mt-1">
                                {{ $org->description }}
                            </p>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 pt-2 md:pt-0 border-t md:border-t-0 border-gray-100 dark:border-gray-700 shrink-0">
                        <button wire:click="editOrganization({{ $org->id }})"
                            class="px-3 py-1.5 text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/50 rounded-xl transition flex items-center gap-1 border border-indigo-200 dark:border-indigo-800">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Edit</span>
                        </button>
                        <button wire:click="confirmDeleteOrganization({{ $org->id }})"
                            class="px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-xl transition flex items-center gap-1 border border-red-200 dark:border-red-800">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Hapus</span>
                        </button>
                    </div>
                </div>
            @empty
                <!-- Empty State matching Admin Panel Style -->
                <div class="bg-white dark:bg-gray-800 p-8 md:p-10 rounded-2xl border border-gray-100 dark:border-gray-700/80 text-center flex flex-col items-center justify-center space-y-4">
                    <svg class="w-10 h-10 text-gray-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.816c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6A2.25 2.25 0 0 0 4.727 20.25h14.546a2.25 2.25 0 0 0 2.224-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                    </svg>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada data untuk ditampilkan</p>
                    <button wire:click="openOrganizationModal"
                        class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-indigo-600 dark:border-indigo-500 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 text-sm font-semibold rounded-2xl transition shadow-2xs">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Tambah Organisasi</span>
                    </button>
                </div>
            @endforelse
        </div>

        @if ($organizations->isNotEmpty())
            <div class="pt-1 flex justify-start">
                <button wire:click="openOrganizationModal"
                    class="inline-flex items-center gap-1.5 px-4 py-2 border border-indigo-200 dark:border-indigo-800 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 text-xs font-semibold rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Organisasi</span>
                </button>
            </div>
        @endif
    </div>


    <!-- ========================================== -->
    <!-- SECTION 2: PRESTASI (ACHIEVEMENTS) CRUD -->
    <!-- ========================================== -->
    <div class="space-y-4 pt-4">
        <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Prestasi & Penghargaan</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Penghargaan perlombaan, kompetisi, atau pencapaian profesional</p>
        </div>

        <div class="space-y-3">
            @forelse ($achievements as $ach)
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-xs border border-gray-100 dark:border-gray-700/80 hover:border-indigo-200 dark:hover:border-indigo-900 transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1.5 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-0.5 bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300 font-semibold text-[11px] rounded-lg border border-indigo-200 dark:border-indigo-800">
                                {{ $ach->scale }}
                            </span>
                            <span class="text-xs text-gray-400 font-medium ml-auto md:ml-0">
                                {{ $ach->month }} {{ $ach->year }}
                            </span>
                        </div>

                        <h4 class="text-base font-bold text-gray-900 dark:text-white tracking-tight">
                            {{ $ach->name }}
                        </h4>

                        @if ($ach->description)
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2">
                                {{ $ach->description }}
                            </p>
                        @endif

                        @if ($ach->certificate_path)
                            <div class="pt-1">
                                <a href="{{ asset('storage/' . $ach->certificate_path) }}" target="_blank"
                                    class="inline-flex items-center gap-1 text-xs text-indigo-600 dark:text-indigo-400 font-medium hover:underline">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    <span>Lihat Bukti Sertifikat</span>
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 pt-2 md:pt-0 border-t md:border-t-0 border-gray-100 dark:border-gray-700 shrink-0">
                        <button wire:click="editAchievement({{ $ach->id }})"
                            class="px-3 py-1.5 text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/50 rounded-xl transition flex items-center gap-1 border border-indigo-200 dark:border-indigo-800">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Edit</span>
                        </button>
                        <button wire:click="confirmDeleteAchievement({{ $ach->id }})"
                            class="px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-xl transition flex items-center gap-1 border border-red-200 dark:border-red-800">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Hapus</span>
                        </button>
                    </div>
                </div>
            @empty
                <!-- Empty State matching Admin Panel Style -->
                <div class="bg-white dark:bg-gray-800 p-8 md:p-10 rounded-2xl border border-gray-100 dark:border-gray-700/80 text-center flex flex-col items-center justify-center space-y-4">
                    <svg class="w-10 h-10 text-gray-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.816c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6A2.25 2.25 0 0 0 4.727 20.25h14.546a2.25 2.25 0 0 0 2.224-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                    </svg>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada data untuk ditampilkan</p>
                    <button wire:click="openAchievementModal"
                        class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-indigo-600 dark:border-indigo-500 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 text-sm font-semibold rounded-2xl transition shadow-2xs">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Tambah Prestasi</span>
                    </button>
                </div>
            @endforelse
        </div>

        @if ($achievements->isNotEmpty())
            <div class="pt-1 flex justify-start">
                <button wire:click="openAchievementModal"
                    class="inline-flex items-center gap-1.5 px-4 py-2 border border-indigo-200 dark:border-indigo-800 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 text-xs font-semibold rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Prestasi</span>
                </button>
            </div>
        @endif
    </div>


    <!-- ========================================== -->
    <!-- MODAL 1: FORM ORGANISASI -->
    <!-- ========================================== -->
    @if ($showOrganizationModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" wire:click="closeOrganizationModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>{{ $isEditOrganization ? 'Edit Organisasi' : 'Tambah Organisasi' }}</span>
                        </h3>
                        <button wire:click="closeOrganizationModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveOrganization" class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Nama Organisasi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="org_name" placeholder="Contoh: Himpunan Mahasiswa Informatika"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 transition">
                                @error('org_name')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Jabatan / Posisi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="org_position" placeholder="Contoh: Ketua Departemen Kominfo"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 transition">
                                @error('org_position')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Periode Mulai -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                        Bulan Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model="org_start_month"
                                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 transition">
                                        <option value="">Bulan</option>
                                        @foreach ($months as $m)
                                            <option value="{{ $m }}">{{ $m }}</option>
                                        @endforeach
                                    </select>
                                    @error('org_start_month')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                        Tahun Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" wire:model="org_start_year" placeholder="2021"
                                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 transition">
                                    @error('org_start_year')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Checkbox Masih Aktif -->
                            <div class="md:col-span-2 flex items-center gap-2 pt-1">
                                <input type="checkbox" id="org_is_active" wire:model.live="org_is_active"
                                    class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                                <label for="org_is_active" class="text-xs font-semibold text-gray-700 dark:text-gray-300 select-none">
                                    Saya masih aktif dalam organisasi ini
                                </label>
                            </div>

                            <!-- Periode Selesai (Jika Tidak Aktif) -->
                            @if (!$org_is_active)
                                <div class="grid grid-cols-2 gap-2 md:col-span-2">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                            Bulan Selesai
                                        </label>
                                        <select wire:model="org_end_month"
                                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 transition">
                                            <option value="">Bulan</option>
                                            @foreach ($months as $m)
                                                <option value="{{ $m }}">{{ $m }}</option>
                                            @endforeach
                                        </select>
                                        @error('org_end_month')
                                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                            Tahun Selesai
                                        </label>
                                        <input type="number" wire:model="org_end_year" placeholder="2023"
                                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 transition">
                                        @error('org_end_year')
                                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Deskripsi Kegiatan / Peran (Opsional)
                                </label>
                                <textarea wire:model="org_description" rows="3" placeholder="Jelaskan peran, program kerja utama, atau tanggung jawab Anda..."
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 transition"></textarea>
                                @error('org_description')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <button type="button" wire:click="closeOrganizationModal"
                                class="px-5 py-2.5 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled"
                                class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md transition flex items-center gap-2">
                                <span wire:loading.remove wire:target="saveOrganization">{{ $isEditOrganization ? 'Simpan Perubahan' : 'Tambah Organisasi' }}</span>
                                <span wire:loading wire:target="saveOrganization">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    <!-- ========================================== -->
    <!-- MODAL 2: FORM PRESTASI -->
    <!-- ========================================== -->
    @if ($showAchievementModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" wire:click="closeAchievementModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span>{{ $isEditAchievement ? 'Edit Prestasi' : 'Tambah Prestasi' }}</span>
                        </h3>
                        <button wire:click="closeAchievementModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveAchievement" class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Nama Penghargaan / Prestasi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="achievement_name" placeholder="Contoh: Juara 1 Hackathon Nasional"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 transition">
                                @error('achievement_name')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Tingkat / Skala <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="achievement_scale"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 transition">
                                    <option value="">-- Pilih Tingkat --</option>
                                    @foreach ($scales as $sc)
                                        <option value="{{ $sc }}">{{ $sc }}</option>
                                    @endforeach
                                </select>
                                @error('achievement_scale')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Bulan Perolehan <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="achievement_month"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 transition">
                                    <option value="">-- Pilih Bulan --</option>
                                    @foreach ($months as $m)
                                        <option value="{{ $m }}">{{ $m }}</option>
                                    @endforeach
                                </select>
                                @error('achievement_month')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Tahun Perolehan <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model="achievement_year" placeholder="Contoh: 2023"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 transition">
                                @error('achievement_year')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Deskripsi Singkat (Opsional)
                                </label>
                                <textarea wire:model="achievement_description" rows="3" placeholder="Jelaskan secara singkat mengenai kompetisi atau kriteria perolehan..."
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 transition"></textarea>
                                @error('achievement_description')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Upload Bukti / Sertifikat (Opsional, PDF / Gambar max 2MB)
                                </label>
                                <input type="file" wire:model="achievement_certificate" accept=".pdf,.jpg,.jpeg,.png"
                                    class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-950 dark:file:text-indigo-300 hover:file:bg-indigo-100 transition">
                                @error('achievement_certificate')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                                @if ($existing_achievement_certificate && !$achievement_certificate)
                                    <p class="text-[11px] text-gray-400 mt-1">Sertifikat terpasang: {{ basename($existing_achievement_certificate) }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <button type="button" wire:click="closeAchievementModal"
                                class="px-5 py-2.5 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled"
                                class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md transition flex items-center gap-2">
                                <span wire:loading.remove wire:target="saveAchievement">{{ $isEditAchievement ? 'Simpan Perubahan' : 'Tambah Prestasi' }}</span>
                                <span wire:loading wire:target="saveAchievement">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" wire:click="cancelDelete"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100 dark:border-gray-700 p-6 space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-red-100 dark:bg-red-950/60 flex items-center justify-center text-red-600 dark:text-red-400 shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-white">Konfirmasi Hapus Data</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                Apakah Anda yakin ingin menghapus data {{ $deleteType === 'organization' ? 'organisasi' : 'prestasi' }} ini? Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" wire:click="cancelDelete" class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition">
                            Batal
                        </button>
                        <button type="button" wire:click="executeDelete" wire:loading.attr="disabled" class="px-5 py-2 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-md shadow-red-500/20 transition flex items-center gap-1.5">
                            <span wire:loading.remove wire:target="executeDelete">Ya, Hapus</span>
                            <span wire:loading wire:target="executeDelete">Menghapus...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
