<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Job;
use App\Models\Company;
use App\Models\Department;

class JobTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $jobs = Job::with(['company', 'department'])
            ->when($this->search, function ($query) {
                $search = strtolower(trim($this->search));
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(location) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(employment_type) LIKE ?', ['%' . $search . '%'])
                      ->orWhereHas('company', function ($cq) use ($search) {
                          $cq->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                      })
                      ->orWhereHas('department', function ($dq) use ($search) {
                          $dq->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                      });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $companies = Company::all();
        $departments = Department::all();

        return view('livewire.admin.jobs.table', [
            'jobs' => $jobs,
            'companies' => $companies,
            'departments' => $departments,
        ]);
    }
}
