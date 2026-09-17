@auth
@php
    $user = auth()->user();
    $roleName = strtolower($user?->role?->name ?? '');
    $roleId = (int) ($user?->role_id ?? 0);
    $defaultIdle = (int) config('session.idle_timeout', 30);
    $idleTimeoutMinutes = match (true) {
        $roleId === 1 || in_array($roleName, ['admin', 'superadmin'], true) =>
            (int) (config('session.lifetime_admin') ?: $defaultIdle),
        $roleId === 2 || $roleName === 'recruiter' =>
            (int) (config('session.lifetime_recruiter') ?: $defaultIdle),
        $roleId === 4 || $roleName === 'employee' =>
            (int) (config('session.lifetime_employee') ?: $defaultIdle),
        default =>
            (int) (config('session.lifetime_applicant') ?: $defaultIdle),
    };
    $idleTimeoutSeconds = max(10, $idleTimeoutMinutes * 60);
    // Durasi countdown peringatan seragam: 2 menit (120 detik) untuk semua sesi
    $configuredCountdown = (int) config('session.countdown_window', 120);
    $warningWindowSeconds = $idleTimeoutSeconds > ($configuredCountdown + 10)
        ? $configuredCountdown
        : max(15, (int) round($idleTimeoutSeconds * 0.5));
@endphp

<!-- Modal Peringatan Idle Timeout (Pilihan Lanjutkan / Keluar + Auto Logout saat Waktu Habis) -->
<div id="session-timeout-modal"
     class="hidden fixed inset-0 z-[99999] bg-black/50 backdrop-blur-xs flex items-center justify-center p-4 transition-all duration-200"
     role="dialog"
     aria-modal="true">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200/80 dark:border-gray-700/80 max-w-sm w-full p-6 text-center transform transition-all duration-200 pointer-events-auto">
        
        <!-- Icon Sederhana & Elegan -->
        <div class="w-12 h-12 mx-auto mb-3.5 rounded-xl bg-gray-100 dark:bg-gray-700/70 border border-gray-200 dark:border-gray-600/60 text-gray-700 dark:text-gray-200 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <!-- Judul & Keterangan Ringkas -->
        <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white tracking-tight mb-1">
            Pemberitahuan Aktivitas Sesi
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed mb-3">
            Tidak ada aktivitas yang terdeteksi. Sesi Anda akan otomatis keluar dalam:
        </p>

        <!-- Countdown Minimalis (Format mm:ss) & Progress Bar -->
        <div class="mb-5">
            <div class="inline-flex items-baseline gap-1 font-mono text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-0.5">
                <span id="session-timeout-countdown">02:00</span>
            </div>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 font-sans mb-3">(menit : detik)</p>
            <div class="w-full bg-gray-100 dark:bg-gray-700/80 h-1.5 rounded-full overflow-hidden">
                <div id="session-timeout-progress"
                     class="bg-indigo-600 dark:bg-indigo-500 h-full rounded-full transition-all duration-1000 ease-linear"
                     style="width: 100%;"></div>
            </div>
        </div>

        <!-- Tombol Pilihan Aksi: Keluar atau Lanjutkan Sesi -->
        <div class="flex items-center gap-2.5">
            <button id="session-timeout-logout-btn" type="button"
                    class="flex-1 py-2.5 px-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-medium transition focus:outline-none cursor-pointer">
                Keluar
            </button>
            <button id="session-timeout-stay-btn" type="button"
                    class="flex-1 py-2.5 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-xs transition focus:outline-none cursor-pointer">
                Lanjutkan Sesi
            </button>
        </div>
    </div>
</div>

