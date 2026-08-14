<div class="space-y-8">

    <!-- Header Card Pengalaman Kerja -->
    <div
        class="bg-indigo-50/70 dark:bg-indigo-950/30 border-l-[5px] border-indigo-600 p-6 md:p-7 rounded-2xl overflow-hidden shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Riwayat Pengalaman Kerja</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">* Tambahkan riwayat pengalaman kerja profesional Anda.</p>
        </div>
    </div>

    <!-- Success Flash Alert Pengalaman -->
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

    <!-- Experience List Cards -->
    <div class="space-y-4">
        @forelse ($experiences as $item)
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/80 hover:border-indigo-200 dark:hover:border-indigo-900 transition duration-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-2 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="px-3 py-1 bg-indigo-100 dark:bg-indigo-950/80 text-indigo-700 dark:text-indigo-300 font-semibold text-xs rounded-lg border border-indigo-200/60 dark:border-indigo-800/60">
                            {{ $item->employment_type }}
                        </span>
                        @if ($item->currently_working)
                            <span
                                class="px-2.5 py-1 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 font-medium text-xs rounded-lg border border-emerald-200 dark:border-emerald-800">
                                Masih Bekerja
                            </span>
                        @endif
                        <span class="text-xs text-gray-400 font-medium ml-auto md:ml-0">
                            {{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->isoFormat('MMM YYYY') : '-' }} -
                            {{ $item->currently_working ? 'Sekarang' : ($item->end_date ? \Carbon\Carbon::parse($item->end_date)->isoFormat('MMM YYYY') : '-') }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 dark:text-white tracking-tight">
                        {{ $item->position }}
                    </h3>

                    <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                        {{ $item->company_name }}
                    </p>

                    @if ($item->description)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 line-clamp-3 leading-relaxed whitespace-pre-line">
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
                    <button wire:click="confirmDelete({{ $item->id }})"
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
            <!-- Empty State -->
            <div class="col-span-full bg-white dark:bg-gray-800 p-8 md:p-10 rounded-2xl border border-gray-100 dark:border-gray-700/80 text-center flex flex-col items-center justify-center space-y-4">
                <svg class="w-10 h-10 text-gray-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada data untuk ditampilkan</p>
                <button wire:click="openModal"
                    class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-indigo-600 dark:border-indigo-500 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 text-sm font-semibold rounded-2xl transition shadow-2xs">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Tambah Pengalaman</span>
                </button>
            </div>
        @endforelse
    </div>

    @if ($experiences->isNotEmpty())
        <div class="pt-1 flex justify-start">
            <button wire:click="openModal"
                class="inline-flex items-center gap-1.5 px-4 py-2 border border-indigo-200 dark:border-indigo-800 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 text-xs font-semibold rounded-xl transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Pengalaman</span>
            </button>
        </div>
    @endif

    <!-- SECTION MINAT KERJA -->
    <div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/80 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white tracking-tight flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Minat Kerja</span>
            </h3>
        </div>

        <!-- Success Flash Alert Minat Kerja -->
        @if (session()->has('preference_message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
                class="flex items-center justify-between p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-xl shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('preference_message') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <form wire:submit.prevent="savePreference" class="space-y-6"
            x-data="{
                departments: @js($departments),
                
                openField1: false, field1Query: '',
                openField2: false, field2Query: '',
                openField3: false, field3Query: '',

                get filteredField1() {
                    if (!this.field1Query) return this.departments;
                    return this.departments.filter(d => d.toLowerCase().includes(this.field1Query.toLowerCase()));
                },
                get filteredField2() {
                    if (!this.field2Query) return this.departments;
                    return this.departments.filter(d => d.toLowerCase().includes(this.field2Query.toLowerCase()));
                },
                get filteredField3() {
                    if (!this.field3Query) return this.departments;
                    return this.departments.filter(d => d.toLowerCase().includes(this.field3Query.toLowerCase()));
                }
            }" @click.outside="openField1 = false; openField2 = false; openField3 = false;">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Bidang yang diminati 1 -->
                <div class="relative">
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                        Bidang yang diminati 1 <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text"
                            x-model="$wire.interested_field_1"
                            @focus="openField1 = true; field1Query = ''"
                            @input="openField1 = true; field1Query = $event.target.value"
                            placeholder="Pilih / Ketik Bidang Minat 1"
                            class="w-full px-4 py-2.5 pr-10 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <div x-show="openField1 && filteredField1.length > 0" x-transition
                        class="absolute z-30 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl max-h-60 overflow-y-auto">
                        <template x-for="dept in filteredField1" :key="dept">
                            <button type="button"
                                @click="$wire.interested_field_1 = dept; openField1 = false"
                                class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-950/60 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center justify-between border-b border-gray-50 dark:border-gray-700/50 last:border-0">
                                <span x-text="dept"></span>
                            </button>
                        </template>
                    </div>
                    @error('interested_field_1') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Ketersediaan Bekerja (Notice Period) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                        Ketersediaan Bekerja (Notice Period) <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="notice_period"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <option value="">-- Pilih Notice Period --</option>
                        @foreach ($noticePeriodOptions as $np)
                            <option value="{{ $np }}">{{ $np }}</option>
                        @endforeach
                    </select>
                    @error('notice_period') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Bidang yang diminati 2 -->
                <div class="relative">
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                        Bidang yang diminati 2 <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text"
                            x-model="$wire.interested_field_2"
                            @focus="openField2 = true; field2Query = ''"
                            @input="openField2 = true; field2Query = $event.target.value"
                            placeholder="Pilih / Ketik Bidang Minat 2"
                            class="w-full px-4 py-2.5 pr-10 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <div x-show="openField2 && filteredField2.length > 0" x-transition
                        class="absolute z-30 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl max-h-60 overflow-y-auto">
                        <template x-for="dept in filteredField2" :key="dept">
                            <button type="button"
                                @click="$wire.interested_field_2 = dept; openField2 = false"
                                class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-950/60 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center justify-between border-b border-gray-50 dark:border-gray-700/50 last:border-0">
                                <span x-text="dept"></span>
                            </button>
                        </template>
                    </div>
                    @error('interested_field_2') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Harapan Gaji (Rupiah) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                        Harapan Gaji (Rupiah) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-semibold text-gray-500 dark:text-gray-400 pointer-events-none">Rp</span>
                        <input type="number" wire:model="expected_salary" placeholder="10.000.000"
                            class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    </div>
                    @error('expected_salary') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Bidang yang diminati 3 -->
                <div class="relative">
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                        Bidang yang diminati 3 <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text"
                            x-model="$wire.interested_field_3"
                            @focus="openField3 = true; field3Query = ''"
                            @input="openField3 = true; field3Query = $event.target.value"
                            placeholder="Pilih / Ketik Bidang Minat 3"
                            class="w-full px-4 py-2.5 pr-10 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <div x-show="openField3 && filteredField3.length > 0" x-transition
                        class="absolute z-30 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl max-h-60 overflow-y-auto">
                        <template x-for="dept in filteredField3" :key="dept">
                            <button type="button"
                                @click="$wire.interested_field_3 = dept; openField3 = false"
                                class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-950/60 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center justify-between border-b border-gray-50 dark:border-gray-700/50 last:border-0">
                                <span x-text="dept"></span>
                            </button>
                        </template>
                    </div>
                    @error('interested_field_3') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Ketersediaan ditempatkan di luar alamat domisili -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-3">
                        Ketersediaan ditempatkan di luar alamat domisili <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-6 pt-1">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="radio" wire:model="is_willing_to_relocate" value="1"
                                class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Bersedia</span>
                        </label>

                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="radio" wire:model="is_willing_to_relocate" value="0"
                                class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tidak Bersedia</span>
                        </label>
                    </div>
                    @error('is_willing_to_relocate') <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span> @enderror
                </div>

            </div>

            <!-- Submit Button Minat Kerja -->
            <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition duration-150 ease-in-out flex items-center gap-2">
                    <span wire:loading.remove wire:target="savePreference">Simpan Minat Kerja</span>
                    <span wire:loading wire:target="savePreference" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>

    <!-- Modal Form (Tambah / Edit Pengalaman Kerja) -->
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
                            <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>

                            <span>{{ $isEdit ? 'Edit Riwayat Pengalaman Kerja' : 'Tambah Riwayat Pengalaman Kerja' }}</span>
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

                            <!-- Nama Perusahaan / Instansi -->
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Nama Perusahaan / Instansi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="company_name"
                                    placeholder="Contoh: PT. Makna Karya Indonesia"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                @error('company_name')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Posisi / Jabatan -->
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Posisi / Jabatan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="position"
                                    placeholder="Contoh: Software Engineer / Admin Staff"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                @error('position')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jenis Pekerjaan -->
                            <div class="md:col-span-2">
                                <label
                                    class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Jenis Pekerjaan <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="employment_type"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                    <option value="">-- Pilih Jenis Pekerjaan --</option>
                                    @foreach ($employmentTypes as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('employment_type')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tanggal Mulai -->
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="date" wire:model="start_date"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                @error('start_date')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tanggal Selesai -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label
                                        class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal Selesai
                                    </label>
                                    <label
                                        class="flex items-center gap-1.5 cursor-pointer text-xs font-medium text-indigo-600 dark:text-indigo-400 select-none">
                                        <input type="checkbox" wire:model.live="currently_working"
                                            class="w-3.5 h-3.5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                                        <span>Masih Bekerja Di Sini</span>
                                    </label>
                                </div>
                                <input type="date" wire:model="end_date"
                                    @if ($currently_working) disabled @endif
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition {{ $currently_working ? 'bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 cursor-not-allowed select-none' : 'bg-gray-50/50 dark:bg-gray-900/50' }}">
                                @error('end_date')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Deskripsi Pekerjaan / Tanggung Jawab -->
                            <div class="md:col-span-2">
                                <label
                                    class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                                    Deskripsi Pekerjaan & Tanggung Jawab
                                </label>
                                <textarea wire:model="description" rows="3"
                                    placeholder="Tuliskan tugas utama, pencapaian, dan tanggung jawab posisi ini..."
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
                                    wire:target="save">{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Pengalaman' }}</span>
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
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Apakah Anda yakin ingin menghapus riwayat pengalaman kerja ini? Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" wire:click="cancelDelete" class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition">
                            Batal
                        </button>
                        <button type="button" wire:click="delete" wire:loading.attr="disabled" class="px-5 py-2 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-md shadow-red-500/20 transition flex items-center gap-1.5">
                            <span wire:loading.remove wire:target="delete">Ya, Hapus</span>
                            <span wire:loading wire:target="delete">Menghapus...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
