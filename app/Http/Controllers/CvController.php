<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CvController extends Controller
{
    /**
     * Preview applicant CV
     */
    public function preview(Request $request)
    {
        $user = auth()->user();
        
        $isAdminOrRecruiter = $user && (
            in_array($user->role_id, [1, 2]) ||
            in_array(strtolower($user->role?->name ?? ''), ['admin', 'superadmin', 'recruiter'])
        );

        if ($isAdminOrRecruiter) {
            return redirect()->route($user->role_id == 2 || strtolower($user->role?->name ?? '') === 'recruiter' ? 'recruiter.dashboard' : 'admin.dashboard')
                ->with('error', 'Fitur preview CV pelamar hanya diperuntukkan bagi akun pelamar.');
        }

        $profile = $user->applicantProfile()
            ->with([
                'educations',
                'workExperiences',
                'organizations',
                'achievements',
                'certifications',
                'trainings',
                'skills',
                'socialMedias',
                'languages',
            ])
            ->first();

        return view('profile.cv-preview', compact('user', 'profile'));
    }
}
