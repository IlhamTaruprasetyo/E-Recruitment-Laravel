<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApplicantProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect(): RedirectResponse
    {
        // Check if Google credentials are configured in .env
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')->with(
                'error',
                'Autentikasi Google belum dikonfigurasi di server (.env GOOGLE_CLIENT_ID / GOOGLE_CLIENT_SECRET).'
            );
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google and authenticate.
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            Log::error('Google OAuth callback error: ' . $e->getMessage());

            return redirect()->route('login')->with(
                'error',
                'Gagal terhubung dengan Google atau proses login dibatalkan. Silakan coba lagi.'
            );
        }

        if (! $googleUser || ! $googleUser->getEmail()) {
            return redirect()->route('login')->with(
                'error',
                'Tidak dapat memperoleh data akun Google Anda. Pastikan izin email diizinkan.'
            );
        }

        // 1. Check if user already exists by google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        if (! $user) {
            // 2. Check if a user exists with the same email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Link google_id and avatar if not already set
                $userUpdates = ['google_id' => $googleUser->getId()];
                if (empty($user->avatar) && $googleUser->getAvatar()) {
                    $userUpdates['avatar'] = $googleUser->getAvatar();
                }
                if (empty($user->email_verified_at)) {
                    $userUpdates['email_verified_at'] = now();
                }
                $user->update($userUpdates);
            } else {
                // 3. Register new Applicant (Pelamar) user
                $user = User::create([
                    'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Pelamar MIKA',
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'role_id' => 3, // Applicant / Pelamar
                    'password' => null, // No password initially (Option 1)
                    'nik' => null, // Can be completed later in Applicant Profile
                    'email_verified_at' => now(),
                ]);
            }
        }

        // Ensure applicant profile exists
        if ($user->role_id == 3) {
            $profile = ApplicantProfile::firstOrCreate(['user_id' => $user->id]);
            if (empty($profile->full_name)) {
                $profile->update(['full_name' => $user->name]);
            }
        }

        // Log the user in
        Auth::login($user, remember: true);
        request()->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}
