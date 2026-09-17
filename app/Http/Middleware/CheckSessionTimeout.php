<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya periksa jika pengguna sedang terotentikasi
        if (! Auth::check()) {
            return $next($request);
        }

        $currentTime = time();

        // Catat waktu mulai sesi login jika belum ada (untuk batas Absolute Expiry)
        if (! $request->session()->has('session_start_time')) {
            $request->session()->put('session_start_time', $currentTime);
        }

        // Kecualikan sesi ujian aktif agar peserta tidak terputus di tengah pengerjaan soal
        if ($request->routeIs('applicant.test', 'employee.test')) {
            $request->session()->put('last_activity_time', $currentTime);
            return $next($request);
        }

        $user = Auth::user();

        // 1. CEK ABSOLUTE EXPIRY (Maksimal durasi sesi sejak login, default 12 jam / 720 menit)
        $absoluteTimeoutMinutes = (int) config('session.absolute_timeout', 720);
        $sessionStartTime = $request->session()->get('session_start_time');

        if ($sessionStartTime && ($currentTime - $sessionStartTime) > ($absoluteTimeoutMinutes * 60)) {
            $hours = round($absoluteTimeoutMinutes / 60);
            $message = "Batas maksimal sesi login Anda ({$hours} jam) telah tercapai demi keamanan. Silakan masuk kembali.";

            return $this->handleLogout($request, $user, $message);
        }

        // 2. CEK IDLE TIMEOUT (Batas inaktivitas tanpa aktivitas, default 30 menit)
        $idleTimeoutMinutes = $this->getIdleTimeoutForRole($user);
        $lastActivity = $request->session()->get('last_activity_time');

        // Berikan toleransi 15 detik untuk network latency dan render delay browser
        $toleranceSeconds = 15;

        if ($request->has('timeout') || ($lastActivity && ($currentTime - $lastActivity) >= (($idleTimeoutMinutes * 60) + $toleranceSeconds))) {
            $message = "Sesi Anda telah berakhir karena tidak ada aktivitas selama {$idleTimeoutMinutes} menit. Silakan masuk kembali.";

            return $this->handleLogout($request, $user, $message);
        }

        // 3. SLIDING REFRESH: Perbarui waktu aktivitas terakhir selama pengguna aktif
        $request->session()->put('last_activity_time', $currentTime);

        return $next($request);
    }

    /**
     * Dapatkan batas waktu inaktivitas (menit) berdasarkan peran pengguna.
     */
    protected function getIdleTimeoutForRole($user): int
    {
        $roleName = strtolower($user->role?->name ?? '');
        $roleId = (int) ($user->role_id ?? 0);

        // Default idle timeout (fallback ke config idle_timeout atau 30 menit)
        $defaultIdleTimeout = (int) config('session.idle_timeout', 30);

        return match (true) {
            $roleId === 1 || in_array($roleName, ['admin', 'superadmin'], true) =>
                (int) (config('session.lifetime_admin') ?: $defaultIdleTimeout),
            $roleId === 2 || $roleName === 'recruiter' =>
                (int) (config('session.lifetime_recruiter') ?: $defaultIdleTimeout),
            $roleId === 4 || $roleName === 'employee' =>
                (int) (config('session.lifetime_employee') ?: $defaultIdleTimeout),
            default =>
                (int) (config('session.lifetime_applicant') ?: $defaultIdleTimeout),
        };
    }

    /**
     * Tangani proses logout, pembersihan sesi, token, dan redirect.
     */
    protected function handleLogout(Request $request, $user, string $message): Response
    {
        $recallerName = Auth::guard('web')->getRecallerName();

        // Kosongkan remember token pada database user jika ada
        if ($user && $user->remember_token) {
            $user->setRememberToken(null);
            $user->saveQuietly();
        }

        // Logout dan bersihkan session
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus cookie remember-me agar tidak terjadi auto re-login
        if ($recallerName) {
            Cookie::queue(Cookie::forget($recallerName));
        }

        // Tangani request AJAX atau Livewire
        if ($request->ajax() || $request->wantsJson() || $request->header('X-Livewire')) {
            $request->session()->flash('error', $message);
            return response()->json([
                'message' => $message,
                'redirect' => route('login', ['timeout' => 1]),
            ], 401)->header('X-Livewire-Redirect', route('login', ['timeout' => 1]));
        }

        return redirect()->route('login', ['timeout' => 1])->with('error', $message);
    }
}
