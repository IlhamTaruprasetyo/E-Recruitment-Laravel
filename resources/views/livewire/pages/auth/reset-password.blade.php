<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div class="w-full max-w-md mx-auto">
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
                Buat Sandi Baru
            </h1>
            <p class="text-xs sm:text-sm text-gray-400 mt-2 font-medium">
                Silakan atur kata sandi baru untuk akun MIKA CAREER Anda
            </p>
        </div>

        <form wire:submit="resetPassword" class="space-y-4 relative z-10">
            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1.5">
                    Alamat Email
                </label>
                <input wire:model="email" 
                       id="email" 
                       type="email" 
                       name="email" 
                       required 
                       autofocus 
                       class="w-full px-4 py-3 bg-black/40 border border-white/15 focus:border-[#93F514] focus:ring-2 focus:ring-[#93F514]/30 rounded-xl text-sm text-[#EEEEEE] placeholder-gray-500 transition-all outline-none" />
                @if ($errors->has('email'))
                    <p class="mt-1 text-xs text-red-400 font-medium">
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>

            <!-- Password -->
            <div x-data="{ showPassword: false }">
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1.5">
                    Kata Sandi Baru
                </label>
                <div class="relative">
                    <input wire:model="password" 
                           id="password" 
                           x-bind:type="showPassword ? 'text' : 'password'"
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password" 
                           placeholder="••••••••"
                           class="w-full pl-4 pr-11 py-3 bg-black/40 border border-white/15 focus:border-[#93F514] focus:ring-2 focus:ring-[#93F514]/30 rounded-xl text-sm text-[#EEEEEE] placeholder-gray-500 transition-all outline-none" />

                    <button type="button" @click="showPassword = !showPassword" 
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-[#93F514] transition focus:outline-none" 
                            title="Tampilkan/Sembunyikan Kata Sandi">
                        <svg x-show="!showPassword" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" x-cloak class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @if ($errors->has('password'))
                    <p class="mt-1 text-xs text-red-400 font-medium">
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>

            <!-- Confirm Password -->
            <div x-data="{ showConfirmPassword: false }">
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1.5">
                    Konfirmasi Sandi Baru
                </label>
                <div class="relative">
                    <input wire:model="password_confirmation" 
                           id="password_confirmation" 
                           x-bind:type="showConfirmPassword ? 'text' : 'password'"
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password" 
                           placeholder="••••••••"
                           class="w-full pl-4 pr-11 py-3 bg-black/40 border border-white/15 focus:border-[#93F514] focus:ring-2 focus:ring-[#93F514]/30 rounded-xl text-sm text-[#EEEEEE] placeholder-gray-500 transition-all outline-none" />

                    <button type="button" @click="showConfirmPassword = !showConfirmPassword" 
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-[#93F514] transition focus:outline-none" 
                            title="Tampilkan/Sembunyikan Konfirmasi Sandi">
                        <svg x-show="!showConfirmPassword" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showConfirmPassword" x-cloak class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @if ($errors->has('password_confirmation'))
                    <p class="mt-1 text-xs text-red-400 font-medium">
                        {{ $errors->first('password_confirmation') }}
                    </p>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                        class="w-full py-3.5 px-4 bg-[#93F514] hover:bg-[#82dc0e] active:scale-[0.99] text-black font-extrabold text-sm rounded-xl shadow-lg shadow-[#93F514]/25 hover:shadow-[#93F514]/40 transition-all duration-200 flex items-center justify-center gap-2 group">
                    <span>Simpan Sandi Baru</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
