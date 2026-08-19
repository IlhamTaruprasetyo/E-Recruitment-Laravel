<div class="space-y-6">
    <!-- Header Card (Konsisten dengan tab lain) -->
    <div class="bg-indigo-50/70 dark:bg-indigo-950/30 border-l-[5px] border-indigo-600 p-6 md:p-7 rounded-2xl overflow-hidden shadow-sm">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Pengaturan Keamanan Akun</h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 font-medium">* Perbarui kata sandi atau kelola akun Anda.</p>
    </div>

    <!-- Single Column Layout -->
    <div class="space-y-6">
        <!-- Update Password Card -->
        <div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/80">
            <livewire:profile.update-password-form />
        </div>

        <!-- Delete Account Card -->
        <div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/80">
            <livewire:profile.delete-user-form />
        </div>
    </div>
</div>
