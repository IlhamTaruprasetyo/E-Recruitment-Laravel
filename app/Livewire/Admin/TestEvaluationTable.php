<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TestAttempt;
use App\Models\Job;
use App\Models\Test;

class TestEvaluationTable extends Component
{
    use WithPagination;

    public $search = '';
    public $jobId = '';
    public $testId = '';
    public $status = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingJobId()
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

    public function resetFilters()
    {
        $this->search = '';
        $this->jobId = '';
        $this->testId = '';
        $this->status = '';
        $this->resetPage();
    }

    public function render()
    {
        $jobs = Job::orderBy('title', 'asc')->get();
        $tests = Test::orderBy('title', 'asc')->get();

        $attempts = TestAttempt::with([
            'jobApplication.applicantProfile.user',
            'jobApplication.job',
            'test.category',
            'answers.question.options',
            'answers.option',
            'answers.reviewer',
        ])
        ->when($this->search, function ($query) {
            $search = strtolower(trim($this->search));
            $query->where(function ($q) use ($search) {
                $q->whereHas('jobApplication.applicantProfile', function ($p) use ($search) {
                    $p->whereRaw('LOWER(full_name) LIKE ?', ['%' . $search . '%']);
                })
                ->orWhereHas('test', function ($t) use ($search) {
                    $t->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%']);
                });
            });
        })
        ->when($this->jobId, function ($query) {
            $query->whereHas('jobApplication', function ($j) {
                $j->where('job_id', $this->jobId);
            });
        })
        ->when($this->testId, function ($query) {
            $query->where('test_id', $this->testId);
        })
        ->when($this->status, function ($query) {
            if ($this->status === 'needs_grading') {
                $query->whereHas('answers.question', function ($q) {
                    $q->where('question_type', 'essay');
                })->whereHas('answers', function ($a) {
                    $a->whereNull('reviewed_by');
                });
            } else {
                $query->where('status', $this->status);
            }
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('livewire.admin.test-evaluation.table', [
            'attempts' => $attempts,
            'jobs' => $jobs,
            'tests' => $tests,
        ]);
    }
}
