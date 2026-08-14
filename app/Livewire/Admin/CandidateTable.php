<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class CandidateTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $candidates = User::with([
            'applicantProfile.educations',
            'applicantProfile.workExperiences',
            'applicantProfile.organizations',
            'applicantProfile.certifications',
            'applicantProfile.trainings',
            'applicantProfile.skills',
            'applicantProfile.socialMedias',
            'applicantProfile.languages',
            'applicantProfile.jobApplications.job.company'
        ])
        ->where(function ($q) {
            $q->where('role_id', 3)
              ->orWhereHas('role', function ($rq) {
                  $rq->whereRaw('LOWER(name) = ?', ['applicant']);
              })
              ->orWhereHas('applicantProfile');
        })
        ->whereNotIn('role_id', [1, 2])
        ->whereDoesntHave('role', function ($rq) {
            $rq->whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(name)'), ['admin', 'superadmin', 'recruiter']);
        })
        ->when($this->search, function ($query) {
            $search = strtolower(trim($this->search));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search . '%'])
                  ->orWhereHas('applicantProfile', function ($apq) use ($search) {
                      $apq->whereRaw('LOWER(full_name) LIKE ?', ['%' . $search . '%'])
                          ->orWhereRaw('LOWER(city) LIKE ?', ['%' . $search . '%'])
                          ->orWhereRaw('LOWER(province) LIKE ?', ['%' . $search . '%'])
                          ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . $search . '%'])
                          ->orWhereRaw('LOWER(phone) LIKE ?', ['%' . $search . '%']);
                  });
            });
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('livewire.admin.candidates.table', [
            'candidates' => $candidates
        ]);
    }
}
