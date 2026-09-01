<div class="space-y-6">

    <!-- Control Header -->
    <div class="p-5 bg-white dark:bg-slate-800 rounded-3xl border border-gray-100 dark:border-slate-700 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        
        <!-- Search & Filter Controls -->
        <div class="flex flex-wrap items-center gap-3 w-full flex-1">
            <div class="relative w-full sm:w-72">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama karyawan, NIK, posisi..." 
                    class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-xl text-xs text-gray-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#93F514] focus:border-transparent transition-all">
                <svg class="w-4 h-4 text-gray-400 dark:text-slate-400 absolute left-3.5 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Filter Departemen -->
            <select wire:model.live="departmentId" class="px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition max-w-[180px]">
                <option value="">Semua Departemen</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }} {{ $dept->company ? '('.$dept->company->name.')' : '' }}</option>
                @endforeach
            </select>

            @if ($search || $departmentId)
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
                        <th class="py-4 px-6">Identitas Karyawan</th>
                        <th class="py-4 px-6">Departemen / Divisi</th>
                        <th class="py-4 px-6">Jabatan / Posisi</th>
                        <th class="py-4 px-6">Kontak / Email</th>
                        <th class="py-4 px-6 text-center">Status Akun</th>
                        <th class="py-4 px-6 text-right">Terdaftar Pada</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700/50 text-xs">
                    @forelse ($employees as $emp)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-slate-700/30 transition duration-150">
                            <td class="py-4 px-6">
                                <div class="font-bold text-gray-800 dark:text-slate-100 text-sm">
                                    {{ $emp->full_name ?? ($emp->user?->name ?? '-') }}
                                </div>
                                <div class="text-[11px] text-gray-400 dark:text-slate-500 mt-0.5">
                                    NIK: <span class="font-mono text-gray-600 dark:text-slate-300">{{ $emp->nik ?? ($emp->user?->nik ?? '-') }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-300 font-semibold text-[11px] border border-indigo-200 dark:border-indigo-800/60">
                                    {{ $emp->department?->name ?? 'Belum Diatur' }}
                                </span>
                                @if ($emp->department?->company)
                                    <div class="text-[10px] text-gray-400 mt-1">{{ $emp->department->company->name }}</div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800 dark:text-slate-200">
                                    {{ $emp->position_title ?? 'Staff Internal' }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-gray-700 dark:text-slate-300 font-medium">{{ $emp->user?->email ?? '-' }}</div>
                                @if ($emp->phone_number)
                                    <div class="text-[11px] text-gray-400">{{ $emp->phone_number }}</div>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center justify-center whitespace-nowrap px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 font-semibold text-[11px]">
                                    Karyawan Aktif
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right text-gray-400">
                                {{ $emp->created_at ? $emp->created_at->translatedFormat('d M Y, H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400 dark:text-slate-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-gray-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>Belum ada karyawan internal yang mendaftar.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($employees->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-slate-700">
                {{ $employees->links() }}
            </div>
        @endif
    </div>

</div>
