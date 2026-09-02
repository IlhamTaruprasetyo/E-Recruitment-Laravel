<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Test;
use App\Models\Job;
use App\Models\TestCategory;
use App\Models\QuestionBank;

class TestTable extends Component
{
    use WithPagination;

    public $search = '';
    public $jobId = '';
    public $categoryId = '';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingJobId()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->jobId = '';
        $this->categoryId = '';
        $this->resetPage();
    }

    public function render()
    {
        $jobs = Job::orderBy('title', 'asc')->get();
        $categories = TestCategory::orderBy('name', 'asc')->get();

        $allQuestions = QuestionBank::with(['category', 'options'])
            ->orderBy('category_id', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        $tests = Test::with(['job', 'category', 'questions'])
            ->withCount(['questions', 'attempts'])
            ->when($this->search, function ($query) {
                $search = strtolower(trim($this->search));
                $query->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%']);
            })
            ->when($this->jobId, function ($query) {
                $query->where('job_id', $this->jobId);
            })
            ->when($this->categoryId, function ($query) {
                $query->where('category_id', $this->categoryId);
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.test.table', [
            'tests' => $tests,
            'jobs' => $jobs,
            'categories' => $categories,
            'allQuestions' => $allQuestions,
        ]);
    }
}
