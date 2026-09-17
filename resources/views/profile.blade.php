<x-app-layout>
    <div x-on:switch-tab.window="activeTab = $event.detail">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profil Saya') }}
            </h2>
        </x-slot>

        @php
            $user = auth()->user();
            $roleName = strtolower($user?->role?->name ?? '');
            $isAdminOrRecruiter = auth()->check() && (
                in_array($user->role_id, [1, 2]) ||
                in_array($roleName, ['admin', 'superadmin', 'recruiter'])
            );
            $isEmployee = auth()->check() && ($user->role_id == 4 || $roleName === 'employee');
            $roleLabel = $user->role?->name ?? ($isAdminOrRecruiter ? 'Admin' : ($isEmployee ? 'Employee' : 'Pelamar'));
            $employeeProfile = $isEmployee ? $user->employeeProfile : null;
            $adminAvatarUrl = null;
            if (!empty($user->avatar)) {
                $adminAvatarUrl = \Illuminate\Support\Str::startsWith($user->avatar, ['http://', 'https://'])
                    ? $user->avatar
                    : asset('storage/' . $user->avatar);
            }
        @endphp

        <div class="py-4 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto space-y-4">

                @if ($isAdminOrRecruiter)
                    <!-- Admin / Recruiter Profile View -->
                    <div class="p-6 bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 rounded-2xl shadow-lg text-white flex flex-col sm:flex-row items-center justify-between gap-4"
                         x-data="{ 
                             bannerPhoto: @js($adminAvatarUrl), 
                             bannerName: @js(auth()->user()->name ?? 'Admin'),
                             get bannerInitial() { return (this.bannerName || 'A').charAt(0).toUpperCase(); }
                         }"
                         x-on:profile-updated.window="
                             if ($event.detail) {
                                 if ('photo' in $event.detail) bannerPhoto = $event.detail.photo;
                                 if ($event.detail.name) bannerName = $event.detail.name;
                             }
                         ">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-full bg-white/15 backdrop-blur-md border-2 border-white/30 ring-2 ring-white/20 overflow-hidden flex items-center justify-center text-white text-2xl font-black shadow-inner shrink-0 relative">
                                <template x-if="bannerPhoto">
                                    <img :src="bannerPhoto" :alt="bannerName" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!bannerPhoto">
                                    <span x-text="bannerInitial"></span>
                                </template>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold tracking-tight" x-text="bannerName">{{ auth()->user()->name }}</h3>
                                <p class="text-xs text-indigo-100 mt-0.5">{{ auth()->user()->email }} &bull; <span class="px-2 py-0.5 rounded-md bg-white/20 text-white font-semibold">{{ $roleLabel }}</span></p>
                            </div>
                        </div>
                        <a href="{{ auth()->user()->role_id == 2 || strtolower(auth()->user()->role?->name ?? '') === 'recruiter' ? route('recruiter.dashboard') : route('admin.dashboard') }}" 
                           class="px-5 py-2.5 rounded-xl bg-white text-indigo-700 font-bold text-xs hover:bg-indigo-50 transition shadow-md shrink-0">
                            Buka Panel Dashboard
                        </a>
                    </div>

                    <div class="p-4 bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 rounded-2xl flex items-start gap-3 text-amber-800 dark:text-amber-300 text-xs">
                        <svg class="w-5 h-5 shrink-0 text-amber-600 dark:text-amber-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <span class="font-bold block mb-0.5">Informasi Akun Internal</span>
                            Akun Anda terdaftar sebagai <strong>{{ $roleLabel }}</strong> untuk manajemen rekrutmen. Pengisian biodata pelamar & pelamaran lowongan dinonaktifkan untuk akun ini. Anda dapat memperbarui profil dan kata sandi di bawah ini.
                        </div>
                    </div>

                    <!-- Profile Information & Password Form -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-6 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl">
                            <livewire:profile.update-profile-information-form />
                        </div>
                        <div class="p-6 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl">
                            <livewire:profile.update-password-form />
                        </div>
                    </div>
                @elseif ($isEmployee)
                    <!-- Employee Internal Assessment Portal -->
                    <livewire:employee.employee-assessment-portal />
                @else
                    <!-- Tab 1: Data Pribadi -->
                    <div x-show="activeTab === 'pribadi'" class="space-y-3" x-cloak>
                        <livewire:applicant.pribadi />
                    </div>

                    <!-- Tab 1.5: Data Keluarga -->
                    <div x-show="activeTab === 'keluarga'" class="space-y-3" x-cloak>
                        <livewire:applicant.keluarga />
                    </div>

                    <!-- Tab 2: Pendidikan -->
                    <div x-show="activeTab === 'pendidikan'" class="space-y-3" x-cloak>
                        <livewire:applicant.pendidikan />
                    </div>

                    <!-- Tab 3: Pengalaman Kerja -->
                    <div x-show="activeTab === 'pengalaman'" class="space-y-3" x-cloak>
                        <livewire:applicant.pengalaman />
                    </div>

                    <!-- Tab 4 & 5: Organisasi & Prestasi -->
                    <div x-show="activeTab === 'prestasi' || activeTab === 'organisasi' || activeTab === 'organisasi_prestasi'" class="space-y-3" x-cloak>
                        <livewire:applicant.prestasi />
                    </div>

                    <!-- Tab 6: Social Media -->
                    <div x-show="activeTab === 'social_media'" class="space-y-3" x-cloak>
                        <livewire:applicant.social-media />
                    </div>

                    <!-- Tab 7: Data Tambahan (Keahlian / Skill) -->
                    <div x-show="activeTab === 'data_tambahan'" class="space-y-3" x-cloak>
                        <livewire:applicant.data-tambahan />
                    </div>

                    <!-- Tab 8: Riwayat Lamaran -->
                    <div x-show="activeTab === 'riwayat'" class="space-y-3" x-cloak>
                        <livewire:applicant.riwayat />
                    </div>

                    <!-- Tab 9: Pengaturan Akun -->
                    <div x-show="activeTab === 'pengaturan'" class="space-y-3" x-cloak>
                        @include('livewire.applicant.pengaturan')
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
