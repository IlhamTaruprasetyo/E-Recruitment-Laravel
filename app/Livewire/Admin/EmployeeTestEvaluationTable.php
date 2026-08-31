<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TestAttempt;
use App\Models\Department;
use App\Models\Test;
use Illuminate\Support\Facades\DB;

class EmployeeTestEvaluationTable extends Component
{
    use WithPagination;

    public $search = '';
    public $departmentId = '';
    public $testId = '';
    public $status = '';

    public $sortField = 'id';
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDepartmentId()
    {
        $this->resetPage();
    }

    public function updatingTestId()
    {
        $this->resetPage();
    }

    public function updatingStatus()
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

    public function resetFilters()
    {
        $this->search = '';
        $this->departmentId = '';
        $this->testId = '';
        $this->status = '';
        $this->sortField = 'id';
        $this->sortDirection = 'desc';
        $this->resetPage();
    }

    public function render()
    {
        $departments = Department::orderBy('name', 'asc')->get();
        $tests = Test::where('test_type', 'employee')->orderBy('title', 'asc')->get();

        $query = TestAttempt::with([
            'user.employeeProfile.department',
            'test.category',
            'test.department',
            'answers.question.options',
            'answers.option',
            'answers.reviewer',
            'discTestResult.discProfile',
        ])
        ->where(function ($q) {
            $q->where('attempt_type', 'employee')
              ->orWhereNotNull('user_id');
        });

        // Search Filter
        if (!empty($this->search)) {
            $search = strtolower(trim($this->search));
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . $search . '%']);
                })
                ->orWhereHas('user.employeeProfile', function ($ep) use ($search) {
                    $ep->whereRaw('LOWER(full_name) LIKE ?', ['%' . $search . '%'])
                       ->orWhereRaw('LOWER(position_title) LIKE ?', ['%' . $search . '%']);
                })
                ->orWhereHas('test', function ($t) use ($search) {
                    $t->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%']);
                });
            });
        }

        // Filter Departemen
        if (!empty($this->departmentId)) {
            $query->whereHas('user.employeeProfile', function ($ep) {
                $ep->where('department_id', $this->departmentId);
            });
        }

        // Filter Paket Asesmen
        if (!empty($this->testId)) {
            $query->where('test_id', $this->testId);
        }

        // Filter Status
        if (!empty($this->status)) {
            if ($this->status === 'needs_grading') {
                $query->whereHas('answers.question', function ($q) {
                    $q->where('question_type', 'essay');
                })->whereHas('answers', function ($a) {
                    $a->whereNull('reviewed_by');
                });
            } elseif ($this->status === 'disc') {
                $query->where(function ($q) {
                    $q->whereHas('discTestResult')
                      ->orWhereHas('test', function ($t) {
                          $t->whereRaw('LOWER(title) LIKE ?', ['%disc%']);
                      });
                });
            } else {
                $query->where('status', $this->status);
            }
        }

        // Sorting
        if ($this->sortField === 'employee') {
            $query->join('users', 'test_attempts.user_id', '=', 'users.id')
                  ->orderBy('users.name', $this->sortDirection)
                  ->select('test_attempts.*');
        } elseif ($this->sortField === 'score') {
            $query->orderBy('total_score', $this->sortDirection);
        } elseif ($this->sortField === 'started_at') {
            $query->orderBy('started_at', $this->sortDirection);
        } else {
            $query->orderBy('id', $this->sortDirection);
        }

        $attempts = $query->paginate(10);

        return view('livewire.admin.employee-test-evaluation.table', [
            'attempts' => $attempts,
            'departments' => $departments,
            'tests' => $tests,
        ]);
    }
}
