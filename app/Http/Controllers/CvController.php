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
