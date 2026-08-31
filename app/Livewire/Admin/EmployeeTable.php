<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmployeeProfile;
use App\Models\Department;

class EmployeeTable extends Component
{
    use WithPagination;

    public $search = '';
    public $departmentId = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDepartmentId()
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
        $departments = Department::with('company')->orderBy('name', 'asc')->get();

        $employees = EmployeeProfile::with(['user', 'department.company'])
            ->when($this->search, function ($query) {
                $search = strtolower(trim($this->search));
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(full_name) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(position_title) LIKE ?', ['%' . $search . '%'])
                      ->orWhereHas('user', function ($uq) use ($search) {
                          $uq->whereRaw('LOWER(email) LIKE ?', ['%' . $search . '%']);
                      });
                });
            })
            ->when($this->departmentId, function ($query) {
                $query->where('department_id', $this->departmentId);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.employee.table', [
            'employees' => $employees,
            'departments' => $departments,
        ]);
    }
}
