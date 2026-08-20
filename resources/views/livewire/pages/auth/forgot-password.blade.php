<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="w-full max-w-md mx-auto">
    <!-- Back to Login Link -->
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('login') }}" wire:navigate 
           class="inline-flex items-center gap-2 text-xs font-semibold text-gray-400 hover:text-[#93F514] px-3.5 py-1.5 rounded-full bg-white/[0.03] hover:bg-[#93F514]/10 border border-white/10 hover:border-[#93F514]/40 transition-all duration-300 backdrop-blur-md group">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke Masuk</span>
        </a>

        <span class="text-[11px] font-bold tracking-widest uppercase px-2.5 py-1 rounded-md bg-[#93F514]/10 text-[#93F514] border border-[#93F514]/30">
            Reset Sandi
        </span>
    </div>

    <!-- Glassmorphic Card -->
    <div class="glass-card rounded-3xl p-7 sm:p-9 shadow-2xl relative overflow-hidden transition-all duration-300">
        
        <!-- Decorative Glow Accents inside Card -->
        <div class="absolute -top-16 -right-16 w-36 h-36 bg-[#93F514]/15 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-36 h-36 bg-[#46ee40]/10 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Header -->
        <div class="text-center mb-6 relative z-10">
            <div class="inline-flex items-center justify-center p-2.5 rounded-2xl bg-white/[0.04] border border-[#93F514]/30 shadow-lg shadow-[#93F514]/10 mb-4">
                <img src="{{ asset('storage/logo/mikaaaa.png') }}" 
                     alt="Logo MIKA" 
                     class="h-12 w-auto object-contain rounded-lg">
            </div>

            <h1 class="text-2xl font-extrabold text-[#EEEEEE] tracking-tight">
                Lupa Kata Sandi?
            </h1>
            <p class="text-xs sm:text-sm text-gray-400 mt-2 font-medium">
                Masukkan email Anda dan kami akan mengirimkan tautan reset kata sandi baru.
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-5 p-3.5 rounded-2xl bg-[#93F514]/15 border border-[#93F514]/40 text-[#93F514] text-xs font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form wire:submit="sendPasswordResetLink" class="space-y-5 relative z-10">
            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1.5">
                    Alamat Email Terdaftar
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input wire:model="email" 
                           id="email" 
                           type="email" 
                           name="email" 
                           required 
                           autofocus 
                           placeholder="nama@email.com"
                           class="w-full pl-10 pr-4 py-3 bg-black/40 border border-white/15 focus:border-[#93F514] focus:ring-2 focus:ring-[#93F514]/30 rounded-xl text-sm text-[#EEEEEE] placeholder-gray-500 transition-all outline-none" />
                </div>
                @if ($errors->has('email'))
                    <p class="mt-1.5 text-xs text-red-400 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                        class="w-full py-3.5 px-4 bg-[#93F514] hover:bg-[#82dc0e] active:scale-[0.99] text-black font-extrabold text-sm rounded-xl shadow-lg shadow-[#93F514]/25 hover:shadow-[#93F514]/40 transition-all duration-200 flex items-center justify-center gap-2 group">
                    <span>Kirim Tautan Reset</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
