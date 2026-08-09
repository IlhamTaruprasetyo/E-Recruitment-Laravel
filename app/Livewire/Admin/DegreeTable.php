<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Degree;

class DegreeTable extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $degrees = Degree::when($this->search, function ($query) {
                $search = strtolower(trim($this->search));
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
            })
            ->orderBy('rank', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.degree.table', [
            'degrees' => $degrees,
        ]);
    }
}
