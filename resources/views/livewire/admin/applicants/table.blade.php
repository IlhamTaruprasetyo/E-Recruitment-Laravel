<div class="space-y-6" x-data="{ 
    showDetailModal: false,
    showStatusModal: false,
    detailData: {},
    statusData: {
        id: '',
        applicant_name: '',
        job_title: '',
        status: '',
        notes: ''
    },
    openDetailModal(application) {
        this.detailData = application;
        this.showDetailModal = true;
    },
    openStatusModal(application) {
        this.statusData = {
            id: application.id,
            applicant_name: application.applicant_profile ? application.applicant_profile.full_name : 'Pelamar',
            job_title: application.job ? application.job.title : 'Lowongan',
            status: application.status || 'Submitted',
            notes: application.notes || ''
        };
        this.showStatusModal = true;
    }
}">
    <!-- Session Notifications -->
    @if (session('update'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs font-semibold">{{ session('update') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs font-semibold">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Header & Filter Section -->
    <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 overflow-hidden shadow-sm rounded-2xl p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Lamaran Kerja</h3>
                <p class="text-xs text-gray-500 dark:text-slate-400">Pantau dan kelola tahapan seleksi berkas pelamar pekerjaan.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <!-- Status Filter -->
                <select wire:model.live="statusFilter" class="w-full sm:w-auto px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                    <option value="">Semua Status</option>
                    <option value="Submitted">Submitted (Diajukan)</option>
                    <option value="Reviewed">Reviewed (Ditinjau)</option>
                    <option value="Shortlisted">Shortlisted (Lolos Berkas)</option>
                    <option value="Interview">Interview (Wawancara)</option>
                    <option value="Accepted">Accepted (Diterima)</option>
                    <option value="Rejected">Rejected (Ditolak)</option>
                </select>

                <!-- Search Input -->
                <div class="relative w-full sm:w-64">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Cari pelamar, posisi..." 
                           class="w-full pl-9 pr-4 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-800/50 text-gray-500 dark:text-slate-400 uppercase tracking-wider font-semibold">
                        <th class="px-6 py-4">Pelamar</th>
                        <th class="px-6 py-4">Posisi & Perusahaan</th>
                        <th class="px-6 py-4">Tanggal Melamar</th>
                        <th class="px-6 py-4">Status & Catatan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800/60 text-gray-700 dark:text-slate-300">
                    @forelse ($applications as $app)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($app->applicantProfile && $app->applicantProfile->photo)
                                        <img src="{{ asset('storage/' . $app->applicantProfile->photo) }}" alt="{{ $app->applicantProfile->full_name }}" class="w-9 h-9 rounded-full object-cover border border-gray-200 dark:border-slate-700 shadow-sm shrink-0">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs shadow-sm shrink-0">
                                            {{ strtoupper(substr($app->applicantProfile->full_name ?? 'P', 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <span class="font-bold text-gray-900 dark:text-white block text-sm">{{ $app->applicantProfile->full_name ?? 'Pelamar' }}</span>
                                        <span class="text-[11px] text-gray-400 dark:text-slate-400 block">{{ $app->applicantProfile->user->email ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <span class="font-semibold text-gray-800 dark:text-slate-200 block">{{ $app->job->title ?? 'Lowongan' }}</span>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        @if ($app->job && $app->job->company)
                                            <span class="text-[11px] font-medium text-indigo-600 dark:text-indigo-400">
                                                {{ $app->job->company->name }}
                                            </span>
                                        @endif
                                        @if ($app->job && $app->job->department)
                                            <span class="text-[11px] text-gray-400">
                                                • {{ $app->job->department->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-600 dark:text-slate-300 font-medium">
                                    {{ \Carbon\Carbon::parse($app->applied_at)->format('d M Y, H:i') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @if ($app->status === 'Accepted')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                            Accepted (Diterima)
                                        </span>
                                    @elseif ($app->status === 'Rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800">
                                            Rejected (Ditolak)
                                        </span>
                                    @elseif ($app->status === 'Interview')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
                                            Interview (Wawancara)
                                        </span>
                                    @elseif ($app->status === 'Shortlisted')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-800">
                                            Shortlisted (Lolos Berkas)
                                        </span>
                                    @elseif ($app->status === 'Reviewed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                            Reviewed (Ditinjau)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                                            Submitted (Diajukan)
                                        </span>
                                    @endif

                                    @if ($app->notes)
                                        <p class="text-[11px] text-gray-400 dark:text-slate-500 italic truncate max-w-xs" title="{{ $app->notes }}">
                                            "{{ $app->notes }}"
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- View Detail Button -->
                                    <button @click="openDetailModal({{ json_encode($app) }})" class="p-1.5 rounded-lg text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors" title="Lihat Detail Profil">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <!-- Edit Status Button -->
                                    <button @click="openStatusModal({{ json_encode($app) }})" class="p-1.5 rounded-lg text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors" title="Update Status Lamaran">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 dark:text-slate-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-10 h-10 text-gray-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-sm font-medium">Belum ada data lamaran kerja</span>
                                    <span class="text-xs">Lamaran yang diajukan oleh pelamar akan muncul di sini.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($applications->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-800">
                {{ $applications->links() }}
            </div>
        @endif
    </div>

    <!-- Detail Applicant Modal (Read Only) -->
    <div x-show="showDetailModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-detail" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showDetailModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showDetailModal = false" class="fixed inset-0 transition-opacity bg-gray-900/60 dark:bg-black/70 backdrop-blur-sm"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showDetailModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-gray-200 dark:border-slate-800">
                
                <div class="p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 dark:bg-indigo-950/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-sm border border-indigo-200 dark:border-indigo-800">
                                <span x-text="detailData.applicant_profile ? detailData.applicant_profile.full_name.substring(0, 2).toUpperCase() : 'P'"></span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-white" x-text="detailData.applicant_profile ? detailData.applicant_profile.full_name : 'Detail Pelamar'"></h3>
                                <p class="text-xs text-gray-500 dark:text-slate-400" x-text="detailData.job ? detailData.job.title + ' • ' + (detailData.job.company ? detailData.job.company.name : '') : ''"></p>
                            </div>
                        </div>
                        <button @click="showDetailModal = false" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-4 space-y-4 max-h-[65vh] overflow-y-auto pr-1">
                        <!-- Personal Info Grid -->
                        <div class="grid grid-cols-2 gap-4 p-4 rounded-xl bg-gray-50 dark:bg-slate-800/50 border border-gray-200/60 dark:border-slate-700/60 text-xs">
                            <div>
                                <span class="text-gray-400 dark:text-slate-400 block text-[11px]">NIK</span>
                                <span class="font-semibold text-gray-800 dark:text-slate-200" x-text="detailData.applicant_profile ? (detailData.applicant_profile.nik || '-') : '-'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 dark:text-slate-400 block text-[11px]">Email</span>
                                <span class="font-semibold text-gray-800 dark:text-slate-200" x-text="detailData.applicant_profile && detailData.applicant_profile.user ? detailData.applicant_profile.user.email : '-'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 dark:text-slate-400 block text-[11px]">Nomor Telepon</span>
                                <span class="font-semibold text-gray-800 dark:text-slate-200" x-text="detailData.applicant_profile ? (detailData.applicant_profile.phone || '-') : '-'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 dark:text-slate-400 block text-[11px]">Jenis Kelamin</span>
                                <span class="font-semibold text-gray-800 dark:text-slate-200" x-text="detailData.applicant_profile ? (detailData.applicant_profile.gender || '-') : '-'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 dark:text-slate-400 block text-[11px]">Tempat, Tanggal Lahir</span>
                                <span class="font-semibold text-gray-800 dark:text-slate-200" x-text="detailData.applicant_profile ? ((detailData.applicant_profile.birth_place || '') + ', ' + (detailData.applicant_profile.birth_date || '')) : '-'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 dark:text-slate-400 block text-[11px]">Kota / Provinsi</span>
                                <span class="font-semibold text-gray-800 dark:text-slate-200" x-text="detailData.applicant_profile ? ((detailData.applicant_profile.city || '') + ' ' + (detailData.applicant_profile.province || '')) : '-'"></span>
                            </div>
                        </div>

                        <!-- About Me -->
                        <template x-if="detailData.applicant_profile && detailData.applicant_profile.about_me">
                            <div>
                                <h4 class="text-xs font-bold text-gray-900 dark:text-white mb-1">Tentang Saya</h4>
                                <p class="text-xs text-gray-600 dark:text-slate-300 leading-relaxed bg-gray-50 dark:bg-slate-800/40 p-3 rounded-xl border border-gray-200/60 dark:border-slate-800" x-text="detailData.applicant_profile.about_me"></p>
                            </div>
                        </template>

                        <!-- Generated CV Document Link -->
                        <template x-if="detailData.applicant_profile && detailData.applicant_profile.generated_cv_url">
                            <div class="p-3 rounded-xl bg-indigo-50/50 dark:bg-indigo-950/30 border border-indigo-200 dark:border-indigo-900/50 flex items-center justify-between">
                                <div class="flex items-center gap-2 text-xs text-indigo-700 dark:text-indigo-300 font-semibold">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Curriculum Vitae (CV) Pelamar
                                </div>
                                <a :href="detailData.applicant_profile.generated_cv_url" target="_blank" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                                    Buka CV
                                </a>
                            </div>
                        </template>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-800 mt-4">
                        <button type="button" @click="showDetailModal = false" class="px-4 py-2 text-xs font-semibold text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-xl transition">
                            Tutup
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Update Status Modal (Update Only) -->
    <div x-show="showStatusModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-status" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showStatusModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showStatusModal = false" class="fixed inset-0 transition-opacity bg-gray-900/60 dark:bg-black/70 backdrop-blur-sm"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showStatusModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-200 dark:border-slate-800">
                
                <div class="p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-slate-800">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white" id="modal-title-status">
                            Update Status Lamaran
                        </h3>
                        <button @click="showStatusModal = false" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form :action="'/admin/applicants/' + statusData.id" method="POST" class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="p-3 rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200/60 dark:border-slate-700 text-xs">
                            <span class="text-gray-400 block text-[11px]">Pelamar & Posisi</span>
                            <span class="font-bold text-gray-900 dark:text-white block" x-text="statusData.applicant_name"></span>
                            <span class="text-indigo-600 dark:text-indigo-400 block text-[11px]" x-text="statusData.job_title"></span>
                        </div>

                        <!-- Status Selection -->
                        <div>
                            <label for="status_select" class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">
                                Status Lamaran <span class="text-rose-500">*</span>
                            </label>
                            <select name="status" id="status_select" x-model="statusData.status" required class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                                <option value="Submitted">Submitted (Diajukan)</option>
                                <option value="Reviewed">Reviewed (Ditinjau)</option>
                                <option value="Shortlisted">Shortlisted (Lolos Berkas)</option>
                                <option value="Interview">Interview (Wawancara)</option>
                                <option value="Accepted">Accepted (Diterima)</option>
                                <option value="Rejected">Rejected (Ditolak)</option>
                            </select>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes_text" class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1">
                                Catatan / Feedback Internal
                            </label>
                            <textarea name="notes" id="notes_text" rows="3" x-model="statusData.notes" placeholder="Tambahkan catatan untuk proses seleksi pelamar ini..." class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"></textarea>
                        </div>

                        <!-- Modal Actions -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-800">
                            <button type="button" @click="showStatusModal = false" class="px-4 py-2 text-xs font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl shadow-md shadow-indigo-500/20 transition">
                                Simpan Perubahan Status
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
