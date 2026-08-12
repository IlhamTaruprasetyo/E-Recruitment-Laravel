<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\ApplicationStatusHistory;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of job applications (Read)
     */
    public function index()
    {
        $applications = JobApplication::with(['job.company', 'job.department', 'applicantProfile.user'])->get();
        return response()->json($applications);
    }

    /**
     * Display the specified job application details (Read)
     */
    public function show(string $id)
    {
        $application = JobApplication::with([
            'job.company', 
            'job.department', 
            'applicantProfile.user',
            'applicantProfile.educations',
            'applicantProfile.workExperiences',
            'applicantProfile.skills',
            'statusHistories.changedBy'
        ])->findOrFail($id);

        return response()->json($application);
    }

    /**
     * Update the specified job application status (Update)
     */
    public function update(Request $request, string $id)
    {
        $application = JobApplication::with('job')->findOrFail($id);

        $user = auth()->user();
        $isRecruiter = $user && ($user->role_id == 2 || strtolower($user->role?->name ?? '') === 'recruiter');
        $redirectRoute = $isRecruiter ? 'recruiter.application' : 'admin.application';

        if ($isRecruiter) {
            $job = $application->job;
            $isActive = $job && $job->status === 'Open' && (! $job->deadline || $job->deadline >= now()->toDateString());
            if (! $isActive) {
                return redirect()->route($redirectRoute)
                    ->with('error', 'Recruiter hanya diperbolehkan menyeleksi CV pada lowongan yang aktif.');
            }
        }

        $request->validate([
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $newStatus = $request->input('status', $application->status);
        $notes = $request->input('notes', $application->notes);

        $application->update([
            'status' => $newStatus,
            'notes' => $notes,
        ]);

        // Catat perubahan status secara otomatis ke application_status_history
        ApplicationStatusHistory::create([
            'job_applications_id' => $application->id,
            'status'              => $newStatus,
            'notes'               => $notes,
            'changed_by'          => auth()->id() ?? 1,
            'changed_at'          => now(),
        ]);

        return redirect()->route($redirectRoute)
            ->with('update', 'Status lamaran berhasil diperbarui dan dicatat ke riwayat status.');
    }
}
