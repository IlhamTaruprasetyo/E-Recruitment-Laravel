<footer class="relative bg-[#020602] border-t border-[#08CB00]/30 text-gray-400 overflow-hidden">
    <!-- Glow element in footer #08CB00 -->
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3/4 h-32 bg-[#08CB00]/10 blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
            <!-- Brand Info (2 cols) -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center gap-3">
                    @php
                        $logoUrl = null;
                        if (isset($mainCompany) && $mainCompany->logo) {
                            if (Str::startsWith($mainCompany->logo, ['http://', 'https://', 'res.cloudinary.com'])) {
                                $logoUrl = $mainCompany->logo;
                            } else {
                                $logoUrl = asset('storage/' . $mainCompany->logo);
                            }
                        } else {
                            $logoUrl = asset('storage/logo/mikalight.png');
                        }
                    @endphp
                    <img src="{{ $logoUrl }}" 
                         alt="{{ $mainCompany->name ?? 'Logo MIKA' }}" 
                         class="h-10 w-auto object-contain rounded-lg">
                    <span class="text-xl font-extrabold tracking-tight text-[#EEEEEE]">
                        {{ isset($mainCompany) ? $mainCompany->name : 'MIKA CAREER' }}
                    </span>
                </div>
                <p class="text-sm text-gray-400 max-w-sm leading-relaxed">
                    Platform rekrutmen digital terintegrasi yang mempertemukan talenta profesional unggul dengan peluang karir terbaik di {{ isset($mainCompany) ? $mainCompany->name : 'Mitra Karya Analitika' }}.
                </p>
                <div class="flex items-center gap-3 pt-2">
                    @if(isset($mainCompany) && $mainCompany->website)
                        <a href="{{ Str::startsWith($mainCompany->website, ['http://', 'https://']) ? $mainCompany->website : 'https://' . $mainCompany->website }}" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           title="Kunjungi Website Perusahaan"
                           class="px-3 py-1.5 rounded-lg bg-[#050e05] border border-[#08CB00]/40 flex items-center gap-2 text-xs font-semibold text-gray-300 hover:text-[#08CB00] hover:border-[#08CB00] transition">
                            <svg class="w-4 h-4 text-[#08CB00]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                            <span>Official Website</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-sm font-bold tracking-wider uppercase text-[#08CB00] mb-4">Navigasi</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-[#08CB00] transition">Beranda</a></li>
                    <li><a href="{{ route('jobs.index') }}" class="hover:text-[#08CB00] transition">Cari Lowongan</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-[#08CB00] transition">Daftar</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-[#08CB00] transition">Masuk</a></li>
                </ul>
            </div>

            <!-- Company Categories -->
            <div>
                <h4 class="text-sm font-bold tracking-wider uppercase text-[#08CB00] mb-4">Kategori Pekerjaan</h4>
                <ul class="space-y-2.5 text-sm">
                    @forelse($footerDepartments ?? [] as $fDept)
                        <li>
                            <a href="{{ route('jobs.index', ['department_id' => $fDept->id]) }}" class="hover:text-[#08CB00] transition">
                                {{ $fDept->name }}
                            </a>
                        </li>
                    @empty
                        <li><a href="{{ route('jobs.index') }}" class="hover:text-[#08CB00] transition">Semua Lowongan</a></li>
                    @endforelse
                </ul>
            </div>

            <!-- Contact & Location (Dynamic) -->
            <div>
                <h4 class="text-sm font-bold tracking-wider uppercase text-[#08CB00] mb-4">Hubungi Kami</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-[#08CB00] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-gray-300">
                            @if(isset($mainCompany) && ($mainCompany->address || $mainCompany->city))
                                {{ $mainCompany->address ? $mainCompany->address . ', ' : '' }}
                                {{ $mainCompany->city ?? '' }}
                                {{ $mainCompany->province ? ', ' . $mainCompany->province : '' }}
                            @else
                                Semarang, Jawa Tengah, Indonesia
                            @endif
                        </span>
                    </li>
                    {{-- @if(isset($mainCompany) && $mainCompany->website)
                        @php
                            $footerWebUrl = Str::startsWith($mainCompany->website, ['http://', 'https://']) ? $mainCompany->website : 'https://' . $mainCompany->website;
                            $footerWebDisplay = preg_replace('/^https?:\/\/(www\.)?/', '', rtrim($mainCompany->website, '/'));
                        @endphp
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#08CB00] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            <a href="{{ $footerWebUrl }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="text-gray-300 hover:text-[#08CB00] transition truncate max-w-[200px]"
                               title="{{ $mainCompany->website }}">
                                {{ $footerWebDisplay }}
                            </a>
                        </li>
                    @endif --}}
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-[#08CB00]/20 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-4">
            <p>&copy; {{ date('Y') }} {{ isset($mainCompany) ? $mainCompany->name : 'Mitra Karya Analitika' }}. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-[#08CB00] transition">Kebijakan Privasi</a>
                <a href="#" class="hover:text-[#08CB00] transition">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
