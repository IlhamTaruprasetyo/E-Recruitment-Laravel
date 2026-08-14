<x-app-layout>
    <div x-on:switch-tab.window="activeTab = $event.detail">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profil Saya') }}
            </h2>
        </x-slot>

        <div class="py-4 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto space-y-3">
                
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

            </div>
        </div>
    </div>
</x-app-layout>
