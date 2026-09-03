<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Position;
use App\Models\Department;

class PositionTable extends Component
{
    use WithPagination;

    public $search = '';
    public $departmentId = '';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDepartmentId()
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
        $this->departmentId = '';
        $this->resetPage();
    }

    public function render()
    {
        $positions = Position::with(['department.company'])
            ->when($this->departmentId, function ($query) {
                $query->where('department_id', $this->departmentId);
            })
            ->when($this->search, function ($query) {
                $search = strtolower(trim($this->search));
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(description) LIKE ?', ['%' . $search . '%'])
                      ->orWhereHas('department', function ($dq) use ($search) {
                          $dq->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                            ->orWhereHas('company', function ($cq) use ($search) {
                                $cq->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                            });
                      });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $departments = Department::with('company')->orderBy('name')->get();

        return view('livewire.admin.position.table', [
            'positions' => $positions,
            'departments' => $departments,
        ]);
    }
}