<script>
    (function () {
        // Jangan aktifkan auto-logout jika pengguna sedang mengerjakan ujian online
        if (window.location.pathname.includes('/test/') || window.location.pathname.includes('applicant/test')) {
            return;
        }

        const idleTimeoutSeconds = {{ $idleTimeoutSeconds }};
        const warningWindowSeconds = {{ $warningWindowSeconds }};
        const loginUrl = "{{ route('login') }}?timeout=1";
        const keepAliveUrl = "{{ route('session.keep_alive') }}";

        let lastActivity = Date.now();
        let lastPing = Date.now();
        let isRedirecting = false;
        let isWarningShown = false;
        let hasActivitySinceLastPing = false;

        const modal = document.getElementById('session-timeout-modal');
        const countdownEl = document.getElementById('session-timeout-countdown');
        const progressEl = document.getElementById('session-timeout-progress');
        const stayBtn = document.getElementById('session-timeout-stay-btn');
        const logoutBtn = document.getElementById('session-timeout-logout-btn');

        // Fungsi memperpanjang sesi saat pengguna mengonfirmasi lanjut bekerja
        function continueSession() {
            if (isRedirecting) return;
            lastActivity = Date.now();
            lastPing = Date.now();
            hasActivitySinceLastPing = false;
            hideWarning();
            sendKeepAlivePing();
        }

        function showWarning(secondsLeft) {
            if (countdownEl) {
                const minutes = Math.floor(secondsLeft / 60);
                const seconds = secondsLeft % 60;
                countdownEl.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            }
            if (progressEl) {
                const percentage = Math.max(0, Math.min(100, (secondsLeft / warningWindowSeconds) * 100));
                progressEl.style.width = percentage + '%';
            }
            if (!isWarningShown) {
                isWarningShown = true;
                if (modal) modal.classList.remove('hidden');
            }
        }

        function hideWarning() {
            isWarningShown = false;
            if (modal) modal.classList.add('hidden');
        }

        function sendKeepAlivePing() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) return;

            fetch(keepAliveUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }).then(function (res) {
                if (res.ok) {
                    lastPing = Date.now();
                    // JANGAN update lastActivity di sini agar timer inaktivitas pengguna tidak ter-reset secara palsu
                } else if (res.status === 401) {
                    performAutoLogout();
                }
            }).catch(function () {});
        }

        function performAutoLogout() {
            if (isRedirecting) return;
            isRedirecting = true;
            hideWarning();
            window.location.href = loginUrl;
        }

        // Pantau aktivitas pengguna di layar sebelum modal muncul
        const activityEvents = [
            'mousemove', 'mousedown', 'keydown', 'scroll', 'wheel', 'touchstart', 'click'
        ];

        activityEvents.forEach(function (evt) {
            window.addEventListener(evt, function () {
                // Hanya update aktivitas normal saat modal peringatan belum muncul
                if (isWarningShown || isRedirecting) return;
                hasActivitySinceLastPing = true;
                if (Date.now() - lastActivity < 1000) return; // Throttle hemat CPU
                lastActivity = Date.now();
            }, { passive: true });
        });

        // Event Tombol "Lanjutkan Sesi"
        if (stayBtn) {
            stayBtn.addEventListener('click', function (e) {
                e.preventDefault();
                continueSession();
            });
        }

        // Event Tombol "Keluar"
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function (e) {
                e.preventDefault();
                performAutoLogout();
            });
        }

        // Hitung interval ping keep-alive (minimal 30 detik, maksimal 3 menit, atau separuh dari idle timeout)
        const pingIntervalMs = Math.max(30, Math.min(180, Math.floor(idleTimeoutSeconds / 2))) * 1000;

        // Pengecekan setiap detik
        setInterval(function () {
            if (isRedirecting) return;

            const now = Date.now();
            const elapsedSeconds = Math.floor((now - lastActivity) / 1000);
            const remainingSeconds = idleTimeoutSeconds - elapsedSeconds;

            if (remainingSeconds <= 0) {
                // WAKTU HABIS: Otomatis keluar ke halaman login
                performAutoLogout();
            } else if (remainingSeconds <= warningWindowSeconds) {
                // Zona peringatan: Tampilkan modal dengan angka hitungan mundur
                showWarning(remainingSeconds);
            } else {
                hideWarning();

                // Sliding refresh di latar belakang HANYA jika pengguna terbukti aktif sejak ping terakhir
                if (now - lastPing >= pingIntervalMs && hasActivitySinceLastPing) {
                    hasActivitySinceLastPing = false;
                    sendKeepAlivePing();
                }
            }
        }, 1000);

        // Jika tab browser baru saja dibuka kembali setelah ditinggal lama
        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') {
                const elapsedSeconds = Math.floor((Date.now() - lastActivity) / 1000);
                const remaining = idleTimeoutSeconds - elapsedSeconds;
                if (remaining <= 0) {
                    performAutoLogout();
                } else if (remaining <= warningWindowSeconds) {
                    showWarning(remaining);
                }
            }
        });
    })();
</script>
@endauth
