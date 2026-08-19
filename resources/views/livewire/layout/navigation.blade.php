<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component
{
    #[On('profile-updated')]
    public function refreshNavigation(): void
    {
        // Re-renders component when profile is updated
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

@php
    $user = auth()->user();
    $roleName = strtolower($user?->role?->name ?? '');
    $roleId = $user?->role_id;
    
    $isAdmin = $roleId == 1 || in_array($roleName, ['admin', 'superadmin']);
    $isRecruiter = $roleId == 2 || $roleName === 'recruiter';
    
    $roleLabel = match(true) {
        $isAdmin => 'Admin',
        $isRecruiter => 'Recruiter',
        default => 'Pelamar',
    };

    $profileRoute = match(true) {
        $isAdmin => route('admin.profile'),
        $isRecruiter => route('recruiter.profile'),
        default => route('profile'),
    };
    
    $profile = $user?->applicantProfile;
    $photoUrl = $profile && $profile->photo ? asset('storage/' . $profile->photo) : null;
    $displayName = $profile && !empty($profile->full_name) ? $profile->full_name : ($user->name ?? 'User');
    $userInitial = strtoupper(substr($displayName, 0, 1));
@endphp

<nav x-data="{ open: false }" class="bg-transparent">
    <div class="flex items-center justify-between">
        <!-- Settings Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:ms-6">
            <x-dropdown align="right" width="56">
                <x-slot name="trigger">
                    <button class="inline-flex items-center gap-2.5 px-3 py-1.5 border border-gray-200 dark:border-gray-700/80 rounded-full text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/60 focus:outline-none transition shadow-2xs group">
                        @if ($photoUrl)
                            <img src="{{ $photoUrl }}" alt="{{ $displayName }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-indigo-500/20 group-hover:ring-indigo-500/50 transition">
                        @else
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-600 via-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-xs shadow-2xs">
                                {{ $userInitial }}
                            </div>
                        @endif

                        <div class="text-left leading-tight max-w-[150px] truncate">
                            <span class="block text-xs font-bold text-gray-800 dark:text-gray-200 truncate" x-data="{{ json_encode(['name' => $displayName]) }}" x-text="name" x-on:profile-updated.window="if ($event.detail && $event.detail.name) name = $event.detail.name"></span>
                            <span class="block text-[9.5px] font-semibold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">{{ $roleLabel }}</span>
                        </div>

                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-200 transition-transform group-hover:translate-y-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-4 py-2.5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                        <p class="text-xs font-bold text-gray-900 dark:text-white truncate">{{ $displayName }}</p>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>

                    <x-dropdown-link :href="url('/')">
                        {{ __('Lihat Beranda Website') }}
                    </x-dropdown-link>

                    @if($isAdmin)
                        <x-dropdown-link :href="route('admin.dashboard')">
                            {{ __('Dashboard Admin') }}
                        </x-dropdown-link>
                    @elseif($isRecruiter)
                        <x-dropdown-link :href="route('recruiter.dashboard')">
                            {{ __('Dashboard Recruiter') }}
                        </x-dropdown-link>
                    @endif

                    <x-dropdown-link :href="$profileRoute">
                        {{ __('Profil Saya') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <button wire:click="logout" class="w-full text-start border-t border-gray-100 dark:border-gray-700 mt-1">
                        <x-dropdown-link class="text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </button>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Mobile User Settings Toggle (Right) -->
        <div class="-me-2 flex items-center sm:hidden">
            <button @click="open = ! open" class="inline-flex items-center gap-2 p-1.5 rounded-full border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition" title="Toggle User Menu">
                @if ($photoUrl)
                    <img src="{{ $photoUrl }}" alt="{{ $displayName }}" class="w-7 h-7 rounded-full object-cover">
                @else
                    <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-xs">
                        {{ $userInitial }}
                    </div>
                @endif
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden mt-2 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-2">
            <div class="px-4 flex items-center gap-3">
                @if ($photoUrl)
                    <img src="{{ $photoUrl }}" alt="{{ $displayName }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-indigo-500/20">
                @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                        {{ $userInitial }}
                    </div>
                @endif
                <div>
                    <div class="font-bold text-sm text-gray-900 dark:text-white" x-data="{{ json_encode(['name' => $displayName]) }}" x-text="name" x-on:profile-updated.window="if ($event.detail && $event.detail.name) name = $event.detail.name"></div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</span>
                        <span class="px-1.5 py-0.5 text-[9px] font-extrabold uppercase rounded bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">{{ $roleLabel }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="url('/')">
                    {{ __('Lihat Beranda Website') }}
                </x-responsive-nav-link>

                @if($isAdmin)
                    <x-responsive-nav-link :href="route('admin.dashboard')">
                        {{ __('Dashboard Admin') }}
                    </x-responsive-nav-link>
                @elseif($isRecruiter)
                    <x-responsive-nav-link :href="route('recruiter.dashboard')">
                        {{ __('Dashboard Recruiter') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="$profileRoute">
                    {{ __('Profil Saya') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link class="text-red-600 dark:text-red-400">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
