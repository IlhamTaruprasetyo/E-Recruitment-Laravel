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
     * Handle applicant job application submission (Create/Store)
     */
    public function store(Request $request, string $id)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $applicantProfile = \App\Models\ApplicantProfile::where('user_id', $user->id)->first();
        if (!$applicantProfile) {
            return redirect()->route('profile')
                ->with('error', 'Profil pelamar tidak ditemukan. Silakan lengkapi profil Anda terlebih dahulu.');
        }

        // Cek kelengkapan data wajib
        if (!$applicantProfile->is_mandatory_complete) {
            return redirect()->route('jobs.show', $id)
                ->with('error', 'Mohon lengkapi seluruh data wajib profil Anda sebelum mengajukan lamaran.');
        }

        $job = \App\Models\Job::findOrFail($id);

        // Cek apakah lowongan aktif
        $isActive = $job->status === 'Open' && (!$job->deadline || $job->deadline >= now()->toDateString());
        if (!$isActive) {
            return redirect()->route('jobs.show', $id)
                ->with('error', 'Lowongan pekerjaan ini sudah ditutup atau tidak menerima lamaran baru.');
        }

        // Cek apakah sudah pernah melamar lowongan ini
        $alreadyApplied = JobApplication::where('job_id', $job->id)
            ->where('profile_id', $applicantProfile->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect()->route('jobs.show', $id)
                ->with('error', 'Anda sudah pernah mengajukan lamaran untuk lowongan pekerjaan ini.');
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $application = JobApplication::create([
                'job_id'     => $job->id,
                'profile_id' => $applicantProfile->id,
                'status'     => 'Submitted',
                'applied_at' => now(),
                'notes'      => null,
            ]);

            // Catat history status awal
            ApplicationStatusHistory::create([
                'job_applications_id' => $application->id,
                'status'              => 'Submitted',
                'notes'               => 'Lamaran pekerjaan berhasil diajukan oleh pelamar.',
                'changed_by'          => $user->id,
                'changed_at'          => now(),
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('profile', ['tab' => 'riwayat'])
                ->with('create', 'Lamaran Anda berhasil dikirim! Silakan pantau perkembangan seleksi dan ikuti tes online jika tersedia.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->route('jobs.show', $id)
                ->with('error', 'Gagal mengirimkan lamaran: ' . $e->getMessage());
        }
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
