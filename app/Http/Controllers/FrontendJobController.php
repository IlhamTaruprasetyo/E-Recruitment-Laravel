<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\Department;
use App\Models\JobApplication;
use App\Models\ApplicantProfile;
use Illuminate\Http\Request;

class FrontendJobController extends Controller
{
    /**
     * Display a listing of jobs on a dedicated page with filters and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $location = $request->query('location');
        $departmentId = $request->query('department_id');
        $companyId = $request->query('company_id');
        $employmentType = $request->query('employment_type');

        $jobsQuery = Job::active()->with(['company', 'department', 'degrees', 'majors']);

        if ($search) {
            $searchLower = mb_strtolower($search);
            $jobsQuery->where(function ($q) use ($searchLower) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$searchLower}%"])
                  ->orWhereRaw('LOWER(location) LIKE ?', ["%{$searchLower}%"])
                  ->orWhereRaw('LOWER(employment_type) LIKE ?', ["%{$searchLower}%"])
                  ->orWhereHas('company', function ($cq) use ($searchLower) {
                      $cq->whereRaw('LOWER(name) LIKE ?', ["%{$searchLower}%"]);
                  })
                  ->orWhereHas('department', function ($dq) use ($searchLower) {
                      $dq->whereRaw('LOWER(name) LIKE ?', ["%{$searchLower}%"]);
                  });
            });
        }

        if ($location) {
            $jobsQuery->where('location', 'like', "%{$location}%");
        }

        if ($departmentId) {
            $jobsQuery->where('department_id', $departmentId);
        }

        if ($companyId) {
            $jobsQuery->where('company_id', $companyId);
        }

        if ($employmentType) {
            $jobsQuery->where(function ($q) use ($employmentType) {
                if ($employmentType === 'Magang' || $employmentType === 'Internship') {
                    $q->whereIn('employment_type', ['Magang', 'Internship']);
                } elseif ($employmentType === 'Full Time' || $employmentType === 'Full-time') {
                    $q->whereIn('employment_type', ['Full Time', 'Full-time']);
                } elseif ($employmentType === 'Part Time' || $employmentType === 'Part-time') {
                    $q->whereIn('employment_type', ['Part Time', 'Part-time']);
                } elseif ($employmentType === 'Kontrak' || $employmentType === 'Contract') {
                    $q->whereIn('employment_type', ['Kontrak', 'Contract']);
                } else {
                    $q->where('employment_type', $employmentType);
                }
            });
        }

        $jobs = $jobsQuery->latest('id')->paginate(9)->withQueryString();
        $departments = Department::withCount(['jobs' => fn($q) => $q->active()])->get();
        $companies = Company::withCount(['jobs' => fn($q) => $q->active()])->get();
        $employmentTypes = [
            'Magang' => 'Magang / Internship',
            'Full Time' => 'Full Time',
            'Part Time' => 'Part Time',
            'Contract' => 'Kontrak / Contract',
            'Freelance' => 'Freelance',
            'Remote' => 'Remote'
        ];

        return view('frontend.jobs.index', compact(
            'jobs',
            'departments',
            'companies',
            'employmentTypes',
            'search',
            'location',
            'departmentId',
            'companyId',
            'employmentType'
        ));
    }

    /**
     * Display the specified job detail page.
     */
    public function show(string $id)
    {
        $job = Job::with(['company', 'department', 'degrees', 'majors'])
            ->findOrFail($id);

        $relatedJobs = Job::active()
            ->with(['company', 'department'])
            ->where('id', '!=', $id)
            ->where(function ($q) use ($job) {
                $q->where('department_id', $job->department_id)
                  ->orWhere('company_id', $job->company_id);
            })
            ->take(3)
            ->get();

        $hasApplied = false;
        $isMandatoryComplete = false;
        $missingMandatorySections = [];
        $applicantProfile = null;

        if (auth()->check()) {
            $applicantProfile = ApplicantProfile::where('user_id', auth()->id())->first();
            if ($applicantProfile) {
                $hasApplied = JobApplication::where('job_id', $job->id)
                    ->where('profile_id', $applicantProfile->id)
                    ->exists();

                $isMandatoryComplete = $applicantProfile->is_mandatory_complete;
                $missingMandatorySections = $applicantProfile->missing_mandatory_sections;
            } else {
                $missingMandatorySections = [
                    'Data Pribadi',
                    'Dokumen CV',
                    'Data Keluarga',
                    'Pendidikan',
                    'Skill / Keahlian',
                    'Pengalaman Kerja'
                ];
            }
        }

        return view('frontend.jobs.show', compact(
            'job',
            'relatedJobs',
            'hasApplied',
            'isMandatoryComplete',
            'missingMandatorySections',
            'applicantProfile'
        ));
    }
}
