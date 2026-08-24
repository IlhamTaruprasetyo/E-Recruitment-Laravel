<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\JobApplication;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Support\Facades\DB;

class ApplicantTable extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public array $selectedStatuses = [];
    public array $selectedColumns = ['applicant', 'job', 'applied_at', 'status', 'actions'];

    public $sortField = 'id';
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatuses()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function resetColumnSelection()
    {
        $this->selectedColumns = ['applicant', 'job', 'applied_at', 'status', 'actions'];
    }

    public function selectAllColumns()
    {
        $this->selectedColumns = ['applicant', 'contact', 'job', 'applied_at', 'status', 'actions'];
    }

    public function resetAllFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->selectedStatuses = [];
        $this->sortField = 'id';
        $this->sortDirection = 'desc';
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        $isRecruiterOnly = $user && ($user->role_id == 2 || strtolower($user->role?->name ?? '') === 'recruiter');

        $applications = JobApplication::with([
            'job.company',
            'job.department',
            'applicantProfile.user',
            'applicantProfile.educations',
            'applicantProfile.workExperiences',
            'applicantProfile.organizations',
            'applicantProfile.achievements',
            'applicantProfile.certifications',
            'applicantProfile.trainings',
            'applicantProfile.skills',
            'applicantProfile.socialMedias',
            'applicantProfile.languages',
            'statusHistories.changedBy',
            'interviewSchedules.user'
        ])
        ->when($isRecruiterOnly, function ($query) {
            $query->whereHas('job', function ($jq) {
                $jq->whereIn(DB::raw('LOWER(status)'), ['open', 'published', 'active', 'draft'])
                  ->where(function($q) {
                      $q->whereNull('deadline')->orWhere('deadline', '>=', now()->toDateString());
                  });
            });
        })
        ->when($this->search, function ($query) {
            $search = strtolower(trim($this->search));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(status) LIKE ?', ['%' . $search . '%'])
                  ->orWhereHas('applicantProfile', function ($apq) use ($search) {
                      $apq->whereRaw('LOWER(full_name) LIKE ?', ['%' . $search . '%'])
                          ->orWhereRaw('LOWER(city) LIKE ?', ['%' . $search . '%'])
                          ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . $search . '%'])
                          ->orWhereHas('user', function ($uq) use ($search) {
                              $uq->whereRaw('LOWER(email) LIKE ?', ['%' . $search . '%']);
                          });
                  })
                  ->orWhereHas('job', function ($jq) use ($search) {
                      $jq->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%'])
                        ->orWhereHas('company', function ($cq) use ($search) {
                            $cq->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                        });
                  });
            });
        })
        ->when(!empty($this->selectedStatuses), function ($query) {
            $query->whereIn('status', $this->selectedStatuses);
        })
        ->when($this->statusFilter, function ($query) {
            $query->where('status', $this->statusFilter);
        })
        ->when($this->sortField === 'position', function ($query) {
            $query->join('jobs', 'job_applications.job_id', '=', 'jobs.id')
                  ->orderBy('jobs.title', $this->sortDirection)
                  ->select('job_applications.*');
        })
        ->when($this->sortField === 'company', function ($query) {
            $query->join('jobs', 'job_applications.job_id', '=', 'jobs.id')
                  ->join('companies', 'jobs.company_id', '=', 'companies.id')
                  ->orderBy('companies.name', $this->sortDirection)
                  ->select('job_applications.*');
        })
        ->when($this->sortField === 'applicant', function ($query) {
            $query->join('applicant_profile', 'job_applications.profile_id', '=', 'applicant_profile.id')
                  ->orderBy('applicant_profile.full_name', $this->sortDirection)
                  ->select('job_applications.*');
        })
        ->when($this->sortField === 'applied_at', function ($query) {
            $query->orderBy('job_applications.created_at', $this->sortDirection);
        })
        ->when($this->sortField === 'status', function ($query) {
            $query->orderBy('job_applications.status', $this->sortDirection);
        })
        ->when($this->sortField === 'id' || !in_array($this->sortField, ['position', 'company', 'applicant', 'applied_at', 'status']), function ($query) {
            $query->orderBy('job_applications.id', $this->sortDirection);
        })
        ->paginate(10);

        return view('livewire.admin.applicants.table', [
            'applications'     => $applications,
            'isRecruiter'      => $isRecruiterOnly,
            'search'           => $this->search,
            'statusFilter'     => $this->statusFilter,
            'selectedStatuses' => $this->selectedStatuses,
            'selectedColumns'  => $this->selectedColumns,
            'sortField'        => $this->sortField,
            'sortDirection'    => $this->sortDirection,
        ]);
    }
}
