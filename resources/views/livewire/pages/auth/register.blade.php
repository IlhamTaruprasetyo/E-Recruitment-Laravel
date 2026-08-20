<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $nik = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'max:16', 'unique:users,nik'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role_id'] = 3; // Tetapkan role_id default untuk pendaftar baru (3 untuk Applicant)

        $user = User::create($validated);

        event(new Registered($user));

        session()->flash('status', 'Registrasi berhasil! Silakan masuk menggunakan akun Anda.');
        $this->redirect(route('login', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full max-w-5xl mx-auto">
    <!-- Main 2-Column Card Container -->
    <div class="glass-card-main rounded-[2rem] sm:rounded-[2.5rem] p-3 sm:p-4 md:p-6 shadow-2xl relative overflow-hidden">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-stretch">
            
            <!-- LEFT COLUMN: Showcase / Value Proposition Banner (5 Cols) -->
            <div class="lg:col-span-5 banner-gradient rounded-[1.75rem] p-6 sm:p-8 lg:p-9 flex flex-col justify-between relative overflow-hidden min-h-[360px] lg:min-h-[560px]">
                
                <!-- Ambient Glow inside Left Panel -->
                <div class="absolute -top-20 -left-20 w-52 h-52 bg-[#93F514]/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -right-20 w-52 h-52 bg-[#46ee40]/15 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Hexagon / Geometric Background Motifs -->
                <div class="absolute inset-0 opacity-10 pointer-events-none flex items-center justify-center">
                    <svg class="w-full h-full text-[#93F514]" viewBox="0 0 400 400" fill="none" stroke="currentColor" stroke-width="1.5">
                        <polygon points="200,60 280,105 280,195 200,240 120,195 120,105"/>
                        <polygon points="320,130 380,165 380,235 320,270 260,235 260,165"/>
                        <polygon points="80,130 140,165 140,235 80,270 20,235 20,165"/>
                        <polygon points="200,220 280,265 280,355 200,400 120,355 120,265"/>
                    </svg>
                </div>

                <!-- Top Area: Brand Logo & Heading -->
                <div class="relative z-10">
                    <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center gap-3 group">
                        <div class="p-2 rounded-xl bg-black/40 border border-[#93F514]/30 shadow-md group-hover:scale-105 transition-transform duration-200">
                            <img src="{{ asset('storage/logo/mikaaaa.png') }}" 
                                 alt="Logo MIKA" 
                                 class="h-8 w-auto object-contain rounded-lg">
                        </div>
                        <div>
                            <span class="heading-font text-base sm:text-lg font-bold tracking-tight text-white flex items-center gap-1">
                                MIKA <span class="text-[#93F514]">CAREER</span>
                            </span>
                            <span class="block text-[10px] text-gray-400 font-normal">
                                Portal Rekrutmen Online
                            </span>
                        </div>
                    </a>

                    <!-- Slogan Heading -->
                    <div class="mt-8">
                        {{-- <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-[#93F514]/15 text-[#93F514] border border-[#93F514]/30 mb-3">
                            Pendaftaran Pelamar
                        </span> --}}
                        <h2 class="heading-font text-2xl sm:text-3xl font-bold text-white leading-tight">
                            Start your journey with <br>
                            <span class="text-[#93F514]">
                                Mitra Karya Analitika Group
                            </span>
                        </h2>
                    </div>
                </div>

                <!-- Middle / Illustration Showcase (Gambar Orang / Karakter Pelamar Kerja) -->
                <div class="relative z-10 my-auto py-5 flex items-center justify-center">
                    <div class="relative w-full max-w-[280px] flex flex-col items-center">
                        
                        <!-- Glow Behind Person -->
                        <div class="absolute w-44 h-44 rounded-full bg-[#93F514]/20 blur-2xl pointer-events-none top-4"></div>

                        <!-- Vector Professional Person Illustration -->
                        <div class="relative z-10 flex flex-col items-center">
                            <svg class="w-48 h-48 sm:w-52 sm:h-52 drop-shadow-[0_15px_25px_rgba(0,0,0,0.8)]" viewBox="0 0 240 240" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Background Circle Accent -->
                                <circle cx="120" cy="120" r="90" fill="#051406" stroke="#93F514" stroke-width="2" stroke-dasharray="6 6" stroke-opacity="0.6"/>
                                <circle cx="120" cy="120" r="76" fill="#08220a" fill-opacity="0.8"/>
                                
                                <!-- Decorative Floating Plus & Dots -->
                                <path d="M45 75h8m-4-4v8" stroke="#93F514" stroke-width="2" stroke-linecap="round"/>
                                <path d="M195 90h8m-4-4v8" stroke="#46ee40" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="50" cy="160" r="3" fill="#93F514" fill-opacity="0.6"/>
                                <circle cx="190" cy="150" r="3.5" fill="#5FE6B6" fill-opacity="0.7"/>

                                <!-- Candidate Avatar / Person -->
                                <!-- Body / Suit Jacket -->
                                <path d="M60 216c0-33 27-56 60-56s60 23 60 56v4H60v-4z" fill="#0d3511"/>
                                <path d="M85 220c3-25 18-42 35-42s32 17 35 42H85z" fill="#144d1a"/>
                                
                                <!-- Tie / Lanyard -->
                                <path d="M116 160l4 35 4-35h-8z" fill="#93F514"/>
                                <circle cx="120" cy="162" r="3" fill="#ffffff"/>

                                <!-- Shirt Collar -->
                                <path d="M102 142l18 20 18-20-10-8h-16l-10 8z" fill="#EEEEEE"/>
                                
                                <!-- Neck -->
                                <path d="M110 128h20v18h-20z" fill="#e0a97a"/>

                                <!-- Head / Face -->
                                <path d="M96 95c0 22 10.7 39 24 39s24-17 24-39-10.7-35-24-35-24 13-24 35z" fill="#f5c296"/>
                                
                                <!-- Hair (Modern Professional Style) -->
                                <path d="M93 85c2-22 15-32 32-32 15 0 26 8 28 20 2 12-2 18-5 18s-4-10-12-12c-9-2-19 3-23 8-3 4-8 4-10-2z" fill="#1b241c"/>
                                <path d="M93 88c0 8 2 15 3 17 1.5-3 3-8 3-12 0-8-3-10-6-5z" fill="#1b241c"/>

                                <!-- Ears -->
                                <circle cx="95" cy="98" r="5.5" fill="#e0a97a"/>
                                <circle cx="145" cy="98" r="5.5" fill="#e0a97a"/>

                                <!-- Eyes -->
                                <circle cx="111" cy="94" r="2.5" fill="#1b241c"/>
                                <circle cx="129" cy="94" r="2.5" fill="#1b241c"/>
                                <circle cx="112" cy="93" r="0.8" fill="#ffffff"/>
                                <circle cx="130" cy="93" r="0.8" fill="#ffffff"/>

                                <!-- Eyebrows -->
                                <path d="M106 88c3-2 8-2 10 0" stroke="#1b241c" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M124 88c2-2 7-2 10 0" stroke="#1b241c" stroke-width="1.8" stroke-linecap="round"/>

                                <!-- Friendly Smile -->
                                <path d="M113 112c3.5 4 10.5 4 14 0" stroke="#a65832" stroke-width="2" stroke-linecap="round"/>

                                <!-- Briefcase / Application Folder in front -->
                                <g transform="translate(142, 140)">
                                    <rect width="44" height="34" rx="6" fill="#051406" stroke="#93F514" stroke-width="1.5"/>
                                    <path d="M12 0h20a3 3 0 013 3v4H9V3a3 3 0 013-3z" fill="#93F514" fill-opacity="0.3" stroke="#93F514" stroke-width="1.5"/>
                                    <circle cx="22" cy="18" r="4" fill="#93F514"/>
                                    <path d="M14 26h16" stroke="#93F514" stroke-width="1.5" stroke-linecap="round" opacity="0.6"/>
                                </g>
                            </svg>
                        </div>

                        <!-- Floating Candidate Verified Pill Badge -->
                        {{-- <div class="mt-2 bg-[#051406]/95 backdrop-blur-md border border-[#93F514]/40 rounded-full px-4 py-1.5 shadow-xl flex items-center gap-2">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#93F514] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#93F514]"></span>
                            </span>
                            <span class="text-xs font-semibold text-white tracking-wide">Calon Karyawan MIKA</span>
                        </div> --}}

                    </div>
                </div>

                <!-- Bottom Back Link -->
                <div class="relative z-10 pt-2">
                    <a href="{{ url('/') }}" wire:navigate 
                       class="inline-flex items-center gap-2 text-xs font-medium text-gray-300 hover:text-[#93F514] transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>

            <!-- RIGHT COLUMN: Registration Form (7 Cols) -->
            <div class="lg:col-span-7 p-4 sm:p-6 lg:p-8 flex flex-col justify-center relative z-10">
                
                <!-- Form Header -->
                <div class="mb-5 sm:mb-6">
                    <div class="flex items-center justify-between mb-1.5">
                        <h1 class="heading-font text-2xl sm:text-3xl font-bold text-white tracking-tight">
                            Buat Akun Baru
                        </h1>
                        {{-- <span class="text-xs font-medium px-3 py-1 rounded-full bg-[#93F514]/10 text-[#93F514] border border-[#93F514]/30">
                            Daftar
                        </span> --}}
                    </div>
                    <p class="text-sm text-gray-400 font-normal">
                        Lengkapi data di bawah ini untuk mendaftar di <span class="text-white font-medium">MIKA CAREER</span>.
                    </p>
                </div>

                <form wire:submit="register" class="space-y-3.5 sm:space-y-4">
                    
                    <!-- NIK Field -->
                    <div>
                        <label for="nik" class="block text-xs font-semibold text-gray-300 mb-1">
                            Nomor Induk Kependudukan (NIK)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <input wire:model="nik" 
                                   id="nik" 
                                   type="text" 
                                   name="nik" 
                                   maxlength="16"
                                   required 
                                   autofocus 
                                   autocomplete="nik" 
                                   placeholder="16 digit nomor NIK KTP"
                                   class="w-full pl-10 pr-4 py-2.5 bg-black/40 border border-white/15 focus:border-[#93F514] focus:ring-1 focus:ring-[#93F514] rounded-xl text-sm text-white placeholder-gray-500 transition outline-none" />
                        </div>
                        @if ($errors->has('nik'))
                            <p class="mt-1 text-xs text-red-400 font-normal flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $errors->first('nik') }}
                            </p>
                        @endif
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-gray-300 mb-1">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input wire:model="name" 
                                   id="name" 
                                   type="text" 
                                   name="name" 
                                   required 
                                   autocomplete="name" 
                                   placeholder="Nama sesuai KTP"
                                   class="w-full pl-10 pr-4 py-2.5 bg-black/40 border border-white/15 focus:border-[#93F514] focus:ring-1 focus:ring-[#93F514] rounded-xl text-sm text-white placeholder-gray-500 transition outline-none" />
                        </div>
                        @if ($errors->has('name'))
                            <p class="mt-1 text-xs text-red-400 font-normal flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $errors->first('name') }}
                            </p>
                        @endif
                    </div>

                    <!-- Alamat Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-300 mb-1">
                            Alamat Email
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
                                   autocomplete="username" 
                                   placeholder="nama@email.com"
                                   class="w-full pl-10 pr-4 py-2.5 bg-black/40 border border-white/15 focus:border-[#93F514] focus:ring-1 focus:ring-[#93F514] rounded-xl text-sm text-white placeholder-gray-500 transition outline-none" />
                        </div>
                        @if ($errors->has('email'))
                            <p class="mt-1 text-xs text-red-400 font-normal flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>

                    <!-- Password & Confirm Password Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <!-- Password -->
                        <div x-data="{ showPassword: false }">
                            <label for="password" class="block text-xs font-semibold text-gray-300 mb-1">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <input wire:model="password" 
                                       id="password" 
                                       x-bind:type="showPassword ? 'text' : 'password'"
                                       type="password" 
                                       name="password" 
                                       required 
                                       autocomplete="new-password" 
                                       placeholder="Min. 8 karakter"
                                       class="w-full pl-3.5 pr-10 py-2.5 bg-black/40 border border-white/15 focus:border-[#93F514] focus:ring-1 focus:ring-[#93F514] rounded-xl text-sm text-white placeholder-gray-500 transition outline-none" />

                                <button type="button" @click="showPassword = !showPassword" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#93F514] transition focus:outline-none" 
                                        title="Tampilkan/Sembunyikan Kata Sandi">
                                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 013.682-.813c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                            @if ($errors->has('password'))
                                <p class="mt-1 text-xs text-red-400 font-normal">
                                    {{ $errors->first('password') }}
                                </p>
                            @endif
                        </div>

                        <!-- Confirm Password -->
                        <div x-data="{ showConfirmPassword: false }">
                            <label for="password_confirmation" class="block text-xs font-semibold text-gray-300 mb-1">
                                Ulangi Sandi
                            </label>
                            <div class="relative">
                                <input wire:model="password_confirmation" 
                                       id="password_confirmation" 
                                       x-bind:type="showConfirmPassword ? 'text' : 'password'"
                                       type="password" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password" 
                                       placeholder="Ulangi sandi"
                                       class="w-full pl-3.5 pr-10 py-2.5 bg-black/40 border border-white/15 focus:border-[#93F514] focus:ring-1 focus:ring-[#93F514] rounded-xl text-sm text-white placeholder-gray-500 transition outline-none" />

                                <button type="button" @click="showConfirmPassword = !showConfirmPassword" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#93F514] transition focus:outline-none" 
                                        title="Tampilkan/Sembunyikan Konfirmasi Sandi">
                                    <svg x-show="!showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showConfirmPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 013.682-.813c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <p class="mt-1 text-xs text-red-400 font-normal">
                                    {{ $errors->first('password_confirmation') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-3 px-4 bg-[#93F514] hover:bg-[#82dc0e] active:scale-[0.99] text-black font-semibold text-sm rounded-xl shadow-lg shadow-[#93F514]/20 hover:shadow-[#93F514]/30 transition flex items-center justify-center gap-2 group cursor-pointer">
                            <span>Daftar Sekarang</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Divider & Login Link -->
                <div class="mt-6 pt-5 border-t border-white/10 text-center">
                    <p class="text-xs text-gray-400">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" wire:navigate 
                           class="font-semibold text-[#93F514] hover:underline ml-1">
                            Masuk
                        </a>
                    </p>
                </div>

            </div>

        </div>

    </div>
</div>

