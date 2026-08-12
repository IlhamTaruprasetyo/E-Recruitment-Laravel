<div>
    <div class="bg-indigo-50/70 dark:bg-indigo-950/30 border-l-[5px] border-indigo-600 p-6 md:p-7 rounded-2xl overflow-hidden shadow-sm">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Pengaturan Keamanan Akun</h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 font-medium">* Perbarui kata sandi atau kelola akun Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="p-6 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
            <livewire:profile.update-password-form />
        </div>
        <div class="p-6 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
            <livewire:profile.delete-user-form />
        </div>
    </div>
</div>
