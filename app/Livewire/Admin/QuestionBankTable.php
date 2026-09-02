<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\QuestionBank;
use App\Models\TestCategory;

class QuestionBankTable extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryId = '';
    public $type = '';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function updatingType()
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
        $this->categoryId = '';
        $this->type = '';
        $this->resetPage();
    }

    public function render()
    {
        $categories = TestCategory::orderBy('name', 'asc')->get();

        $questions = QuestionBank::with(['category', 'options'])
            ->when($this->search, function ($query) {
                $search = strtolower(trim($this->search));
                $query->whereRaw('LOWER(question) LIKE ?', ['%' . $search . '%']);
            })
            ->when($this->categoryId, function ($query) {
                $query->where('category_id', $this->categoryId);
            })
            ->when($this->type, function ($query) {
                $query->where('question_type', $this->type);
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.question-bank.table', [
            'questions' => $questions,
            'categories' => $categories,
        ]);
    }
}
