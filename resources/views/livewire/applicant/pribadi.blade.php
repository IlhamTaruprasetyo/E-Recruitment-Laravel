<div class="space-y-6" x-data="{
    showCropperModal: false,
    cropper: null,
    
    initCropper(imageElement) {
        if (this.cropper) {
            this.cropper.destroy();
        }
        this.cropper = new Cropper(imageElement, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 0.85,
            dragMode: 'move',
            background: false,
            responsive: true,
            restore: true,
            checkCrossOrigin: false,
        });
    },

    onFileSelect(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            const cropperImage = $refs.cropperImage;
            cropperImage.src = e.target.result;
            this.showCropperModal = true;

            this.$nextTick(() => {
                this.initCropper(cropperImage);
            });
        };
        reader.readAsDataURL(file);
        event.target.value = '';
    },

    applyCrop() {
        if (!this.cropper) return;
        const canvas = this.cropper.getCroppedCanvas({
            width: 450,
            height: 450,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        const croppedBase64 = canvas.toDataURL('image/jpeg', 0.92);
        $wire.set('cropped_photo_base64', croppedBase64);

        this.showCropperModal = false;
        if (this.cropper) {
            this.cropper.destroy();
            this.cropper = null;
        }
    },

    cancelCrop() {
        this.showCropperModal = false;
        if (this.cropper) {
            this.cropper.destroy();
            this.cropper = null;
        }
    },

    zoomIn() { if (this.cropper) this.cropper.zoom(0.1); },
    zoomOut() { if (this.cropper) this.cropper.zoom(-0.1); },
    rotateLeft() { if (this.cropper) this.cropper.rotate(-90); },
    rotateRight() { if (this.cropper) this.cropper.rotate(90); }
}">

    <!-- Load Cropper.js CDN Assets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <!-- Header Card -->
    <div class="bg-indigo-50/70 dark:bg-indigo-950/30 border-l-[5px] border-indigo-600 p-6 md:p-7 rounded-2xl overflow-hidden shadow-sm">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Data Pribadi</h2>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 font-medium">* Isilah data dibawah dengan sebenarnya Anda.</p>
    </div>

    <!-- Success Flash Alert -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="flex items-center justify-between p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-xl shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm font-medium">{{ session('message') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Main Form Card -->
    <div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/80">
        <form wire:submit.prevent="save" class="space-y-6">

            <!-- Photo & Basic Info Row -->
            <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-gray-100 dark:border-gray-700">
                <div class="relative group shrink-0">
                    <div class="w-28 h-28 rounded-full overflow-hidden bg-indigo-100 dark:bg-indigo-950/50 border-2 border-indigo-500 shadow-md flex items-center justify-center relative">
                        @if ($cropped_photo_base64)
                            <img src="{{ $cropped_photo_base64 }}" class="w-full h-full object-cover">
                        @elseif ($current_photo_url)
                            <img src="{{ $current_photo_url }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-14 h-14 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        @endif
                    </div>
                </div>

                <div class="flex-1 text-center sm:text-left space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Foto Profil / Pas Foto</label>
                    
                    <div class="flex flex-wrap items-center gap-3 justify-center sm:justify-start">
                        <label class="px-4 py-2 bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-100 dark:hover:bg-indigo-900 text-xs font-semibold rounded-xl cursor-pointer transition border border-indigo-200 dark:border-indigo-800 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Pilih & Atur Foto</span>
                            <input type="file" @change="onFileSelect" accept="image/*" class="hidden">
                        </label>
                    </div>

                    <p class="text-[11px] text-gray-400 dark:text-gray-500">* Anda dapat menggeser, memperbesar, dan memotong posisi foto sebelum disimpan.</p>
                    @error('photo') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Form Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- NIK -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" wire:model="nik" placeholder="Masukkan 16 digit NIK"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    @error('nik') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="full_name" placeholder="Nama lengkap sesuai KTP"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    @error('full_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                    <select wire:model="gender"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    @error('gender') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Nomor Telepon / WA -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">No. Telepon / WhatsApp</label>
                    <input type="text" wire:model="phone" placeholder="Contoh: 081234567890"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Tempat Lahir</label>
                    <input type="text" wire:model="birth_place" placeholder="Kota tempat lahir"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    @error('birth_place') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Tanggal Lahir</label>
                    <input type="date" wire:model="birth_date"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    @error('birth_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- NPWP -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">NPWP</label>
                    <input type="text" wire:model="npwp" placeholder="Nomor NPWP (jika ada)"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    @error('npwp') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Autocomplete Wilayah Domisili (Kota/Kabupaten & Provinsi) -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{
                    provinces: [],
                    regencies: [],
                    filteredRegencies: [],
                    filteredProvinces: [],
                    showCityDropdown: false,
                    showProvinceDropdown: false,
                    loadingCities: false,

                    async init() {
                        try {
                            const provRes = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                            if (provRes.ok) {
                                this.provinces = await provRes.json();
                            }
                        } catch (err) {
                            console.warn('Gagal memuat provinsi:', err);
                        }
                    },

                    async fetchRegenciesForProvince(provId) {
                        try {
                            const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`);
                            if (res.ok) {
                                const data = await res.json();
                                data.forEach(r => {
                                    if (!this.regencies.some(existing => existing.id == r.id)) {
                                        this.regencies.push(r);
                                    }
                                });
                            }
                        } catch (e) {}
                    },

                    async loadAllRegencies() {
                        if (this.regencies.length > 0 || this.loadingCities) return;
                        this.loadingCities = true;
                        try {
                            if (this.provinces.length === 0) {
                                const provRes = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                                if (provRes.ok) this.provinces = await provRes.json();
                            }
                            const fetchPromises = this.provinces.map(p => 
                                fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${p.id}.json`)
                                    .then(r => r.ok ? r.json() : [])
                                    .catch(() => [])
                            );
                            const results = await Promise.all(fetchPromises);
                            this.regencies = results.flat();
                        } catch (e) {
                            console.warn('Gagal memuat kabupaten/kota:', e);
                        } finally {
                            this.loadingCities = false;
                        }
                    },

                    async searchRegency() {
                        this.showCityDropdown = true;
                        if (this.regencies.length === 0 && !this.loadingCities) {
                            await this.loadAllRegencies();
                        }
                        const val = $wire.city || '';
                        if (!val.trim()) {
                            this.filteredRegencies = this.regencies.slice(0, 20);
                            return;
                        }
                        const q = val.toLowerCase();
                        this.filteredRegencies = this.regencies
                            .filter(r => r.name.toLowerCase().includes(q))
                            .slice(0, 25);
                    },

                    selectRegency(reg) {
                        $wire.city = reg.name;
                        this.showCityDropdown = false;
                        
                        if (reg.province_id) {
                            const prov = this.provinces.find(p => p.id == reg.province_id);
                            if (prov) {
                                $wire.province = prov.name;
                            }
                        }
                    },

                    searchProv() {
                        this.showProvinceDropdown = true;
                        const val = $wire.province || '';
                        if (!val.trim()) {
                            this.filteredProvinces = this.provinces;
                            return;
                        }
                        const q = val.toLowerCase();
                        this.filteredProvinces = this.provinces.filter(p => p.name.toLowerCase().includes(q));
                    },

                    async selectProv(prov) {
                        $wire.province = prov.name;
                        this.showProvinceDropdown = false;
                        await this.fetchRegenciesForProvince(prov.id);
                    }
                }" @click.outside="showCityDropdown = false; showProvinceDropdown = false">

                    <!-- Kota / Kabupaten Dropdown -->
                    <div class="relative">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                            Kota / Kabupaten Domisili
                        </label>
                        <div class="relative">
                            <input type="text" 
                                x-model="$wire.city"
                                @focus="searchRegency()"
                                @input="searchRegency()"
                                placeholder="Ketik untuk mencari Kota / Kabupaten..."
                                class="w-full px-4 py-2.5 pr-10 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Dropdown List Kota/Kabupaten -->
                        <div x-show="showCityDropdown && filteredRegencies.length > 0" 
                            x-transition
                            class="absolute z-30 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl max-h-60 overflow-y-auto"
                            style="display: none;">
                            <template x-for="reg in filteredRegencies" :key="reg.id">
                                <button type="button" 
                                    @click="selectRegency(reg)"
                                    class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-950/60 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center justify-between border-b border-gray-50 dark:border-gray-700/50 last:border-0">
                                    <span x-text="reg.name"></span>
                                </button>
                            </template>
                        </div>
                        @error('city') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Provinsi Dropdown -->
                    <div class="relative">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">
                            Provinsi Domisili
                        </label>
                        <div class="relative">
                            <input type="text" 
                                x-model="$wire.province"
                                @focus="searchProv()"
                                @input="searchProv()"
                                placeholder="Ketik untuk mencari Provinsi..."
                                class="w-full px-4 py-2.5 pr-10 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Dropdown List Provinsi -->
                        <div x-show="showProvinceDropdown && filteredProvinces.length > 0" 
                            x-transition
                            class="absolute z-30 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl max-h-60 overflow-y-auto"
                            style="display: none;">
                            <template x-for="prov in filteredProvinces" :key="prov.id">
                                <button type="button" 
                                    @click="selectProv(prov)"
                                    class="w-full text-left px-4 py-2.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-950/60 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center justify-between border-b border-gray-50 dark:border-gray-700/50 last:border-0">
                                    <span x-text="prov.name"></span>
                                </button>
                            </template>
                        </div>
                        @error('province') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                </div>

                <!-- Alamat Lengkap -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                    <textarea wire:model="address" rows="3" placeholder="Alamat lengkap tempat tinggal saat ini"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"></textarea>
                    @error('address') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Tentang Saya -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Tentang Saya / Ringkasan Diri</label>
                    <textarea wire:model="about_me" rows="4" placeholder="Tuliskan gambaran singkat mengenai latar belakang, motivasi, dan keahlian Anda..."
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"></textarea>
                    @error('about_me') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-500/20 transition duration-150 ease-in-out flex items-center gap-2">
                    <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>

    <!-- Image Cropper Modal -->
    <div x-show="showCropperModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" @click="cancelCrop"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Body -->
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-gray-200 dark:border-gray-700">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 19" />
                        </svg>
                        Atur & Potong Foto Profil
                    </h3>
                    <button @click="cancelCrop" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Content / Cropper Area -->
                <div class="p-6 bg-gray-900 flex justify-center items-center min-h-[320px] max-h-[420px] overflow-hidden">
                    <img x-ref="cropperImage" class="max-w-full max-h-[380px] block">
                </div>

                <!-- Toolbar Controls -->
                <div class="flex items-center justify-center gap-3 py-3 bg-gray-50 dark:bg-gray-900/60 border-t border-gray-100 dark:border-gray-700">
                    <button type="button" @click="zoomIn" title="Perbesar" class="p-2 rounded-lg bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 shadow-sm border border-gray-200 dark:border-gray-700">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" /></svg>
                    </button>
                    <button type="button" @click="zoomOut" title="Perkecil" class="p-2 rounded-lg bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 shadow-sm border border-gray-200 dark:border-gray-700">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" /></svg>
                    </button>
                    <button type="button" @click="rotateLeft" title="Putar Kiri" class="p-2 rounded-lg bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 shadow-sm border border-gray-200 dark:border-gray-700">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>
                    </button>
                    <button type="button" @click="rotateRight" title="Putar Kanan" class="p-2 rounded-lg bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 shadow-sm border border-gray-200 dark:border-gray-700">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a8 8 0 00-8 8v2m18-10l-6 6m6-6l-6-6" /></svg>
                    </button>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <button type="button" @click="cancelCrop"
                        class="px-4 py-2 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition">
                        Batal
                    </button>
                    <button type="button" @click="applyCrop"
                        class="px-5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-500/20 transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Gunakan Foto Ini</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
