<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Test;
use App\Models\Department;
use App\Models\TestCategory;
use App\Models\QuestionBank;

class EmployeeTestTable extends Component
{
    use WithPagination;

    public $search = '';
    public $departmentId = '';
    public $categoryId = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDepartmentId()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->departmentId = '';
        $this->categoryId = '';
        $this->resetPage();
    }

    public function render()
    {
        $departments = Department::with('company')->orderBy('name', 'asc')->get();
        $categories = TestCategory::orderBy('name', 'asc')->get();

        $allQuestions = QuestionBank::with(['category', 'options'])
            ->orderBy('category_id', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        $tests = Test::with(['department.company', 'category', 'questions'])
            ->withCount(['questions', 'attempts'])
            ->where('test_type', 'employee')
            ->when($this->search, function ($query) {
                $search = strtolower(trim($this->search));
                $query->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%']);
            })
            ->when($this->departmentId, function ($query) {
                if ($this->departmentId === 'all') {
                    $query->whereNull('department_id');
                } else {
                    $query->where('department_id', $this->departmentId);
                }
            })
            ->when($this->categoryId, function ($query) {
                $query->where('category_id', $this->categoryId);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.employee-test.table', [
            'tests' => $tests,
            'departments' => $departments,
            'categories' => $categories,
            'allQuestions' => $allQuestions,
        ]);
    }
}
