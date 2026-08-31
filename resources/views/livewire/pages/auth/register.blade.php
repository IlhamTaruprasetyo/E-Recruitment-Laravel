<?php

use App\Models\User;
use App\Models\Department;
use App\Models\EmployeeProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $account_type = 'applicant'; // 'applicant' | 'employee'
    public string $name = '';
    public string $nik = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Field khusus Karyawan Internal
    public string $company_passkey = '';
    public string $department_id = '';
    public string $position_title = '';

    public function with(): array
    {
        return [
            'departments' => Department::with('company')->orderBy('name')->get(),
        ];
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $rules = [
            'account_type' => ['required', 'in:applicant,employee'],
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'max:20', 'unique:users,nik'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ];

        if ($this->account_type === 'employee') {
            $expectedPasskey = env('EMPLOYEE_REGISTRATION_PASSKEY', 'MIKA2026');
            $rules['company_passkey'] = [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($expectedPasskey) {
                    if (trim($value) !== trim($expectedPasskey)) {
                        $fail('Kode token perusahaan tidak valid. Silakan hubungi tim HR.');
                    }
                },
            ];
            $rules['department_id'] = ['nullable', 'exists:departments,id'];
            $rules['position_title'] = ['nullable', 'string', 'max:100'];
        }

        $validated = $this->validate($rules);

        $userData = [
            'name' => $validated['name'],
            'nik' => $validated['nik'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $this->account_type === 'employee' ? 4 : 3,
        ];

        $user = User::create($userData);

        if ($this->account_type === 'employee') {
            $dept = !empty($this->department_id) ? Department::find($this->department_id) : null;
            EmployeeProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nik' => $user->nik,
                    'full_name' => $user->name,
                    'department_id' => !empty($this->department_id) ? (int)$this->department_id : null,
                    'company_id' => $dept?->company_id,
                    'position_title' => $this->position_title ?: null,
                ]
            );
        }

        event(new Registered($user));

        session()->flash('status', 'Registrasi berhasil! Silakan masuk menggunakan akun Anda.');
        $this->redirect(route('login', absolute: false));
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
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
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
                                Portal Rekrutmen & Asesmen Online
                            </span>
                        </div>
                    </a>

                    <!-- Slogan Heading -->
                    <div class="mt-8">
                        <h2 class="heading-font text-2xl sm:text-3xl font-bold text-white leading-tight">
                            Start your journey with <br>
                            <span class="text-[#93F514]">
                                Mitra Karya Analitika Group
                            </span>
                        </h2>
                    </div>
                </div>

                <!-- Middle / Illustration Showcase -->
                <div class="relative z-10 my-auto py-5 flex items-center justify-center">
                    <div class="relative w-full max-w-[280px] flex flex-col items-center">
                        
                        <!-- Glow Behind Person -->
                        <div class="absolute w-44 h-44 rounded-full bg-[#93F514]/20 blur-2xl pointer-events-none top-4"></div>

                        <!-- Vector Professional Person Illustration -->
                        <div class="relative z-10 flex flex-col items-center">
                            <svg class="w-48 h-48 sm:w-52 sm:h-52 drop-shadow-[0_15px_25px_rgba(0,0,0,0.8)]" viewBox="0 0 240 240" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="120" cy="120" r="90" fill="#051406" stroke="#93F514" stroke-width="2" stroke-dasharray="6 6" stroke-opacity="0.6"/>
                                <circle cx="120" cy="120" r="76" fill="#08220a" fill-opacity="0.8"/>
                                
                                <path d="M45 75h8m-4-4v8" stroke="#93F514" stroke-width="2" stroke-linecap="round"/>
                                <path d="M195 90h8m-4-4v8" stroke="#46ee40" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="50" cy="160" r="3" fill="#93F514" fill-opacity="0.6"/>
                                <circle cx="190" cy="150" r="3.5" fill="#5FE6B6" fill-opacity="0.7"/>

                                <path d="M60 216c0-33 27-56 60-56s60 23 60 56v4H60v-4z" fill="#0d3511"/>
                                <path d="M85 220c3-25 18-42 35-42s32 17 35 42H85z" fill="#144d1a"/>
                                
                                <path d="M116 160l4 35 4-35h-8z" fill="#93F514"/>
                                <circle cx="120" cy="162" r="3" fill="#ffffff"/>

                                <path d="M102 142l18 20 18-20-10-8h-16l-10 8z" fill="#EEEEEE"/>
                                <path d="M110 128h20v18h-20z" fill="#e0a97a"/>

                                <path d="M96 95c0 22 10.7 39 24 39s24-17 24-39-10.7-35-24-35-24 13-24 35z" fill="#f5c296"/>
                                
                                <path d="M93 85c2-22 15-32 32-32 15 0 26 8 28 20 2 12-2 18-5 18s-4-10-12-12c-9-2-19 3-23 8-3 4-8 4-10-2z" fill="#1b241c"/>
                                <path d="M93 88c0 8 2 15 3 17 1.5-3 3-8 3-12 0-8-3-10-6-5z" fill="#1b241c"/>

                                <circle cx="95" cy="98" r="5.5" fill="#e0a97a"/>
                                <circle cx="145" cy="98" r="5.5" fill="#e0a97a"/>

                                <circle cx="111" cy="94" r="2.5" fill="#1b241c"/>
                                <circle cx="129" cy="94" r="2.5" fill="#1b241c"/>
                                <circle cx="112" cy="93" r="0.8" fill="#ffffff"/>
                                <circle cx="130" cy="93" r="0.8" fill="#ffffff"/>

                                <path d="M106 88c3-2 8-2 10 0" stroke="#1b241c" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M124 88c2-2 7-2 10 0" stroke="#1b241c" stroke-width="1.8" stroke-linecap="round"/>

                                <path d="M113 112c3.5 4 10.5 4 14 0" stroke="#a65832" stroke-width="2" stroke-linecap="round"/>

                                <g transform="translate(142, 140)">
                                    <rect width="44" height="34" rx="6" fill="#051406" stroke="#93F514" stroke-width="1.5"/>
                                    <path d="M12 0h20a3 3 0 013 3v4H9V3a3 3 0 013-3z" fill="#93F514" fill-opacity="0.3" stroke="#93F514" stroke-width="1.5"/>
                                    <circle cx="22" cy="18" r="4" fill="#93F514"/>
                                    <path d="M14 26h16" stroke="#93F514" stroke-width="1.5" stroke-linecap="round" opacity="0.6"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Bottom Back Link -->
                <div class="relative z-10 pt-2">
                    <a href="{{ url('/') }}" 
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
                <div class="mb-4 sm:mb-5">
                    <div class="flex items-center justify-between mb-1">
                        <h1 class="heading-font text-2xl sm:text-3xl font-bold text-white tracking-tight">
                            Buat Akun Baru
                        </h1>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-400 font-normal">
                        Silakan pilih tipe pendaftaran dan lengkapi data Anda.
                    </p>
                </div>

                <!-- SEGMENTED SELECTOR: Tipe Pendaftar -->
                <div class="mb-5 p-1 bg-black/50 border border-white/10 rounded-2xl grid grid-cols-2 gap-1 shadow-inner">
                    <button type="button" 
                            wire:click="$set('account_type', 'applicant')"
                            class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200 cursor-pointer {{ $account_type === 'applicant' ? 'bg-[#93F514] text-black shadow-md shadow-[#93F514]/20 scale-[1.01]' : 'text-gray-400 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>Pelamar Kerja</span>
                    </button>

                    <button type="button" 
                            wire:click="$set('account_type', 'employee')"
                            class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200 cursor-pointer {{ $account_type === 'employee' ? 'bg-[#93F514] text-black shadow-md shadow-[#93F514]/20 scale-[1.01]' : 'text-gray-400 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Karyawan Internal</span>
                    </button>
                </div>

                @if ($account_type === 'employee')
                    <!-- Information Callout for Employee -->
                    <div class="mb-4 p-3 bg-[#93F514]/10 border border-[#93F514]/30 rounded-xl text-xs text-[#93F514] flex items-start gap-2.5">
                        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <span class="font-semibold block text-white">Khusus Karyawan Internal MIKA Group</span>
                            Masukkan kode token perusahaan yang diberikan oleh tim HR untuk memverifikasi akun karyawan Anda.
                        </div>
                    </div>
                @endif

                <form wire:submit="register" class="space-y-3 sm:space-y-3.5">
                    
                    <!-- NIK Field -->
                    <div>
                        <label for="nik" class="block text-xs font-semibold text-gray-300 mb-1">
                            {{ $account_type === 'employee' ? 'NIK / Nomor Induk Karyawan' : 'Nomor Induk Kependudukan (NIK KTP)' }}
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
                                   maxlength="20"
                                   required 
                                   autofocus 
                                   autocomplete="nik" 
                                   placeholder="{{ $account_type === 'employee' ? 'Contoh: NIK Karyawan atau KTP' : '16 digit nomor NIK KTP' }}"
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
                                   placeholder="Nama lengkap"
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

                    @if ($account_type === 'employee')
                        <!-- EMPLOYEE ONLY: Departemen & Posisi Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-3">
                            <!-- Departemen -->
                            <div>
                                <label for="department_id" class="block text-xs font-semibold text-gray-300 mb-1">
                                    Departemen / Divisi
                                </label>
                                <div class="relative">
                                    <select wire:model="department_id" 
                                            id="department_id" 
                                            class="w-full px-3.5 py-2.5 bg-black/60 border border-white/15 focus:border-[#93F514] focus:ring-1 focus:ring-[#93F514] rounded-xl text-sm text-white transition outline-none cursor-pointer">
                                        <option value="" class="bg-gray-900 text-gray-400">-- Pilih Departemen --</option>
                                        @foreach ($departments as $dept)
                                            <option value="{{ $dept->id }}" class="bg-gray-900 text-white">
                                                {{ $dept->name }} {{ $dept->company ? '('.$dept->company->name.')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('department_id'))
                                    <p class="mt-1 text-xs text-red-400 font-normal">
                                        {{ $errors->first('department_id') }}
                                    </p>
                                @endif
                            </div>

                            <!-- Posisi / Jabatan -->
                            <div>
                                <label for="position_title" class="block text-xs font-semibold text-gray-300 mb-1">
                                    Jabatan / Posisi
                                </label>
                                <input wire:model="position_title" 
                                       id="position_title" 
                                       type="text" 
                                       placeholder="Contoh: Staff IT, Supervisor, dll"
                                       class="w-full px-3.5 py-2.5 bg-black/40 border border-white/15 focus:border-[#93F514] focus:ring-1 focus:ring-[#93F514] rounded-xl text-sm text-white placeholder-gray-500 transition outline-none" />
                                @if ($errors->has('position_title'))
                                    <p class="mt-1 text-xs text-red-400 font-normal">
                                        {{ $errors->first('position_title') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- EMPLOYEE ONLY: Token Perusahaan (Passkey) -->
                        <div>
                            <label for="company_passkey" class="block text-xs font-semibold text-[#93F514] mb-1 flex items-center justify-between">
                                <span>Kode Token Perusahaan (Passkey HR) *</span>
                                <span class="text-[10px] text-gray-400 font-normal">Wajib diisi</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#93F514]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                </div>
                                <input wire:model="company_passkey" 
                                       id="company_passkey" 
                                       type="password" 
                                       required 
                                       placeholder="Masukkan kode token dari HR"
                                       class="w-full pl-10 pr-4 py-2.5 bg-black/40 border border-[#93F514]/40 focus:border-[#93F514] focus:ring-1 focus:ring-[#93F514] rounded-xl text-sm text-white placeholder-gray-500 transition outline-none" />
                            </div>
                            @if ($errors->has('company_passkey'))
                                <p class="mt-1 text-xs text-red-400 font-normal flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $errors->first('company_passkey') }}
                                </p>
                            @endif
                        </div>
                    @endif

                    <!-- Password and Confirmation Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-3">
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
                                <p class="mt-1 text-xs text-red-400 font-normal">
                                    {{ $errors->first('password_confirmation') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                class="w-full py-3 px-4 bg-[#93F514] hover:bg-[#82dc0e] active:scale-[0.99] disabled:opacity-60 disabled:cursor-not-allowed text-black font-semibold text-sm rounded-xl shadow-lg shadow-[#93F514]/20 hover:shadow-[#93F514]/30 transition flex items-center justify-center gap-2 group cursor-pointer">
                            <span wire:loading.remove wire:target="register">
                                {{ $account_type === 'employee' ? 'Daftar Sebagai Karyawan' : 'Daftar Sekarang' }}
                            </span>
                            <span wire:loading wire:target="register" class="inline-flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <span>Mendaftarkan...</span>
                            </span>
                            <svg wire:loading.remove wire:target="register" class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Divider & Login Link -->
                <div class="mt-6 pt-4 border-t border-white/10 text-center">
                    <p class="text-xs text-gray-400">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" 
                           class="font-semibold text-[#93F514] hover:underline ml-1">
                            Masuk
                        </a>
                    </p>
                </div>

            </div>

        </div>

    </div>
</div>
