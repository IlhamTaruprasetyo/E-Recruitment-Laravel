<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\JobApplication;
use Illuminate\Support\Facades\DB;

class ApplicantTable extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
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
            'applicantProfile.certifications',
            'applicantProfile.trainings',
            'applicantProfile.skills',
            'applicantProfile.socialMedias',
            'applicantProfile.languages',
            'statusHistories.changedBy'
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
        ->when($this->statusFilter, function ($query) {
            $query->where('status', $this->statusFilter);
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('livewire.admin.applicants.table', [
            'applications' => $applications,
        ]);
    }
}
